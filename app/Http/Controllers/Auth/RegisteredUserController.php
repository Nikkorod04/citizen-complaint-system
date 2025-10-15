<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'middle_name' => ['nullable', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'suffix' => ['nullable', 'string', 'max:10'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'national_id' => ['required', 'string', 'max:20', 'unique:'.User::class],
            'national_id_image' => ['required', 'image', 'mimes:jpeg,png,jpg', 'max:2048'], // 2MB max
            'date_of_birth' => ['required', 'date', 'before:today'],
            'age' => ['required', 'integer', 'min:18', 'max:120'],
            'gender' => ['required', 'in:male,female,other'],
            'civil_status' => ['required', 'in:single,married,widowed,separated,divorced'],
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

        // Combine address for the old address field
        $addressParts = array_filter([
            $request->house_number,
            $request->street,
            $request->barangay,
            $request->city,
            $request->province,
            $request->zip_code,
        ]);
        $fullAddress = implode(', ', $addressParts);

        // Handle National ID image upload
        $nationalIdImagePath = null;
        if ($request->hasFile('national_id_image')) {
            $nationalIdImagePath = $request->file('national_id_image')->store('national-ids', 'public');
        }

        $user = User::create([
            'first_name' => $request->first_name,
            'middle_name' => $request->middle_name,
            'last_name' => $request->last_name,
            'suffix' => $request->suffix,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'national_id' => $request->national_id,
            'national_id_image' => $nationalIdImagePath,
            'date_of_birth' => $request->date_of_birth,
            'age' => $request->age,
            'gender' => $request->gender,
            'civil_status' => $request->civil_status,
            'phone' => $request->phone,
            'address' => $fullAddress,
            'house_number' => $request->house_number,
            'street' => $request->street,
            'barangay' => $request->barangay,
            'city' => $request->city,
            'province' => $request->province,
            'zip_code' => $request->zip_code,
            'occupation' => $request->occupation,
            'emergency_contact_name' => $request->emergency_contact_name,
            'emergency_contact_number' => $request->emergency_contact_number,
            'role' => 'citizen',
            'verification_status' => 'pending',
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect()->route('verification.pending')
            ->with('success', 'Registration successful! Please wait for account verification.');
    }
}
