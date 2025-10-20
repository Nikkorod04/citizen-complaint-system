<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
                {{ __('Edit Complaint') }}
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
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 border-b border-gray-200">
                    <div class="mb-4">
                        <h3 class="text-lg font-semibold text-gray-900 mb-1">Complaint #{{ str_pad($complaint->id, 4, '0', STR_PAD_LEFT) }}</h3>
                        <p class="text-sm text-gray-600">Status: 
                            <span class="px-3 py-1 rounded-full bg-yellow-100 text-yellow-800 font-medium">
                                Pending
                            </span>
                        </p>
                    </div>
                    <p class="text-sm text-gray-700 mb-4">You can only edit complaints that are still pending. Once validated by the secretary, the complaint details are locked.</p>
                </div>

                <form action="{{ route('complaints.update', $complaint) }}" method="POST" enctype="multipart/form-data" class="p-6">
                    @csrf
                    @method('PUT')

                    <div class="space-y-6">
                        <!-- Category -->
                        <div>
                            <label for="complaint_category_id" class="block font-semibold text-gray-900 mb-2">
                                Category <span class="text-red-600">*</span>
                            </label>
                            <select id="complaint_category_id" name="complaint_category_id" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 @error('complaint_category_id') border-red-500 @enderror">
                                <option value="">Select a category</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" @selected(old('complaint_category_id', $complaint->complaint_category_id) == $category->id)>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('complaint_category_id')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Subject -->
                        <div>
                            <label for="subject" class="block font-semibold text-gray-900 mb-2">
                                Subject <span class="text-red-600">*</span>
                            </label>
                            <input type="text" id="subject" name="subject" value="{{ old('subject', $complaint->subject) }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 @error('subject') border-red-500 @enderror" required>
                            @error('subject')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Description -->
                        <div>
                            <label for="description" class="block font-semibold text-gray-900 mb-2">
                                Description <span class="text-red-600">*</span>
                            </label>
                            <div x-data="{ description: '{{ old('description', $complaint->description) }}' }">
                                <textarea id="description" name="description" rows="6" x-model="description" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 @error('description') border-red-500 @enderror" maxlength="2000" required>{{ old('description', $complaint->description) }}</textarea>
                                <p class="text-sm text-gray-600 mt-2" x-text="`${description.length} / 2000 characters`"></p>
                            </div>
                            @error('description')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Location -->
                        <div>
                            <label for="location" class="block font-semibold text-gray-900 mb-2">
                                Location
                            </label>
                            <input type="text" id="location" name="location" value="{{ old('location', $complaint->location) }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500" placeholder="Where did this happen?">
                            @error('location')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Evidence -->
                        <div x-data="complaintEditForm()">
                            <label class="block font-semibold text-gray-900 mb-2">
                                Evidence (Photos/Videos)
                                <span class="text-sm font-normal text-gray-600">- Optional, update to add new files</span>
                            </label>

                            <!-- Current Evidence -->
                            @if($complaint->media && $complaint->media->count() > 0)
                                <div class="mb-4">
                                    <h4 class="font-medium text-gray-900 mb-2">Current Evidence</h4>
                                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                                        @foreach($complaint->media as $media)
                                            <div class="relative group">
                                                @if(str_starts_with($media->mime_type, 'image/'))
                                                    <img src="{{ $media->getUrl() }}" alt="Evidence" class="w-full h-32 object-cover rounded-lg">
                                                @else
                                                    <div class="w-full h-32 bg-gray-200 rounded-lg flex items-center justify-center">
                                                        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" />
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                        </svg>
                                                    </div>
                                                @endif
                                                <p class="text-xs text-gray-600 mt-2 text-center truncate">{{ $media->file_name }}</p>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            <!-- New Evidence Upload -->
                            <div class="border-2 border-dashed border-gray-300 rounded-lg p-8 text-center cursor-pointer hover:border-indigo-500 transition"
                                @dragover.prevent="$el.classList.add('border-indigo-500', 'bg-indigo-50')"
                                @dragleave.prevent="$el.classList.remove('border-indigo-500', 'bg-indigo-50')"
                                @drop.prevent="handleDrop($event); $el.classList.remove('border-indigo-500', 'bg-indigo-50')"
                                @click="$refs.evidence.click()">
                                <svg class="mx-auto h-12 w-12 text-gray-400 mb-2" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                    <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-8l-3.172-3.172a4 4 0 00-5.656 0L28 20M12 20l3.172-3.172a4 4 0 015.656 0L28 20" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                                <p class="font-semibold text-gray-900">Drag and drop files here</p>
                                <p class="text-sm text-gray-600">or click to browse</p>
                                <p class="text-xs text-gray-500 mt-2">Supported: JPG, PNG, MP4, MOV (max 5 files, 20MB each)</p>
                            </div>

                            <input type="file" 
                                x-ref="evidence" 
                                id="evidence" 
                                name="evidence[]" 
                                multiple 
                                accept="image/jpeg,image/png,video/mp4,video/quicktime"
                                @change="updateFileList($event)"
                                class="hidden">

                            <!-- File List -->
                            <template x-if="files.length > 0">
                                <div class="mt-4">
                                    <h4 class="font-medium text-gray-900 mb-2">
                                        New Files to Upload (<span x-text="files.length"></span>/5)
                                    </h4>
                                    <ul class="space-y-2">
                                        <template x-for="(file, index) in files" :key="index">
                                            <li class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                                <div class="flex items-center flex-1">
                                                    <svg class="w-5 h-5 text-gray-400 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M8 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM15 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z" clip-rule="evenodd" />
                                                        <path d="M3 4a1 1 0 00-1 1v10a1 1 0 001 1h1.05a2.5 2.5 0 014.9 0H10a1 1 0 001-1V5a1 1 0 00-1-1H3zM14 7a1 1 0 00-1 1v6.05A2.5 2.5 0 0115.95 16H17a1 1 0 001-1v-5a1 1 0 00-.293-.707l-2-2A1 1 0 0015 7h-1z" />
                                                    </svg>
                                                    <div class="flex-1">
                                                        <p class="text-sm font-medium text-gray-900" x-text="file.name"></p>
                                                        <p class="text-xs text-gray-600" x-text="`${(file.size / 1024 / 1024).toFixed(2)} MB`"></p>
                                                    </div>
                                                </div>
                                                <button type="button" @click="removeFile(index)" class="text-red-600 hover:text-red-800 text-sm font-medium">
                                                    Remove
                                                </button>
                                            </li>
                                        </template>
                                    </ul>
                                </div>
                            </template>

                            @error('evidence')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Submit Buttons -->
                        <div class="flex gap-4 pt-6 border-t">
                            <button type="submit" class="flex-1 bg-indigo-600 text-white font-semibold py-2 px-4 rounded-lg hover:bg-indigo-700 transition flex items-center justify-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                                Update Complaint
                            </button>
                            <a href="{{ route('citizen.complaints') }}" class="flex-1 bg-gray-200 text-gray-900 font-semibold py-2 px-4 rounded-lg hover:bg-gray-300 transition text-center">
                                Cancel
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function complaintEditForm() {
            return {
                files: [],
                updateFileList(event) {
                    this.files = Array.from(event.target.files);
                    if (this.files.length > 5) {
                        alert('Maximum 5 files allowed');
                        this.files = this.files.slice(0, 5);
                        document.getElementById('evidence').value = '';
                    }
                },
                removeFile(index) {
                    this.files.splice(index, 1);
                    const dataTransfer = new DataTransfer();
                    this.files.forEach(file => dataTransfer.items.add(file));
                    document.getElementById('evidence').files = dataTransfer.files;
                },
                handleDrop(event) {
                    const droppedFiles = Array.from(event.dataTransfer.files);
                    const inputElement = this.$refs.evidence;
                    const dataTransfer = new DataTransfer();
                    
                    // Add existing files
                    Array.from(this.files).forEach(file => dataTransfer.items.add(file));
                    
                    // Add dropped files
                    droppedFiles.forEach(file => {
                        if (dataTransfer.items.length < 5) {
                            dataTransfer.items.add(file);
                        }
                    });
                    
                    inputElement.files = dataTransfer.files;
                    this.updateFileList({ target: inputElement });
                }
            }
        }
    </script>
</x-app-layout>
