<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
                {{ __('Barangay Tanod Dashboard') }}
            </h2>
            <div class="text-sm text-gray-600">
                {{ now()->format('l, F j, Y') }}
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <!-- Statistics Cards -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                <!-- Pending Requests -->
                <div class="bg-gradient-to-br from-yellow-500 to-yellow-600 rounded-xl shadow-lg p-6 text-white">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-yellow-100 text-sm font-medium">Pending Requests</p>
                            <p class="text-3xl font-bold mt-2">{{ $stats['pending'] }}</p>
                        </div>
                        <div class="bg-white bg-opacity-20 rounded-full p-3">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Assigned to Me -->
                <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl shadow-lg p-6 text-white">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-blue-100 text-sm font-medium">Assigned to Me</p>
                            <p class="text-3xl font-bold mt-2">{{ $stats['assigned'] }}</p>
                        </div>
                        <div class="bg-white bg-opacity-20 rounded-full p-3">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Active Responses -->
                <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl shadow-lg p-6 text-white">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-purple-100 text-sm font-medium">Active Responses</p>
                            <p class="text-3xl font-bold mt-2">{{ $stats['active'] }}</p>
                        </div>
                        <div class="bg-white bg-opacity-20 rounded-full p-3">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Resolved Today -->
                <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-xl shadow-lg p-6 text-white">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-green-100 text-sm font-medium">Resolved Today</p>
                            <p class="text-3xl font-bold mt-2">{{ $stats['resolved_today'] }}</p>
                        </div>
                        <div class="bg-white bg-opacity-20 rounded-full p-3">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Content Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Active Requests -->
                <div class="lg:col-span-2 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-6">
                            <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                                <svg class="w-6 h-6 mr-2 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                                </svg>
                                Currently Active Requests
                            </h3>
                            <a href="{{ route('tanod.assigned') }}" class="text-sm text-indigo-600 hover:text-indigo-800 font-medium flex items-center">
                                View All
                                <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                            </a>
                        </div>

                        @if ($activeRequests->count() > 0)
                            <div class="space-y-3">
                                @foreach ($activeRequests as $request)
                                    <div class="border-l-4 border-purple-500 bg-purple-50 p-4 rounded-lg hover:shadow-md transition">
                                        <div class="flex justify-between items-start">
                                            <div class="flex-1">
                                                <p class="font-semibold text-gray-900">{{ $request->title }}</p>
                                                <p class="text-sm text-gray-600 mt-1">{{ $request->location }}</p>
                                                <span class="inline-block mt-2 px-2 py-1 text-xs font-semibold rounded {{ $request->getStatusColor() }}">
                                                    {{ ucfirst(str_replace('_', ' ', $request->status)) }}
                                                </span>
                                            </div>
                                            <a href="{{ route('tanod.show', $request->id) }}" class="ml-2 text-indigo-600 hover:text-indigo-800 font-medium">→</a>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-center text-gray-500 py-4">No active requests at the moment</p>
                        @endif
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                            <svg class="w-6 h-6 mr-2 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                            </svg>
                            Quick Actions
                        </h3>
                        <div class="space-y-2">
                            <a href="{{ route('tanod.pending') }}" class="block w-full text-left px-4 py-3 bg-yellow-50 hover:bg-yellow-100 rounded-lg transition font-medium text-yellow-800">
                                📋 View Pending Requests
                            </a>
                            <a href="{{ route('tanod.assigned') }}" class="block w-full text-left px-4 py-3 bg-blue-50 hover:bg-blue-100 rounded-lg transition font-medium text-blue-800">
                                ✓ My Assigned Requests
                            </a>
                            <a href="{{ route('tanod.resolved') }}" class="block w-full text-left px-4 py-3 bg-green-50 hover:bg-green-100 rounded-lg transition font-medium text-green-800">
                                ✓ Resolved Requests
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Requests -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                        <svg class="w-6 h-6 mr-2 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        Recent Requests
                    </h3>

                    @if ($recentRequests->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="w-full text-sm">
                                <thead>
                                    <tr class="border-b border-gray-200 bg-gray-50">
                                        <th class="px-4 py-3 text-left font-semibold text-gray-700">Title</th>
                                        <th class="px-4 py-3 text-left font-semibold text-gray-700">Category</th>
                                        <th class="px-4 py-3 text-left font-semibold text-gray-700">Status</th>
                                        <th class="px-4 py-3 text-left font-semibold text-gray-700">Priority</th>
                                        <th class="px-4 py-3 text-left font-semibold text-gray-700">Submitted</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($recentRequests as $request)
                                        <tr class="border-b border-gray-100 hover:bg-gray-50">
                                            <td class="px-4 py-3">
                                                <a href="{{ route('tanod.show', $request->id) }}" class="text-indigo-600 hover:text-indigo-800 font-medium">
                                                    {{ Str::limit($request->title, 30) }}
                                                </a>
                                            </td>
                                            <td class="px-4 py-3 text-gray-600">{{ ucfirst($request->category) }}</td>
                                            <td class="px-4 py-3">
                                                <span class="px-2 py-1 text-xs font-semibold rounded-full {{ $request->getStatusColor() }}">
                                                    {{ ucfirst(str_replace('_', ' ', $request->status)) }}
                                                </span>
                                            </td>
                                            <td class="px-4 py-3">
                                                <span class="px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">
                                                    {{ ucfirst($request->priority) }}
                                                </span>
                                            </td>
                                            <td class="px-4 py-3 text-gray-600">{{ $request->submitted_at->format('M d, H:i') }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-center text-gray-500 py-4">No requests yet</p>
                    @endif
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
