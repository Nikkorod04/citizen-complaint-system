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
            @if($complaints->count() > 0)
                <div class="space-y-4">
                    @foreach($complaints as $complaint)
                        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg hover:shadow-lg transition">
                            <div class="p-6">
                                <div class="flex items-start justify-between">
                                    <div class="flex-1">
                                        <!-- Header with Status -->
                                        <div class="flex items-center space-x-3 mb-2">
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
                                            <span class="px-2 py-1 text-xs rounded bg-gray-100 text-gray-600">
                                                #{{ str_pad($complaint->id, 4, '0', STR_PAD_LEFT) }}
                                            </span>
                                        </div>

                                        <!-- Complaint Title and Description -->
                                        <h3 class="text-lg font-semibold text-gray-900 mb-2">
                                            {{ $complaint->subject }}
                                        </h3>
                                        <p class="text-gray-600 text-sm mb-3">
                                            {{ Str::limit($complaint->description, 150) }}
                                        </p>

                                        <!-- Complaint Meta Info -->
                                        <div class="flex flex-wrap gap-4 text-sm text-gray-500">
                                            <span class="flex items-center">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                                {{ $complaint->created_at->format('M d, Y') }}
                                            </span>
                                            @if($complaint->location)
                                                <span class="flex items-center">
                                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    </svg>
                                                    {{ Str::limit($complaint->location, 40) }}
                                                </span>
                                            @endif
                                            @if($complaint->media && $complaint->media->count() > 0)
                                                <span class="flex items-center">
                                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 14.172l2.828-2.828m0 0a4 4 0 10-5.656 0l5.656 5.656a4 4 0 010-5.656z" />
                                                    </svg>
                                                    {{ $complaint->media->count() }} attachment(s)
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                    <!-- Action Button -->
                                    <div class="ml-6 flex-shrink-0">
                                        <a href="{{ route('complaints.show', $complaint) }}" class="px-4 py-2 bg-indigo-600 text-white font-medium text-sm rounded-lg hover:bg-indigo-700 transition flex items-center whitespace-nowrap">
                                            View Details
                                            <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                            </svg>
                                        </a>
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
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        <h3 class="mt-6 text-lg font-semibold text-gray-900">No complaints yet</h3>
                        <p class="mt-2 text-gray-600 mb-6">You haven't filed any complaints yet. Start by filing your first complaint.</p>
                        <a href="{{ route('complaints.create') }}" class="inline-flex items-center px-6 py-2 bg-indigo-600 text-white font-medium rounded-lg hover:bg-indigo-700 transition">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                            </svg>
                            File a Complaint
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
