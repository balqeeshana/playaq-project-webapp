@extends('layouts.app')

@section('title', 'My Dashboard - PLAYAQ')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <!-- Header Summary -->
    <div class="bg-gradient-to-r from-brand-600 to-indigo-600 rounded-2xl p-8 text-white shadow-xl shadow-slate-100/80 border border-slate-100 mb-8 flex flex-col md:flex-row justify-between items-start md:items-center">
        <div>
            <h1 class="text-white text-3xl font-extrabold tracking-tight">Customer Dashboard</h1>
            <p class="text-indigo-100 mt-1">Manage your active service bookings and view transaction history</p>
        </div>
        <div class="mt-4 md:mt-0 bg-white/10 px-4 py-2.5 rounded-xl border border-white/10 text-sm">
            <p class="font-semibold">Account: {{ Auth::user()->name }}</p>
            <p class="text-xs text-indigo-200">{{ Auth::user()->email }}</p>
        </div>
    </div>

    <!-- Alert Success -->
    @if(session('success'))
        <div class="mb-6 bg-emerald-50 border-l-4 border-emerald-400 p-4 rounded-xl shadow-sm">
            <div class="flex">
                <i data-lucide="check-circle" class="w-5 h-5 text-emerald-500 mr-3"></i>
                <span class="text-emerald-800 text-sm font-semibold">{{ session('success') }}</span>
            </div>
        </div>
    @endif

    <!-- Content Sections -->
    <div class="grid lg:grid-cols-3 gap-8">
        <!-- Bookings Column -->
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6">
                <h3 class="text-slate-900 font-bold text-lg mb-4">My Bookings</h3>

                @if($bookings->isEmpty())
                    <div class="text-center py-12 border border-dashed border-slate-200 rounded-xl bg-slate-50/50">
                        <i data-lucide="calendar" class="w-12 h-12 text-slate-300 mx-auto mb-2"></i>
                        <p class="text-slate-500 font-medium">No bookings found</p>
                        <p class="text-xs text-slate-400 mt-1">Book certified professionals directly from the home search page.</p>
                        <a href="/" class="inline-flex items-center space-x-1 mt-4 text-xs font-bold text-brand-600 hover:text-brand-700 bg-brand-50 px-3 py-1.5 rounded-full transition-colors">
                            <span>Browse Professionals</span>
                            <i data-lucide="arrow-right" class="w-3.5 h-3.5"></i>
                        </a>
                    </div>
                @else
                    <div class="space-y-4">
                        @foreach($bookings as $booking)
                            <div class="border border-slate-100 rounded-xl p-5 hover:border-brand-100 transition-colors space-y-4">
                                <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                                    <div class="space-y-2">
                                        <div class="flex items-center space-x-2.5">
                                            <span class="text-slate-950 font-bold capitalize text-lg">{{ $booking->service_name }}</span>
                                            <span class="px-2.5 py-0.5 rounded-full text-xs font-bold uppercase tracking-wider
                                                @if($booking->status === 'completed') bg-emerald-100 text-emerald-700
                                                @elseif($booking->status === 'confirmed') bg-indigo-100 text-indigo-700
                                                @else bg-amber-100 text-amber-700 @endif">
                                                {{ $booking->status }}
                                            </span>
                                        </div>
                                        <p class="text-slate-500 text-sm leading-relaxed">{{ $booking->description }}</p>
                                        @if($booking->photo_paths && count($booking->photo_paths) > 0)
                                            <div class="flex space-x-1.5 mt-2">
                                                @foreach($booking->photo_paths as $photo)
                                                    <a href="{{ asset('images/' . $photo) }}" target="_blank" class="block w-8 h-8 rounded border border-slate-200 overflow-hidden hover:scale-105 transition-transform">
                                                        <img src="{{ asset('images/' . $photo) }}" class="w-full h-full object-cover">
                                                    </a>
                                                @endforeach
                                            </div>
                                        @endif
                                        <div class="flex flex-wrap gap-4 text-xs text-slate-400 font-medium pt-1">
                                            <span class="flex items-center"><i data-lucide="user" class="w-3.5 h-3.5 mr-1 text-slate-400"></i>{{ $booking->professionalProfile->business_name }}</span>
                                            <span class="flex items-center"><i data-lucide="calendar" class="w-3.5 h-3.5 mr-1 text-slate-400"></i>{{ $booking->booking_date }}</span>
                                            <span class="flex items-center"><i data-lucide="clock" class="w-3.5 h-3.5 mr-1 text-slate-400"></i><span class="capitalize">{{ $booking->booking_time }}</span></span>
                                        </div>
                                    </div>

                                    <!-- Actions & Price Details -->
                                    <div class="w-full md:w-auto text-left md:text-right space-y-2.5 self-stretch flex flex-col justify-between items-start md:items-end">
                                        <div>
                                            <p class="text-xs text-slate-400 font-medium">Estimated Pricing</p>
                                            <p class="font-bold text-slate-800">{{ $booking->total_estimated_cost }}</p>
                                            <p class="text-xs text-brand-600 font-medium">Deposit Paid: RM {{ $booking->deposit_amount }}</p>
                                        </div>
                                        <div class="flex flex-col sm:flex-row gap-2 w-full md:w-auto">
                                            <a href="/chat/{{ $booking->professionalProfile->user_id }}" class="bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold px-4 py-2.5 rounded-lg transition-colors flex items-center justify-center space-x-1">
                                                <i data-lucide="message-square" class="w-3.5 h-3.5 text-slate-500"></i>
                                                <span>Chat with Pro</span>
                                            </a>
                                            @if($booking->status === 'confirmed')
                                                <a href="/bookings/{{ $booking->id }}/pay-balance" class="bg-brand-600 hover:bg-brand-700 text-white text-xs font-bold px-4 py-2.5 rounded-lg transition-colors flex items-center justify-center space-x-1 shadow-md shadow-brand-500/10">
                                                    <i data-lucide="credit-card" class="w-3.5 h-3.5"></i>
                                                    <span>Pay Final Balance</span>
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <!-- Review Section (Only for completed bookings) -->
                                @if($booking->status === 'completed')
                                    <div class="border-t border-slate-100 pt-4 mt-2">
                                        @if(is_null($booking->rating))
                                            <div class="bg-brand-50/30 border border-brand-100 rounded-xl p-4" x-data="{ userRating: 5 }">
                                                <h4 class="text-brand-900 font-bold text-sm mb-2 flex items-center">
                                                    <i data-lucide="sparkles" class="w-4 h-4 mr-1 text-brand-600 animate-pulse"></i>
                                                    <span>How was your service? Leave a review!</span>
                                                </h4>
                                                <form action="/bookings/{{ $booking->id }}/rate" method="POST" class="space-y-3">
                                                    @csrf
                                                    <!-- Star Selector -->
                                                    <div class="flex items-center space-x-1">
                                                        <input type="hidden" name="rating" :value="userRating">
                                                        <template x-for="star in [1, 2, 3, 4, 5]" :key="star">
                                                            <button type="button" @click="userRating = star" class="focus:outline-none transition-transform hover:scale-110">
                                                                <svg class="w-6 h-6" :class="star <= userRating ? 'text-amber-400 fill-amber-400' : 'text-slate-200'" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                                                    <path fill-rule="evenodd" d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.006 5.404.434c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.434 2.082-5.005Z" clip-rule="evenodd" />
                                                                </svg>
                                                            </button>
                                                        </template>
                                                        <span class="text-slate-500 text-xs font-semibold ml-2" x-text="userRating + ' Stars'"></span>
                                                    </div>
                                                    <!-- Comment -->
                                                    <div>
                                                        <textarea name="review_comment" required rows="2" 
                                                                  class="w-full border border-slate-200 rounded-lg p-2 text-xs focus:ring-1 focus:ring-brand-500 focus:border-brand-500 outline-none" 
                                                                  placeholder="Share your experience (e.g. Mike was fast and professional)..."></textarea>
                                                    </div>
                                                    <div class="flex justify-end">
                                                        <button type="submit" class="bg-brand-600 hover:bg-brand-700 text-white font-semibold text-xs px-4 py-2 rounded-lg shadow-sm">
                                                            Submit Review
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>
                                        @else
                                            <div class="bg-slate-50 rounded-xl p-4 border border-slate-100 flex flex-col space-y-1.5">
                                                <div class="flex items-center justify-between">
                                                    <span class="text-slate-700 text-xs font-bold">Your Review</span>
                                                    <div class="flex items-center space-x-0.5">
                                                        @for($i = 1; $i <= 5; $i++)
                                                            <i data-lucide="star" class="w-3.5 h-3.5 @if($i <= $booking->rating) text-amber-400 fill-amber-400 @else text-slate-200 @endif"></i>
                                                        @endfor
                                                    </div>
                                                </div>
                                                <p class="text-slate-600 text-xs italic">"{{ $booking->review_comment }}"</p>
                                            </div>
                                        @endif
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>

        <!-- Sidebar / Tips & Guide -->
        <div class="space-y-6">


            <!-- Help Guide -->
            <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6 space-y-4">
                <h4 class="text-slate-900 font-bold">Booking Process Guide</h4>
                <div class="space-y-3 text-xs leading-relaxed text-slate-500">
                    <p><strong class="text-slate-700">1. Pending:</strong> Handyman is currently checking schedule availability to accept the job.</p>
                    <p><strong class="text-slate-700">2. Confirmed:</strong> Handyman accepted the job. They will contact you shortly and show up at the scheduled slot.</p>
                    <p><strong class="text-slate-700">3. Completed:</strong> Service is done. Balance has been paid via secure portal.</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
