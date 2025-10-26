<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
                    {{ __('My Active Requests') }}
                </h2>
                <p class="text-sm text-gray-600 mt-1">Requests assigned, in progress, or on the way</p>
            </div>
            <a href="{{ route('tanod.dashboard') }}" class="text-indigo-600 hover:text-indigo-800 font-medium flex items-center">
                Back to Dashboard
                <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            
            @if ($assignedRequests->count() > 0)
                <div class="grid grid-cols-1 gap-6">
                    @foreach ($assignedRequests as $request)
                        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border-l-4 border-blue-500">
                            <div class="p-6">
                                <div class="flex justify-between items-start mb-4">
                                    <div>
                                        <h3 class="text-xl font-bold text-gray-900">{{ $request->title }}</h3>
                                        <p class="text-sm text-gray-600 mt-1">
                                            From: <span class="font-semibold">{{ $request->citizen->full_name }}</span>
                                        </p>
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
                                        <p class="text-xs text-gray-600 font-medium">Contact</p>
                                        <p class="text-sm font-semibold text-gray-900">{{ $request->citizen->phone }}</p>
                                    </div>
                                </div>

                                <p class="text-gray-700 mb-4">{{ Str::limit($request->description, 200) }}</p>

                                <div class="flex gap-2">
                                    <a href="{{ route('tanod.show', $request->id) }}" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition">
                                        View & Respond
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="mt-6">
                    {{ $assignedRequests->links() }}
                </div>
            @else
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-12 text-center">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        <p class="mt-4 text-gray-600 text-lg">No requests assigned to you yet.</p>
                        <a href="{{ route('tanod.pending') }}" class="mt-4 inline-block px-6 py-2 bg-yellow-600 hover:bg-yellow-700 text-white font-medium rounded-lg transition">
                            View Pending Requests
                        </a>
                    </div>
                </div>
            @endif

        </div>
    </div>
</x-app-layout>
