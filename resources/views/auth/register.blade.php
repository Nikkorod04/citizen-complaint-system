<x-guest-layout>
    <div class="mb-4 text-sm text-gray-600">
        <h2 class="text-xl font-semibold text-gray-900 mb-2">Citizen Registration</h2>
        <p>Register to file complaints with your barangay. Please fill in all required information accurately.</p>
    </div>

    <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data" x-data="registrationForm()">
        @csrf

        <div class="space-y-6">
            <!-- Personal Information Section -->
            <div class="bg-gray-50 p-4 rounded-lg">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Personal Information</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- First Name -->
                    <div>
                        <x-input-label for="first_name" :value="__('First Name')" />
                        <x-text-input id="first_name" class="block mt-1 w-full" type="text" name="first_name" :value="old('first_name')" required autofocus />
                        <x-input-error :messages="$errors->get('first_name')" class="mt-2" />
                    </div>

                    <!-- Middle Name -->
                    <div>
                        <x-input-label for="middle_name" :value="__('Middle Name (Optional)')" />
                        <x-text-input id="middle_name" class="block mt-1 w-full" type="text" name="middle_name" :value="old('middle_name')" />
                        <x-input-error :messages="$errors->get('middle_name')" class="mt-2" />
                    </div>

                    <!-- Last Name -->
                    <div>
                        <x-input-label for="last_name" :value="__('Last Name')" />
                        <x-text-input id="last_name" class="block mt-1 w-full" type="text" name="last_name" :value="old('last_name')" required />
                        <x-input-error :messages="$errors->get('last_name')" class="mt-2" />
                    </div>

                    <!-- Suffix -->
                    <div>
                        <x-input-label for="suffix" :value="__('Suffix (Jr, Sr, III, etc.)')" />
                        <x-text-input id="suffix" class="block mt-1 w-full" type="text" name="suffix" :value="old('suffix')" placeholder="Jr, Sr, III" />
                        <x-input-error :messages="$errors->get('suffix')" class="mt-2" />
                    </div>

                    <!-- Date of Birth -->
                    <div>
                        <x-input-label for="date_of_birth" :value="__('Date of Birth')" />
                        <x-text-input id="date_of_birth" class="block mt-1 w-full" type="date" name="date_of_birth" :value="old('date_of_birth')" required x-on:change="calculateAge()" />
                        <x-input-error :messages="$errors->get('date_of_birth')" class="mt-2" />
                    </div>

                    <!-- Age -->
                    <div>
                        <x-input-label for="age" :value="__('Age')" />
                        <x-text-input id="age" class="block mt-1 w-full" type="number" name="age" x-model="age" readonly />
                        <x-input-error :messages="$errors->get('age')" class="mt-2" />
                    </div>

                    <!-- Gender -->
                    <div>
                        <x-input-label for="gender" :value="__('Gender')" />
                        <select id="gender" name="gender" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                            <option value="">Select Gender</option>
                            <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Male</option>
                            <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Female</option>
                            <option value="other" {{ old('gender') == 'other' ? 'selected' : '' }}>Other</option>
                        </select>
                        <x-input-error :messages="$errors->get('gender')" class="mt-2" />
                    </div>

                    <!-- Civil Status -->
                    <div>
                        <x-input-label for="civil_status" :value="__('Civil Status')" />
                        <select id="civil_status" name="civil_status" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                            <option value="">Select Status</option>
                            <option value="single" {{ old('civil_status') == 'single' ? 'selected' : '' }}>Single</option>
                            <option value="married" {{ old('civil_status') == 'married' ? 'selected' : '' }}>Married</option>
                            <option value="widowed" {{ old('civil_status') == 'widowed' ? 'selected' : '' }}>Widowed</option>
                            <option value="separated" {{ old('civil_status') == 'separated' ? 'selected' : '' }}>Separated</option>
                            <option value="divorced" {{ old('civil_status') == 'divorced' ? 'selected' : '' }}>Divorced</option>
                        </select>
                        <x-input-error :messages="$errors->get('civil_status')" class="mt-2" />
                    </div>

                    <!-- Occupation -->
                    <div class="md:col-span-2">
                        <x-input-label for="occupation" :value="__('Occupation (Optional)')" />
                        <x-text-input id="occupation" class="block mt-1 w-full" type="text" name="occupation" :value="old('occupation')" placeholder="e.g., Teacher, Engineer, Self-employed" />
                        <x-input-error :messages="$errors->get('occupation')" class="mt-2" />
                    </div>
                </div>
            </div>

            <!-- Identification Section -->
            <div class="bg-gray-50 p-4 rounded-lg">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Identification</h3>
                
                <div class="space-y-4">
                    <!-- National ID Number -->
                    <div>
                        <x-input-label for="national_id" :value="__('Philippine National ID Number')" />
                        <x-text-input id="national_id" class="block mt-1 w-full" type="text" name="national_id" :value="old('national_id')" required placeholder="XXXX-XXXX-XXXX-XXXX" />
                        <p class="mt-1 text-xs text-gray-500">Enter your Philippine National ID number for verification</p>
                        <x-input-error :messages="$errors->get('national_id')" class="mt-2" />
                    </div>

                    <!-- National ID Image Upload -->
                    <div>
                        <x-input-label for="national_id_image" :value="__('Upload National ID Image')" />
                        <div class="mt-2">
                            <div class="flex items-center justify-center w-full">
                                <label for="national_id_image" class="flex flex-col items-center justify-center w-full h-64 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 hover:bg-gray-100 transition">
                                    <div x-show="!imagePreview" class="flex flex-col items-center justify-center pt-5 pb-6">
                                        <svg class="w-10 h-10 mb-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                                        </svg>
                                        <p class="mb-2 text-sm text-gray-500"><span class="font-semibold">Click to upload</span> or drag and drop</p>
                                        <p class="text-xs text-gray-500">PNG, JPG or JPEG (MAX. 2MB)</p>
                                    </div>
                                    <div x-show="imagePreview" class="relative w-full h-full p-4">
                                        <img :src="imagePreview" alt="ID Preview" class="w-full h-full object-contain rounded-lg">
                                        <button @click.prevent="clearImage()" type="button" class="absolute top-6 right-6 bg-red-500 text-white rounded-full p-2 hover:bg-red-600 shadow-lg">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                        </button>
                                    </div>
                                    <input id="national_id_image" name="national_id_image" type="file" class="hidden" accept="image/jpeg,image/png,image/jpg" @change="previewImage($event)" required />
                                </label>
                            </div>
                            <p class="mt-2 text-xs text-gray-500">
                                <strong>Note:</strong> Please upload a clear photo of your Philippine National ID (front side). This will be used for verification purposes only.
                            </p>
                            <x-input-error :messages="$errors->get('national_id_image')" class="mt-2" />
                        </div>
                    </div>
                </div>
            </div>

            <!-- Contact Information Section -->
            <div class="bg-gray-50 p-4 rounded-lg">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Contact Information</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Email -->
                    <div class="md:col-span-2">
                        <x-input-label for="email" :value="__('Email Address')" />
                        <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <!-- Phone -->
                    <div class="md:col-span-2">
                        <x-input-label for="phone" :value="__('Phone Number')" />
                        <x-text-input id="phone" class="block mt-1 w-full" type="text" name="phone" :value="old('phone')" required placeholder="09XXXXXXXXX" />
                        <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                    </div>
                </div>
            </div>

            <!-- Address Section -->
            <div class="bg-gray-50 p-4 rounded-lg">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Address Information</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- House Number -->
                    <div>
                        <x-input-label for="house_number" :value="__('House/Unit Number')" />
                        <x-text-input id="house_number" class="block mt-1 w-full" type="text" name="house_number" :value="old('house_number')" placeholder="e.g., 123" />
                        <x-input-error :messages="$errors->get('house_number')" class="mt-2" />
                    </div>

                    <!-- Street -->
                    <div>
                        <x-input-label for="street" :value="__('Street/Subdivision')" />
                        <x-text-input id="street" class="block mt-1 w-full" type="text" name="street" :value="old('street')" required placeholder="e.g., Main Street" />
                        <x-input-error :messages="$errors->get('street')" class="mt-2" />
                    </div>

                    <!-- Barangay -->
                    <div>
                        <x-input-label for="barangay" :value="__('Barangay')" />
                        <x-text-input id="barangay" class="block mt-1 w-full" type="text" name="barangay" :value="old('barangay')" required />
                        <x-input-error :messages="$errors->get('barangay')" class="mt-2" />
                    </div>

                    <!-- City -->
                    <div>
                        <x-input-label for="city" :value="__('City/Municipality')" />
                        <x-text-input id="city" class="block mt-1 w-full" type="text" name="city" :value="old('city')" required />
                        <x-input-error :messages="$errors->get('city')" class="mt-2" />
                    </div>

                    <!-- Province -->
                    <div>
                        <x-input-label for="province" :value="__('Province')" />
                        <x-text-input id="province" class="block mt-1 w-full" type="text" name="province" :value="old('province')" required />
                        <x-input-error :messages="$errors->get('province')" class="mt-2" />
                    </div>

                    <!-- Zip Code -->
                    <div>
                        <x-input-label for="zip_code" :value="__('Zip Code')" />
                        <x-text-input id="zip_code" class="block mt-1 w-full" type="text" name="zip_code" :value="old('zip_code')" placeholder="e.g., 1000" />
                        <x-input-error :messages="$errors->get('zip_code')" class="mt-2" />
                    </div>
                </div>
            </div>

            <!-- Emergency Contact Section -->
            <div class="bg-gray-50 p-4 rounded-lg">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Emergency Contact (Optional)</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Emergency Contact Name -->
                    <div>
                        <x-input-label for="emergency_contact_name" :value="__('Contact Person Name')" />
                        <x-text-input id="emergency_contact_name" class="block mt-1 w-full" type="text" name="emergency_contact_name" :value="old('emergency_contact_name')" />
                        <x-input-error :messages="$errors->get('emergency_contact_name')" class="mt-2" />
                    </div>

                    <!-- Emergency Contact Number -->
                    <div>
                        <x-input-label for="emergency_contact_number" :value="__('Contact Number')" />
                        <x-text-input id="emergency_contact_number" class="block mt-1 w-full" type="text" name="emergency_contact_number" :value="old('emergency_contact_number')" placeholder="09XXXXXXXXX" />
                        <x-input-error :messages="$errors->get('emergency_contact_number')" class="mt-2" />
                    </div>
                </div>
            </div>

            <!-- Account Security Section -->
            <div class="bg-gray-50 p-4 rounded-lg">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Account Security</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Password -->
                    <div class="md:col-span-2">
                        <x-input-label for="password" :value="__('Password')" />
                        <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
                        <p class="mt-1 text-xs text-gray-500">Minimum 8 characters</p>
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <!-- Confirm Password -->
                    <div class="md:col-span-2">
                        <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
                        <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" />
                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                    </div>
                </div>
            </div>
        </div>

        <div class="flex items-center justify-between mt-6">
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="ms-4">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>

        <script>
        function registrationForm() {
            return {
                dateOfBirth: '',
                age: '',
                imagePreview: null,
                calculateAge() {
                    if (this.dateOfBirth) {
                        const today = new Date();
                        const birthDate = new Date(this.dateOfBirth);
                        let age = today.getFullYear() - birthDate.getFullYear();
                        const monthDiff = today.getMonth() - birthDate.getMonth();
                        
                        if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < birthDate.getDate())) {
                            age--;
                        }
                        
                        this.age = age;
                    }
                },
                previewImage(event) {
                    const file = event.target.files[0];
                    if (file) {
                        // Validate file size (2MB max)
                        if (file.size > 2048 * 1024) {
                            alert('File size must not exceed 2MB');
                            event.target.value = '';
                            return;
                        }
                        
                        // Validate file type
                        const allowedTypes = ['image/jpeg', 'image/png', 'image/jpg'];
                        if (!allowedTypes.includes(file.type)) {
                            alert('Only JPEG, JPG, and PNG files are allowed');
                            event.target.value = '';
                            return;
                        }
                        
                        // Create preview
                        const reader = new FileReader();
                        reader.onload = (e) => {
                            this.imagePreview = e.target.result;
                        };
                        reader.readAsDataURL(file);
                    }
                },
                clearImage() {
                    this.imagePreview = null;
                    document.getElementById('national_id_image').value = '';
                }
            }
        }
    </script>
</x-guest-layout>
