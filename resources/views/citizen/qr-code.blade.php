<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
                {{ __('My QR Code') }}
            </h2>
            <a href="{{ route('citizen.dashboard') }}" class="text-sm text-indigo-600 hover:text-indigo-800 font-medium flex items-center">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Back to Dashboard
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    @if($user->verification_status === 'approved' && $qrCodeUrl)
                        <div class="space-y-6">
                            <!-- Header -->
                            <div class="text-center">
                                <h3 class="text-2xl font-bold text-gray-900 mb-2">Your Citizen QR Code</h3>
                                <p class="text-gray-600">This QR code verifies your identity as a registered citizen. You can use it for barangay transactions and complaints.</p>
                            </div>

                            <!-- QR Code Display -->
                            <div class="flex justify-center bg-gradient-to-br from-indigo-50 to-blue-50 p-8 rounded-lg border-2 border-indigo-200">
                                <div class="bg-white p-6 rounded-lg shadow-lg">
                                    <img src="{{ $qrCodeUrl }}" alt="QR Code" class="w-64 h-64">
                                </div>
                            </div>

                            <!-- User Information -->
                            <div class="bg-gray-50 p-4 rounded-lg space-y-3">
                                <div class="flex justify-between items-center">
                                    <span class="text-gray-700 font-medium">Name:</span>
                                    <span class="text-gray-900">{{ $user->full_name }}</span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-gray-700 font-medium">National ID:</span>
                                    <span class="text-gray-900 font-mono">{{ $user->national_id }}</span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-gray-700 font-medium">Verification Status:</span>
                                    <span class="px-3 py-1 bg-green-100 text-green-800 rounded-full text-sm font-semibold">
                                        ✓ Verified
                                    </span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-gray-700 font-medium">Verified Date:</span>
                                    <span class="text-gray-900">{{ $user->verified_at->format('F j, Y') }}</span>
                                </div>
                            </div>

                            <!-- Instructions -->
                            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                                <h4 class="font-semibold text-blue-900 mb-2">How to use your QR code:</h4>
                                <ul class="text-sm text-blue-800 space-y-1 ml-4 list-disc">
                                    <li>Present this QR code for verification at barangay transactions</li>
                                    <li>Use it to prove your identity when filing complaints</li>
                                    <li>Keep a digital copy for reference</li>
                                    <li>You can download or print this QR code for your records</li>
                                </ul>
                            </div>

                            <!-- Action Buttons -->
                            <div class="flex gap-4 justify-center">
                                <button onclick="window.print()" class="px-6 py-2 bg-indigo-600 text-white font-medium rounded-lg hover:bg-indigo-700 transition flex items-center">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4H9a2 2 0 00-2 2v2a2 2 0 002 2h10a2 2 0 002-2v-2a2 2 0 00-2-2" />
                                    </svg>
                                    Print QR Code
                                </button>
                                <a href="javascript:void(0)" onclick="downloadQRCode()" class="px-6 py-2 bg-green-600 text-white font-medium rounded-lg hover:bg-green-700 transition flex items-center">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10" />
                                    </svg>
                                    Download QR Code
                                </a>
                            </div>
                        </div>
                    @else
                        <div class="text-center py-12">
                            <svg class="mx-auto h-16 w-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4v.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <h3 class="mt-4 text-lg font-semibold text-gray-900">QR Code Not Yet Available</h3>
                            @if($user->verification_status === 'pending')
                                <p class="mt-2 text-gray-600">Your account is awaiting verification. Once approved by the secretary, your QR code will be generated automatically.</p>
                            @else
                                <p class="mt-2 text-gray-600">Your account verification status is: <span class="font-semibold capitalize">{{ $user->verification_status }}</span></p>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script>
        function downloadQRCode() {
            const qrImage = document.querySelector('img');
            const link = document.createElement('a');
            link.href = qrImage.src;
            link.download = 'qr-code-{{ $user->id }}.svg';
            link.click();
        }
    </script>
</x-app-layout>
