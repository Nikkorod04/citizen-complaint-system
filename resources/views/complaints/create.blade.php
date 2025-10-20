<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
                {{ __('File a New Complaint') }}
            </h2>
            <a href="{{ route('citizen.complaints') }}" class="text-sm text-indigo-600 hover:text-indigo-800 font-medium flex items-center">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Back to My Complaints
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form method="POST" action="{{ route('complaints.store') }}" enctype="multipart/form-data" x-data="complaintForm()">
                        @csrf

                        <div class="space-y-6">
                            <!-- Complaint Category -->
                            <div>
                                <x-input-label for="complaint_category_id" :value="__('Complaint Category')" />
                                <select id="complaint_category_id" name="complaint_category_id" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                    <option value="">Select a category...</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ old('complaint_category_id') == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('complaint_category_id')" class="mt-2" />
                            </div>

                            <!-- Subject -->
                            <div>
                                <x-input-label for="subject" :value="__('Complaint Subject')" />
                                <x-text-input id="subject" class="block mt-1 w-full" type="text" name="subject" :value="old('subject')" required placeholder="Brief summary of your complaint" />
                                <p class="mt-1 text-xs text-gray-500">Maximum 255 characters</p>
                                <x-input-error :messages="$errors->get('subject')" class="mt-2" />
                            </div>

                            <!-- Description -->
                            <div>
                                <x-input-label for="description" :value="__('Complaint Description')" />
                                <textarea id="description" name="description" rows="6" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required placeholder="Provide detailed information about your complaint...">{{ old('description') }}</textarea>
                                <p class="mt-1 text-xs text-gray-500">Maximum 2000 characters | <span x-text="description.length"></span> characters used</p>
                                <x-input-error :messages="$errors->get('description')" class="mt-2" />
                            </div>

                            <!-- Location -->
                            <div>
                                <x-input-label for="location" :value="__('Location of Incident (Optional)')" />
                                <x-text-input id="location" class="block mt-1 w-full" type="text" name="location" :value="old('location')" placeholder="Where did this happen?" />
                                <x-input-error :messages="$errors->get('location')" class="mt-2" />
                            </div>

                            <!-- Evidence Upload -->
                            <div>
                                <x-input-label for="evidence" :value="__('Upload Evidence (Photos/Videos - Optional)')" />
                                <div class="mt-2">
                                    <div class="flex items-center justify-center w-full">
                                        <label for="evidence" class="flex flex-col items-center justify-center w-full h-64 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 hover:bg-gray-100 transition">
                                            <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                                <svg class="w-10 h-10 mb-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                                                </svg>
                                                <p class="mb-2 text-sm text-gray-500"><span class="font-semibold">Click to upload</span> or drag and drop</p>
                                                <p class="text-xs text-gray-500">PNG, JPG, JPEG, MP4, MPEG, MOV (MAX. 20MB per file)</p>
                                            </div>
                                            <input id="evidence" name="evidence[]" type="file" class="hidden" multiple accept="image/jpeg,image/png,image/jpg,video/mp4,video/mpeg,video/quicktime" @change="updateFileList($event)" />
                                        </label>
                                    </div>
                                    
                                    <!-- File List -->
                                    <template x-if="files.length > 0">
                                        <div class="mt-4">
                                            <h4 class="font-semibold text-gray-900 mb-3">Selected Files:</h4>
                                            <ul class="space-y-2">
                                                <template x-for="(file, index) in files" :key="index">
                                                    <li class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                                        <div class="flex items-center">
                                                            <svg class="w-5 h-5 text-indigo-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                            </svg>
                                                            <span class="text-sm text-gray-900" x-text="file.name"></span>
                                                        </div>
                                                        <button @click.prevent="removeFile(index)" type="button" class="text-red-600 hover:text-red-700">
                                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                            </svg>
                                                        </button>
                                                    </li>
                                                </template>
                                            </ul>
                                        </div>
                                    </template>
                                </div>
                                <p class="mt-2 text-xs text-gray-500">You can upload up to 5 files as evidence for your complaint.</p>
                                <x-input-error :messages="$errors->get('evidence')" class="mt-2" />
                            </div>

                            <!-- Submit Button -->
                            <div class="flex justify-end gap-4 pt-6 border-t">
                                <a href="{{ route('citizen.complaints') }}" class="px-6 py-2 border border-gray-300 text-gray-700 font-medium rounded-lg hover:bg-gray-50 transition">
                                    Cancel
                                </a>
                                <button type="submit" class="px-6 py-2 bg-indigo-600 text-white font-medium rounded-lg hover:bg-indigo-700 transition flex items-center">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                                    </svg>
                                    File Complaint
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function complaintForm() {
            return {
                description: '',
                files: [],
                updateFileList(event) {
                    this.files = Array.from(event.target.files);
                    // Validate max 5 files
                    if (this.files.length > 5) {
                        alert('Maximum 5 files allowed');
                        this.files = this.files.slice(0, 5);
                        event.target.files = this.files; // This won't work with FileList, but we'll clear the input
                        document.getElementById('evidence').value = '';
                    }
                },
                removeFile(index) {
                    this.files.splice(index, 1);
                    // Update the file input
                    const dataTransfer = new DataTransfer();
                    this.files.forEach(file => dataTransfer.items.add(file));
                    document.getElementById('evidence').files = dataTransfer.files;
                }
            }
        }
    </script>
</x-app-layout>
