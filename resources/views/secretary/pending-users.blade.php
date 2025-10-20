<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
                {{ __('Pending User Verifications') }}
            </h2>
            <a href="{{ route('secretary.dashboard') }}" class="text-sm text-indigo-600 hover:text-indigo-800 font-medium flex items-center">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Back to Dashboard
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if($users->count() > 0)
                <div class="space-y-4">
                    @foreach($users as $user)
                        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg hover:shadow-lg transition">
                            <div class="p-6">
                                <div class="flex items-start justify-between mb-4">
                                    <div class="flex-1">
                                        <!-- User Info Header -->
                                        <div class="mb-4">
                                            <h3 class="text-2xl font-bold text-gray-900">{{ $user->full_name }}</h3>
                                            <p class="text-sm text-gray-500 mt-1">
                                                Applied {{ $user->created_at->format('F j, Y \a\t g:i A') }}
                                            </p>
                                        </div>

                                        <!-- National ID Image Display -->
                                        @if($user->national_id_image)
                                            <div class="mb-6">
                                                <p class="text-sm font-semibold text-gray-700 mb-2">National ID Image:</p>
                                                <div class="relative inline-block">
                                                    <img src="{{ asset('storage/' . $user->national_id_image) }}" 
                                                         alt="National ID" 
                                                         class="h-48 border-2 border-indigo-500 rounded-lg shadow-md cursor-pointer hover:shadow-lg transition"
                                                         onclick="openImageModal('{{ asset('storage/' . $user->national_id_image) }}', '{{ $user->full_name }}')">
                                                    <button onclick="openImageModal('{{ asset('storage/' . $user->national_id_image) }}', '{{ $user->full_name }}')" 
                                                            class="absolute top-2 right-2 bg-indigo-600 text-white rounded-full p-2 hover:bg-indigo-700 transition shadow-lg">
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM13 10H7" />
                                                        </svg>
                                                    </button>
                                                </div>
                                            </div>
                                        @endif

                                        <!-- Personal Information -->
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                                            <div>
                                                <h4 class="text-sm font-semibold text-gray-700 mb-3">Personal Information</h4>
                                                <div class="space-y-2">
                                                    <div class="flex justify-between text-sm">
                                                        <span class="text-gray-600">Email:</span>
                                                        <span class="font-medium text-gray-900">{{ $user->email }}</span>
                                                    </div>
                                                    <div class="flex justify-between text-sm">
                                                        <span class="text-gray-600">Phone:</span>
                                                        <span class="font-medium text-gray-900">{{ $user->phone }}</span>
                                                    </div>
                                                    <div class="flex justify-between text-sm">
                                                        <span class="text-gray-600">Date of Birth:</span>
                                                        <span class="font-medium text-gray-900">{{ $user->date_of_birth->format('F j, Y') }}</span>
                                                    </div>
                                                    <div class="flex justify-between text-sm">
                                                        <span class="text-gray-600">Age:</span>
                                                        <span class="font-medium text-gray-900">{{ $user->age }}</span>
                                                    </div>
                                                    <div class="flex justify-between text-sm">
                                                        <span class="text-gray-600">Gender:</span>
                                                        <span class="font-medium text-gray-900 capitalize">{{ $user->gender }}</span>
                                                    </div>
                                                </div>
                                            </div>

                                            <div>
                                                <h4 class="text-sm font-semibold text-gray-700 mb-3">Identification</h4>
                                                <div class="space-y-2">
                                                    <div class="flex justify-between text-sm">
                                                        <span class="text-gray-600">National ID:</span>
                                                        <span class="font-mono font-bold text-gray-900">{{ $user->national_id }}</span>
                                                    </div>
                                                    <div class="flex justify-between text-sm">
                                                        <span class="text-gray-600">Civil Status:</span>
                                                        <span class="font-medium text-gray-900 capitalize">{{ str_replace('_', ' ', $user->civil_status) }}</span>
                                                    </div>
                                                    <div class="flex justify-between text-sm">
                                                        <span class="text-gray-600">Occupation:</span>
                                                        <span class="font-medium text-gray-900">{{ $user->occupation ?? 'Not specified' }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Address Information -->
                                        <div class="mb-6">
                                            <h4 class="text-sm font-semibold text-gray-700 mb-3">Address</h4>
                                            <div class="bg-gray-50 p-4 rounded-lg">
                                                <p class="text-sm text-gray-900">
                                                    {{ $user->house_number }} {{ $user->street }}, 
                                                    {{ $user->barangay }}, {{ $user->city }}, 
                                                    {{ $user->province }} {{ $user->zip_code }}
                                                </p>
                                            </div>
                                        </div>

                                        <!-- Emergency Contact -->
                                        <div class="mb-6">
                                            <h4 class="text-sm font-semibold text-gray-700 mb-3">Emergency Contact</h4>
                                            <div class="space-y-2 text-sm">
                                                <div class="flex justify-between">
                                                    <span class="text-gray-600">Name:</span>
                                                    <span class="font-medium text-gray-900">{{ $user->emergency_contact_name }}</span>
                                                </div>
                                                <div class="flex justify-between">
                                                    <span class="text-gray-600">Relationship:</span>
                                                    <span class="font-medium text-gray-900">{{ $user->emergency_contact_relationship }}</span>
                                                </div>
                                                <div class="flex justify-between">
                                                    <span class="text-gray-600">Phone:</span>
                                                    <span class="font-medium text-gray-900">{{ $user->emergency_contact_phone }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Verification Status Badge -->
                                    <div class="ml-6 flex-shrink-0">
                                        <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-yellow-100">
                                            <svg class="w-8 h-8 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                        </div>
                                        <p class="mt-2 text-center text-xs font-semibold text-yellow-700">PENDING</p>
                                    </div>
                                </div>

                                <!-- Action Buttons -->
                                <div class="flex flex-col md:flex-row gap-3 pt-4 border-t border-gray-200">
                                    <form action="{{ route('secretary.users.verify', $user) }}" method="POST" class="flex-1">
                                        @csrf
                                        <button type="submit" class="w-full px-4 py-2 bg-green-600 text-white font-medium rounded-lg hover:bg-green-700 transition flex items-center justify-center">
                                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                            </svg>
                                            Approve & Generate QR Code
                                        </button>
                                    </form>

                                    <form action="{{ route('secretary.users.reject', $user) }}" method="POST" class="flex-1">
                                        @csrf
                                        <button type="submit" class="w-full px-4 py-2 bg-red-600 text-white font-medium rounded-lg hover:bg-red-700 transition flex items-center justify-center" onclick="return confirm('Are you sure you want to reject this application?')">
                                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                            Reject Application
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="mt-8">
                    {{ $users->links() }}
                </div>
            @else
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-12 text-center">
                        <svg class="mx-auto h-16 w-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <h3 class="mt-6 text-lg font-medium text-gray-900">All verified!</h3>
                        <p class="mt-2 text-gray-500">There are no pending user verifications at the moment.</p>
                        <div class="mt-6">
                            <a href="{{ route('secretary.dashboard') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white font-medium rounded-lg hover:bg-indigo-700 transition">
                                Back to Dashboard
                            </a>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- Image Modal -->
    <div id="imageModal" class="hidden fixed inset-0 bg-black bg-opacity-75 flex items-center justify-center z-50 p-4">
        <div class="bg-white rounded-lg max-w-2xl w-full max-h-[90vh] overflow-auto">
            <div class="sticky top-0 flex items-center justify-between p-4 bg-gray-50 border-b">
                <h3 class="text-lg font-semibold text-gray-900" id="modalTitle">National ID Image</h3>
                <button onclick="closeImageModal()" class="text-gray-500 hover:text-gray-700">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <div class="p-6 flex items-center justify-center">
                <img id="modalImage" src="" alt="National ID" class="max-w-full max-h-[70vh] rounded-lg">
            </div>
        </div>
    </div>

    <script>
        function openImageModal(imageSrc, userName) {
            document.getElementById('imageModal').classList.remove('hidden');
            document.getElementById('modalImage').src = imageSrc;
            document.getElementById('modalTitle').textContent = userName + ' - National ID Image';
        }

        function closeImageModal() {
            document.getElementById('imageModal').classList.add('hidden');
        }

        // Close modal when clicking outside the image
        document.getElementById('imageModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeImageModal();
            }
        });

        // Close modal with ESC key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeImageModal();
            }
        });
    </script>
</x-app-layout>
