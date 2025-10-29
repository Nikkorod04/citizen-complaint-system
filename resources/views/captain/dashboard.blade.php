<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-bold text-3xl text-gray-900 leading-tight">
                    {{ __('Barangay Captain Dashboard') }}
                </h2>
                <p class="text-sm text-gray-600 mt-1">Manage complaints and monitor community issues</p>
            </div>
            <div class="text-right">
                <p class="text-sm font-medium text-gray-700">{{ now()->format('l') }}</p>
                <p class="text-xs text-gray-500">{{ now()->format('F j, Y') }}</p>
            </div>
        </div>
    </x-slot>

    <div class="py-12 bg-gradient-to-b from-blue-50/30 to-transparent min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
            <!-- Statistics Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-6">
                <!-- Total Complaints -->
                <div class="bg-gradient-to-br from-blue-600 to-blue-700 rounded-xl shadow-lg p-6 text-white hover:shadow-xl transition transform hover:scale-105">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-blue-100 text-sm font-semibold opacity-90">Total Complaints</p>
                            <p class="text-4xl font-bold mt-3">{{ $stats['total_complaints'] }}</p>
                        </div>
                        <div class="bg-white bg-opacity-20 rounded-full p-4 backdrop-blur-sm">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Awaiting Review (Validated) -->
                <div class="bg-gradient-to-br from-amber-500 to-amber-600 rounded-xl shadow-lg p-6 text-white hover:shadow-xl transition transform hover:scale-105">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-amber-100 text-sm font-semibold opacity-90">Awaiting Review</p>
                            <p class="text-4xl font-bold mt-3">{{ $stats['validated_pending'] }}</p>
                        </div>
                        <div class="bg-white bg-opacity-20 rounded-full p-4 backdrop-blur-sm">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- In Progress -->
                <div class="bg-gradient-to-br from-purple-600 to-purple-700 rounded-xl shadow-lg p-6 text-white hover:shadow-xl transition transform hover:scale-105">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-purple-100 text-sm font-semibold opacity-90">In Progress</p>
                            <p class="text-4xl font-bold mt-3">{{ $stats['in_progress'] }}</p>
                        </div>
                        <div class="bg-white bg-opacity-20 rounded-full p-4 backdrop-blur-sm">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Resolved This Month -->
                <div class="bg-gradient-to-br from-green-600 to-green-700 rounded-xl shadow-lg p-6 text-white hover:shadow-xl transition transform hover:scale-105">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-green-100 text-sm font-semibold opacity-90">Resolved This Month</p>
                            <p class="text-4xl font-bold mt-3">{{ $stats['resolved_this_month'] }}</p>
                        </div>
                        <div class="bg-white bg-opacity-20 rounded-full p-4 backdrop-blur-sm">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Verified Citizens -->
                <div class="bg-gradient-to-br from-indigo-600 to-indigo-700 rounded-xl shadow-lg p-6 text-white hover:shadow-xl transition transform hover:scale-105">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-indigo-100 text-sm font-semibold opacity-90">Verified Citizens</p>
                            <p class="text-4xl font-bold mt-3">{{ $stats['total_citizens'] }}</p>
                        </div>
                        <div class="bg-white bg-opacity-20 rounded-full p-4 backdrop-blur-sm">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Category Breakdown -->
            <div class="bg-white overflow-hidden shadow-md sm:rounded-xl border border-gray-100 hover:shadow-lg transition">
                <div class="p-6 sm:p-8">
                    <h3 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
                        <svg class="w-6 h-6 mr-3 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                        </svg>
                        Complaints by Category
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        @forelse($categoryStats as $stat)
                            <div class="border border-gray-200 bg-white/50 rounded-lg p-4 hover:border-blue-300 hover:shadow-md transition transform hover:scale-102">
                                <div class="flex items-center justify-between">
                                    <div class="flex-1">
                                        <p class="text-sm font-semibold text-gray-900">{{ $stat->category->name }}</p>
                                        <p class="text-xs text-gray-500 mt-1.5 font-medium">{{ $stat->category->republic_act }}</p>
                                    </div>
                                    <div class="ml-4 flex-shrink-0">
                                        <span class="inline-flex items-center justify-center w-12 h-12 rounded-full bg-gradient-to-br from-blue-100 to-blue-50 text-blue-700 font-bold text-lg">
                                            {{ $stat->total }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-span-3 text-center text-gray-500 py-12">
                                <svg class="mx-auto h-12 w-12 text-gray-400 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                                </svg>
                                <p class="font-medium">No complaint data available yet.</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Recent Validated Complaints (Awaiting Captain Review) -->
            <div class="bg-white overflow-hidden shadow-md sm:rounded-xl border border-gray-100 hover:shadow-lg transition">
                <div class="p-6 sm:p-8">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-xl font-bold text-gray-900 flex items-center">
                            <svg class="w-6 h-6 mr-3 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                            </svg>
                            Complaints Awaiting Your Review
                        </h3>
                        <a href="{{ route('captain.complaints', ['status' => 'validated']) }}" class="text-sm text-blue-600 hover:text-blue-700 font-semibold flex items-center transition">
                            View All
                            <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </a>
                    </div>

                    <div class="space-y-4">
                        @forelse($validatedComplaints as $complaint)
                            <div class="border border-amber-200 bg-gradient-to-r from-amber-50/50 to-white rounded-lg p-5 hover:border-amber-300 hover:shadow-md transition">
                                <div class="flex items-start justify-between gap-4">
                                    <div class="flex-1">
                                        <div class="flex items-center space-x-3 mb-3 flex-wrap gap-2">
                                            <span class="px-3 py-1.5 text-xs font-bold rounded-full bg-amber-200 text-amber-900">
                                                {{ strtoupper($complaint->status) }}
                                            </span>
                                            <span class="px-3 py-1.5 text-xs font-semibold rounded-full bg-blue-100 text-blue-700">
                                                {{ $complaint->category->name }}
                                            </span>
                                            <span class="px-2.5 py-1 text-xs font-medium rounded bg-gray-200 text-gray-700">
                                                #{{ str_pad($complaint->id, 4, '0', STR_PAD_LEFT) }}
                                            </span>
                                        </div>
                                        
                                        <h4 class="text-base font-semibold text-gray-900 mb-2">
                                            {{ Str::limit($complaint->description, 100) }}
                                        </h4>
                                        
                                        <div class="flex items-center text-sm text-gray-600 space-x-4 flex-wrap gap-3">
                                            <span class="flex items-center">
                                                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                                </svg>
                                                {{ $complaint->user->full_name }}
                                            </span>
                                            <span class="flex items-center">
                                                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                                {{ $complaint->created_at->diffForHumans() }}
                                            </span>
                                            @if($complaint->location)
                                                <span class="flex items-center">
                                                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    </svg>
                                                    {{ Str::limit($complaint->location, 30) }}
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    
                                    <div class="ml-4 flex-shrink-0">
                                        <a href="{{ route('captain.complaints.show', $complaint->id) }}" class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white text-sm font-semibold rounded-lg transition shadow-md hover:shadow-lg transform hover:scale-105">
                                            Review
                                            <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                                            </svg>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-16 bg-gradient-to-b from-gray-50 to-transparent rounded-lg border-2 border-dashed border-gray-300">
                                <svg class="mx-auto h-14 w-14 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <p class="text-lg font-semibold text-gray-900">All caught up!</p>
                                <p class="text-sm text-gray-600 mt-2">No complaints awaiting your review at the moment.</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <a href="{{ route('captain.complaints') }}" class="block bg-gradient-to-br from-white to-blue-50/20 overflow-hidden shadow-md border border-blue-200/30 sm:rounded-xl hover:shadow-lg hover:border-blue-300/60 transition transform hover:scale-105 group">
                    <div class="p-6 sm:p-7">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-gradient-to-br from-blue-100 to-blue-50 rounded-xl p-3 group-hover:from-blue-200 group-hover:to-blue-100 transition shadow-sm">
                                <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                            </div>
                            <div class="ml-5">
                                <h3 class="text-lg font-bold text-gray-900 group-hover:text-blue-600 transition">All Complaints</h3>
                                <p class="text-sm text-gray-600">Review and manage</p>
                            </div>
                        </div>
                    </div>
                </a>

                <a href="{{ route('captain.categories.index') }}" class="block bg-gradient-to-br from-white to-orange-50/20 overflow-hidden shadow-md border border-orange-200/30 sm:rounded-xl hover:shadow-lg hover:border-orange-300/60 transition transform hover:scale-105 group">
                    <div class="p-6 sm:p-7">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-gradient-to-br from-orange-100 to-orange-50 rounded-xl p-3 group-hover:from-orange-200 group-hover:to-orange-100 transition shadow-sm">
                                <svg class="w-8 h-8 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                                </svg>
                            </div>
                            <div class="ml-5">
                                <h3 class="text-lg font-bold text-gray-900 group-hover:text-orange-600 transition">Categories</h3>
                                <p class="text-sm text-gray-600">Manage complaint types</p>
                            </div>
                        </div>
                    </div>
                </a>

                <a href="{{ route('captain.analytics') }}" class="block bg-gradient-to-br from-white to-green-50/20 overflow-hidden shadow-md border border-green-200/30 sm:rounded-xl hover:shadow-lg hover:border-green-300/60 transition transform hover:scale-105 group">
                    <div class="p-6 sm:p-7">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-gradient-to-br from-green-100 to-green-50 rounded-xl p-3 group-hover:from-green-200 group-hover:to-green-100 transition shadow-sm">
                                <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                                </svg>
                            </div>
                            <div class="ml-5">
                                <h3 class="text-lg font-bold text-gray-900 group-hover:text-green-600 transition">Analytics</h3>
                                <p class="text-sm text-gray-600">View trends & insights</p>
                            </div>
                        </div>
                    </div>
                </a>

                <a href="{{ route('captain.reports') }}" class="block bg-gradient-to-br from-white to-purple-50/20 overflow-hidden shadow-md border border-purple-200/30 sm:rounded-xl hover:shadow-lg hover:border-purple-300/60 transition transform hover:scale-105 group">
                    <div class="p-6 sm:p-7">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-gradient-to-br from-purple-100 to-purple-50 rounded-xl p-3 group-hover:from-purple-200 group-hover:to-purple-100 transition shadow-sm">
                                <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                            </div>
                            <div class="ml-5">
                                <h3 class="text-lg font-bold text-gray-900 group-hover:text-purple-600 transition">Reports</h3>
                                <p class="text-sm text-gray-600">Download summaries</p>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

        </div>
    </div>
</x-app-layout>
