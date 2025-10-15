<x-guest-layout>
    <div class="text-center">
        <div class="mb-4">
            <svg class="mx-auto h-16 w-16 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
        </div>
        
        <h2 class="text-2xl font-bold text-gray-900 mb-2">Account Verification Pending</h2>
        
        <div class="mt-4 bg-yellow-50 border border-yellow-200 rounded-lg p-4">
            <p class="text-sm text-gray-700 mb-2">
                Thank you for registering! Your account is currently under review by the Barangay Secretary.
            </p>
            <p class="text-sm text-gray-600">
                You will receive a notification once your account has been verified. This usually takes 1-2 business days.
            </p>
        </div>

        <div class="mt-6 space-y-2">
            <p class="text-sm text-gray-600">
                <strong>Registered as:</strong> {{ auth()->user()->full_name }}
            </p>
            <p class="text-sm text-gray-600">
                <strong>Email:</strong> {{ auth()->user()->email }}
            </p>
            <p class="text-sm text-gray-600">
                <strong>Status:</strong> 
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                    {{ ucfirst(auth()->user()->verification_status) }}
                </span>
            </p>
        </div>

        <div class="mt-6">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="text-sm text-indigo-600 hover:text-indigo-500">
                    Sign Out
                </button>
            </form>
        </div>
    </div>
</x-guest-layout>
