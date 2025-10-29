<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-bold text-3xl text-gray-900 leading-tight">
                    {{ __('Create Complaint Category') }}
                </h2>
                <p class="text-sm text-gray-600 mt-1">Add a new complaint category to the system</p>
            </div>
        </div>
    </x-slot>

    <div class="py-12 bg-gradient-to-b from-blue-50/30 to-transparent min-h-screen">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-md sm:rounded-xl border border-gray-100">
                <div class="p-6 sm:p-8">
                    <form method="POST" action="{{ route('captain.categories.store') }}" class="space-y-6">
                        @csrf

                        <!-- Category Name -->
                        <div>
                            <label for="name" class="block text-sm font-bold text-gray-900 mb-2">Category Name <span class="text-red-600">*</span></label>
                            <input type="text" id="name" name="name" value="{{ old('name') }}" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:border-blue-600 focus:ring-1 focus:ring-blue-500 @error('name') border-red-500 @enderror" placeholder="e.g., Noise Pollution, Illegal Vendors" />
                            @error('name') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                        </div>

                        <!-- Description -->
                        <div>
                            <label for="description" class="block text-sm font-bold text-gray-900 mb-2">Description</label>
                            <textarea id="description" name="description" rows="4" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:border-blue-600 focus:ring-1 focus:ring-blue-500 @error('description') border-red-500 @enderror" placeholder="Describe what this category covers...">{{ old('description') }}</textarea>
                            @error('description') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                        </div>

                        <!-- Republic Act -->
                        <div>
                            <label for="republic_act" class="block text-sm font-bold text-gray-900 mb-2">Republic Act Reference</label>
                            <input type="text" id="republic_act" name="republic_act" value="{{ old('republic_act') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:border-blue-600 focus:ring-1 focus:ring-blue-500 @error('republic_act') border-red-500 @enderror" placeholder="e.g., RA 9003, RA 8353" />
                            @error('republic_act') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                        </div>

                        <!-- Active Status -->
                        <div class="flex items-center gap-3">
                            <input type="checkbox" id="is_active" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }} class="w-5 h-5 text-blue-600 rounded border-gray-300 focus:ring-blue-500" />
                            <label for="is_active" class="text-sm font-semibold text-gray-900">Active (Allow complaints in this category)</label>
                        </div>

                        <!-- Actions -->
                        <div class="flex items-center justify-between gap-4 pt-6 border-t border-gray-200">
                            <a href="{{ route('captain.categories.index') }}" class="px-6 py-3 text-gray-700 font-semibold rounded-lg border border-gray-300 hover:bg-gray-50 transition">
                                Cancel
                            </a>
                            <button type="submit" class="px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-semibold rounded-lg transition shadow-md hover:shadow-lg flex items-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                </svg>
                                Create Category
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
