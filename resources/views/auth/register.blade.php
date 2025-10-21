<x-guest-layout>
    <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data" x-data="registrationForm()" class="w-full">
        @csrf

        <!-- Header -->
        <div class="mb-6 text-center">
            <h2 class="text-2xl font-bold text-white mb-1">Create Your Account</h2>
            <p class="text-white/60 text-sm">Join us and make your voice heard in the community</p>
        </div>

        <div class="space-y-4 max-h-[65vh] overflow-y-auto pr-3 custom-scrollbar">
            <!-- Personal Information Section -->
            <div class="bg-white/5 p-4 rounded-xl border border-white/10">
                <h3 class="text-base font-bold text-white mb-3 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-indigo-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                    </svg>
                    Personal Information
                </h3>
                
                <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-3">
                    <!-- First Name -->
                    <div class="col-span-1">
                        <label class="block text-xs font-medium text-white/80 mb-1">First Name *</label>
                        <input type="text" name="first_name" value="{{ old('first_name') }}" @input="filterAlphabeticOnly('first_name')" required autofocus placeholder="John" class="w-full bg-white/10 border border-white/20 text-white placeholder-white/40 rounded-lg px-3 py-2 text-sm focus:border-indigo-400 focus:bg-white/15 transition" />
                        <x-input-error :messages="$errors->get('first_name')" class="mt-1 text-red-400 text-xs" />
                    </div>

                    <!-- Middle Name -->
                    <div class="col-span-1">
                        <label class="block text-xs font-medium text-white/80 mb-1">Middle Name</label>
                        <input type="text" name="middle_name" value="{{ old('middle_name') }}" @input="filterAlphabeticOnly('middle_name')" placeholder="Optional" class="w-full bg-white/10 border border-white/20 text-white placeholder-white/40 rounded-lg px-3 py-2 text-sm focus:border-indigo-400 focus:bg-white/15 transition" />
                        <x-input-error :messages="$errors->get('middle_name')" class="mt-1 text-red-400 text-xs" />
                    </div>

                    <!-- Last Name -->
                    <div class="col-span-1">
                        <label class="block text-xs font-medium text-white/80 mb-1">Last Name *</label>
                        <input type="text" name="last_name" value="{{ old('last_name') }}" @input="filterAlphabeticOnly('last_name')" required placeholder="Doe" class="w-full bg-white/10 border border-white/20 text-white placeholder-white/40 rounded-lg px-3 py-2 text-sm focus:border-indigo-400 focus:bg-white/15 transition" />
                        <x-input-error :messages="$errors->get('last_name')" class="mt-1 text-red-400 text-xs" />
                    </div>

                    <!-- Suffix -->
                    <div class="col-span-1">
                        <label class="block text-xs font-medium text-white/80 mb-1">Suffix</label>
                        <input type="text" name="suffix" value="{{ old('suffix') }}" @input="filterAlphabeticOnly('suffix')" placeholder="Jr, Sr, III" class="w-full bg-white/10 border border-white/20 text-white placeholder-white/40 rounded-lg px-3 py-2 text-sm focus:border-indigo-400 focus:bg-white/15 transition" />
                        <x-input-error :messages="$errors->get('suffix')" class="mt-1 text-red-400 text-xs" />
                    </div>

                    <!-- Date of Birth -->
                    <div class="col-span-2 sm:col-span-1">
                        <label class="block text-xs font-medium text-white/80 mb-1">Date of Birth *</label>
                        <input type="date" name="date_of_birth" value="{{ old('date_of_birth') }}" required @change="calculateAge()" class="w-full bg-white/10 border border-white/20 text-white rounded-lg px-3 py-2 text-sm focus:border-indigo-400 focus:bg-white/15 transition" />
                        <x-input-error :messages="$errors->get('date_of_birth')" class="mt-1 text-red-400 text-xs" />
                    </div>

                    <!-- Age -->
                    <div class="col-span-1">
                        <label class="block text-xs font-medium text-white/80 mb-1">Age</label>
                        <div class="w-full bg-white/5 border border-white/20 text-white rounded-lg px-3 py-2 text-sm font-semibold">
                            <span x-text="age || '—'"></span>
                        </div>
                        <input type="hidden" name="age" x-model="age" />
                    </div>

                    <!-- Gender -->
                    <div class="col-span-1 sm:col-span-2 lg:col-span-1">
                        <label class="block text-xs font-medium text-white/80 mb-1">Gender *</label>
                        <select name="gender" required class="w-full bg-white/10 border border-white/20 text-white rounded-lg px-3 py-2 text-sm focus:border-indigo-400 focus:bg-white/15 transition">
                            <option value="" class="bg-slate-800">Select</option>
                            <option value="male" class="bg-slate-800" {{ old('gender') == 'male' ? 'selected' : '' }}>Male</option>
                            <option value="female" class="bg-slate-800" {{ old('gender') == 'female' ? 'selected' : '' }}>Female</option>
                            <option value="other" class="bg-slate-800" {{ old('gender') == 'other' ? 'selected' : '' }}>Other</option>
                        </select>
                        <x-input-error :messages="$errors->get('gender')" class="mt-1 text-red-400 text-xs" />
                    </div>

                    <!-- Civil Status -->
                    <div class="col-span-1 sm:col-span-2 lg:col-span-1">
                        <label class="block text-xs font-medium text-white/80 mb-1">Civil Status *</label>
                        <select name="civil_status" required class="w-full bg-white/10 border border-white/20 text-white rounded-lg px-3 py-2 text-sm focus:border-indigo-400 focus:bg-white/15 transition">
                            <option value="" class="bg-slate-800">Select</option>
                            <option value="single" class="bg-slate-800" {{ old('civil_status') == 'single' ? 'selected' : '' }}>Single</option>
                            <option value="married" class="bg-slate-800" {{ old('civil_status') == 'married' ? 'selected' : '' }}>Married</option>
                            <option value="widowed" class="bg-slate-800" {{ old('civil_status') == 'widowed' ? 'selected' : '' }}>Widowed</option>
                            <option value="separated" class="bg-slate-800" {{ old('civil_status') == 'separated' ? 'selected' : '' }}>Separated</option>
                            <option value="divorced" class="bg-slate-800" {{ old('civil_status') == 'divorced' ? 'selected' : '' }}>Divorced</option>
                        </select>
                        <x-input-error :messages="$errors->get('civil_status')" class="mt-1 text-red-400 text-xs" />
                    </div>

                    <!-- Occupation -->
                    <div class="col-span-2 sm:col-span-3 lg:col-span-2">
                        <label class="block text-xs font-medium text-white/80 mb-1">Occupation</label>
                        <input type="text" name="occupation" value="{{ old('occupation') }}" @input="filterAlphabeticOnly('occupation')" placeholder="e.g., Teacher, Engineer" class="w-full bg-white/10 border border-white/20 text-white placeholder-white/40 rounded-lg px-3 py-2 text-sm focus:border-indigo-400 focus:bg-white/15 transition" />
                        <x-input-error :messages="$errors->get('occupation')" class="mt-1 text-red-400 text-xs" />
                    </div>
                </div>
            </div>

            <!-- Identification Section -->
            <div class="bg-white/5 p-4 rounded-xl border border-white/10">
                <h3 class="text-base font-bold text-white mb-3 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-purple-400" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z" />
                    </svg>
                    Identification
                </h3>
                
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
                    <!-- National ID Number -->
                    <div class="lg:col-span-1">
                        <label class="block text-xs font-medium text-white/80 mb-1">Philippine National ID Number *</label>
                        <input type="text" name="national_id" value="{{ old('national_id') }}" required placeholder="XXXX-XXXX-XXXX-XXXX" maxlength="19" @input="formatNationalId($event)" class="w-full bg-white/10 border border-white/20 text-white placeholder-white/40 rounded-lg px-3 py-2 text-sm focus:border-indigo-400 focus:bg-white/15 transition uppercase" />
                        <p class="mt-1 text-xs text-white/50">Format: 4-4-4-4 (auto-formatted)</p>
                        <x-input-error :messages="$errors->get('national_id')" class="mt-1 text-red-400 text-xs" />
                    </div>

                    <!-- National ID Image Upload -->
                    <div class="lg:col-span-1">
                        <label class="block text-xs font-medium text-white/80 mb-2">Upload National ID Image *</label>
                        <div class="relative">
                            <label for="national_id_image" class="flex flex-col items-center justify-center w-full h-40 border-2 border-dashed border-white/30 rounded-xl cursor-pointer bg-white/5 hover:bg-white/10 transition">
                                <div x-show="!imagePreview" class="flex flex-col items-center justify-center pt-3 pb-4">
                                    <svg class="w-8 h-8 mb-2 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                                    </svg>
                                    <p class="text-xs text-white/70"><span class="font-semibold">Click</span> or drag drop</p>
                                </div>
                                <div x-show="imagePreview" class="relative w-full h-full p-2">
                                    <img :src="imagePreview" alt="ID Preview" class="w-full h-full object-contain rounded-lg">
                                    <button @click.prevent="clearImage()" type="button" class="absolute top-1 right-1 bg-red-500 text-white rounded-full p-1 hover:bg-red-600 shadow-lg">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </button>
                                </div>
                                <input id="national_id_image" name="national_id_image" type="file" class="hidden" accept="image/jpeg,image/png,image/jpg" @change="previewImage($event)" required />
                            </label>
                        </div>
                        <x-input-error :messages="$errors->get('national_id_image')" class="mt-1 text-red-400 text-xs" />
                    </div>
                </div>
            </div>

            <!-- Contact Information Section -->
            <div class="bg-white/5 p-4 rounded-xl border border-white/10">
                <h3 class="text-base font-bold text-white mb-3 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-cyan-400" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773c.346.998.956 2.447 1.945 3.435 1.002 1.002 2.505 1.612 3.554 1.945l.774-1.548a1 1 0 011.059-.54l4.436.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z" />
                    </svg>
                    Contact Information
                </h3>
                
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-3">
                    <!-- Email -->
                    <div class="lg:col-span-1">
                        <label class="block text-xs font-medium text-white/80 mb-1">Email Address *</label>
                        <input type="email" name="email" value="{{ old('email') }}" required placeholder="your@email.com" class="w-full bg-white/10 border border-white/20 text-white placeholder-white/40 rounded-lg px-3 py-2 text-sm focus:border-indigo-400 focus:bg-white/15 transition" />
                        <x-input-error :messages="$errors->get('email')" class="mt-1 text-red-400 text-xs" />
                    </div>

                    <!-- Phone -->
                    <div class="lg:col-span-1">
                        <label class="block text-xs font-medium text-white/80 mb-1">Phone Number *</label>
                        <input type="text" name="phone" value="{{ old('phone') }}" required placeholder="09XXXXXXXXX" maxlength="11" @input="formatPhoneNumber($event)" class="w-full bg-white/10 border border-white/20 text-white placeholder-white/40 rounded-lg px-3 py-2 text-sm focus:border-indigo-400 focus:bg-white/15 transition" />
                        <x-input-error :messages="$errors->get('phone')" class="mt-1 text-red-400 text-xs" />
                    </div>
                </div>
            </div>

            <!-- Address Section -->
            <div class="bg-white/5 p-4 rounded-xl border border-white/10">
                <h3 class="text-base font-bold text-white mb-3 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-emerald-400" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z" />
                    </svg>
                    Address Information
                </h3>
                
                <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-3">
                    <!-- House Number -->
                    <div class="col-span-1">
                        <label class="block text-xs font-medium text-white/80 mb-1">House/Unit #</label>
                        <input type="text" name="house_number" value="{{ old('house_number') }}" placeholder="123" class="w-full bg-white/10 border border-white/20 text-white placeholder-white/40 rounded-lg px-3 py-2 text-sm focus:border-indigo-400 focus:bg-white/15 transition" />
                        <x-input-error :messages="$errors->get('house_number')" class="mt-1 text-red-400 text-xs" />
                    </div>

                    <!-- Street -->
                    <div class="col-span-2 sm:col-span-2 lg:col-span-2">
                        <label class="block text-xs font-medium text-white/80 mb-1">Street/Subdivision *</label>
                        <input type="text" name="street" value="{{ old('street') }}" required placeholder="Main St" class="w-full bg-white/10 border border-white/20 text-white placeholder-white/40 rounded-lg px-3 py-2 text-sm focus:border-indigo-400 focus:bg-white/15 transition" />
                        <x-input-error :messages="$errors->get('street')" class="mt-1 text-red-400 text-xs" />
                    </div>

                    <!-- Barangay -->
                    <div class="col-span-1 sm:col-span-1">
                        <label class="block text-xs font-medium text-white/80 mb-1">Barangay *</label>
                        <input type="text" name="barangay" value="{{ old('barangay') }}" required placeholder="Barangay" class="w-full bg-white/10 border border-white/20 text-white placeholder-white/40 rounded-lg px-3 py-2 text-sm focus:border-indigo-400 focus:bg-white/15 transition" />
                        <x-input-error :messages="$errors->get('barangay')" class="mt-1 text-red-400 text-xs" />
                    </div>

                    <!-- City -->
                    <div class="col-span-1 sm:col-span-1">
                        <label class="block text-xs font-medium text-white/80 mb-1">City/Municipality *</label>
                        <input type="text" name="city" value="{{ old('city') }}" required placeholder="City" class="w-full bg-white/10 border border-white/20 text-white placeholder-white/40 rounded-lg px-3 py-2 text-sm focus:border-indigo-400 focus:bg-white/15 transition" />
                        <x-input-error :messages="$errors->get('city')" class="mt-1 text-red-400 text-xs" />
                    </div>

                    <!-- Province -->
                    <div class="col-span-1 sm:col-span-1">
                        <label class="block text-xs font-medium text-white/80 mb-1">Province *</label>
                        <input type="text" name="province" value="{{ old('province') }}" required placeholder="Province" class="w-full bg-white/10 border border-white/20 text-white placeholder-white/40 rounded-lg px-3 py-2 text-sm focus:border-indigo-400 focus:bg-white/15 transition" />
                        <x-input-error :messages="$errors->get('province')" class="mt-1 text-red-400 text-xs" />
                    </div>

                    <!-- Zip Code -->
                    <div class="col-span-1 sm:col-span-1">
                        <label class="block text-xs font-medium text-white/80 mb-1">Zip Code</label>
                        <input type="text" name="zip_code" value="{{ old('zip_code') }}" placeholder="1000" class="w-full bg-white/10 border border-white/20 text-white placeholder-white/40 rounded-lg px-3 py-2 text-sm focus:border-indigo-400 focus:bg-white/15 transition" />
                        <x-input-error :messages="$errors->get('zip_code')" class="mt-1 text-red-400 text-xs" />
                    </div>
                </div>
            </div>

            <!-- Emergency Contact Section -->
            <div class="bg-white/5 p-4 rounded-xl border border-white/10">
                <h3 class="text-base font-bold text-white mb-3 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-orange-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 5v8a2 2 0 01-2 2h-5l-5 4v-4H4a2 2 0 01-2-2V5a2 2 0 012-2h12a2 2 0 012 2zM7 8H5v2h2V8zm2 0h2v2H9V8zm6 0h-2v2h2V8z" clip-rule="evenodd" />
                    </svg>
                    Emergency Contact (Optional)
                </h3>
                
                <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-3 gap-3">
                    <!-- Emergency Contact Name -->
                    <div class="col-span-1">
                        <label class="block text-xs font-medium text-white/80 mb-1">Contact Name</label>
                        <input type="text" name="emergency_contact_name" value="{{ old('emergency_contact_name') }}" @input="filterAlphabeticOnly('emergency_contact_name')" placeholder="Full name" class="w-full bg-white/10 border border-white/20 text-white placeholder-white/40 rounded-lg px-3 py-2 text-sm focus:border-indigo-400 focus:bg-white/15 transition" />
                        <x-input-error :messages="$errors->get('emergency_contact_name')" class="mt-1 text-red-400 text-xs" />
                    </div>

                    <!-- Emergency Contact Relationship -->
                    <div class="col-span-1">
                        <label class="block text-xs font-medium text-white/80 mb-1">Relationship</label>
                        <input type="text" name="emergency_contact_relationship" value="{{ old('emergency_contact_relationship') }}" @input="filterAlphabeticOnly('emergency_contact_relationship')" placeholder="Mother" class="w-full bg-white/10 border border-white/20 text-white placeholder-white/40 rounded-lg px-3 py-2 text-sm focus:border-indigo-400 focus:bg-white/15 transition" />
                        <x-input-error :messages="$errors->get('emergency_contact_relationship')" class="mt-1 text-red-400 text-xs" />
                    </div>

                    <!-- Emergency Contact Phone -->
                    <div class="col-span-1">
                        <label class="block text-xs font-medium text-white/80 mb-1">Phone #</label>
                        <input type="text" name="emergency_contact_phone" value="{{ old('emergency_contact_phone') }}" placeholder="09XXXXXXXXX" maxlength="11" @input="formatPhoneNumber($event)" class="w-full bg-white/10 border border-white/20 text-white placeholder-white/40 rounded-lg px-3 py-2 text-sm focus:border-indigo-400 focus:bg-white/15 transition" />
                        <x-input-error :messages="$errors->get('emergency_contact_phone')" class="mt-1 text-red-400 text-xs" />
                    </div>
                </div>
            </div>

            <!-- Account Security Section -->
            <div class="bg-white/5 p-4 rounded-xl border border-white/10">
                <h3 class="text-base font-bold text-white mb-3 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-rose-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" />
                    </svg>
                    Account Security
                </h3>
                
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-3">
                    <!-- Password -->
                    <div class="lg:col-span-1">
                        <label class="block text-xs font-medium text-white/80 mb-1">Password *</label>
                        <input type="password" name="password" required autocomplete="new-password" placeholder="Min. 8 characters" class="w-full bg-white/10 border border-white/20 text-white placeholder-white/40 rounded-lg px-3 py-2 text-sm focus:border-indigo-400 focus:bg-white/15 transition" />
                        <x-input-error :messages="$errors->get('password')" class="mt-1 text-red-400 text-xs" />
                    </div>

                    <!-- Confirm Password -->
                    <div class="lg:col-span-1">
                        <label class="block text-xs font-medium text-white/80 mb-1">Confirm Password *</label>
                        <input type="password" name="password_confirmation" required autocomplete="new-password" placeholder="Re-enter password" class="w-full bg-white/10 border border-white/20 text-white placeholder-white/40 rounded-lg px-3 py-2 text-sm focus:border-indigo-400 focus:bg-white/15 transition" />
                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1 text-red-400 text-xs" />
                    </div>
                </div>
            </div>
        </div>

        <!-- Form Actions -->
        <div class="flex flex-col sm:flex-row items-center justify-between gap-4 mt-8 pt-6 border-t border-white/10">
            <a href="{{ route('login') }}" class="text-sm text-indigo-400 hover:text-indigo-300 transition">
                Already have an account? Sign in
            </a>

            <button type="submit" class="px-8 py-3 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white font-semibold rounded-lg transition shadow-lg hover:shadow-xl">
                Create Account
            </button>
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
                filterAlphabeticOnly(fieldId) {
                    const field = document.getElementById(fieldId);
                    // Allow only letters, spaces, and hyphens
                    field.value = field.value.replace(/[^a-zA-Z\s\-]/g, '');
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
                    
                    // Format with dashes every 4 digits
                    let formatted = '';
                    for (let i = 0; i < value.length; i++) {
                        if (i > 0 && i % 4 === 0) {
                            formatted += '-';
                        }
                        formatted += value[i];
                    }
                    
                    // Update the input value
                    event.target.value = formatted;
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
