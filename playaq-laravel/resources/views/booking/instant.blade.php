@extends('layouts.app')

@section('title', 'Instant Booking - PLAYAQ')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12"
     x-data="{
        step: 1,
        service: 'plumbing',
        description: '',
        date: '',
        time: 'morning',
        files: [],
        pros: @js($professionals),
        selectedPro: null,
        
        get filteredPros() {
            return this.pros.filter(p => p.specialty === this.service);
        },
        handleUpload(e) {
            this.files = Array.from(e.target.files).map(f => {
                return {
                    name: f.name,
                    url: URL.createObjectURL(f)
                };
            });
        },
        selectHandyman(proId) {
            this.selectedPro = proId;
            // Submit form
            this.$nextTick(() => {
                document.getElementById('instant-booking-form').submit();
            });
        }
     }">

    <div class="bg-white rounded-2xl border border-slate-100 shadow-xl overflow-hidden">
        <!-- Header -->
        <div class="bg-gradient-to-r from-brand-600 to-indigo-600 text-white p-6 flex justify-between items-center shadow-md">
            <div>
                <h2 class="text-white text-2xl font-bold">Instant Service Matcher</h2>
                <p class="text-indigo-100 text-sm">Tell us what you need and book a professional instantly</p>
            </div>
            <span class="bg-white/20 text-white px-3 py-1 rounded-full text-xs font-semibold">Step <span x-text="step"></span> of 4</span>
        </div>

        <div class="p-8">
            <!-- Progress Bar -->
            <div class="mb-8">
                <div class="flex justify-between text-xs font-bold uppercase tracking-wider text-slate-400 mb-2">
                    <span :class="step >= 1 ? 'text-brand-600' : ''">1. What</span>
                    <span :class="step >= 2 ? 'text-brand-600' : ''">2. Details & Photo</span>
                    <span :class="step >= 3 ? 'text-brand-600' : ''">3. When</span>
                    <span :class="step >= 4 ? 'text-brand-600' : ''">4. Choose Pro</span>
                </div>
                <div class="w-full bg-slate-100 rounded-full h-2">
                    <div class="bg-brand-600 h-2 rounded-full transition-all duration-300" :style="'width: ' + ((step/4)*100) + '%'"></div>
                </div>
            </div>

            <form action="/bookings" method="POST" enctype="multipart/form-data" id="instant-booking-form">
                @csrf
                <input type="hidden" name="professional_profile_id" :value="selectedPro">
                <input type="hidden" name="service_name" :value="service">
                <input type="hidden" name="booking_date" :value="date">
                <input type="hidden" name="booking_time" :value="time">

                <!-- Step 1: What (Service Type) -->
                <div x-show="step === 1" x-transition>
                <h3 class="text-lg font-bold text-slate-900 mb-4">What service do you need?</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <button type="button" @click="service = 'plumbing'; step = 2"
                            class="flex flex-col items-center justify-center p-6 border-2 border-slate-150 hover:border-brand-500 rounded-2xl hover:bg-brand-50/10 transition-all text-center group">
                        <div class="w-12 h-12 rounded-xl bg-blue-100 text-blue-600 flex items-center justify-center mb-3 group-hover:scale-110 transition-transform">
                            <i data-lucide="droplet" class="w-6 h-6"></i>
                        </div>
                        <span class="font-bold text-slate-800 text-sm">Plumbing Services</span>
                        <span class="text-xs text-slate-400 mt-1">Leaks, toilets, faucets & pipe repairs</span>
                    </button>

                    <button type="button" @click="service = 'painting'; step = 2"
                            class="flex flex-col items-center justify-center p-6 border-2 border-slate-150 hover:border-brand-500 rounded-2xl hover:bg-brand-50/10 transition-all text-center group">
                        <div class="w-12 h-12 rounded-xl bg-purple-100 text-purple-600 flex items-center justify-center mb-3 group-hover:scale-110 transition-transform">
                            <i data-lucide="paint-brush" class="w-6 h-6"></i>
                        </div>
                        <span class="font-bold text-slate-800 text-sm">Painting Services</span>
                        <span class="text-xs text-slate-400 mt-1">Interior & exterior room wall coloring</span>
                    </button>

                    <button type="button" @click="service = 'appliance-repair'; step = 2"
                            class="flex flex-col items-center justify-center p-6 border-2 border-slate-150 hover:border-brand-500 rounded-2xl hover:bg-brand-50/10 transition-all text-center group">
                        <div class="w-12 h-12 rounded-xl bg-amber-100 text-amber-600 flex items-center justify-center mb-3 group-hover:scale-110 transition-transform">
                            <i data-lucide="wrench" class="w-6 h-6"></i>
                        </div>
                        <span class="font-bold text-slate-800 text-sm">Appliance Repair</span>
                        <span class="text-xs text-slate-400 mt-1">Refrigerators, washing machines & dishwashers</span>
                    </button>

                    <button type="button" @click="service = 'appliance-installation'; step = 2"
                            class="flex flex-col items-center justify-center p-6 border-2 border-slate-150 hover:border-brand-500 rounded-2xl hover:bg-brand-50/10 transition-all text-center group">
                        <div class="w-12 h-12 rounded-xl bg-green-100 text-green-600 flex items-center justify-center mb-3 group-hover:scale-110 transition-transform">
                            <i data-lucide="package" class="w-6 h-6"></i>
                        </div>
                        <span class="font-bold text-slate-800 text-sm">Appliance Installation</span>
                        <span class="text-xs text-slate-400 mt-1">Ovens, stoves, washer & dryer alignments</span>
                    </button>
                </div>
            </div>

            <!-- Step 2: Details & Photo (Picture) -->
            <div x-show="step === 2" x-cloak x-transition class="space-y-6">
                <div>
                    <h3 class="text-lg font-bold text-slate-900 mb-2">Describe the problem</h3>
                    <textarea x-model="description" name="description" required rows="4"
                              class="w-full px-4 py-3 border border-slate-200 focus:border-brand-500 rounded-xl outline-none transition-colors text-sm"
                              placeholder="Describe your issue here in detail (e.g. leaking sink faucet)..."></textarea>
                </div>

                <div>
                    <h3 class="text-lg font-bold text-slate-900 mb-2">Upload problem photo</h3>
                    <label class="border-2 border-dashed border-slate-200 rounded-xl p-8 text-center hover:border-brand-400 transition-colors cursor-pointer block bg-slate-50/50">
                        <i data-lucide="upload-cloud" class="w-12 h-12 text-slate-400 mx-auto mb-2"></i>
                        <p class="text-slate-600 font-medium text-sm">Click to upload or drag and drop</p>
                        <p class="text-slate-400 text-xs mt-1">PNG, JPG up to 10MB</p>
                        <input type="file" name="photos[]" multiple class="hidden" @change="handleUpload">
                    </label>
                    <div x-show="files.length > 0" class="mt-4 space-y-2">
                        <p class="text-xs font-bold text-slate-500 uppercase tracking-wider">Uploaded Photo Preview:</p>
                        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                            <template x-for="(file, idx) in files" :key="idx">
                                <div class="relative rounded-xl overflow-hidden border border-slate-200 aspect-square bg-slate-100 shadow-sm">
                                    <img :src="file.url" class="w-full h-full object-cover" />
                                    <div class="absolute bottom-0 inset-x-0 bg-black/60 text-white text-[10px] p-1.5 truncate" x-text="file.name"></div>
                                </div>
                            </template>
                        </div>
                    </div>
                </div>

                <!-- Navigation -->
                <div class="flex justify-between pt-4 border-t border-slate-100">
                    <button type="button" @click="step = 1"
                            class="border border-slate-200 hover:bg-slate-50 text-slate-700 font-semibold py-3 px-8 rounded-xl transition-all flex items-center space-x-2 text-sm">
                        <i data-lucide="arrow-left" class="w-4 h-4"></i>
                        <span>Back</span>
                    </button>
                    <button type="button" @click="if(description.trim()) { step = 3 } else { alert('Please fill in the description.') }"
                            class="bg-brand-600 hover:bg-brand-700 text-white font-semibold py-3 px-8 rounded-xl transition-all shadow-md shadow-brand-500/10 flex items-center space-x-2 text-sm">
                        <span>Continue</span>
                        <i data-lucide="arrow-right" class="w-4 h-4"></i>
                    </button>
                </div>
            </div>

            <!-- Step 3: When (Schedule) -->
            <div x-show="step === 3" x-cloak x-transition class="space-y-6">
                <!-- Date -->
                <div>
                    <h3 class="text-lg font-bold text-slate-900 mb-2">Preferred Date</h3>
                    <input type="date" x-model="date" required min="{{ date('Y-m-d', strtotime('+1 day')) }}"
                           class="w-full px-4 py-3 border border-slate-200 focus:border-brand-500 rounded-xl outline-none transition-colors text-sm">
                </div>

                <!-- Time Slot -->
                <div>
                    <h3 class="text-lg font-bold text-slate-900 mb-2">Preferred Time</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <label class="flex flex-col items-center justify-center border-2 rounded-xl p-4 cursor-pointer transition-all"
                               :class="time === 'morning' ? 'border-brand-600 bg-brand-50/50 text-brand-700' : 'border-slate-200 hover:border-brand-300 text-slate-600'">
                            <input type="radio" value="morning" x-model="time" class="sr-only">
                            <i data-lucide="sun" class="w-6 h-6 mb-2"></i>
                            <span class="font-semibold text-sm">Morning</span>
                            <span class="text-xs text-slate-500 mt-1">8:00 AM - 12:00 PM</span>
                        </label>
                        <label class="flex flex-col items-center justify-center border-2 rounded-xl p-4 cursor-pointer transition-all"
                               :class="time === 'afternoon' ? 'border-brand-600 bg-brand-50/50 text-brand-700' : 'border-slate-200 hover:border-brand-300 text-slate-600'">
                            <input type="radio" value="afternoon" x-model="time" class="sr-only">
                            <i data-lucide="sunset" class="w-6 h-6 mb-2"></i>
                            <span class="font-semibold text-sm">Afternoon</span>
                            <span class="text-xs text-slate-500 mt-1">12:00 PM - 5:00 PM</span>
                        </label>
                        <label class="flex flex-col items-center justify-center border-2 rounded-xl p-4 cursor-pointer transition-all"
                               :class="time === 'evening' ? 'border-brand-600 bg-brand-50/50 text-brand-700' : 'border-slate-200 hover:border-brand-300 text-slate-600'">
                            <input type="radio" value="evening" x-model="time" class="sr-only">
                            <i data-lucide="moon" class="w-6 h-6 mb-2"></i>
                            <span class="font-semibold text-sm">Evening</span>
                            <span class="text-xs text-slate-500 mt-1">5:00 PM - 8:00 PM</span>
                        </label>
                    </div>
                </div>

                <!-- Navigation -->
                <div class="flex justify-between pt-4 border-t border-slate-100">
                    <button type="button" @click="step = 2"
                            class="border border-slate-200 hover:bg-slate-50 text-slate-700 font-semibold py-3 px-8 rounded-xl transition-all flex items-center space-x-2 text-sm">
                        <i data-lucide="arrow-left" class="w-4 h-4"></i>
                        <span>Back</span>
                    </button>
                    <button type="button" @click="if(date && time) { step = 4 } else { alert('Please select a date and time slot.') }"
                            class="bg-brand-600 hover:bg-brand-700 text-white font-semibold py-3 px-8 rounded-xl transition-all shadow-md shadow-brand-500/10 flex items-center space-x-2 text-sm">
                        <span>Find Professionals</span>
                        <i data-lucide="arrow-right" class="w-4 h-4"></i>
                    </button>
                </div>
            </div>

            <!-- Step 4: Choose Professional & Book -->
            <div x-show="step === 4" x-cloak x-transition class="space-y-6">
                <h3 class="text-lg font-bold text-slate-900 mb-2">Select an Available Professional</h3>
                <p class="text-sm text-slate-500">We found the following verified handymen for <span class="font-semibold capitalize" x-text="service"></span>. Click book now on the professional you prefer.</p>

                <div class="space-y-4">
                    <template x-for="pro in filteredPros" :key="pro.id">
                        <div class="border border-slate-150 rounded-2xl p-6 hover:border-brand-500 transition-colors flex flex-col md:flex-row justify-between items-start md:items-center gap-4 bg-slate-50/30">
                            <div class="flex items-start space-x-4">
                                <!-- Avatar -->
                                <div class="w-16 h-16 rounded-xl overflow-hidden shrink-0 border border-slate-200">
                                    <template x-if="pro.image_path">
                                        <img :src="'/images/' + pro.image_path" class="w-full h-full object-cover" />
                                    </template>
                                    <template x-if="!pro.image_path">
                                        <div class="w-full h-full bg-brand-100 text-brand-700 flex items-center justify-center font-bold text-xl" x-text="pro.business_name.substring(0,1)"></div>
                                    </template>
                                </div>
                                <div class="space-y-1">
                                    <h4 class="font-bold text-slate-800 text-base" x-text="pro.business_name"></h4>
                                    <p class="text-xs text-slate-400 capitalize" x-text="'Specialty: ' + pro.specialty.replace('-', ' ')"></p>
                                    <div class="flex items-center space-x-3 text-xs text-slate-500 font-medium">
                                        <span class="flex items-center"><i data-lucide="star" class="w-3.5 h-3.5 text-amber-400 fill-amber-400 mr-1"></i> <span x-text="Number(pro.rating).toFixed(1)"></span></span>
                                        <span class="flex items-center"><i data-lucide="map-pin" class="w-3.5 h-3.5 text-slate-400 mr-1"></i> <span x-text="pro.location || 'Klang Valley'"></span></span>
                                    </div>
                                    <p class="text-xs text-slate-500 mt-2 line-clamp-2" x-text="pro.bio"></p>
                                </div>
                            </div>

                            <!-- Form & Book Button -->
                            <!-- Book Button -->
                            <div class="shrink-0 w-full md:w-auto">
                                <button type="button" @click="selectHandyman(pro.id)"
                                        class="w-full bg-brand-600 hover:bg-brand-700 text-white font-bold text-xs py-3 px-6 rounded-xl transition-all shadow-md shadow-brand-500/10 flex items-center justify-center space-x-1">
                                    <i data-lucide="check-circle" class="w-4 h-4"></i>
                                    <span>Confirm & Book Now</span>
                                </button>
                            </div>
                        </div>
                    </template>
                    <template x-if="filteredPros.length === 0">
                        <div class="text-center py-12 text-slate-400 bg-slate-50 rounded-2xl border border-dashed border-slate-200">
                            <i data-lucide="users" class="w-12 h-12 mx-auto mb-2 opacity-50"></i>
                            <p class="text-sm font-semibold">No professionals found</p>
                            <p class="text-xs">There are no professionals registered under this category yet.</p>
                        </div>
                    </template>
                </div>

                <!-- Navigation -->
                <div class="flex justify-between pt-4 border-t border-slate-100">
                    <button type="button" @click="step = 3"
                            class="border border-slate-200 hover:bg-slate-50 text-slate-700 font-semibold py-3 px-8 rounded-xl transition-all flex items-center space-x-2 text-sm">
                        <i data-lucide="arrow-left" class="w-4 h-4"></i>
                        <span>Back</span>
                    </button>
                </div>
            </div>
            </form>

        </div>
    </div>
</div>
@endsection
