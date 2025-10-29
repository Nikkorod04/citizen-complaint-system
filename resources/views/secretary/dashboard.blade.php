<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-bold text-3xl text-gray-900 leading-tight">
                    {{ __('Secretary Dashboard') }}
                </h2>
                <p class="text-sm text-gray-600 mt-1">Verify citizens and validate complaints</p>
            </div>
            <div class="text-right">
                <p class="text-sm font-medium text-gray-700">{{ now()->format('l') }}</p>
                <p class="text-xs text-gray-500">{{ now()->format('F j, Y') }}</p>
            </div>
        </div>
    </x-slot>

    <div class="py-12 bg-gradient-to-b from-purple-50/30 to-transparent min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
            <!-- Statistics Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Pending Verifications -->
                <div class="bg-gradient-to-br from-amber-600 to-amber-700 rounded-xl shadow-lg p-6 text-white hover:shadow-xl transition transform hover:scale-105">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-amber-100 text-sm font-semibold opacity-90">Pending Verifications</p>
                            <p class="text-4xl font-bold mt-3">{{ $stats['pending_verifications'] }}</p>
                        </div>
                        <div class="bg-white bg-opacity-20 rounded-full p-4 backdrop-blur-sm">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Pending Complaints -->
                <div class="bg-gradient-to-br from-orange-600 to-orange-700 rounded-xl shadow-lg p-6 text-white hover:shadow-xl transition transform hover:scale-105">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-orange-100 text-sm font-semibold opacity-90">Pending Complaints</p>
                            <p class="text-4xl font-bold mt-3">{{ $stats['pending_complaints'] }}</p>
                        </div>
                        <div class="bg-white bg-opacity-20 rounded-full p-4 backdrop-blur-sm">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Validated Today -->
                <div class="bg-gradient-to-br from-green-600 to-green-700 rounded-xl shadow-lg p-6 text-white hover:shadow-xl transition transform hover:scale-105">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-green-100 text-sm font-semibold opacity-90">Validated Today</p>
                            <p class="text-4xl font-bold mt-3">{{ $stats['validated_today'] }}</p>
                        </div>
                        <div class="bg-white bg-opacity-20 rounded-full p-4 backdrop-blur-sm">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

                <!-- Pending User Verifications -->
                <div class="bg-white overflow-hidden shadow-md sm:rounded-xl border border-gray-100 hover:shadow-lg transition">
                    <div class="p-6 sm:p-8">
                        <div class="flex items-center justify-between mb-6">
                            <h3 class="text-xl font-bold text-gray-900 flex items-center">
                                <svg class="w-6 h-6 mr-3 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                                </svg>
                                Pending User Verifications
                            </h3>
                            <a href="{{ route('secretary.pending-users') }}" class="text-sm text-blue-600 hover:text-blue-700 font-semibold flex items-center transition">
                                View All
                                <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                            </a>
                        </div>

                        <div class="space-y-3">
                            @forelse($pendingUsers as $user)
                                <div class="border border-amber-200 bg-gradient-to-r from-amber-50/50 to-white rounded-lg p-5 hover:border-amber-300 hover:shadow-md transition">
                                    <div class="flex items-start justify-between gap-4">
                                        <div class="flex-1">
                                            <h4 class="text-base font-semibold text-gray-900 mb-2">{{ $user->full_name }}</h4>
                                            <div class="mt-3 space-y-2 text-sm text-gray-600">
                                                <p class="flex items-center">
                                                    <svg class="w-4 h-4 mr-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                                    </svg>
                                                    {{ $user->email }}
                                                </p>
                                                <p class="flex items-center">
                                                    <svg class="w-4 h-4 mr-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                    </svg>
                                                    Registered {{ $user->created_at->diffForHumans() }}
                                                </p>
                                            </div>
                                        </div>
                                        <a href="{{ route('secretary.pending-users') }}" class="ml-4 flex-shrink-0 px-4 py-2 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white text-sm font-semibold rounded-lg transition shadow-md hover:shadow-lg">
                                            Review
                                        </a>
                                    </div>
                                </div>
                            @empty
                                <div class="text-center py-16 bg-gradient-to-b from-gray-50 to-transparent rounded-lg border-2 border-dashed border-gray-300">
                                    <svg class="mx-auto h-14 w-14 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <p class="text-lg font-semibold text-gray-900">All verified!</p>
                                    <p class="text-sm text-gray-600 mt-2">No pending user verifications.</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>

                <!-- Pending Complaints -->
                <div class="bg-white overflow-hidden shadow-md sm:rounded-xl border border-gray-100 hover:shadow-lg transition">
                    <div class="p-6 sm:p-8">
                        <div class="flex items-center justify-between mb-6">
                            <h3 class="text-xl font-bold text-gray-900 flex items-center">
                                <svg class="w-6 h-6 mr-3 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                Pending Complaints
                            </h3>
                            <a href="{{ route('secretary.pending-complaints') }}" class="text-sm text-blue-600 hover:text-blue-700 font-semibold flex items-center transition">
                                View All
                                <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                            </a>
                        </div>

                        <div class="space-y-3">
                            @forelse($pendingComplaints as $complaint)
                                <div class="border border-orange-200 bg-gradient-to-r from-orange-50/50 to-white rounded-lg p-5 hover:border-orange-300 hover:shadow-md transition">
                                    <div class="flex items-start justify-between gap-4">
                                        <div class="flex-1">
                                            <div class="flex items-center space-x-2 mb-2 flex-wrap gap-2">
                                                <span class="px-3 py-1.5 text-xs font-bold rounded-full bg-orange-200 text-orange-900">
                                                    {{ strtoupper($complaint->status) }}
                                                </span>
                                                <span class="px-3 py-1.5 text-xs font-semibold rounded-full bg-blue-100 text-blue-700">
                                                    {{ $complaint->category->name }}
                                                </span>
                                            </div>
                                            <h4 class="text-base font-semibold text-gray-900 mb-2">
                                                {{ Str::limit($complaint->description, 80) }}
                                            </h4>
                                            <div class="flex items-center text-sm text-gray-600 space-x-3 flex-wrap gap-3">
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
                                            </div>
                                        </div>
                                        <a href="{{ route('secretary.pending-complaints') }}" class="ml-4 flex-shrink-0 px-4 py-2 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white text-sm font-semibold rounded-lg transition shadow-md hover:shadow-lg">
                                            Review
                                        </a>
                                    </div>
                                </div>
                            @empty
                                <div class="text-center py-16 bg-gradient-to-b from-gray-50 to-transparent rounded-lg border-2 border-dashed border-gray-300">
                                    <svg class="mx-auto h-14 w-14 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <p class="text-lg font-semibold text-gray-900">All processed!</p>
                                    <p class="text-sm text-gray-600 mt-2">No pending complaints for validation.</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>

            </div>

            <!-- Quick Actions -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <a href="{{ route('secretary.pending-users') }}" class="block bg-gradient-to-br from-white to-amber-50/20 overflow-hidden shadow-md border border-amber-200/30 sm:rounded-xl hover:shadow-lg hover:border-amber-300/60 transition transform hover:scale-105 group">
                    <div class="p-6 sm:p-7">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-gradient-to-br from-amber-100 to-amber-50 rounded-xl p-3 group-hover:from-amber-200 group-hover:to-amber-100 transition shadow-sm">
                                <svg class="w-8 h-8 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                                </svg>
                            </div>
                            <div class="ml-5">
                                <h3 class="text-lg font-bold text-gray-900 group-hover:text-amber-600 transition">User Verifications</h3>
                                <p class="text-sm text-gray-600">Verify citizen accounts and validate National IDs</p>
                            </div>
                        </div>
                    </div>
                </a>

                <a href="{{ route('secretary.pending-complaints') }}" class="block bg-gradient-to-br from-white to-orange-50/20 overflow-hidden shadow-md border border-orange-200/30 sm:rounded-xl hover:shadow-lg hover:border-orange-300/60 transition transform hover:scale-105 group">
                    <div class="p-6 sm:p-7">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-gradient-to-br from-orange-100 to-orange-50 rounded-xl p-3 group-hover:from-orange-200 group-hover:to-orange-100 transition shadow-sm">
                                <svg class="w-8 h-8 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                            </div>
                            <div class="ml-5">
                                <h3 class="text-lg font-bold text-gray-900 group-hover:text-orange-600 transition">Complaint Validation</h3>
                                <p class="text-sm text-gray-600">Review and validate complaints for accuracy</p>
                            </div>
                        </div>
                    </div>
                </a>

                <a href="{{ route('secretary.citizens.index') }}" class="block bg-gradient-to-br from-white to-blue-50/20 overflow-hidden shadow-md border border-blue-200/30 sm:rounded-xl hover:shadow-lg hover:border-blue-300/60 transition transform hover:scale-105 group">
                    <div class="p-6 sm:p-7">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-gradient-to-br from-blue-100 to-blue-50 rounded-xl p-3 group-hover:from-blue-200 group-hover:to-blue-100 transition shadow-sm">
                                <div class="w-8 h-8 text-blue-600 text-2xl flex items-center justify-center">👨‍👨‍👦‍👦</div>
                            </div>
                            <div class="ml-5">
                                <h3 class="text-lg font-bold text-gray-900 group-hover:text-blue-600 transition">Manage Citizens</h3>
                                <p class="text-sm text-gray-600">View, add, and edit citizen information</p>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

        </div>
    </div>
</x-app-layout>
