<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-bold text-3xl text-gray-900 leading-tight">
                    {{ __('Edit Citizen') }}
                </h2>
                <p class="text-sm text-gray-600 mt-1">Update {{ $user->full_name }} information</p>
            </div>
        </div>
    </x-slot>

    <div class="py-12 bg-gradient-to-b from-blue-50/30 to-transparent min-h-screen">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-md sm:rounded-xl border border-gray-100">
                <div class="p-6 sm:p-8">
                    <form method="POST" action="{{ route('secretary.citizens.update', $user) }}" class="space-y-8" enctype="multipart/form-data" x-data="editCitizenForm()" @change="calculateAge()">
                        @csrf
                        @method('PUT')

                        <!-- Personal Information -->
                        <div>
                            <h3 class="text-lg font-bold text-gray-900 mb-6 flex items-center">
                                <svg class="w-6 h-6 mr-3 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                Personal Information
                            </h3>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- First Name -->
                                <div>
                                    <label for="first_name" class="block text-sm font-bold text-gray-900 mb-2">First Name <span class="text-red-600">*</span></label>
                                    <input type="text" id="first_name" name="first_name" value="{{ old('first_name', $user->first_name) }}" required @input="filterAlphabeticOnly($event)" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:border-blue-600 focus:ring-1 focus:ring-blue-500 @error('first_name') border-red-500 @enderror" />
                                    @error('first_name') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                                </div>

                                <!-- Middle Name -->
                                <div>
                                    <label for="middle_name" class="block text-sm font-bold text-gray-900 mb-2">Middle Name</label>
                                    <input type="text" id="middle_name" name="middle_name" value="{{ old('middle_name', $user->middle_name) }}" @input="filterAlphabeticOnly($event)" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:border-blue-600 focus:ring-1 focus:ring-blue-500" />
                                </div>

                                <!-- Last Name -->
                                <div>
                                    <label for="last_name" class="block text-sm font-bold text-gray-900 mb-2">Last Name <span class="text-red-600">*</span></label>
                                    <input type="text" id="last_name" name="last_name" value="{{ old('last_name', $user->last_name) }}" required @input="filterAlphabeticOnly($event)" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:border-blue-600 focus:ring-1 focus:ring-blue-500 @error('last_name') border-red-500 @enderror" />
                                    @error('last_name') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                                </div>

                                <!-- Suffix -->
                                <div>
                                    <label for="suffix" class="block text-sm font-bold text-gray-900 mb-2">Suffix (Jr., Sr., etc.)</label>
                                    <input type="text" id="suffix" name="suffix" value="{{ old('suffix', $user->suffix) }}" @input="filterAlphabeticOnly($event)" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:border-blue-600 focus:ring-1 focus:ring-blue-500" />
                                </div>

                                <!-- Email -->
                                <div class="md:col-span-2">
                                    <label for="email" class="block text-sm font-bold text-gray-900 mb-2">Email Address <span class="text-red-600">*</span></label>
                                    <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:border-blue-600 focus:ring-1 focus:ring-blue-500 @error('email') border-red-500 @enderror" />
                                    @error('email') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                                </div>

                                <!-- Phone -->
                                <div>
                                    <label for="phone" class="block text-sm font-bold text-gray-900 mb-2">Phone Number <span class="text-red-600">*</span></label>
                                    <input type="text" id="phone" name="phone" value="{{ old('phone', $user->phone) }}" required maxlength="11" @input="formatPhoneNumber($event)" placeholder="09XXXXXXXXX" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:border-blue-600 focus:ring-1 focus:ring-blue-500 @error('phone') border-red-500 @enderror" />
                                    @error('phone') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                                </div>

                                <!-- Date of Birth -->
                                <div>
                                    <label for="date_of_birth" class="block text-sm font-bold text-gray-900 mb-2">Date of Birth <span class="text-red-600">*</span></label>
                                    <input type="date" id="date_of_birth" name="date_of_birth" value="{{ old('date_of_birth', $user->date_of_birth->format('Y-m-d')) }}" required @change="calculateAge()" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:border-blue-600 focus:ring-1 focus:ring-blue-500 @error('date_of_birth') border-red-500 @enderror" />
                                    @error('date_of_birth') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                                </div>

                                <!-- Age -->
                                <div>
                                    <label for="age" class="block text-sm font-bold text-gray-900 mb-2">Age</label>
                                    <div class="w-full bg-gray-100 border border-gray-300 text-gray-900 rounded-lg px-4 py-2 font-semibold">
                                        <span x-text="age || '{{ $user->age }}'"></span>
                                    </div>
                                    <input type="hidden" name="age" x-model="age" />
                                </div>

                                <!-- Gender -->
                                <div>
                                    <label for="gender" class="block text-sm font-bold text-gray-900 mb-2">Gender <span class="text-red-600">*</span></label>
                                    <select id="gender" name="gender" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:border-blue-600 focus:ring-1 focus:ring-blue-500 @error('gender') border-red-500 @enderror">
                                        <option value="Male" {{ old('gender', $user->gender) === 'Male' ? 'selected' : '' }}>Male</option>
                                        <option value="Female" {{ old('gender', $user->gender) === 'Female' ? 'selected' : '' }}>Female</option>
                                        <option value="Other" {{ old('gender', $user->gender) === 'Other' ? 'selected' : '' }}>Other</option>
                                    </select>
                                    @error('gender') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                                </div>

                                <!-- Civil Status -->
                                <div>
                                    <label for="civil_status" class="block text-sm font-bold text-gray-900 mb-2">Civil Status <span class="text-red-600">*</span></label>
                                    <select id="civil_status" name="civil_status" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:border-blue-600 focus:ring-1 focus:ring-blue-500 @error('civil_status') border-red-500 @enderror">
                                        <option value="Single" {{ old('civil_status', $user->civil_status) === 'Single' ? 'selected' : '' }}>Single</option>
                                        <option value="Married" {{ old('civil_status', $user->civil_status) === 'Married' ? 'selected' : '' }}>Married</option>
                                        <option value="Widowed" {{ old('civil_status', $user->civil_status) === 'Widowed' ? 'selected' : '' }}>Widowed</option>
                                        <option value="Separated" {{ old('civil_status', $user->civil_status) === 'Separated' ? 'selected' : '' }}>Separated</option>
                                        <option value="Divorced" {{ old('civil_status', $user->civil_status) === 'Divorced' ? 'selected' : '' }}>Divorced</option>
                                    </select>
                                    @error('civil_status') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                                </div>

                                <!-- Occupation -->
                                <div class="md:col-span-2">
                                    <label for="occupation" class="block text-sm font-bold text-gray-900 mb-2">Occupation</label>
                                    <input type="text" id="occupation" name="occupation" value="{{ old('occupation', $user->occupation) }}" @input="filterAlphabeticOnly($event)" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:border-blue-600 focus:ring-1 focus:ring-blue-500" />
                                </div>

                                <!-- National ID -->
                                <div class="md:col-span-2">
                                    <label for="national_id" class="block text-sm font-bold text-gray-900 mb-2">National ID (PhilID, Driver's License, etc.) <span class="text-red-600">*</span></label>
                                    <input type="text" id="national_id" name="national_id" value="{{ old('national_id', $user->national_id) }}" required maxlength="19" @input="formatNationalId($event)" placeholder="XXXX-XXXX-XXXX-XXXX" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:border-blue-600 focus:ring-1 focus:ring-blue-500 @error('national_id') border-red-500 @enderror" />
                                    @error('national_id') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                                    <p class="text-xs text-gray-500 mt-1">Format: 4-4-4-4 (auto-formatted)</p>
                                </div>

                                <!-- National ID Image -->
                                <div class="md:col-span-2">
                                    <label for="national_id_image" class="block text-sm font-bold text-gray-900 mb-2">National ID Image (JPEG, PNG, JPG - Max 2MB)</label>
                                    <div class="flex flex-col gap-3">
                                        @if ($user->national_id_image)
                                            <div class="relative w-full h-48 rounded-lg border-2 border-gray-300 overflow-hidden bg-gray-100 flex items-center justify-center">
                                                <img src="{{ Storage::url($user->national_id_image) }}" alt="National ID Image" class="w-full h-full object-cover" />
                                            </div>
                                        @endif
                                        <input type="file" id="national_id_image" name="national_id_image" accept="image/jpeg,image/png,image/jpg" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:border-blue-600 focus:ring-1 focus:ring-blue-500 @error('national_id_image') border-red-500 @enderror" />
                                        @error('national_id_image') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                                        <p class="text-xs text-gray-500">Supported formats: JPEG, PNG, JPG. Maximum file size: 2MB</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Address Information -->
                        <div>
                            <h3 class="text-lg font-bold text-gray-900 mb-6 flex items-center">
                                <svg class="w-6 h-6 mr-3 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                </svg>
                                Address Information
                            </h3>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- House Number -->
                                <div>
                                    <label for="house_number" class="block text-sm font-bold text-gray-900 mb-2">House Number <span class="text-red-600">*</span></label>
                                    <input type="text" id="house_number" name="house_number" value="{{ old('house_number', $user->house_number) }}" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:border-blue-600 focus:ring-1 focus:ring-blue-500 @error('house_number') border-red-500 @enderror" />
                                    @error('house_number') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                                </div>

                                <!-- Street -->
                                <div>
                                    <label for="street" class="block text-sm font-bold text-gray-900 mb-2">Street <span class="text-red-600">*</span></label>
                                    <input type="text" id="street" name="street" value="{{ old('street', $user->street) }}" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:border-blue-600 focus:ring-1 focus:ring-blue-500 @error('street') border-red-500 @enderror" />
                                    @error('street') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                                </div>

                                <!-- Barangay -->
                                <div>
                                    <label for="barangay" class="block text-sm font-bold text-gray-900 mb-2">Barangay <span class="text-red-600">*</span></label>
                                    <input type="text" id="barangay" name="barangay" value="{{ old('barangay', $user->barangay) }}" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:border-blue-600 focus:ring-1 focus:ring-blue-500 @error('barangay') border-red-500 @enderror" />
                                    @error('barangay') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                                </div>

                                <!-- City -->
                                <div>
                                    <label for="city" class="block text-sm font-bold text-gray-900 mb-2">City/Municipality <span class="text-red-600">*</span></label>
                                    <input type="text" id="city" name="city" value="{{ old('city', $user->city) }}" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:border-blue-600 focus:ring-1 focus:ring-blue-500 @error('city') border-red-500 @enderror" />
                                    @error('city') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                                </div>

                                <!-- Province -->
                                <div>
                                    <label for="province" class="block text-sm font-bold text-gray-900 mb-2">Province <span class="text-red-600">*</span></label>
                                    <input type="text" id="province" name="province" value="{{ old('province', $user->province) }}" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:border-blue-600 focus:ring-1 focus:ring-blue-500 @error('province') border-red-500 @enderror" />
                                    @error('province') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                                </div>

                                <!-- Zip Code -->
                                <div>
                                    <label for="zip_code" class="block text-sm font-bold text-gray-900 mb-2">Zip Code <span class="text-red-600">*</span></label>
                                    <input type="text" id="zip_code" name="zip_code" value="{{ old('zip_code', $user->zip_code) }}" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:border-blue-600 focus:ring-1 focus:ring-blue-500 @error('zip_code') border-red-500 @enderror" />
                                    @error('zip_code') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Emergency Contact -->
                        <div>
                            <h3 class="text-lg font-bold text-gray-900 mb-6 flex items-center">
                                <svg class="w-6 h-6 mr-3 text-orange-600" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M6.62 10.79c1.44 2.83 3.76 5.14 6.59 6.59l2.2-2.2c.27-.27.67-.36 1.02-.24 1.12.37 2.33.57 3.57.57.55 0 1 .45 1 1V20c0 .55-.45 1-1 1-9.39 0-17-7.61-17-17 0-.55.45-1 1-1h3.5c.55 0 1 .45 1 1 0 1.25.2 2.45.57 3.57.11.35.03.74-.25 1.02l-2.2 2.2z"/>
                                </svg>
                                Emergency Contact
                            </h3>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Emergency Contact Name -->
                                <div>
                                    <label for="emergency_contact_name" class="block text-sm font-bold text-gray-900 mb-2">Name</label>
                                    <input type="text" id="emergency_contact_name" name="emergency_contact_name" value="{{ old('emergency_contact_name', $user->emergency_contact_name) }}" @input="filterAlphabeticOnly($event)" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:border-blue-600 focus:ring-1 focus:ring-blue-500 @error('emergency_contact_name') border-red-500 @enderror" />
                                    @error('emergency_contact_name') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                                </div>

                                <!-- Emergency Contact Number -->
                                <div>
                                    <label for="emergency_contact_number" class="block text-sm font-bold text-gray-900 mb-2">Phone Number</label>
                                    <input type="text" id="emergency_contact_number" name="emergency_contact_number" value="{{ old('emergency_contact_number', $user->emergency_contact_number) }}" maxlength="11" @input="formatPhoneNumber($event)" placeholder="09XXXXXXXXX" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:border-blue-600 focus:ring-1 focus:ring-blue-500 @error('emergency_contact_number') border-red-500 @enderror" />
                                    @error('emergency_contact_number') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="flex items-center justify-between gap-4 pt-6 border-t border-gray-200">
                            <a href="{{ route('secretary.citizens.show', $user) }}" class="px-6 py-3 text-gray-700 font-semibold rounded-lg border border-gray-300 hover:bg-gray-50 transition">
                                Cancel
                            </a>
                            <button type="submit" class="px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-semibold rounded-lg transition shadow-md hover:shadow-lg flex items-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                                Save Changes
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<script>
    function editCitizenForm() {
        return {
            age: '{{ $user->age }}',
            calculateAge() {
                const dateOfBirthInput = document.getElementById('date_of_birth');
                if (dateOfBirthInput && dateOfBirthInput.value) {
                    const today = new Date();
                    const birthDate = new Date(dateOfBirthInput.value);
                    let age = today.getFullYear() - birthDate.getFullYear();
                    const monthDiff = today.getMonth() - birthDate.getMonth();
                    
                    if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < birthDate.getDate())) {
                        age--;
                    }
                    
                    this.age = age;
                }
            },
            filterAlphabeticOnly(event) {
                // Allow only letters, spaces, and hyphens
                event.target.value = event.target.value.replace(/[^a-zA-Z\s\-]/g, '');
            },
            formatPhoneNumber(event) {
                // Remove all non-numeric characters
                let value = event.target.value.replace(/\D/g, '');
                
                // Limit to 11 digits
                if (value.length > 11) {
                    value = value.slice(0, 11);
                }
                
                // Enforce 09 prefix
                if (value.length > 0 && !value.startsWith('09')) {
                    value = '09' + value.replace(/^0+/, '').slice(0, 9);
                }
                
                event.target.value = value;
            },
            formatNationalId(event) {
                // Remove all non-numeric characters
                let value = event.target.value.replace(/\D/g, '');
                
                // Limit to 16 digits
                if (value.length > 16) {
                    value = value.slice(0, 16);
                }
                
                // Format with dashes every 4 digits (4-4-4-4)
                let formatted = '';
                for (let i = 0; i < value.length; i++) {
                    if (i > 0 && i % 4 === 0) {
                        formatted += '-';
                    }
                    formatted += value[i];
                }
                
                // Update the input value
                event.target.value = formatted;
            }
        }
    }
</script>
