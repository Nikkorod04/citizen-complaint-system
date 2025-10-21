<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
                {{ __('Complaint Details') }}
            </h2>
            <a href="{{ route('captain.complaints') }}" class="text-sm text-indigo-600 hover:text-indigo-800 font-medium flex items-center">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Back to Complaints
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <!-- Header Card -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 border-b border-gray-200">
                    <div class="flex items-start justify-between mb-4">
                        <div>
                            <div class="flex items-center space-x-3 mb-2">
                                <span class="px-4 py-2 text-sm font-semibold rounded-full 
                                    @if($complaint->status === 'pending') bg-yellow-100 text-yellow-800
                                    @elseif($complaint->status === 'validated') bg-blue-100 text-blue-800
                                    @elseif($complaint->status === 'in_progress') bg-purple-100 text-purple-800
                                    @elseif($complaint->status === 'resolved') bg-green-100 text-green-800
                                    @elseif($complaint->status === 'rejected') bg-red-100 text-red-800
                                    @endif">
                                    {{ strtoupper($complaint->status) }}
                                </span>
                                <span class="px-4 py-2 text-sm font-medium rounded-full bg-indigo-100 text-indigo-700">
                                    {{ $complaint->category->name }}
                                </span>
                            </div>
                            <h3 class="text-3xl font-bold text-gray-900 mb-2">
                                {{ $complaint->subject }}
                            </h3>
                            <p class="text-sm text-gray-600">
                                Complaint #{{ str_pad($complaint->id, 4, '0', STR_PAD_LEFT) }} 
                                • Filed on {{ $complaint->created_at->format('F j, Y \a\t g:i A') }}
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Complaint Details -->
                <div class="p-6 space-y-6">
                    <!-- Description -->
                    <div>
                        <h4 class="font-semibold text-gray-900 mb-2">Description</h4>
                        <p class="text-gray-700 whitespace-pre-wrap">{{ $complaint->description }}</p>
                    </div>

                    <!-- Location -->
                    @if($complaint->location)
                        <div>
                            <h4 class="font-semibold text-gray-900 mb-2">📍 Location</h4>
                            <p class="text-gray-700">{{ $complaint->location }}</p>
                        </div>
                    @endif

                    <!-- Complainant Info -->
                    <div class="bg-blue-50 p-4 rounded-lg border border-blue-200">
                        <h4 class="font-semibold text-gray-900 mb-3">Complainant Information</h4>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <p class="text-sm text-gray-600">Full Name</p>
                                <p class="font-medium text-gray-900">{{ $complaint->user->full_name }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Email</p>
                                <p class="font-medium text-gray-900">{{ $complaint->user->email }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Phone</p>
                                <p class="font-medium text-gray-900">{{ $complaint->user->phone ?? 'N/A' }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">National ID</p>
                                <p class="font-medium text-gray-900">{{ $complaint->user->national_id }}</p>
                            </div>
                            <div class="col-span-2">
                                <p class="text-sm text-gray-600">Address</p>
                                <p class="font-medium text-gray-900">
                                    {{ $complaint->user->house_number }} {{ $complaint->user->street }}, 
                                    {{ $complaint->user->barangay }}, {{ $complaint->user->city }}, {{ $complaint->user->province }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Meta Information -->
                    <div class="grid grid-cols-2 gap-4 pt-4 border-t">
                        <div>
                            <h4 class="font-semibold text-gray-900 mb-1">Category</h4>
                            <p class="text-gray-700">{{ $complaint->category->name }}</p>
                        </div>
                        @if($complaint->category->republic_act)
                            <div>
                                <h4 class="font-semibold text-gray-900 mb-1">Related Law</h4>
                                <p class="text-gray-700">{{ $complaint->category->republic_act }}</p>
                            </div>
                        @endif
                        <div>
                            <h4 class="font-semibold text-gray-900 mb-1">Complaint Status</h4>
                            <p class="text-gray-700 capitalize">{{ str_replace('_', ' ', $complaint->status) }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Evidence -->
            @if($complaint->media && $complaint->media->count() > 0)
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                    <div class="p-6">
                        <h4 class="font-semibold text-gray-900 mb-4 flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Evidence ({{ $complaint->media->count() }})
                        </h4>
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                            @foreach($complaint->media as $media)
                                <div class="relative group">
                                    @if(str_starts_with($media->mime_type, 'image/'))
                                        <img src="{{ $media->getUrl() }}" alt="Evidence" class="w-full h-48 object-cover rounded-lg cursor-pointer hover:opacity-80 transition" onclick="viewMedia('{{ $media->getUrl() }}')">
                                    @else
                                        <div class="w-full h-48 bg-gray-200 rounded-lg flex items-center justify-center cursor-pointer hover:bg-gray-300 transition" onclick="downloadMedia('{{ $media->getUrl() }}', '{{ $media->file_name }}')">
                                            <div class="text-center">
                                                <svg class="w-12 h-12 text-gray-400 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                                <p class="text-xs text-gray-600">Video</p>
                                            </div>
                                        </div>
                                    @endif
                                    <p class="text-xs text-gray-600 mt-2 text-center truncate">{{ $media->file_name }}</p>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif

            <!-- Processing Information -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 space-y-4">
                    <h4 class="font-semibold text-gray-900">Processing Timeline</h4>
                    
                    <div class="space-y-4">
                        <!-- Filed -->
                        <div class="flex space-x-4">
                            <div class="flex-shrink-0">
                                <div class="flex items-center justify-center h-10 w-10 rounded-full bg-gray-100">
                                    <svg class="h-6 w-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                </div>
                            </div>
                            <div>
                                <h5 class="font-semibold text-gray-900">Filed</h5>
                                <p class="text-sm text-gray-600">{{ $complaint->created_at->format('F j, Y \a\t g:i A') }}</p>
                            </div>
                        </div>

                        <!-- Validated -->
                        @if($complaint->validated_at && $complaint->validator)
                            <div class="flex space-x-4">
                                <div class="flex-shrink-0">
                                    <div class="flex items-center justify-center h-10 w-10 rounded-full bg-blue-100">
                                        <svg class="h-6 w-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4" />
                                        </svg>
                                    </div>
                                </div>
                                <div>
                                    <h5 class="font-semibold text-gray-900">Validated by Secretary</h5>
                                    <p class="text-sm text-gray-600">{{ $complaint->validated_at->format('F j, Y \a\t g:i A') }}</p>
                                    <p class="text-sm text-gray-600">Secretary: {{ $complaint->validator->full_name }}</p>
                                    @if($complaint->secretary_notes)
                                        <p class="text-sm text-gray-700 mt-1"><strong>Notes:</strong> {{ $complaint->secretary_notes }}</p>
                                    @endif
                                </div>
                            </div>
                        @endif

                        <!-- Resolved -->
                        @if($complaint->resolved_at && $complaint->resolver)
                            <div class="flex space-x-4">
                                <div class="flex-shrink-0">
                                    <div class="flex items-center justify-center h-10 w-10 rounded-full bg-green-100">
                                        <svg class="h-6 w-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4" />
                                        </svg>
                                    </div>
                                </div>
                                <div>
                                    <h5 class="font-semibold text-gray-900">Resolved</h5>
                                    <p class="text-sm text-gray-600">{{ $complaint->resolved_at->format('F j, Y \a\t g:i A') }}</p>
                                    <p class="text-sm text-gray-600">Resolved by: {{ $complaint->resolver->full_name }}</p>
                                    @if($complaint->captain_resolution)
                                        <p class="text-sm text-gray-700 mt-1"><strong>Resolution:</strong> {{ $complaint->captain_resolution }}</p>
                                    @endif
                                    @if($complaint->recommendation)
                                        <p class="text-sm text-gray-700 mt-1"><strong>Recommendation:</strong> {{ $complaint->recommendation }}</p>
                                    @endif
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            @if($complaint->status === 'validated')
                <div class="flex gap-4 justify-center mb-6">
                    <form action="{{ route('captain.complaints.in-progress', $complaint) }}" method="POST" class="flex-1">
                        @csrf
                        @method('POST')
                        <button type="submit" class="w-full px-6 py-3 bg-purple-600 text-white font-medium rounded-lg hover:bg-purple-700 transition flex items-center justify-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Mark as In Progress
                        </button>
                    </form>
                </div>
            @elseif($complaint->status === 'in_progress')
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h4 class="font-semibold text-gray-900 mb-4">Resolve Complaint</h4>
                    
                    <form action="{{ route('captain.complaints.resolve', $complaint) }}" method="POST">
                        @csrf
                        @method('POST')

                        <div class="mb-4">
                            <label for="captain_resolution" class="block text-sm font-semibold text-gray-900 mb-2">
                                Resolution <span class="text-red-600">*</span>
                            </label>
                            <textarea id="captain_resolution" name="captain_resolution" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500" rows="5" placeholder="Describe the resolution taken..."></textarea>
                            @error('captain_resolution')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-6">
                            <label for="recommendation" class="block text-sm font-semibold text-gray-900 mb-2">
                                Recommendations (Optional)
                            </label>
                            <textarea id="recommendation" name="recommendation" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500" rows="4" placeholder="Any recommendations for preventing similar incidents..."></textarea>
                            @error('recommendation')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex gap-4">
                            <button type="submit" class="flex-1 px-6 py-3 bg-green-600 text-white font-medium rounded-lg hover:bg-green-700 transition flex items-center justify-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                Mark as Resolved
                            </button>
                            <a href="{{ route('captain.complaints') }}" class="flex-1 px-6 py-3 bg-gray-300 text-gray-900 font-medium rounded-lg hover:bg-gray-400 transition text-center">
                                Cancel
                            </a>
                        </div>
                    </form>
                </div>
            @endif
        </div>
    </div>

    <script>
        function viewMedia(url) {
            window.open(url, '_blank');
        }

        function downloadMedia(url, filename) {
            const link = document.createElement('a');
            link.href = url;
            link.download = filename;
            link.click();
        }
    </script>
</x-app-layout>
