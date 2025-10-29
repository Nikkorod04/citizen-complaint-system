<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Complaint;
use App\Services\QRCodeService;
use App\Notifications\AccountVerified;

class SecretaryController extends Controller
{
    protected $qrCodeService;

    public function __construct(QRCodeService $qrCodeService)
    {
        $this->qrCodeService = $qrCodeService;
    }

    /**
     * Display the secretary dashboard
     */
    public function dashboard()
    {
        $pendingUsers = User::where('verification_status', 'pending')
            ->where('role', 'citizen')
            ->latest()
            ->get();

        $pendingComplaints = Complaint::where('status', 'pending')
            ->with(['user', 'category'])
            ->latest()
            ->get();

        $stats = [
            'pending_verifications' => User::where('verification_status', 'pending')->count(),
            'pending_complaints' => Complaint::where('status', 'pending')->count(),
            'validated_today' => Complaint::where('status', 'validated')
                ->whereDate('validated_at', today())
                ->count(),
        ];

        return view('secretary.dashboard', compact('pendingUsers', 'pendingComplaints', 'stats'));
    }

    /**
     * Show pending user verifications
     */
    public function pendingUsers()
    {
        $users = User::where('verification_status', 'pending')
            ->where('role', 'citizen')
            ->latest()
            ->paginate(15);

        return view('secretary.pending-users', compact('users'));
    }

    /**
     * Verify a user account
     */
    public function verifyUser(Request $request, User $user)
    {
        if ($user->verification_status !== 'pending') {
            return back()->with('error', 'This account has already been processed.');
        }

        // Generate QR code for the user
        $qrCodePath = $this->qrCodeService->generateUserQRCode(
            $user->id,
            $user->full_name,
            $user->national_id
        );

        $user->update([
            'verification_status' => 'approved',
            'verified_at' => now(),
            'qr_code' => $qrCodePath,
        ]);

        // Send notification to user
        $user->notify(new AccountVerified());

        return back()->with('success', 'User account verified successfully!');
    }

    /**
     * Reject a user account
     */
    public function rejectUser(Request $request, User $user)
    {
        $request->validate([
            'reason' => 'required|string|max:500'
        ]);

        if ($user->verification_status !== 'pending') {
            return back()->with('error', 'This account has already been processed.');
        }

        $user->update([
            'verification_status' => 'rejected',
        ]);

        return back()->with('success', 'User account rejected.');
    }

    /**
     * Show pending complaints
     */
    public function pendingComplaints()
    {
        $complaints = Complaint::where('status', 'pending')
            ->with(['user', 'category'])
            ->latest()
            ->paginate(15);

        return view('secretary.pending-complaints', compact('complaints'));
    }

    /**
     * Validate a complaint
     */
    public function validateComplaint(Request $request, Complaint $complaint)
    {
        $request->validate([
            'secretary_notes' => 'nullable|string|max:1000'
        ]);

        $complaint->update([
            'status' => 'validated',
            'secretary_notes' => $request->secretary_notes,
            'validated_at' => now(),
            'validated_by' => auth()->id(),
        ]);

        return back()->with('success', 'Complaint validated and forwarded to Captain.');
    }

    /**
     * Reject a complaint
     */
    public function rejectComplaint(Request $request, Complaint $complaint)
    {
        $request->validate([
            'secretary_notes' => 'required|string|max:1000'
        ]);

        $complaint->update([
            'status' => 'rejected',
            'secretary_notes' => $request->secretary_notes,
            'validated_at' => now(),
            'validated_by' => auth()->id(),
        ]);

        return back()->with('success', 'Complaint rejected.');
    }

    /**
     * Show all citizens
     */
    public function manageCitizens()
    {
        $citizens = User::where('role', 'citizen')
            ->latest()
            ->paginate(15);

        return view('secretary.citizens.index', compact('citizens'));
    }

    /**
     * Show create citizen form
     */
    public function createCitizen()
    {
        return view('secretary.citizens.create');
    }

