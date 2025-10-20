<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
                {{ __('My Complaints') }}
            </h2>
            <a href="{{ route('complaints.create') }}" class="px-4 py-2 bg-indigo-600 text-white font-medium rounded-lg hover:bg-indigo-700 transition flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                File New Complaint
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Filter and Search Section -->
            <div class="mb-6 bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form method="GET" action="{{ route('complaints.index') }}" class="flex gap-4 flex-wrap">
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
                    <button type="submit" class="px-6 py-2 bg-indigo-600 text-white font-medium rounded-lg hover:bg-indigo-700 transition">
                        Filter
                    </button>
                    @if(request('search') || request('status'))
                        <a href="{{ route('complaints.index') }}" class="px-6 py-2 bg-gray-300 text-gray-900 font-medium rounded-lg hover:bg-gray-400 transition">
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

                                        <!-- Meta Information -->
                                        <div class="flex flex-wrap gap-4 text-sm text-gray-600">
                                            <div class="flex items-center">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                </svg>
                                                {{ $complaint->created_at->format('M d, Y') }}
                                            </div>
                                            @if($complaint->location)
                                                <div class="flex items-center">
                                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    </svg>
                                                    {{ Str::limit($complaint->location, 40) }}
                                                </div>
                                            @endif
                                            @if($complaint->media && $complaint->media->count() > 0)
                                                <div class="flex items-center">
                                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                    </svg>
                                                    {{ $complaint->media->count() }} {{ $complaint->media->count() === 1 ? 'file' : 'files' }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>

                                    <!-- Action Button -->
                                    <div class="ml-4 flex flex-col gap-2">
                                        <a href="{{ route('complaints.show', $complaint) }}" class="px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-lg hover:bg-indigo-700 transition text-center whitespace-nowrap">
                                            View Details
                                        </a>
                                        @if($complaint->status === 'pending')
                                            <a href="{{ route('complaints.edit', $complaint) }}" class="px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition text-center whitespace-nowrap">
                                                Edit
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
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
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        <h3 class="mt-2 text-lg font-semibold text-gray-900">No complaints yet</h3>
                        <p class="mt-1 text-gray-600">Start by filing a new complaint about an issue in your barangay.</p>
                        <div class="mt-4">
                            <a href="{{ route('complaints.create') }}" class="px-6 py-2 bg-indigo-600 text-white font-medium rounded-lg hover:bg-indigo-700 transition inline-flex items-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                </svg>
                                File a Complaint
                            </a>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
