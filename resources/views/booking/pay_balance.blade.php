@extends('layouts.app')

@section('title', 'Pay Remaining Balance - PLAYAQ')

@section('content')
<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-12"
     x-data="{
        paymentMethod: 'fpx',
        bank: 'maybank2u',
        processing: false,
        submitPayment() {
            this.processing = true;
            setTimeout(() => {
                document.getElementById('payment-form').submit();
            }, 1500);
        }
     }">
    <div class="bg-white rounded-2xl border border-slate-100 shadow-xl overflow-hidden">
        <!-- Header -->
        <div class="bg-gradient-to-r from-brand-600 to-indigo-600 text-white p-6 shadow-md">
            <h2 class="text-white text-2xl font-bold">Final Balance Payment</h2>
            <p class="text-indigo-100 text-sm">Secure and complete your service booking transaction</p>
        </div>

        <div class="p-8">
            <form id="payment-form" action="/bookings/{{ $booking->id }}/pay-balance" method="POST" @submit.prevent="submitPayment()">
                @csrf
                <div class="space-y-8">
                    <!-- Summary Box -->
                    <div class="bg-slate-50 border border-slate-100 rounded-xl p-6 space-y-3">
                        <h3 class="text-slate-900 font-bold text-sm uppercase tracking-wider mb-2">Service Details</h3>
                        <div class="grid grid-cols-2 gap-y-2.5 text-sm">
                            <span class="text-slate-500 font-medium">Service Job:</span>
                            <span class="text-slate-900 font-semibold capitalize">{{ $booking->service_name }}</span>

                            <span class="text-slate-500 font-medium">Professional:</span>
                            <span class="text-slate-900 font-semibold">{{ $booking->professionalProfile->business_name }}</span>

                            <span class="text-slate-500 font-medium">Scheduled Date:</span>
                            <span class="text-slate-900 font-semibold">{{ $booking->booking_date }}</span>
                        </div>
                    </div>

                    <!-- Payment Calculation Breakdown -->
                    <div class="space-y-4">
                        <h3 class="text-slate-900 font-bold text-lg border-b border-slate-100 pb-2">Pricing Breakdown</h3>
                        
                        <div class="space-y-2.5 text-sm">
                            <div class="flex justify-between">
                                <span class="text-slate-500">Estimated Total Cost:</span>
                                <span class="text-slate-800 font-semibold">{{ $booking->total_estimated_cost }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-slate-500">Deposit Paid (30%):</span>
                                <span class="text-slate-800 font-semibold text-brand-600">- RM {{ $booking->deposit_amount }}</span>
                            </div>
                            <hr class="border-slate-100 my-1">
                            <div class="flex justify-between items-center bg-brand-50/50 p-4 rounded-xl border border-brand-100/50">
                                <span class="text-slate-900 font-bold">Remaining Balance Due:</span>
                                <span class="text-3xl font-black text-brand-600">RM {{ $remainingBalance }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Payment Gateway Selector -->
                    <div class="space-y-4">
                        <h3 class="text-slate-900 font-bold text-lg border-b border-slate-100 pb-2">Select Payment Method</h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <label class="flex items-center justify-between border-2 rounded-xl p-4 cursor-pointer transition-all"
                                   :class="paymentMethod === 'fpx' ? 'border-brand-600 bg-brand-50/50 text-brand-700' : 'border-slate-200 hover:border-brand-300 text-slate-600'">
                                <span class="flex items-center">
                                    <input type="radio" name="payment_method" value="fpx" x-model="paymentMethod" class="sr-only">
                                    <i data-lucide="landmark" class="w-5 h-5 mr-3 text-slate-500" :class="paymentMethod === 'fpx' ? 'text-brand-600' : ''"></i>
                                    <span class="font-semibold text-sm">FPX Online Banking</span>
                                </span>
                                <span class="text-xxs font-bold uppercase tracking-wider text-brand-600" x-show="paymentMethod === 'fpx'">Selected</span>
                            </label>

                            <label class="flex items-center justify-between border-2 rounded-xl p-4 cursor-pointer transition-all"
                                   :class="paymentMethod === 'card' ? 'border-brand-600 bg-brand-50/50 text-brand-700' : 'border-slate-200 hover:border-brand-300 text-slate-600'">
                                <span class="flex items-center">
                                    <input type="radio" name="payment_method" value="card" x-model="paymentMethod" class="sr-only">
                                    <i data-lucide="credit-card" class="w-5 h-5 mr-3 text-slate-500" :class="paymentMethod === 'card' ? 'text-brand-600' : ''"></i>
                                    <span class="font-semibold text-sm">Credit / Debit Card</span>
                                </span>
                                <span class="text-xxs font-bold uppercase tracking-wider text-brand-600" x-show="paymentMethod === 'card'">Selected</span>
                            </label>

                            <label class="flex items-center justify-between border-2 rounded-xl p-4 cursor-pointer transition-all"
                                   :class="paymentMethod === 'ewallet' ? 'border-brand-600 bg-brand-50/50 text-brand-700' : 'border-slate-200 hover:border-brand-300 text-slate-600'">
                                <span class="flex items-center">
                                    <input type="radio" name="payment_method" value="ewallet" x-model="paymentMethod" class="sr-only">
                                    <i data-lucide="wallet" class="w-5 h-5 mr-3 text-slate-500" :class="paymentMethod === 'ewallet' ? 'text-brand-600' : ''"></i>
                                    <span class="font-semibold text-sm">eWallet (TNG/GrabPay)</span>
                                </span>
                                <span class="text-xxs font-bold uppercase tracking-wider text-brand-600" x-show="paymentMethod === 'ewallet'">Selected</span>
                            </label>

                            <label class="flex items-center justify-between border-2 rounded-xl p-4 cursor-pointer transition-all"
                                   :class="paymentMethod === 'paypal' ? 'border-brand-600 bg-brand-50/50 text-brand-700' : 'border-slate-200 hover:border-brand-300 text-slate-600'">
                                <span class="flex items-center">
                                    <input type="radio" name="payment_method" value="paypal" x-model="paymentMethod" class="sr-only">
                                    <i data-lucide="send" class="w-5 h-5 mr-3 text-slate-500" :class="paymentMethod === 'paypal' ? 'text-brand-600' : ''"></i>
                                    <span class="font-semibold text-sm">PayPal</span>
                                </span>
                                <span class="text-xxs font-bold uppercase tracking-wider text-brand-600" x-show="paymentMethod === 'paypal'">Selected</span>
                            </label>
                        </div>

                        <!-- FPX Bank Selection Details -->
                        <div x-show="paymentMethod === 'fpx'" x-transition class="bg-slate-50 p-4 rounded-xl border border-slate-100 mt-4 space-y-4">
                            <div>
                                <label for="bank" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Choose Bank</label>
                                <select id="bank" name="fpx_bank" x-model="bank" class="w-full px-3 py-2.5 border border-slate-200 rounded-lg text-sm bg-white outline-none">
                                    <option value="maybank2u">Maybank2u</option>
                                    <option value="cimb_clicks">CIMB Clicks</option>
                                    <option value="public_bank">Public Bank</option>
                                    <option value="rhb_now">RHB Now</option>
                                    <option value="hong_leong">Hong Leong Connect</option>
                                    <option value="ambank">AmOnline</option>
                                </select>
                            </div>
                        </div>

                        <!-- Card Details -->
                        <div x-show="paymentMethod === 'card'" x-transition class="bg-slate-50 p-4 rounded-xl border border-slate-100 mt-4 space-y-4">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-1.5">Card Number</label>
                                    <input type="text" class="w-full px-3 py-2 border border-slate-200 rounded-lg text-sm outline-none bg-white" placeholder="4111 2222 3333 4444" value="4111 2222 3333 4444" :required="paymentMethod === 'card'">
                                </div>
                                <div class="grid grid-cols-2 gap-2">
                                    <div>
                                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-1.5">Expiry</label>
                                        <input type="text" class="w-full px-3 py-2 border border-slate-200 rounded-lg text-sm outline-none bg-white" placeholder="12/28" value="12/28" :required="paymentMethod === 'card'">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-1.5">CVV</label>
                                        <input type="password" class="w-full px-3 py-2 border border-slate-200 rounded-lg text-sm outline-none bg-white" placeholder="***" value="123" :required="paymentMethod === 'card'">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Payment Button -->
                    <div class="pt-6 border-t border-slate-100 flex justify-between items-center gap-4">
                        <a href="/dashboard" class="text-slate-600 hover:text-slate-800 font-semibold text-sm">Cancel</a>
                        <button type="submit" :disabled="processing"
                                class="bg-brand-600 hover:bg-brand-700 text-white font-semibold py-3 px-8 rounded-xl transition-all shadow-md shadow-brand-500/25 flex items-center space-x-2 disabled:bg-slate-400 disabled:cursor-not-allowed">
                            <template x-if="processing">
                                <span class="flex items-center space-x-2">
                                    <i data-lucide="loader" class="w-4 h-4 animate-spin text-white"></i>
                                    <span>Processing Secure Gateway...</span>
                                </span>
                            </template>
                            <template x-if="!processing">
                                <span class="flex items-center space-x-2">
                                    <i data-lucide="check-circle" class="w-4 h-4 text-brand-200"></i>
                                    <span>Confirm & Pay RM <span x-text="remainingBalance"></span></span>
                                </span>
                            </template>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
