<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
                {{ __('My Urgent Requests') }}
            </h2>
            <a href="{{ route('urgent-requests.create') }}" class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white font-medium rounded-lg transition">
                + Submit Urgent Request
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if ($urgentRequests->count() > 0)
                <div class="grid grid-cols-1 gap-6">
                    @foreach ($urgentRequests as $request)
                        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border-l-4 border-red-500">
                            <div class="p-6">
                                <div class="flex justify-between items-start mb-4">
                                    <div class="flex-1">
                                        <h3 class="text-xl font-bold text-gray-900">{{ $request->title }}</h3>
                                        <p class="text-sm text-gray-600 mt-1">Request ID: #{{ $request->id }}</p>
                                    </div>
                                    <span class="px-3 py-1 text-xs font-semibold rounded-full {{ $request->getStatusColor() }}">
                                        {{ ucfirst(str_replace('_', ' ', $request->status)) }}
                                    </span>
                                </div>

                                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-4 pb-4 border-b border-gray-200">
                                    <div>
                                        <p class="text-xs text-gray-600 font-medium">Category</p>
                                        <p class="text-sm font-semibold text-gray-900">{{ ucfirst($request->category) }}</p>
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-600 font-medium">Priority</p>
                                        <p class="text-sm font-semibold">
                                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">
                                                {{ ucfirst($request->priority) }}
                                            </span>
                                        </p>
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-600 font-medium">Location</p>
                                        <p class="text-sm font-semibold text-gray-900">{{ $request->location }}</p>
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-600 font-medium">Submitted</p>
                                        <p class="text-sm font-semibold text-gray-900">{{ $request->submitted_at->format('M d, H:i') }}</p>
                                    </div>
                                </div>

                                <p class="text-gray-700 mb-4">{{ Str::limit($request->description, 150) }}</p>

                                <div class="flex gap-2">
                                    <a href="{{ route('urgent-requests.show', $request->id) }}" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition">
                                        View Details
                                    </a>
                                    <a href="{{ route('urgent-requests.track', $request->id) }}" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-lg transition">
                                        Track Status
                                    </a>
                                    @if (in_array($request->status, ['submitted', 'assigned']))
                                        <form method="POST" action="{{ route('urgent-requests.cancel', $request->id) }}" style="display: inline;">
                                            @csrf
                                            <button type="submit" class="px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white font-medium rounded-lg transition" onclick="return confirm('Are you sure?')">
                                                Cancel Request
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="mt-6">
                    {{ $urgentRequests->links() }}
                </div>
            @else
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-12 text-center">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        <p class="mt-4 text-gray-600 text-lg">No urgent requests submitted yet.</p>
                        <a href="{{ route('urgent-requests.create') }}" class="mt-4 inline-block px-6 py-2 bg-red-600 hover:bg-red-700 text-white font-medium rounded-lg transition">
                            Submit Your First Request
                        </a>
                    </div>
                </div>
            @endif

        </div>
    </div>
</x-app-layout>
