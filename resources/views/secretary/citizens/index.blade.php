<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-bold text-3xl text-gray-900 leading-tight">
                    {{ __('Manage Citizens') }}
                </h2>
                <p class="text-sm text-gray-600 mt-1">View, edit, and manage registered citizens</p>
            </div>
            <a href="{{ route('secretary.citizens.create') }}" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-semibold rounded-lg transition shadow-md hover:shadow-lg">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Add New Citizen
            </a>
        </div>
    </x-slot>

    <div class="py-12 bg-gradient-to-b from-blue-50/30 to-transparent min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="mb-6 p-4 bg-green-100 border border-green-300 text-green-800 rounded-lg flex items-center gap-3">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                    </svg>
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-md sm:rounded-xl border border-gray-100">
                <div class="p-6 sm:p-8">
                    <!-- Search and Filter -->
                    <div class="mb-6 flex items-center gap-4">
                        <div class="flex-1">
                            <input type="search" placeholder="Search by name or email..." class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:border-blue-600 focus:ring-1 focus:ring-blue-500" />
                        </div>
                        <button class="px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-900 rounded-lg transition font-medium">
                            Search
                        </button>
                    </div>

                    @if ($citizens->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="w-full">
                                <thead>
                                    <tr class="border-b-2 border-gray-200 bg-gray-50">
                                        <th class="px-6 py-4 text-left font-bold text-gray-900">Name</th>
                                        <th class="px-6 py-4 text-left font-bold text-gray-900">Email</th>
                                        <th class="px-6 py-4 text-left font-bold text-gray-900">Phone</th>
                                        <th class="px-6 py-4 text-left font-bold text-gray-900">Age</th>
                                        <th class="px-6 py-4 text-left font-bold text-gray-900">Status</th>
                                        <th class="px-6 py-4 text-left font-bold text-gray-900">Registered</th>
                                        <th class="px-6 py-4 text-center font-bold text-gray-900">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($citizens as $citizen)
                                        <tr class="border-b border-gray-100 hover:bg-gray-50 transition">
                                            <td class="px-6 py-4">
                                                <div class="flex items-center gap-3">
                                                    <div class="w-10 h-10 rounded-full bg-gradient-to-br from-blue-500 to-blue-600 text-white flex items-center justify-center font-bold text-sm">
                                                        {{ substr($citizen->full_name, 0, 1) }}
                                                    </div>
                                                    <div>
                                                        <p class="font-semibold text-gray-900">{{ $citizen->full_name }}</p>
                                                        <p class="text-xs text-gray-600">{{ $citizen->barangay }}</p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 text-gray-700">{{ $citizen->email }}</td>
                                            <td class="px-6 py-4 text-gray-700">{{ $citizen->phone }}</td>
                                            <td class="px-6 py-4 text-gray-700">{{ $citizen->age ?? 'N/A' }}</td>
                                            <td class="px-6 py-4">
                                                <span class="px-3 py-1.5 text-xs font-bold rounded-full {{ $citizen->verification_status === 'approved' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                                    {{ ucfirst($citizen->verification_status) }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 text-gray-600 text-sm">{{ $citizen->created_at->format('M d, Y') }}</td>
                                            <td class="px-6 py-4 text-center">
                                                <div class="flex items-center justify-center gap-2">
                                                    <a href="{{ route('secretary.citizens.show', $citizen) }}" class="px-3 py-1.5 bg-blue-100 hover:bg-blue-200 text-blue-800 text-xs font-bold rounded-lg transition">
                                                        View
                                                    </a>
                                                    <a href="{{ route('secretary.citizens.edit', $citizen) }}" class="px-3 py-1.5 bg-amber-100 hover:bg-amber-200 text-amber-800 text-xs font-bold rounded-lg transition">
                                                        Edit
                                                    </a>
                                                    <form method="POST" action="{{ route('secretary.citizens.destroy', $citizen) }}" style="display:inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" onclick="return confirm('Are you sure?')" class="px-3 py-1.5 bg-red-100 hover:bg-red-200 text-red-800 text-xs font-bold rounded-lg transition">
                                                            Delete
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <div class="mt-6">
                            {{ $citizens->links() }}
                        </div>
                    @else
                        <div class="text-center py-16 bg-gradient-to-b from-gray-50 to-transparent rounded-lg border-2 border-dashed border-gray-300">
                            <svg class="mx-auto h-14 w-14 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.856-1.487M15 10a3 3 0 11-6 0 3 3 0 016 0zM6 20a9 9 0 0118 0v2h-2v-2a7 7 0 00-14 0v2H6v-2z" />
                            </svg>
                            <p class="text-lg font-semibold text-gray-900">No citizens found</p>
                            <p class="text-sm text-gray-600 mt-2">Start by adding a new citizen to the system</p>
                            <a href="{{ route('secretary.citizens.create') }}" class="mt-4 inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-semibold rounded-lg transition shadow-md hover:shadow-lg">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                </svg>
                                Add First Citizen
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
