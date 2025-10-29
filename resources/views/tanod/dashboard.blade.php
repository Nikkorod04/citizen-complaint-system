<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-bold text-3xl text-gray-900 leading-tight">
                    {{ __('Barangay Tanod Dashboard') }}
                </h2>
                <p class="text-sm text-gray-600 mt-1">Manage and respond to community requests</p>
            </div>
            <div class="text-right">
                <p class="text-sm font-medium text-gray-700">{{ now()->format('l') }}</p>
                <p class="text-xs text-gray-500">{{ now()->format('F j, Y') }}</p>
            </div>
        </div>
    </x-slot>

    <div class="py-12 bg-gradient-to-b from-amber-50/30 to-transparent min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
            <!-- Statistics Cards -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                <!-- Pending Requests -->
                <div class="bg-gradient-to-br from-amber-600 to-amber-700 rounded-xl shadow-lg p-6 text-white hover:shadow-xl transition transform hover:scale-105">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-amber-100 text-sm font-semibold opacity-90">Pending Requests</p>
                            <p class="text-4xl font-bold mt-3">{{ $stats['pending'] }}</p>
                        </div>
                        <div class="bg-white bg-opacity-20 rounded-full p-4 backdrop-blur-sm">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Assigned to Me -->
                <div class="bg-gradient-to-br from-blue-600 to-blue-700 rounded-xl shadow-lg p-6 text-white hover:shadow-xl transition transform hover:scale-105">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-blue-100 text-sm font-semibold opacity-90">Assigned to Me</p>
                            <p class="text-4xl font-bold mt-3">{{ $stats['assigned'] }}</p>
                        </div>
                        <div class="bg-white bg-opacity-20 rounded-full p-4 backdrop-blur-sm">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Active Responses -->
                <div class="bg-gradient-to-br from-purple-600 to-purple-700 rounded-xl shadow-lg p-6 text-white hover:shadow-xl transition transform hover:scale-105">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-purple-100 text-sm font-semibold opacity-90">Active Responses</p>
                            <p class="text-4xl font-bold mt-3">{{ $stats['active'] }}</p>
                        </div>
                        <div class="bg-white bg-opacity-20 rounded-full p-4 backdrop-blur-sm">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Resolved Today -->
                <div class="bg-gradient-to-br from-green-600 to-green-700 rounded-xl shadow-lg p-6 text-white hover:shadow-xl transition transform hover:scale-105">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-green-100 text-sm font-semibold opacity-90">Resolved Today</p>
                            <p class="text-4xl font-bold mt-3">{{ $stats['resolved_today'] }}</p>
                        </div>
                        <div class="bg-white bg-opacity-20 rounded-full p-4 backdrop-blur-sm">
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
                <div class="lg:col-span-2 bg-white overflow-hidden shadow-md sm:rounded-xl border border-gray-100">
                    <div class="p-6 sm:p-8">
                        <div class="flex items-center justify-between mb-6">
                            <h3 class="text-xl font-bold text-gray-900 flex items-center">
                                <svg class="w-6 h-6 mr-3 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                                </svg>
                                Currently Active Requests
                            </h3>
                            <a href="{{ route('tanod.assigned') }}" class="text-blue-600 hover:text-blue-700 text-sm font-semibold flex items-center transition">
                                View All
                                <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                            </a>
                        </div>

                        @if ($activeRequests->count() > 0)
                            <div class="space-y-4">
                                @foreach ($activeRequests as $request)
                                    <div class="border border-gray-200 hover:border-purple-300 bg-white/50 rounded-lg p-5 hover:shadow-md transition">
                                        <div class="flex justify-between items-start gap-4">
                                            <div class="flex-1">
                                                <h4 class="text-base font-semibold text-gray-900 mb-2">{{ $request->title }}</h4>
                                                <p class="text-sm text-gray-600 mb-3">{{ $request->location }}</p>
                                                <div class="flex items-center gap-2 flex-wrap">
                                                    <span class="inline-block px-3 py-1.5 text-xs font-bold rounded-full {{ $request->getStatusColor() }}">
                                                        {{ ucfirst(str_replace('_', ' ', $request->status)) }}
                                                    </span>
                                                </div>
                                            </div>
                                            <a href="{{ route('tanod.show', $request->id) }}" class="ml-4 flex-shrink-0 px-4 py-2 bg-gradient-to-r from-purple-600 to-purple-700 hover:from-purple-700 hover:to-purple-800 text-white text-sm font-semibold rounded-lg transition shadow-md hover:shadow-lg">
                                                View
                                            </a>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-16 bg-gradient-to-b from-gray-50 to-transparent rounded-lg border-2 border-dashed border-gray-300">
                                <svg class="mx-auto h-14 w-14 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                                </svg>
                                <p class="mt-4 text-lg font-semibold text-gray-900">No active requests.</p>
                                <p class="text-sm text-gray-600 mt-2">Check pending requests to see available assignments.</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="bg-white overflow-hidden shadow-md sm:rounded-xl border border-gray-100">
                    <div class="p-6 sm:p-8">
                        <h3 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
                            <svg class="w-6 h-6 mr-3 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                            </svg>
                            Quick Actions
                        </h3>
                        <div class="space-y-3">
                            <a href="{{ route('tanod.pending') }}" class="flex flex-col items-center p-5 bg-gradient-to-br from-amber-50 to-transparent border border-amber-200/30 hover:border-amber-300/60 rounded-xl transition transform hover:scale-105 group shadow-sm hover:shadow-md">
                                <svg class="h-8 w-8 text-amber-600 mb-2 group-hover:scale-110 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                </svg>
                                <p class="font-bold text-gray-900 text-center text-sm">Pending Requests</p>
                            </a>
                            <a href="{{ route('tanod.assigned') }}" class="flex flex-col items-center p-5 bg-gradient-to-br from-blue-50 to-transparent border border-blue-200/30 hover:border-blue-300/60 rounded-xl transition transform hover:scale-105 group shadow-sm hover:shadow-md">
                                <svg class="h-8 w-8 text-blue-600 mb-2 group-hover:scale-110 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <p class="font-bold text-gray-900 text-center text-sm">My Assignments</p>
                            </a>
                            <a href="{{ route('tanod.resolved') }}" class="flex flex-col items-center p-5 bg-gradient-to-br from-green-50 to-transparent border border-green-200/30 hover:border-green-300/60 rounded-xl transition transform hover:scale-105 group shadow-sm hover:shadow-md">
                                <svg class="h-8 w-8 text-green-600 mb-2 group-hover:scale-110 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <p class="font-bold text-gray-900 text-center text-sm">Resolved Requests</p>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Requests -->
            <div class="bg-white overflow-hidden shadow-md sm:rounded-xl border border-gray-100">
                <div class="p-6 sm:p-8">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-xl font-bold text-gray-900 flex items-center">
                            <svg class="w-6 h-6 mr-3 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            Recent Requests
                        </h3>
                    </div>

                    @if ($recentRequests->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="w-full text-sm">
                                <thead>
                                    <tr class="border-b-2 border-gray-200 bg-gray-50">
                                        <th class="px-6 py-4 text-left font-bold text-gray-900">Title</th>
                                        <th class="px-6 py-4 text-left font-bold text-gray-900">Category</th>
                                        <th class="px-6 py-4 text-left font-bold text-gray-900">Status</th>
                                        <th class="px-6 py-4 text-left font-bold text-gray-900">Priority</th>
                                        <th class="px-6 py-4 text-left font-bold text-gray-900">Submitted</th>
                                        <th class="px-6 py-4 text-center font-bold text-gray-900">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($recentRequests as $request)
                                        <tr class="border-b border-gray-100 hover:bg-gray-50 transition">
                                            <td class="px-6 py-4">
                                                <a href="{{ route('tanod.show', $request->id) }}" class="text-blue-600 hover:text-blue-800 font-semibold">
                                                    {{ Str::limit($request->title, 30) }}
                                                </a>
                                            </td>
                                            <td class="px-6 py-4 text-gray-700">{{ ucfirst($request->category) }}</td>
                                            <td class="px-6 py-4">
                                                <span class="px-3 py-1.5 text-xs font-bold rounded-full {{ $request->getStatusColor() }}">
                                                    {{ ucfirst(str_replace('_', ' ', $request->status)) }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4">
                                                <span class="px-3 py-1.5 text-xs font-bold rounded-full bg-red-100 text-red-800">
                                                    {{ ucfirst($request->priority) }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 text-gray-600">{{ $request->submitted_at->format('M d, H:i') }}</td>
                                            <td class="px-6 py-4 text-center">
                                                <a href="{{ route('tanod.show', $request->id) }}" class="inline-flex items-center px-3 py-1.5 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white text-xs font-bold rounded-lg transition shadow-sm hover:shadow-md">
                                                    View
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-16 bg-gradient-to-b from-gray-50 to-transparent rounded-lg border-2 border-dashed border-gray-300">
                            <svg class="mx-auto h-14 w-14 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            <p class="mt-4 text-lg font-semibold text-gray-900">No requests yet.</p>
                            <p class="text-sm text-gray-600 mt-2">All requests will appear here once they are submitted.</p>
                        </div>
                    @endif
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
