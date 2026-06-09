@extends('layouts.app')

@section('title', 'Book a Service - PLAYAQ')

@section('content')
<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-12"
     x-data="{
        step: 1,
        service: '{{ old('service_name', $pro->specialty) }}',
        description: '',
        date: '',
        time: '',
        files: [],
        depositAmount: 0,
        priceRange: '',
        paymentMethod: 'Credit Card',
        
        init() {
            this.updatePricing();
        },
        updatePricing() {
            // Calculate deposit estimate based on selection
            let min = 75, max = 120;
            if (this.service === 'plumbing') { min = 75; max = 120; }
            else if (this.service === 'painting') { min = 200; max = 500; }
            else if (this.service === 'appliance-repair') { min = 65; max = 150; }
            else if (this.service === 'appliance-installation') { min = 70; max = 130; }
            
            let avg = (min + max) / 2;
            this.depositAmount = Math.round(avg * 0.3);
            this.priceRange = 'RM ' + min + ' - RM ' + max;
        },
        handleUpload(e) {
            this.files = Array.from(e.target.files).map(f => {
                return {
                    name: f.name,
                    url: URL.createObjectURL(f)
                };
            });
        }
     }">

    <div class="bg-white rounded-2xl border border-slate-100 shadow-xl overflow-hidden">
        <!-- Header -->
        <div class="sticky top-0 bg-gradient-to-r from-brand-600 to-indigo-600 text-white p-6 flex justify-between items-center shadow-md">
            <div>
                <h2 class="text-white text-2xl font-bold">Book a Service</h2>
                <p class="text-indigo-100 text-sm">Professional: <span class="font-semibold">{{ $pro->business_name }}</span></p>
            </div>
            <span class="bg-white/20 text-white px-3 py-1 rounded-full text-xs font-semibold">Step <span x-text="step"></span> of 3</span>
        </div>

        <div class="p-8">
            <!-- Progress Bar -->
            <div class="mb-8">
                <div class="flex justify-between text-xs font-bold uppercase tracking-wider text-slate-400 mb-2">
                    <span :class="step >= 1 ? 'text-brand-600' : ''">1. Details</span>
                    <span :class="step >= 2 ? 'text-brand-600' : ''">2. Schedule</span>
                    <span :class="step >= 3 ? 'text-brand-600' : ''">3. Deposit Payment</span>
                </div>
                <div class="w-full bg-slate-100 rounded-full h-2">
                    <div class="bg-brand-600 h-2 rounded-full transition-all duration-300" :style="'width: ' + ((step/3)*100) + '%'"></div>
                </div>
            </div>

            <!-- Form -->
            <form action="/bookings" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="professional_profile_id" value="{{ $pro->id }}">

                <!-- Step 1: Details -->
                <div x-show="step === 1" x-transition>
                    <div class="space-y-6">
                        <!-- Service Selection -->
                        <div>
                            <label for="service_name" class="block text-sm font-semibold text-slate-700 mb-2">Select Service</label>
                            <select id="service_name" name="service_name" x-model="service" @change="updatePricing()"
                                    class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-brand-500 focus:border-brand-500 outline-none text-slate-800 font-medium">
                                <option value="plumbing">Plumbing Services</option>
                                <option value="painting">Painting Services</option>
                                <option value="appliance-repair">Appliance Repair</option>
                                <option value="appliance-installation">Appliance Installation</option>
                            </select>
                        </div>

                        <!-- Description -->
                        <div>
                            <label for="description" class="block text-sm font-semibold text-slate-700 mb-2">Describe the problem</label>
                            <textarea id="description" name="description" x-model="description" required rows="4"
                                      class="w-full px-4 py-3 border border-slate-200 focus:border-brand-500 rounded-xl outline-none transition-colors"
                                      placeholder="Please describe the issue in detail (e.g. leaking pipes under the kitchen sink)..."></textarea>
                        </div>

                        <!-- Upload Photo -->
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Upload photos (optional)</label>
                            <label class="border-2 border-dashed border-slate-200 rounded-xl p-8 text-center hover:border-brand-400 transition-colors cursor-pointer block bg-slate-50/50">
                                <i data-lucide="upload-cloud" class="w-12 h-12 text-slate-400 mx-auto mb-2"></i>
                                <p class="text-slate-600 font-medium text-sm">Click to upload or drag and drop</p>
                                <p class="text-slate-400 text-xs mt-1">PNG, JPG up to 10MB</p>
                                <input type="file" name="photos[]" multiple class="hidden" @change="handleUpload">
                            </label>
                            <div x-show="files.length > 0" class="mt-4 space-y-2">
                                <p class="text-xs font-bold text-slate-500 uppercase tracking-wider">Uploaded Files Preview:</p>
                                <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                                    <template x-for="(file, idx) in files" :key="idx">
                                        <div class="relative group rounded-xl overflow-hidden border border-slate-200 aspect-square bg-slate-100 shadow-sm">
                                            <img :src="file.url" class="w-full h-full object-cover" />
                                            <div class="absolute bottom-0 inset-x-0 bg-black/60 text-white text-[10px] p-1.5 truncate" x-text="file.name"></div>
                                        </div>
                                    </template>
                                </div>
                            </div>
                        </div>

                        <!-- Navigation -->
                        <div class="flex justify-end pt-4">
                            <button type="button" @click="if(description.trim()) { step = 2 } else { alert('Please fill in the description.') }"
                                    class="bg-brand-600 hover:bg-brand-700 text-white font-semibold py-3 px-8 rounded-xl transition-all shadow-md shadow-brand-500/25 flex items-center space-x-2">
                                <span>Continue</span>
                                <i data-lucide="arrow-right" class="w-4 h-4"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Step 2: Schedule -->
                <div x-show="step === 2" x-cloak x-transition>
                    <div class="space-y-6">
                        <!-- Preferred Date -->
                        <div>
                            <label for="booking_date" class="block text-sm font-semibold text-slate-700 mb-2">Preferred Date</label>
                            <input type="date" id="booking_date" name="booking_date" x-model="date" required min="{{ date('Y-m-d', strtotime('+1 day')) }}"
                                   class="w-full px-4 py-3 border border-slate-200 focus:border-brand-500 rounded-xl outline-none transition-colors">
                        </div>

                        <!-- Preferred Time Slot -->
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Preferred Time Slot</label>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <label class="flex flex-col items-center justify-center border-2 rounded-xl p-4 cursor-pointer transition-all"
                                       :class="time === 'morning' ? 'border-brand-600 bg-brand-50/50 text-brand-700' : 'border-slate-200 hover:border-brand-300 text-slate-600'">
                                    <input type="radio" name="booking_time" value="morning" x-model="time" class="sr-only">
                                    <i data-lucide="sun" class="w-6 h-6 mb-2"></i>
                                    <span class="font-semibold text-sm">Morning</span>
                                    <span class="text-xs text-slate-500 mt-1">8:00 AM - 12:00 PM</span>
                                </label>
                                <label class="flex flex-col items-center justify-center border-2 rounded-xl p-4 cursor-pointer transition-all"
                                       :class="time === 'afternoon' ? 'border-brand-600 bg-brand-50/50 text-brand-700' : 'border-slate-200 hover:border-brand-300 text-slate-600'">
                                    <input type="radio" name="booking_time" value="afternoon" x-model="time" class="sr-only">
                                    <i data-lucide="sunset" class="w-6 h-6 mb-2"></i>
                                    <span class="font-semibold text-sm">Afternoon</span>
                                    <span class="text-xs text-slate-500 mt-1">12:00 PM - 5:00 PM</span>
                                </label>
                                <label class="flex flex-col items-center justify-center border-2 rounded-xl p-4 cursor-pointer transition-all"
                                       :class="time === 'evening' ? 'border-brand-600 bg-brand-50/50 text-brand-700' : 'border-slate-200 hover:border-brand-300 text-slate-600'">
                                    <input type="radio" name="booking_time" value="evening" x-model="time" class="sr-only">
                                    <i data-lucide="moon" class="w-6 h-6 mb-2"></i>
                                    <span class="font-semibold text-sm">Evening</span>
                                    <span class="text-xs text-slate-500 mt-1">5:00 PM - 8:00 PM</span>
                                </label>
                            </div>
                        </div>

                        <!-- Navigation -->
                        <div class="flex justify-between pt-4">
                            <button type="button" @click="step = 1"
                                    class="border border-slate-200 hover:bg-slate-50 text-slate-700 font-semibold py-3 px-8 rounded-xl transition-all flex items-center space-x-2">
                                <i data-lucide="arrow-left" class="w-4 h-4"></i>
                                <span>Back</span>
                            </button>
                            <button type="button" @click="if(date && time) { step = 3 } else { alert('Please select a date and time slot.') }"
                                    class="bg-brand-600 hover:bg-brand-700 text-white font-semibold py-3 px-8 rounded-xl transition-all shadow-md shadow-brand-500/25 flex items-center space-x-2">
                                <span>Continue</span>
                                <i data-lucide="arrow-right" class="w-4 h-4"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Step 3: Payment Summary & Confirmation -->
                <div x-show="step === 3" x-cloak x-transition>
                    <div class="space-y-6">
                        <!-- Summary Card -->
                        <div class="bg-slate-50 border border-slate-100 rounded-2xl p-6 space-y-4">
                            <h3 class="text-slate-900 font-bold text-lg mb-2">Booking Summary</h3>
                            
                            <div class="grid grid-cols-2 gap-y-3 gap-x-4 text-sm">
                                <span class="text-slate-500 font-medium">Service Type:</span>
                                <span class="text-slate-900 font-semibold capitalize" x-text="service"></span>

                                <span class="text-slate-500 font-medium">Scheduled Date:</span>
                                <span class="text-slate-900 font-semibold" x-text="date"></span>

                                <span class="text-slate-500 font-medium">Time Slot:</span>
                                <span class="text-slate-900 font-semibold capitalize" x-text="time"></span>

                                <span class="text-slate-500 font-medium">Estimated Pricing:</span>
                                <span class="text-brand-600 font-bold" x-text="priceRange"></span>
                            </div>
                        </div>

                        <!-- Deposit Details -->
                        <div class="bg-brand-50/50 border border-brand-100 rounded-2xl p-6">
                            <h3 class="text-brand-900 font-bold text-lg mb-2 flex items-center space-x-2">
                                <i data-lucide="credit-card" class="w-5 h-5 text-brand-600"></i>
                                <span>Deposit Payment Required (30%)</span>
                            </h3>
                            <p class="text-brand-700 text-sm mb-4 leading-relaxed">
                                To secure your booking, a 30% deposit is required. The remaining balance will be paid directly after service completion.
                            </p>
                            
                            <div class="bg-white border border-brand-100 rounded-xl p-4 mb-4 flex justify-between items-center shadow-sm">
                                <span class="text-slate-700 font-medium text-sm">Deposit Amount:</span>
                                <span class="text-2xl font-black text-brand-600">RM <span x-text="depositAmount"></span></span>
                            </div>

                            <!-- Payment Details Fields (Dummy) -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1">Payment Method</label>
                                    <select class="w-full px-3 py-2 border border-slate-200 rounded-lg text-sm bg-white" x-model="paymentMethod">
                                        <option value="Credit Card">Credit Card</option>
                                        <option value="Debit Card">Debit Card</option>
                                        <option value="eWallet">eWallet (Touch 'n Go / GrabPay)</option>
                                        <option value="PayPal">PayPal</option>
                                        <option value="FPX">FPX Online Banking</option>
                                    </select>
                                </div>
                                <div x-show="paymentMethod === 'Credit Card' || paymentMethod === 'Debit Card'" x-transition>
                                    <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1">Card Number</label>
                                    <input type="text" class="w-full px-3 py-2 border border-slate-200 rounded-lg text-sm" placeholder="4111 2222 3333 4444" value="4111 2222 3333 4444" :required="paymentMethod === 'Credit Card' || paymentMethod === 'Debit Card'">
                                </div>
                            </div>
                        </div>

                        <!-- Terms -->
                        <div class="flex items-start">
                            <input type="checkbox" id="terms" required class="mt-1 h-4 w-4 text-brand-600 focus:ring-brand-500 border-slate-300 rounded">
                            <label for="terms" class="ml-2.5 text-xs text-slate-500 leading-relaxed">
                                I agree to the terms and authorize a temporary hold of RM <span x-text="depositAmount"></span> deposit amount. The remaining balance will be released upon project completion.
                            </label>
                        </div>

                        <!-- Navigation -->
                        <div class="flex justify-between pt-4">
                            <button type="button" @click="step = 2"
                                    class="border border-slate-200 hover:bg-slate-50 text-slate-700 font-semibold py-3 px-8 rounded-xl transition-all flex items-center space-x-2">
                                <i data-lucide="arrow-left" class="w-4 h-4"></i>
                                <span>Back</span>
                            </button>
                            <button type="submit"
                                    class="bg-brand-600 hover:bg-brand-700 text-white font-semibold py-3 px-8 rounded-xl transition-all shadow-md shadow-brand-500/25 flex items-center space-x-2">
                                <i data-lucide="check-circle-2" class="w-4 h-4 text-brand-200"></i>
                                <span>Pay Deposit & Book</span>
                            </button>
                        </div>
                    </div>
                </div>

            </form>
        </div>
    </div>
</div>
@endsection
