<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-bold text-3xl text-gray-900 leading-tight">
                    {{ __('Citizen Dashboard') }}
                </h2>
                <p class="text-sm text-gray-600 mt-1">Track and manage your complaints</p>
            </div>
            <div class="text-right">
                <p class="text-sm font-medium text-gray-700">{{ now()->format('l') }}</p>
                <p class="text-xs text-gray-500">{{ now()->format('F j, Y') }}</p>
            </div>
        </div>
    </x-slot>

    <div class="py-12 bg-gradient-to-b from-blue-50/30 to-transparent min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            <!-- Welcome Message -->
            <div class="bg-gradient-to-r from-blue-600 to-blue-700 hover:shadow-xl transition rounded-xl shadow-lg p-7 text-white">
                <h3 class="text-2xl font-bold mb-2">Welcome back, {{ auth()->user()->full_name }}!</h3>
                <p class="text-blue-100 text-sm">Track and manage your complaints with ease. Your voice matters in our community.</p>
            </div>

            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                <div class="bg-gradient-to-br from-blue-600 to-blue-700 rounded-xl shadow-lg p-6 text-white hover:shadow-xl transition transform hover:scale-105">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-blue-100 text-sm font-semibold opacity-90">Total Complaints</p>
                            <p class="text-4xl font-bold mt-3">{{ $stats['total'] }}</p>
                        </div>
                        <div class="bg-white bg-opacity-20 rounded-full p-4 backdrop-blur-sm">
                            <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="bg-gradient-to-br from-amber-600 to-amber-700 rounded-xl shadow-lg p-6 text-white hover:shadow-xl transition transform hover:scale-105">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-amber-100 text-sm font-semibold opacity-90">Pending</p>
                            <p class="text-4xl font-bold mt-3">{{ $stats['pending'] }}</p>
                        </div>
                        <div class="bg-white bg-opacity-20 rounded-full p-4 backdrop-blur-sm">
                            <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="bg-gradient-to-br from-indigo-600 to-indigo-700 rounded-xl shadow-lg p-6 text-white hover:shadow-xl transition transform hover:scale-105">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-indigo-100 text-sm font-semibold opacity-90">Validated</p>
                            <p class="text-4xl font-bold mt-3">{{ $stats['validated'] }}</p>
                        </div>
                        <div class="bg-white bg-opacity-20 rounded-full p-4 backdrop-blur-sm">
                            <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="bg-gradient-to-br from-green-600 to-green-700 rounded-xl shadow-lg p-6 text-white hover:shadow-xl transition transform hover:scale-105">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-green-100 text-sm font-semibold opacity-90">Resolved</p>
                            <p class="text-4xl font-bold mt-3">{{ $stats['resolved'] }}</p>
                        </div>
                        <div class="bg-white bg-opacity-20 rounded-full p-4 backdrop-blur-sm">
                            <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="bg-white overflow-hidden shadow-md sm:rounded-xl border border-gray-100">
                <div class="p-6 sm:p-8">
                    <h3 class="text-xl font-bold text-gray-900 mb-6">Quick Actions</h3>
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <a href="{{ route('complaints.create') }}" class="flex flex-col items-center p-5 bg-gradient-to-br from-blue-50 to-transparent border border-blue-200/30 hover:border-blue-300/60 rounded-xl transition transform hover:scale-105 group shadow-sm hover:shadow-md">
                            <svg class="h-10 w-10 text-blue-600 mb-3 group-hover:scale-110 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                            </svg>
                            <p class="font-bold text-gray-900 text-center">File New Complaint</p>
                            <p class="text-xs text-gray-600 text-center mt-1">Submit a complaint</p>
                        </a>

                        <a href="{{ route('urgent-requests.create') }}" class="flex flex-col items-center p-5 bg-gradient-to-br from-red-50 to-transparent border border-red-200/30 hover:border-red-300/60 rounded-xl transition transform hover:scale-105 group shadow-sm hover:shadow-md">
                            <svg class="h-10 w-10 text-red-600 mb-3 group-hover:scale-110 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4v2m0 0v2m0-2H9m3 0h3M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                            </svg>
                            <p class="font-bold text-gray-900 text-center">Urgent Report</p>
                            <p class="text-xs text-gray-600 text-center mt-1">Emergency request</p>
                        </a>

                        <a href="{{ route('complaints.index') }}" class="flex flex-col items-center p-5 bg-gradient-to-br from-indigo-50 to-transparent border border-indigo-200/30 hover:border-indigo-300/60 rounded-xl transition transform hover:scale-105 group shadow-sm hover:shadow-md">
                            <svg class="h-10 w-10 text-indigo-600 mb-3 group-hover:scale-110 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                            <p class="font-bold text-gray-900 text-center">View All Complaints</p>
                            <p class="text-xs text-gray-600 text-center mt-1">Complaint history</p>
                        </a>

                        <a href="{{ route('citizen.qr-code') }}" class="flex flex-col items-center p-5 bg-gradient-to-br from-purple-50 to-transparent border border-purple-200/30 hover:border-purple-300/60 rounded-xl transition transform hover:scale-105 group shadow-sm hover:shadow-md">
                            <svg class="h-10 w-10 text-purple-600 mb-3 group-hover:scale-110 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z" />
                            </svg>
                            <p class="font-bold text-gray-900 text-center">My QR Code</p>
                            <p class="text-xs text-gray-600 text-center mt-1">Verification QR</p>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Recent Complaints -->
            <div class="bg-white overflow-hidden shadow-md sm:rounded-xl border border-gray-100">
                <div class="p-6 sm:p-8">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-xl font-bold text-gray-900">Recent Complaints</h3>
                        <a href="{{ route('complaints.index') }}" class="text-blue-600 hover:text-blue-700 text-sm font-semibold flex items-center transition">
                            View All
                            <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </a>
                    </div>

                    @if($complaints->count() > 0)
                        <div class="space-y-4">
                            @foreach($complaints as $complaint)
                                <div class="border border-gray-200 hover:border-blue-300 bg-white/50 rounded-lg p-5 hover:shadow-md transition">
                                    <div class="flex justify-between items-start gap-4">
                                        <div class="flex-1">
                                            <div class="flex items-center space-x-3 mb-2 flex-wrap gap-2">
                                                <span class="text-xs font-mono font-semibold text-blue-600 bg-blue-100 px-2.5 py-1 rounded">{{ $complaint->complaint_number }}</span>
                                                @if($complaint->status === 'pending')
                                                    <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-bold bg-yellow-100 text-yellow-800">
                                                        Pending
                                                    </span>
                                                @elseif($complaint->status === 'validated')
                                                    <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-bold bg-blue-100 text-blue-800">
                                                        Validated
                                                    </span>
                                                @elseif($complaint->status === 'resolved')
                                                    <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-bold bg-green-100 text-green-800">
                                                        Resolved
                                                    </span>
                                                @elseif($complaint->status === 'rejected')
                                                    <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-bold bg-red-100 text-red-800">
                                                        Rejected
                                                    </span>
                                                @endif
                                            </div>
                                            <h4 class="text-base font-semibold text-gray-900 mb-1">{{ $complaint->subject }}</h4>
                                            <p class="text-sm text-gray-600 mb-3">{{ Str::limit($complaint->description, 100) }}</p>
                                            <div class="flex items-center text-xs text-gray-600 space-x-4 flex-wrap gap-3">
                                                <span class="flex items-center">
                                                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5a2 2 0 012 2v5a2 2 0 01-2 2H7a2 2 0 01-2-2V5a2 2 0 012-2z" />
                                                    </svg>
                                                    {{ $complaint->category->name }}
                                                </span>
                                                <span class="flex items-center">
                                                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                    </svg>
                                                    {{ $complaint->created_at->format('M d, Y') }}
                                                </span>
                                            </div>
                                        </div>
                                        <a href="{{ route('complaints.show', $complaint) }}" class="ml-4 flex-shrink-0 px-4 py-2 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white text-sm font-semibold rounded-lg transition shadow-md hover:shadow-lg">
                                            View
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-16 bg-gradient-to-b from-gray-50 to-transparent rounded-lg border-2 border-dashed border-gray-300">
                            <svg class="mx-auto h-14 w-14 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            <p class="mt-4 text-lg font-semibold text-gray-900">No complaints filed yet.</p>
                            <p class="text-sm text-gray-600 mt-2">Start by filing your first complaint to report an issue in your community.</p>
                            <a href="{{ route('complaints.create') }}" class="mt-4 inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-semibold rounded-lg transition shadow-md hover:shadow-lg">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                </svg>
                                File Your First Complaint
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
