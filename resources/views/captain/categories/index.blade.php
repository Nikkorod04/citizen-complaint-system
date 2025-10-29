<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-bold text-3xl text-gray-900 leading-tight">
                    {{ __('Complaint Categories') }}
                </h2>
                <p class="text-sm text-gray-600 mt-1">Manage all complaint categories in the system</p>
            </div>
            <a href="{{ route('captain.categories.create') }}" class="px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-semibold rounded-lg transition shadow-md hover:shadow-lg flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Add Category
            </a>
        </div>
    </x-slot>

    <div class="py-12 bg-gradient-to-b from-blue-50/30 to-transparent min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="mb-4 p-4 bg-green-100 border border-green-300 text-green-800 rounded-lg flex items-center gap-3">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                    </svg>
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="mb-4 p-4 bg-red-100 border border-red-300 text-red-800 rounded-lg flex items-center gap-3">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                    </svg>
                    {{ session('error') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-md sm:rounded-xl border border-gray-100">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="bg-gradient-to-r from-blue-50 to-blue-100 border-b border-gray-200">
                                <th class="px-6 py-4 text-left text-sm font-bold text-gray-900">Category Name</th>
                                <th class="px-6 py-4 text-left text-sm font-bold text-gray-900">Description</th>
                                <th class="px-6 py-4 text-left text-sm font-bold text-gray-900">Republic Act</th>
                                <th class="px-6 py-4 text-center text-sm font-bold text-gray-900">Complaints</th>
                                <th class="px-6 py-4 text-center text-sm font-bold text-gray-900">Status</th>
                                <th class="px-6 py-4 text-center text-sm font-bold text-gray-900">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse ($categories as $category)
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="px-6 py-4 text-sm font-semibold text-gray-900">{{ $category->name }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-600">{{ Str::limit($category->description, 50) }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-600">{{ $category->republic_act ?? 'N/A' }}</td>
                                    <td class="px-6 py-4 text-center">
                                        <span class="px-3 py-1 text-sm font-semibold text-blue-800 bg-blue-100 rounded-full">
                                            {{ $category->complaints_count }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <span class="px-3 py-1 text-sm font-semibold rounded-full {{ $category->is_active ? 'text-green-800 bg-green-100' : 'text-gray-800 bg-gray-100' }}">
                                            {{ $category->is_active ? 'Active' : 'Inactive' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <div class="flex items-center justify-center gap-2">
                                            <a href="{{ route('captain.categories.edit', $category) }}" class="px-3 py-2 text-sm font-semibold text-blue-600 hover:text-blue-700 rounded-lg hover:bg-blue-50 transition">
                                                Edit
                                            </a>
                                            <form method="POST" action="{{ route('captain.categories.destroy', $category) }}" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" onclick="return confirm('Are you sure you want to delete this category?')" class="px-3 py-2 text-sm font-semibold text-red-600 hover:text-red-700 rounded-lg hover:bg-red-50 transition">
                                                    Delete
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-8 text-center text-gray-600">
                                        No complaint categories found. <a href="{{ route('captain.categories.create') }}" class="text-blue-600 hover:text-blue-700 font-semibold">Create one</a>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if ($categories->hasPages())
                    <div class="px-6 py-4 border-t border-gray-200">
                        {{ $categories->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