    /**
     * Store a new citizen
     */
    public function storeCitizen(Request $request)
    {
        $validated = $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'middle_name' => ['nullable', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'suffix' => ['nullable', 'string', 'max:10'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email'],
            'national_id' => ['required', 'string', 'max:20', 'unique:users,national_id'],
            'national_id_image' => ['required', 'image', 'mimes:jpeg,png,jpg', 'max:2048'], // 2MB max
            'date_of_birth' => ['required', 'date', 'before:today'],
            'gender' => ['required', 'in:Male,Female,Other'],
            'civil_status' => ['required', 'in:Single,Married,Widowed,Separated,Divorced'],
            'phone' => ['required', 'string', 'max:20'],
            'house_number' => ['nullable', 'string', 'max:50'],
            'street' => ['required', 'string', 'max:255'],
            'barangay' => ['required', 'string', 'max:255'],
            'city' => ['required', 'string', 'max:255'],
            'province' => ['required', 'string', 'max:255'],
            'zip_code' => ['nullable', 'string', 'max:10'],
            'occupation' => ['nullable', 'string', 'max:255'],
            'emergency_contact_name' => ['nullable', 'string', 'max:255'],
            'emergency_contact_number' => ['nullable', 'string', 'max:20'],
        ]);

        $validated['role'] = 'citizen';
        $validated['verification_status'] = 'approved';
        $validated['verified_at'] = now();
        $validated['password'] = bcrypt('password123');

        // Calculate age from date of birth
        $dateOfBirth = \Carbon\Carbon::parse($validated['date_of_birth']);
        $validated['age'] = $dateOfBirth->age;

        // Handle National ID image upload
        if ($request->hasFile('national_id_image')) {
            $nationalIdImagePath = $request->file('national_id_image')->store('national-ids', 'public');
            $validated['national_id_image'] = $nationalIdImagePath;
        }

        // Update complete address
        $addressParts = array_filter([
            $validated['house_number'] ?? null,
            $validated['street'] ?? null,
            $validated['barangay'] ?? null,
            $validated['city'] ?? null,
            $validated['province'] ?? null,
            $validated['zip_code'] ?? null,
        ]);
        $validated['address'] = implode(', ', $addressParts);
        $validated['complete_address'] = $validated['address'];

        $citizen = User::create($validated);

        // Generate QR code
        $qrCodePath = $this->qrCodeService->generateUserQRCode(
            $citizen->id,
            $citizen->full_name,
            $citizen->national_id
        );

        $citizen->update(['qr_code' => $qrCodePath]);

        return redirect()->route('secretary.citizens.show', $citizen)
            ->with('success', 'Citizen created successfully!');
    }

    /**
     * Show citizen details
     */
    public function showCitizen(User $user)
    {
        if ($user->role !== 'citizen') {
            abort(404);
        }

        $complaints = $user->complaints()->latest()->get();
        $urgentRequests = $user->submittedUrgentRequests()->latest()->get();

        return view('secretary.citizens.show', compact('user', 'complaints', 'urgentRequests'));
    }

    /**
     * Show edit citizen form
     */
    public function editCitizen(User $user)
    {
        if ($user->role !== 'citizen') {
            abort(404);
        }

        return view('secretary.citizens.edit', compact('user'));
    }

    /**
     * Update citizen information
     */
    public function updateCitizen(Request $request, User $user)
    {
        if ($user->role !== 'citizen') {
            abort(404);
        }

        $validated = $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'middle_name' => ['nullable', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'suffix' => ['nullable', 'string', 'max:10'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'national_id' => ['required', 'string', 'max:20', 'unique:users,national_id,' . $user->id],
            'national_id_image' => ['nullable', 'image', 'mimes:jpeg,png,jpg', 'max:2048'], // 2MB max
            'date_of_birth' => ['required', 'date', 'before:today'],
            'gender' => ['required', 'in:Male,Female,Other'],
            'civil_status' => ['required', 'in:Single,Married,Widowed,Separated,Divorced'],
            'phone' => ['required', 'string', 'max:20'],
            'house_number' => ['nullable', 'string', 'max:50'],
            'street' => ['required', 'string', 'max:255'],
            'barangay' => ['required', 'string', 'max:255'],
            'city' => ['required', 'string', 'max:255'],
            'province' => ['required', 'string', 'max:255'],
            'zip_code' => ['nullable', 'string', 'max:10'],
            'occupation' => ['nullable', 'string', 'max:255'],
            'emergency_contact_name' => ['nullable', 'string', 'max:255'],
            'emergency_contact_number' => ['nullable', 'string', 'max:20'],
        ]);

        // Handle National ID image upload
        if ($request->hasFile('national_id_image')) {
            $nationalIdImagePath = $request->file('national_id_image')->store('national-ids', 'public');
            $validated['national_id_image'] = $nationalIdImagePath;
        }

        // Calculate age from date of birth
        $dateOfBirth = \Carbon\Carbon::parse($validated['date_of_birth']);
        $validated['age'] = $dateOfBirth->age;

        // Update complete address
        $addressParts = array_filter([
            $validated['house_number'] ?? null,
            $validated['street'] ?? null,
            $validated['barangay'] ?? null,
            $validated['city'] ?? null,
            $validated['province'] ?? null,
            $validated['zip_code'] ?? null,
        ]);
        $validated['address'] = implode(', ', $addressParts);
        $validated['complete_address'] = $validated['address'];

        $user->update($validated);

        return redirect()->route('secretary.citizens.show', $user)
            ->with('success', 'Citizen updated successfully!');
    }

    /**
     * Delete a citizen
     */
    public function deleteCitizen(User $user)
    {
        if ($user->role !== 'citizen') {
            abort(404);
        }

        $user->delete();

        return redirect()->route('secretary.citizens.index')
            ->with('success', 'Citizen deleted successfully!');
    }
}
