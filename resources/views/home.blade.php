@extends('layouts.app')

@section('title', 'PLAYAQ - Trusted Handyman Services')

@section('content')
<!-- Hero Section -->
<section class="relative bg-gradient-to-br from-brand-50 via-white to-indigo-50/30 py-16 overflow-hidden">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
            
            <!-- Left Column: Title, Slogan, Search -->
            <div class="lg:col-span-7 space-y-6 text-left">
                <!-- Badge -->
                <div class="inline-flex items-center space-x-2 bg-brand-100 text-brand-700 px-4 py-1.5 rounded-full text-sm font-semibold shadow-sm shadow-brand-500/5 animate-fade-in">
                    <span>✓</span>
                    <span>100% Verified & Certified Local Handymen</span>
                </div>
                
                <div class="space-y-4">
                    <h1 class="text-6xl font-black text-brand-900 tracking-tight leading-none">
                        PLAYAQ
                    </h1>
                    <p class="text-2xl text-slate-600 italic font-medium leading-relaxed">
                        "Quality You Can Trust, Service You Deserve"
                    </p>
                </div>

                <!-- Search Bar Container -->
                <div class="bg-white p-5 rounded-2xl shadow-xl shadow-slate-100/80 border border-slate-100 relative z-10">
                    <form action="/" method="GET" class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <!-- Service Dropdown -->
                        <div class="relative">
                            <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1">Service Needed</label>
                            <div class="relative">
                                <select name="service" class="w-full pl-3 pr-8 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-brand-500 text-sm font-medium text-slate-800 appearance-none">
                                    <option value="">Select a service...</option>
                                    <option value="plumbing" {{ $selectedService === 'plumbing' ? 'selected' : '' }}>Plumbing Services</option>
                                    <option value="painting" {{ $selectedService === 'painting' ? 'selected' : '' }}>Painting Services</option>
                                    <option value="appliance-repair" {{ $selectedService === 'appliance-repair' ? 'selected' : '' }}>Appliance Repair</option>
                                    <option value="appliance-installation" {{ $selectedService === 'appliance-installation' ? 'selected' : '' }}>Appliance Installation</option>
                                </select>
                                <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none text-slate-400">
                                    <i data-lucide="chevron-down" class="w-4 h-4"></i>
                                </div>
                            </div>
                        </div>

                        <!-- Location Dropdown -->
                        <div class="relative">
                            <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1">Your Location</label>
                            <div class="relative">
                                <select name="location" class="w-full pl-3 pr-8 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-brand-500 text-sm font-medium text-slate-800 appearance-none">
                                    <option value="">Select Klang Valley area...</option>
                                    @foreach($locations as $loc)
                                        <option value="{{ $loc }}" {{ $selectedLocation === $loc ? 'selected' : '' }}>{{ $loc }}</option>
                                    @endforeach
                                </select>
                                <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none text-slate-400">
                                    <i data-lucide="chevron-down" class="w-4 h-4"></i>
                                </div>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="flex items-end">
                            <button type="submit" class="w-full bg-brand-600 hover:bg-brand-700 text-white font-semibold py-3 px-6 rounded-xl transition-all shadow-md shadow-brand-500/25 flex items-center justify-center space-x-2">
                                <i data-lucide="search" class="w-4 h-4"></i>
                                <span>Search Professionals</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            
            <!-- Right Column: Handyman Image -->
            <div class="lg:col-span-5 relative flex justify-center">
                <div class="relative rounded-3xl overflow-hidden shadow-2xl border-4 border-white bg-white w-full max-w-[400px] aspect-square">
                    <img src="{{ asset('images/handyman.jpg') }}" alt="Verified Handyman" class="w-full h-full object-cover">
                </div>
                <!-- Platform safety badge -->
                <div class="absolute -bottom-4 left-4 bg-white px-5 py-3 rounded-2xl shadow-xl border border-slate-100 flex items-center space-x-3">
                    <div class="w-9 h-9 bg-green-100 rounded-xl flex items-center justify-center text-green-600 shrink-0">
                        <i data-lucide="shield-check" class="w-5 h-5"></i>
                    </div>
                    <div>
                        <p class="text-[10px] text-slate-400 font-bold uppercase tracking-wider">Safety Guarantee</p>
                        <p class="text-xs font-extrabold text-slate-800">100% Insured & Verified</p>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</section>

