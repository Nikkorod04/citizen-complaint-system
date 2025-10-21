<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
                {{ __('Reports & Analytics') }}
            </h2>
            <div class="flex gap-2">
                <a href="{{ route('captain.analytics') }}" class="px-4 py-2 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 transition">
                    Analytics
                </a>
                <a href="{{ route('captain.dashboard') }}" class="text-sm text-indigo-600 hover:text-indigo-800 font-medium flex items-center">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Back to Dashboard
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Export Section -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 mb-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Export Report as PDF</h3>
                <form action="{{ route('captain.reports.export') }}" method="GET" class="flex gap-4 flex-wrap">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">From Date</label>
                        <input type="date" name="start_date" value="{{ request('start_date', now()->subMonth()->format('Y-m-d')) }}" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">To Date</label>
                        <input type="date" name="end_date" value="{{ request('end_date', now()->format('Y-m-d')) }}" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500">
                    </div>
                    <div class="flex items-end">
                        <button type="submit" class="px-6 py-2 bg-red-600 text-white font-medium rounded-lg hover:bg-red-700 transition flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            Download PDF
                        </button>
                    </div>
                </form>
            </div>

            <!-- Statistics Overview -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
                <!-- Total Complaints -->
                <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl shadow-lg p-6 text-white">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-blue-100 text-sm font-medium">Total Complaints</p>
                            <p class="text-3xl font-bold mt-2">{{ $statusData->sum('count') }}</p>
                        </div>
                        <div class="bg-white bg-opacity-20 rounded-full p-3">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Status: Resolved -->
                @php $resolved = $statusData->firstWhere('status', 'resolved'); @endphp
                <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-xl shadow-lg p-6 text-white">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-green-100 text-sm font-medium">Resolved</p>
                            <p class="text-3xl font-bold mt-2">{{ $resolved->count ?? 0 }}</p>
                        </div>
                        <div class="bg-white bg-opacity-20 rounded-full p-3">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m7 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Status: In Progress -->
                @php $inProgress = $statusData->firstWhere('status', 'in_progress'); @endphp
                <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl shadow-lg p-6 text-white">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-purple-100 text-sm font-medium">In Progress</p>
                            <p class="text-3xl font-bold mt-2">{{ $inProgress->count ?? 0 }}</p>
                        </div>
                        <div class="bg-white bg-opacity-20 rounded-full p-3">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Status: Pending -->
                @php $pending = $statusData->firstWhere('status', 'pending'); @endphp
                <div class="bg-gradient-to-br from-yellow-500 to-yellow-600 rounded-xl shadow-lg p-6 text-white">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-yellow-100 text-sm font-medium">Pending</p>
                            <p class="text-3xl font-bold mt-2">{{ $pending->count ?? 0 }}</p>
                        </div>
                        <div class="bg-white bg-opacity-20 rounded-full p-3">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Monthly Data -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Monthly Complaints (Last 6 Months)</h3>
                    
                    <div class="space-y-3">
                        @forelse($monthlyData as $data)
                            @php
                                $total = $statusData->sum('count') ?: 1;
                                $percentage = ($data->count / $total) * 100;
                            @endphp
                            <div>
                                <div class="flex justify-between mb-1">
                                    <span class="text-sm font-medium text-gray-700">{{ \Carbon\Carbon::createFromFormat('Y-m', $data->month)->format('F Y') }}</span>
                                    <span class="text-sm font-medium text-gray-700">{{ $data->count }}</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2">
                                    <div class="bg-indigo-600 h-2 rounded-full" style="width: {{ $percentage }}%"></div>
                                </div>
                            </div>
                        @empty
                            <p class="text-gray-600 text-center py-4">No data available</p>
                        @endforelse
                    </div>
                </div>

                <!-- Status Distribution -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Status Distribution</h3>
                    
                    <div class="space-y-3">
                        @forelse($statusData as $data)
                            @php
                                $total = $statusData->sum('count') ?: 1;
                                $percentage = ($data->count / $total) * 100;
                                $statusColors = [
                                    'pending' => 'bg-yellow-500',
                                    'validated' => 'bg-blue-500',
                                    'in_progress' => 'bg-purple-500',
                                    'resolved' => 'bg-green-500',
                                    'rejected' => 'bg-red-500',
                                ];
                                $color = $statusColors[$data->status] ?? 'bg-gray-500';
                            @endphp
                            <div>
                                <div class="flex justify-between mb-1">
                                    <span class="text-sm font-medium text-gray-700 capitalize">{{ str_replace('_', ' ', $data->status) }}</span>
                                    <span class="text-sm font-medium text-gray-700">{{ $data->count }} ({{ round($percentage, 1) }}%)</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2">
                                    <div class="{{ $color }} h-2 rounded-full" style="width: {{ $percentage }}%"></div>
                                </div>
                            </div>
                        @empty
                            <p class="text-gray-600 text-center py-4">No data available</p>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Category Breakdown -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 mt-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Complaints by Category</h3>
                
                @if($categoryData->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-gray-600">
                            <thead class="bg-gray-50 border-b border-gray-200">
                                <tr>
                                    <th class="px-6 py-3 text-left font-semibold text-gray-900">Category</th>
                                    <th class="px-6 py-3 text-left font-semibold text-gray-900">Count</th>
                                    <th class="px-6 py-3 text-left font-semibold text-gray-900">Percentage</th>
                                    <th class="px-6 py-3 text-left font-semibold text-gray-900">Progress</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @foreach($categoryData as $data)
                                    @php
                                        $total = $categoryData->sum('count') ?: 1;
                                        $percentage = ($data->count / $total) * 100;
                                    @endphp
                                    <tr>
                                        <td class="px-6 py-3">
                                            <span class="px-3 py-1 rounded-full bg-indigo-100 text-indigo-700 text-sm font-medium">
                                                {{ $data->category->name ?? 'Unknown' }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-3 font-medium text-gray-900">{{ $data->count }}</td>
                                        <td class="px-6 py-3">{{ round($percentage, 1) }}%</td>
                                        <td class="px-6 py-3">
                                            <div class="w-full bg-gray-200 rounded-full h-2">
                                                <div class="bg-indigo-600 h-2 rounded-full" style="width: {{ $percentage }}%"></div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-gray-600 text-center py-4">No category data available</p>
                @endif
            </div>

            <!-- Report Information -->
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mt-6">
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-blue-600 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-blue-700">
                            <strong>Report Info:</strong> All data in this report is based on complaints filed and processed in the system. 
                            You can export a detailed PDF report with specific date ranges using the form above.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
