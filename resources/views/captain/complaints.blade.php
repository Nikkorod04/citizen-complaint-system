<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
                {{ __('All Complaints') }}
            </h2>
            <a href="{{ route('captain.dashboard') }}" class="text-sm text-indigo-600 hover:text-indigo-800 font-medium flex items-center">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Back to Dashboard
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Filter Section -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 mb-6">
                <form method="GET" action="{{ route('captain.complaints') }}" class="flex gap-4 flex-wrap">
                    <div class="flex-1 min-w-64">
                        <input type="text" name="search" placeholder="Search by subject or complaint #..." value="{{ request('search') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500">
                    </div>
                    <div>
                        <select name="status" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500">
                            <option value="">All Status</option>
                            <option value="pending" @selected(request('status') === 'pending')>Pending</option>
                            <option value="validated" @selected(request('status') === 'validated')>Validated</option>
                            <option value="in_progress" @selected(request('status') === 'in_progress')>In Progress</option>
                            <option value="resolved" @selected(request('status') === 'resolved')>Resolved</option>
                            <option value="rejected" @selected(request('status') === 'rejected')>Rejected</option>
                        </select>
                    </div>
                    <div>
                        <select name="category" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500">
                            <option value="">All Categories</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" @selected(request('category') == $category->id)>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="px-6 py-2 bg-indigo-600 text-white font-medium rounded-lg hover:bg-indigo-700 transition">
                        Filter
                    </button>
                    @if(request('search') || request('status') || request('category'))
                        <a href="{{ route('captain.complaints') }}" class="px-6 py-2 bg-gray-300 text-gray-900 font-medium rounded-lg hover:bg-gray-400 transition">
                            Clear
                        </a>
                    @endif
                </form>
            </div>

            <!-- Complaints List -->
            @if($complaints->count() > 0)
                <div class="space-y-4">
                    @foreach($complaints as $complaint)
                        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg hover:shadow-lg transition">
                            <div class="p-6">
                                <div class="flex items-start justify-between">
                                    <div class="flex-1">
                                        <!-- Header with Status -->
                                        <div class="flex items-center space-x-3 mb-3">
                                            <span class="px-3 py-1 text-xs font-semibold rounded-full 
                                                @if($complaint->status === 'pending') bg-yellow-100 text-yellow-800
                                                @elseif($complaint->status === 'validated') bg-blue-100 text-blue-800
                                                @elseif($complaint->status === 'in_progress') bg-purple-100 text-purple-800
                                                @elseif($complaint->status === 'resolved') bg-green-100 text-green-800
                                                @elseif($complaint->status === 'rejected') bg-red-100 text-red-800
                                                @endif">
                                                {{ strtoupper($complaint->status) }}
                                            </span>
                                            <span class="px-3 py-1 text-xs font-medium rounded-full bg-indigo-100 text-indigo-700">
                                                {{ $complaint->category->name }}
                                            </span>
                                            <span class="text-xs text-gray-600">
                                                #{{ str_pad($complaint->id, 4, '0', STR_PAD_LEFT) }}
                                            </span>
                                        </div>

                                        <!-- Subject and Description -->
                                        <h3 class="text-lg font-semibold text-gray-900 mb-2">
                                            {{ $complaint->subject }}
                                        </h3>
                                        <p class="text-gray-700 text-sm line-clamp-2 mb-3">
                                            {{ Str::limit($complaint->description, 150) }}
                                        </p>

                                        <!-- Complainant Info -->
                                        <div class="flex items-center space-x-4 text-sm text-gray-600 mb-3">
                                            <div class="flex items-center">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                                </svg>
                                                <strong>{{ $complaint->user->full_name }}</strong>
                                            </div>
                                            <div class="flex items-center">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8a6 6 0 016-6h8a6 6 0 016 6v9a6 6 0 01-6 6H9a6 6 0 01-6-6V8z" />
                                                </svg>
                                                {{ $complaint->user->email }}
                                            </div>
                                        </div>

                                        <!-- Meta Information -->
                                        <div class="flex flex-wrap gap-4 text-sm text-gray-600 border-t pt-3">
                                            <div class="flex items-center">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                </svg>
                                                Filed: {{ $complaint->created_at->format('M d, Y') }}
                                            </div>
                                            @if($complaint->validated_at)
                                                <div class="flex items-center">
                                                    <svg class="w-4 h-4 mr-1 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4" />
                                                    </svg>
                                                    Validated: {{ $complaint->validated_at->format('M d, Y') }}
                                                </div>
                                            @endif
                                            @if($complaint->resolved_at)
                                                <div class="flex items-center">
                                                    <svg class="w-4 h-4 mr-1 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4" />
                                                    </svg>
                                                    Resolved: {{ $complaint->resolved_at->format('M d, Y') }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>

                                    <!-- Action Buttons -->
                                    <div class="ml-4 flex flex-col gap-2">
                                        <a href="{{ route('captain.complaints.show', $complaint) }}" class="px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-lg hover:bg-indigo-700 transition text-center whitespace-nowrap">
                                            View Details
                                        </a>
                                        @if($complaint->status === 'validated')
                                            <button onclick="markInProgress({{ $complaint->id }})" class="px-4 py-2 bg-purple-600 text-white text-sm font-medium rounded-lg hover:bg-purple-700 transition">
                                                Start
                                            </button>
                                        @elseif($complaint->status === 'in_progress')
                                            <button onclick="document.getElementById('resolve-{{ $complaint->id }}').style.display = 'block'" class="px-4 py-2 bg-green-600 text-white text-sm font-medium rounded-lg hover:bg-green-700 transition">
                                                Resolve
                                            </button>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Quick Resolve Modal -->
                        @if($complaint->status === 'in_progress')
                            <div id="resolve-{{ $complaint->id }}" style="display: none;" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
                                <div class="bg-white rounded-lg shadow-lg p-6 max-w-2xl w-full mx-4">
                                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Resolve Complaint #{{ str_pad($complaint->id, 4, '0', STR_PAD_LEFT) }}</h3>
                                    
                                    <form action="{{ route('captain.complaints.resolve', $complaint) }}" method="POST">
                                        @csrf
                                        
                                        <div class="mb-4">
                                            <label class="block text-sm font-medium text-gray-900 mb-2">Resolution <span class="text-red-600">*</span></label>
                                            <textarea name="captain_resolution" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500" rows="4" placeholder="Describe the resolution..."></textarea>
                                        </div>

                                        <div class="mb-4">
                                            <label class="block text-sm font-medium text-gray-900 mb-2">Recommendation</label>
                                            <textarea name="recommendation" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500" rows="3" placeholder="Any recommendations for future..."></textarea>
                                        </div>

                                        <div class="flex gap-3">
                                            <button type="submit" class="flex-1 bg-green-600 text-white font-medium py-2 px-4 rounded-lg hover:bg-green-700 transition">
                                                Mark as Resolved
                                            </button>
                                            <button type="button" onclick="document.getElementById('resolve-{{ $complaint->id }}').style.display = 'none'" class="flex-1 bg-gray-300 text-gray-900 font-medium py-2 px-4 rounded-lg hover:bg-gray-400 transition">
                                                Cancel
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="mt-6">
                    {{ $complaints->links() }}
                </div>
            @else
                <!-- Empty State -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-12">
                    <div class="text-center">
                        <svg class="mx-auto h-12 w-12 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                        </svg>
                        <h3 class="mt-2 text-lg font-semibold text-gray-900">No complaints found</h3>
                        <p class="mt-1 text-gray-600">Try adjusting your filters</p>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <script>
        function markInProgress(complaintId) {
            if (confirm('Mark this complaint as in progress?')) {
                fetch(`/captain/complaints/${complaintId}/in-progress`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Content-Type': 'application/json'
                    }
                })
                .then(response => {
                    if (response.ok) {
                        location.reload();
                    }
                })
                .catch(error => console.error('Error:', error));
            }
        }
    </script>
</x-app-layout>
