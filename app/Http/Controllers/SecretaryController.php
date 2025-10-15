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
}
