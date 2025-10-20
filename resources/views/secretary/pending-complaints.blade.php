<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
                {{ __('Pending Complaints for Validation') }}
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
            
            @if($complaints->count() > 0)
                <div class="space-y-4">
                    @foreach($complaints as $complaint)
                        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg hover:shadow-lg transition">
                            <div class="p-6">
                                <!-- Header -->
                                <div class="flex items-start justify-between mb-4">
                                    <div>
                                        <div class="flex items-center space-x-3 mb-2">
                                            <span class="px-3 py-1 text-sm font-semibold rounded-full bg-orange-100 text-orange-800">
                                                #{{ str_pad($complaint->id, 4, '0', STR_PAD_LEFT) }}
                                            </span>
                                            <span class="px-3 py-1 text-sm font-semibold rounded-full bg-orange-200 text-orange-900">
                                                {{ strtoupper($complaint->status) }}
                                            </span>
                                            <span class="px-3 py-1 text-sm font-medium rounded-full bg-purple-100 text-purple-700">
                                                {{ $complaint->category->name }}
                                            </span>
                                        </div>
                                        <h3 class="text-2xl font-bold text-gray-900">{{ Str::limit($complaint->description, 120) }}</h3>
                                        <p class="text-sm text-gray-500 mt-1">
                                            Submitted {{ $complaint->created_at->format('F j, Y \a\t g:i A') }}
                                        </p>
                                    </div>
                                </div>

                                <!-- Complaint Details -->
                                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
                                    <!-- Left Column: Complaint Info -->
                                    <div class="lg:col-span-2">
                                        <div class="space-y-4">
                                            <!-- Complainant Information -->
                                            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                                                <h4 class="text-sm font-semibold text-blue-900 mb-3">Complainant Information</h4>
                                                <div class="space-y-2 text-sm">
                                                    <div class="flex justify-between">
                                                        <span class="text-blue-700">Name:</span>
                                                        <span class="font-medium text-gray-900">{{ $complaint->user->full_name }}</span>
                                                    </div>
                                                    <div class="flex justify-between">
                                                        <span class="text-blue-700">Email:</span>
                                                        <span class="font-medium text-gray-900">{{ $complaint->user->email }}</span>
                                                    </div>
                                                    <div class="flex justify-between">
                                                        <span class="text-blue-700">Phone:</span>
                                                        <span class="font-medium text-gray-900">{{ $complaint->user->phone }}</span>
                                                    </div>
                                                    <div class="flex justify-between">
                                                        <span class="text-blue-700">National ID:</span>
                                                        <span class="font-mono font-bold text-gray-900">{{ $complaint->user->national_id }}</span>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Complaint Details -->
                                            <div class="bg-gray-50 border border-gray-200 rounded-lg p-4">
                                                <h4 class="text-sm font-semibold text-gray-900 mb-3">Complaint Details</h4>
                                                <div class="space-y-3 text-sm">
                                                    @if($complaint->location)
                                                        <div>
                                                            <span class="block text-gray-600 font-medium mb-1">📍 Location:</span>
                                                            <span class="text-gray-900">{{ $complaint->location }}</span>
                                                        </div>
                                                    @endif
                                                    
                                                    @if($complaint->description)
                                                        <div>
                                                            <span class="block text-gray-600 font-medium mb-1">📝 Description:</span>
                                                            <span class="text-gray-900">{{ $complaint->description }}</span>
                                                        </div>
                                                    @endif

                                                    @if($complaint->category->republic_act)
                                                        <div>
                                                            <span class="block text-gray-600 font-medium mb-1">📋 Related Law:</span>
                                                            <span class="text-gray-900">{{ $complaint->category->republic_act }}</span>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Right Column: Attachments & Status -->
                                    <div>
                                        <!-- Attachments -->
                                        @if($complaint->media && $complaint->media->count() > 0)
                                            <div class="bg-purple-50 border border-purple-200 rounded-lg p-4">
                                                <h4 class="text-sm font-semibold text-purple-900 mb-3">📎 Attachments ({{ $complaint->media->count() }})</h4>
                                                <div class="space-y-2">
                                                    @foreach($complaint->media as $media)
                                                        <a href="{{ $media->getUrl() }}" 
                                                           target="_blank" 
                                                           class="block p-2 bg-white border border-purple-200 rounded hover:bg-purple-50 transition text-sm text-purple-600 hover:text-purple-700 truncate">
                                                            📄 {{ $media->file_name }}
                                                        </a>
                                                    @endforeach
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <!-- Secretary Notes Section -->
                                <div class="border-t border-gray-200 pt-6">
                                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                                        <!-- Validate Form -->
                                        <form action="{{ route('secretary.complaints.validate', $complaint) }}" method="POST" class="bg-green-50 border border-green-200 rounded-lg p-4">
                                            @csrf
                                            <h4 class="text-sm font-semibold text-green-900 mb-3 flex items-center">
                                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                                Approve Complaint
                                            </h4>
                                            <div class="mb-3">
                                                <label class="block text-sm text-green-700 font-medium mb-1">
                                                    Secretary Notes (Optional)
                                                </label>
                                                <textarea name="secretary_notes" 
                                                          rows="3" 
                                                          placeholder="Add any notes for the Captain..." 
                                                          class="w-full px-3 py-2 border border-green-300 rounded-lg text-sm focus:ring-2 focus:ring-green-500 focus:border-transparent"></textarea>
                                                @error('secretary_notes')
                                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                                @enderror
                                            </div>
                                            <button type="submit" class="w-full px-4 py-2 bg-green-600 text-white font-medium text-sm rounded-lg hover:bg-green-700 transition flex items-center justify-center">
                                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                                </svg>
                                                Validate & Send to Captain
                                            </button>
                                        </form>

                                        <!-- Reject Form -->
                                        <form action="{{ route('secretary.complaints.reject', $complaint) }}" method="POST" class="bg-red-50 border border-red-200 rounded-lg p-4">
                                            @csrf
                                            <h4 class="text-sm font-semibold text-red-900 mb-3 flex items-center">
                                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                </svg>
                                                Reject Complaint
                                            </h4>
                                            <div class="mb-3">
                                                <label class="block text-sm text-red-700 font-medium mb-1">
                                                    Reason for Rejection <span class="text-red-600">*</span>
                                                </label>
                                                <textarea name="secretary_notes" 
                                                          rows="3" 
                                                          placeholder="Explain why this complaint is being rejected..." 
                                                          required
                                                          class="w-full px-3 py-2 border border-red-300 rounded-lg text-sm focus:ring-2 focus:ring-red-500 focus:border-transparent"></textarea>
                                                @error('secretary_notes')
                                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                                @enderror
                                            </div>
                                            <button type="submit" class="w-full px-4 py-2 bg-red-600 text-white font-medium text-sm rounded-lg hover:bg-red-700 transition flex items-center justify-center" onclick="return confirm('Are you sure you want to reject this complaint?')">
                                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                                Reject Complaint
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="mt-8">
                    {{ $complaints->links() }}
                </div>
            @else
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-12 text-center">
                        <svg class="mx-auto h-16 w-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <h3 class="mt-6 text-lg font-medium text-gray-900">All processed!</h3>
                        <p class="mt-2 text-gray-500">There are no pending complaints for validation at the moment.</p>
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
</x-app-layout>