<!-- Main Professional Search Results -->
<section id="results" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
    <div class="flex justify-between items-center mb-8">
        <div>
            <h2 class="text-3xl font-extrabold text-slate-900 tracking-tight">Available Professionals</h2>
            <p class="text-slate-500 mt-1">
                @if($selectedService || $selectedLocation)
                    Showing matches for {{ ucfirst($selectedService) }} in {{ $selectedLocation ?: 'all areas' }}
                @else
                    Showing highly-rated handymen in Klang Valley
                @endif
            </p>
        </div>
    </div>

    <!-- Professionals Grid -->
    @if($professionals->isEmpty())
        <div class="text-center py-16 bg-white rounded-2xl border border-slate-150 shadow-inner">
            <i data-lucide="users" class="w-16 h-16 mx-auto text-slate-300 mb-4"></i>
            <h3 class="text-lg font-semibold text-slate-700">No professionals found</h3>
            <p class="text-slate-500 mt-1">Try expanding your search query parameters or checking other services.</p>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($professionals as $pro)
                <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden hover:shadow-lg transition-all duration-300 flex flex-col justify-between">
                    <!-- Banner/Photo -->
                    <div class="relative h-48 bg-slate-100 overflow-hidden">
                        @if($pro->image_path)
                            <img src="{{ asset('images/' . $pro->image_path) }}" alt="{{ $pro->business_name }}" class="w-full h-full object-cover hover:scale-105 transition-transform duration-500">
                        @else
                            <div class="w-full h-full bg-indigo-50 flex flex-col items-center justify-center text-brand-600">
                                <i data-lucide="user" class="w-12 h-12 mb-1 opacity-70"></i>
                                <span class="text-xs font-semibold text-indigo-400">Professional Handyman</span>
                            </div>
                        @endif
                    </div>
                    <!-- Card Body -->
                    <div class="p-6">
                        <!-- Rating & Badge -->
                        <div class="flex justify-between items-center mb-4">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-50 text-emerald-700 border border-emerald-100">
                                <i data-lucide="check" class="w-3.5 h-3.5 mr-1 text-emerald-600"></i>
                                Certified
                            </span>
                            <div class="flex items-center space-x-1">
                                <i data-lucide="star" class="w-4 h-4 text-amber-400 fill-amber-400"></i>
                                <span class="text-sm font-bold text-slate-800">{{ number_format($pro->rating, 1) }}</span>
                                <span class="text-xs text-slate-400">({{ $pro->completed_jobs }} jobs)</span>
                            </div>
                        </div>

                        <!-- Name & Business -->
                        <h3 class="text-xl font-bold text-slate-900 mb-1 leading-snug">{{ $pro->business_name }}</h3>
                        <p class="text-slate-500 text-sm font-medium capitalize mb-4">Specialty: {{ str_replace('-', ' ', $pro->specialty) }}</p>
                        
                        <!-- Bio -->
                        <p class="text-slate-600 text-sm line-clamp-3 mb-6">
                            {{ $pro->bio ?: 'Experienced certified handyman offering fast, reliable services and fully background-checked guarantee.' }}
                        </p>

                        <!-- Details (Phone & Location) -->
                        <div class="space-y-2.5 border-t border-slate-100 pt-4">
                            <div class="flex items-center text-slate-600 text-sm">
                                <i data-lucide="map-pin" class="w-4.5 h-4.5 mr-2 text-brand-500"></i>
                                <span>{{ $pro->location ?: 'Kuala Lumpur' }}</span>
                            </div>
                            <div class="flex items-center text-slate-600 text-sm">
                                <i data-lucide="phone" class="w-4.5 h-4.5 mr-2 text-brand-500"></i>
                                <span>{{ $pro->phone ?: '+60 12-345 6789' }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Card Actions -->
                    <div class="px-6 pb-6 pt-2 bg-slate-50/50 border-t border-slate-100/50">
                        @auth
                            <a href="/bookings/create?professional_id={{ $pro->id }}" class="w-full flex justify-center py-2.5 px-4 border border-transparent rounded-xl shadow-sm text-sm font-semibold text-white bg-brand-600 hover:bg-brand-700 transition-colors">
                                Book This Professional
                            </a>
                        @else
                            <a href="/login" class="w-full flex justify-center py-2.5 px-4 border border-transparent rounded-xl shadow-sm text-sm font-semibold text-white bg-brand-600 hover:bg-brand-700 transition-colors">
                                Log In to Book
                            </a>
                        @endauth
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</section>

<!-- How It Works Section -->
<section class="bg-slate-900 text-white py-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-4xl font-extrabold tracking-tight">How PLAYAQ Works</h2>
            <p class="text-slate-400 mt-2 max-w-2xl mx-auto">Get your home repair problems solved in 4 simple steps.</p>
        </div>
        <div class="grid md:grid-cols-4 gap-8">
            <div class="text-center">
                <div class="w-12 h-12 bg-brand-600 rounded-full flex items-center justify-center font-bold text-lg mx-auto mb-4">1</div>
                <h4 class="font-bold mb-2">Search Service</h4>
                <p class="text-slate-400 text-sm">Specify the service and select your Klang Valley location.</p>
            </div>
            <div class="text-center">
                <div class="w-12 h-12 bg-brand-600 rounded-full flex items-center justify-center font-bold text-lg mx-auto mb-4">2</div>
                <h4 class="font-bold mb-2">Select Handyman</h4>
                <p class="text-slate-400 text-sm">Compare ratings, specialties, and prices to choose your handyman.</p>
            </div>
            <div class="text-center">
                <div class="w-12 h-12 bg-brand-600 rounded-full flex items-center justify-center font-bold text-lg mx-auto mb-4">3</div>
                <h4 class="font-bold mb-2">Secure Deposit</h4>
                <p class="text-slate-400 text-sm">Submit your booking request with a secure 30% deposit payment.</p>
            </div>
            <div class="text-center">
                <div class="w-12 h-12 bg-brand-600 rounded-full flex items-center justify-center font-bold text-lg mx-auto mb-4">4</div>
                <h4 class="font-bold mb-2">Pay Balance</h4>
                <p class="text-slate-400 text-sm">After the job is successfully done, pay the remaining balance.</p>
            </div>
        </div>
    </div>
</section>

@if(request()->has('service') || request()->has('location'))
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const resultsSection = document.getElementById('results');
        if (resultsSection) {
            resultsSection.scrollIntoView({ behavior: 'smooth' });
        }
    });
</script>
@endif
@endsection
