<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-bold text-3xl text-gray-900 leading-tight">
                    {{ $user->full_name }}
                </h2>
                <p class="text-sm text-gray-600 mt-1">View and manage citizen information</p>
            </div>
            <div class="flex gap-3">
                <a href="{{ route('secretary.citizens.edit', $user) }}" class="px-6 py-3 bg-gradient-to-r from-amber-600 to-amber-700 hover:from-amber-700 hover:to-amber-800 text-white font-semibold rounded-lg transition shadow-md hover:shadow-lg flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                    Edit
                </a>
                <form method="POST" action="{{ route('secretary.citizens.destroy', $user) }}" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" onclick="return confirm('Are you sure you want to delete this citizen?')" class="px-6 py-3 bg-gradient-to-r from-red-600 to-red-700 hover:from-red-700 hover:to-red-800 text-white font-semibold rounded-lg transition shadow-md hover:shadow-lg flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                        Delete
                    </button>
                </form>
            </div>
        </div>
    </x-slot>

    <div class="py-12 bg-gradient-to-b from-blue-50/30 to-transparent min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            @if (session('success'))
                <div class="p-4 bg-green-100 border border-green-300 text-green-800 rounded-lg flex items-center gap-3">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                    </svg>
                    {{ session('success') }}
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Citizen Information Card -->
                <div class="bg-white overflow-hidden shadow-md sm:rounded-xl border border-gray-100">
                    <div class="p-6 sm:p-8 text-center">
                        <div class="w-24 h-24 rounded-full bg-gradient-to-br from-blue-500 to-blue-600 text-white flex items-center justify-center font-bold text-3xl mx-auto mb-4">
                            {{ substr($user->full_name, 0, 1) }}
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900">{{ $user->full_name }}</h3>
                        <p class="text-gray-600 mt-2">{{ $user->email }}</p>
                        <p class="text-sm text-gray-600">{{ $user->phone }}</p>
                        <div class="mt-4 flex justify-center">
                            <span class="px-4 py-2 text-sm font-bold rounded-full {{ $user->verification_status === 'approved' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                {{ ucfirst($user->verification_status) }}
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Personal Details -->
                <div class="lg:col-span-2 bg-white overflow-hidden shadow-md sm:rounded-xl border border-gray-100">
                    <div class="p-6 sm:p-8">
                        <h3 class="text-xl font-bold text-gray-900 mb-6">Personal Information</h3>
                        <div class="space-y-4">
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <p class="text-xs font-bold text-gray-600 uppercase">Date of Birth</p>
                                    <p class="text-gray-900 font-semibold">{{ $user->date_of_birth->format('M d, Y') }}</p>
                                </div>
                                <div>
                                    <p class="text-xs font-bold text-gray-600 uppercase">Age</p>
                                    <p class="text-gray-900 font-semibold">{{ $user->age }} years old</p>
                                </div>
                                <div>
                                    <p class="text-xs font-bold text-gray-600 uppercase">Gender</p>
                                    <p class="text-gray-900 font-semibold">{{ $user->gender }}</p>
                                </div>
                                <div>
                                    <p class="text-xs font-bold text-gray-600 uppercase">Civil Status</p>
                                    <p class="text-gray-900 font-semibold">{{ $user->civil_status }}</p>
                                </div>
                            </div>
                            <div>
                                <p class="text-xs font-bold text-gray-600 uppercase">Occupation</p>
                                <p class="text-gray-900 font-semibold">{{ $user->occupation ?? 'N/A' }}</p>
                            </div>
                            <div>
                                <p class="text-xs font-bold text-gray-600 uppercase">National ID</p>
                                <p class="text-gray-900 font-semibold">{{ $user->national_id ?? 'Not provided' }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- National ID Image -->
            @if ($user->national_id_image)
                <div class="bg-white overflow-hidden shadow-md sm:rounded-xl border border-gray-100">
                    <div class="p-6 sm:p-8">
                        <h3 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
                            <svg class="w-6 h-6 mr-3 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            National ID Image
                        </h3>
                        <div class="flex justify-center">
                            <div class="relative w-full max-w-2xl rounded-lg border-2 border-gray-300 overflow-hidden bg-gray-100">
                                <img src="{{ Storage::url($user->national_id_image) }}" alt="National ID Image" class="w-full h-auto object-contain" />
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Address Information -->
            <div class="bg-white overflow-hidden shadow-md sm:rounded-xl border border-gray-100">
                <div class="p-6 sm:p-8">
                    <h3 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
                        <svg class="w-6 h-6 mr-3 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                        </svg>
                        Address Information
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <p class="text-xs font-bold text-gray-600 uppercase">Complete Address</p>
                            <p class="text-gray-900 font-semibold">{{ $user->complete_address }}</p>
                        </div>
                        <div>
                            <p class="text-xs font-bold text-gray-600 uppercase">House Number</p>
                            <p class="text-gray-900 font-semibold">{{ $user->house_number }}</p>
                        </div>
                        <div>
                            <p class="text-xs font-bold text-gray-600 uppercase">Street</p>
                            <p class="text-gray-900 font-semibold">{{ $user->street }}</p>
                        </div>
                        <div>
                            <p class="text-xs font-bold text-gray-600 uppercase">Barangay</p>
                            <p class="text-gray-900 font-semibold">{{ $user->barangay }}</p>
                        </div>
                        <div>
                            <p class="text-xs font-bold text-gray-600 uppercase">City</p>
                            <p class="text-gray-900 font-semibold">{{ $user->city }}</p>
                        </div>
                        <div>
                            <p class="text-xs font-bold text-gray-600 uppercase">Province</p>
                            <p class="text-gray-900 font-semibold">{{ $user->province }}</p>
                        </div>
                        <div>
                            <p class="text-xs font-bold text-gray-600 uppercase">Zip Code</p>
                            <p class="text-gray-900 font-semibold">{{ $user->zip_code }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Emergency Contact -->
            <div class="bg-white overflow-hidden shadow-md sm:rounded-xl border border-gray-100">
                <div class="p-6 sm:p-8">
                    <h3 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
                        <svg class="w-6 h-6 mr-3 text-orange-600" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M6.62 10.79c1.44 2.83 3.76 5.14 6.59 6.59l2.2-2.2c.27-.27.67-.36 1.02-.24 1.12.37 2.33.57 3.57.57.55 0 1 .45 1 1V20c0 .55-.45 1-1 1-9.39 0-17-7.61-17-17 0-.55.45-1 1-1h3.5c.55 0 1 .45 1 1 0 1.25.2 2.45.57 3.57.11.35.03.74-.25 1.02l-2.2 2.2z"/>
                        </svg>
                        Emergency Contact
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <p class="text-xs font-bold text-gray-600 uppercase">Contact Name</p>
                            <p class="text-gray-900 font-semibold">{{ $user->emergency_contact_name }}</p>
                        </div>
                        <div>
                            <p class="text-xs font-bold text-gray-600 uppercase">Contact Number</p>
                            <p class="text-gray-900 font-semibold">{{ $user->emergency_contact_number }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Complaints -->
            <div class="bg-white overflow-hidden shadow-md sm:rounded-xl border border-gray-100">
                <div class="p-6 sm:p-8">
                    <h3 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
                        <svg class="w-6 h-6 mr-3 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        Complaints ({{ $complaints->count() }})
                    </h3>
                    @if ($complaints->count() > 0)
                        <div class="space-y-3">
                            @foreach ($complaints as $complaint)
                                <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition">
                                    <div class="flex items-start justify-between gap-4">
                                        <div class="flex-1">
                                            <h4 class="font-semibold text-gray-900">{{ $complaint->subject }}</h4>
                                            <p class="text-sm text-gray-600 mt-2">{{ Str::limit($complaint->description, 100) }}</p>
                                            <div class="mt-3 flex items-center gap-3 flex-wrap">
                                                <span class="px-2 py-1 text-xs font-bold rounded-full bg-{{ $complaint->status === 'pending' ? 'yellow' : ($complaint->status === 'validated' ? 'blue' : ($complaint->status === 'resolved' ? 'green' : 'red')) }}-100 text-{{ $complaint->status === 'pending' ? 'yellow' : ($complaint->status === 'validated' ? 'blue' : ($complaint->status === 'resolved' ? 'green' : 'red')) }}-800">
                                                    {{ ucfirst($complaint->status) }}
                                                </span>
                                                <span class="text-xs text-gray-600">{{ $complaint->created_at->diffForHumans() }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-center text-gray-600 py-8">No complaints filed by this citizen</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
