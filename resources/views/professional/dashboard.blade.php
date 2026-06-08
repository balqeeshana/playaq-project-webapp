@extends('layouts.app')

@section('title', 'Pro Dashboard - PLAYAQ')

@section('content')
<div class="relative min-h-screen bg-slate-50">
    <!-- Shading background image -->
    <div class="absolute inset-0 z-0 opacity-[0.03] pointer-events-none" style="background-image: url('{{ asset('images/dashboard.jpg') }}'); background-repeat: no-repeat; background-position: right bottom; background-size: 35%;"></div>

    <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12"
         x-data="{ activeTab: 'profile' }">
     
    <!-- Header -->
    <div class="bg-gradient-to-r from-brand-600 to-indigo-600 rounded-2xl p-8 text-white shadow-xl shadow-slate-100/80 border border-slate-100 mb-8 flex flex-col md:flex-row justify-between items-start md:items-center">
        <div>
            <div class="flex items-center space-x-2">
                <h1 class="text-white text-3xl font-extrabold tracking-tight">Professional Dashboard</h1>
                <span class="bg-white/20 text-white border border-white/20 px-2.5 py-0.5 rounded-full text-xs font-bold uppercase tracking-wider">Pro Account</span>
            </div>
            <p class="text-indigo-100 mt-1">Manage your services, verify documents, track bookings and earnings</p>
        </div>
        <div class="mt-4 md:mt-0 text-left md:text-right">
            <p class="font-bold text-lg text-white leading-tight">{{ $pro->business_name }}</p>
            <p class="text-xs text-indigo-200 capitalize font-medium">Specialty: {{ str_replace('-', ' ', $pro->specialty) }}</p>
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

    <!-- Stats Panel -->
    <div class="grid grid-cols-2 md:grid-cols-5 gap-4 mb-8">
        <div class="bg-white rounded-xl border border-slate-100 p-5 shadow-sm">
            <div class="w-8 h-8 bg-brand-100 text-brand-600 rounded-lg flex items-center justify-center mb-3">
                <i data-lucide="dollar-sign" class="w-4 h-4"></i>
            </div>
            <p class="text-slate-400 text-xs font-semibold uppercase tracking-wider">Total Earnings</p>
            <p class="text-xl font-bold text-slate-800 mt-1">RM {{ number_format($stats['totalEarnings']) }}</p>
        </div>
        <div class="bg-white rounded-xl border border-slate-100 p-5 shadow-sm">
            <div class="w-8 h-8 bg-emerald-100 text-emerald-600 rounded-lg flex items-center justify-center mb-3">
                <i data-lucide="trending-up" class="w-4 h-4"></i>
            </div>
            <p class="text-slate-400 text-xs font-semibold uppercase tracking-wider">This Month</p>
            <p class="text-xl font-bold text-slate-800 mt-1">RM {{ number_format($stats['monthlyEarnings']) }}</p>
        </div>
        <div class="bg-white rounded-xl border border-slate-100 p-5 shadow-sm">
            <div class="w-8 h-8 bg-purple-100 text-purple-600 rounded-lg flex items-center justify-center mb-3">
                <i data-lucide="briefcase" class="w-4 h-4"></i>
            </div>
            <p class="text-slate-400 text-xs font-semibold uppercase tracking-wider">Completed Jobs</p>
            <p class="text-xl font-bold text-slate-800 mt-1">{{ $stats['completedJobs'] }}</p>
        </div>
        <div class="bg-white rounded-xl border border-slate-100 p-5 shadow-sm">
            <div class="w-8 h-8 bg-amber-100 text-amber-500 rounded-lg flex items-center justify-center mb-3">
                <i data-lucide="star" class="w-4 h-4 fill-amber-500"></i>
            </div>
            <p class="text-slate-400 text-xs font-semibold uppercase tracking-wider">Rating</p>
            <p class="text-xl font-bold text-slate-800 mt-1">{{ number_format($stats['avgRating'], 1) }}</p>
        </div>
        <div class="bg-white rounded-xl border border-slate-100 p-5 shadow-sm">
            <div class="w-8 h-8 bg-orange-100 text-orange-600 rounded-lg flex items-center justify-center mb-3">
                <i data-lucide="clock" class="w-4 h-4"></i>
            </div>
            <p class="text-slate-400 text-xs font-semibold uppercase tracking-wider">Pending Tasks</p>
            <p class="text-xl font-bold text-slate-800 mt-1">{{ $stats['pendingBookings'] }}</p>
        </div>
    </div>

    <!-- Navigation Tabs -->
    <div class="border-b border-slate-200 mb-8">
        <div class="flex space-x-8">
            <button @click="activeTab = 'profile'"
                    :class="activeTab === 'profile' ? 'border-brand-600 text-brand-600 font-semibold' : 'border-transparent text-slate-500 hover:text-slate-700'"
                    class="pb-4 px-1 border-b-2 font-medium text-sm transition-all outline-none">
                Profile & Bio
            </button>
            <button @click="activeTab = 'services'"
                    :class="activeTab === 'services' ? 'border-brand-600 text-brand-600 font-semibold' : 'border-transparent text-slate-500 hover:text-slate-700'"
                    class="pb-4 px-1 border-b-2 font-medium text-sm transition-all outline-none">
                Service Offerings
            </button>
            <button @click="activeTab = 'bookings'"
                    :class="activeTab === 'bookings' ? 'border-brand-600 text-brand-600 font-semibold' : 'border-transparent text-slate-500 hover:text-slate-700'"
                    class="pb-4 px-1 border-b-2 font-medium text-sm transition-all outline-none flex items-center space-x-1.5">
                <span>Bookings</span>
                @if($stats['pendingBookings'] > 0)
                    <span class="bg-brand-100 text-brand-700 px-2 py-0.5 rounded-full text-xs font-bold">{{ $stats['pendingBookings'] }}</span>
                @endif
            </button>
            <button @click="activeTab = 'earnings'"
                    :class="activeTab === 'earnings' ? 'border-brand-600 text-brand-600 font-semibold' : 'border-transparent text-slate-500 hover:text-slate-700'"
                    class="pb-4 px-1 border-b-2 font-medium text-sm transition-all outline-none">
                Earnings Summary
            </button>
        </div>
    </div>

    <!-- Tab 1: Profile & Bio Form -->
    <div x-show="activeTab === 'profile'" x-transition>
        <div class="grid lg:grid-cols-3 gap-8">
            <!-- Left Info Form -->
            <div class="lg:col-span-2 bg-white rounded-2xl border border-slate-100 shadow-sm p-6 space-y-6">
                <h3 class="text-slate-900 font-bold text-lg border-b border-slate-100 pb-3">Update Business Information</h3>
                <form action="/pro/profile/update" method="POST" class="space-y-6">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="business_name" class="block text-sm font-semibold text-slate-700">Business Name</label>
                            <input type="text" id="business_name" name="business_name" value="{{ $pro->business_name }}" required
                                   class="mt-1 block w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-brand-500 focus:border-brand-500 sm:text-sm">
                        </div>
                        <div>
                            <label for="location" class="block text-sm font-semibold text-slate-700">Location Base</label>
                            <input type="text" id="location" name="location" value="{{ $pro->location ?: 'Kuala Lumpur' }}" required
                                   class="mt-1 block w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-brand-500 focus:border-brand-500 sm:text-sm">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="experience_years" class="block text-sm font-semibold text-slate-700">Years of Experience</label>
                            <input type="number" id="experience_years" name="experience_years" value="{{ $pro->experience_years }}" required min="0"
                                   class="mt-1 block w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-brand-500 focus:border-brand-500 sm:text-sm">
                        </div>
                        <div>
                            <label for="phone" class="block text-sm font-semibold text-slate-700">Contact Number</label>
                            <input type="text" id="phone" name="phone" value="{{ $pro->phone ?: '+60 12-345 6789' }}" required
                                   class="mt-1 block w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-brand-500 focus:border-brand-500 sm:text-sm">
                        </div>
                    </div>

                    <div>
                        <label for="bio" class="block text-sm font-semibold text-slate-700">Professional Bio</label>
                        <textarea id="bio" name="bio" rows="4" required
                                  class="mt-1 block w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:outline-none focus:ring-brand-500 focus:border-brand-500 sm:text-sm">{{ $pro->bio }}</textarea>
                    </div>

                    <div class="flex justify-end">
                        <button type="submit" class="bg-brand-600 hover:bg-brand-700 text-white font-semibold py-2.5 px-6 rounded-lg transition-colors shadow-md shadow-brand-500/10">
                            Save Changes
                        </button>
                    </div>
                </form>
            </div>

            <!-- Right Verification Uploads -->
            <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6 space-y-6">
                <h3 class="text-slate-900 font-bold text-lg border-b border-slate-100 pb-3">Certificates & Licenses</h3>
                <p class="text-xs text-slate-400 leading-relaxed mb-4">Provide professional documentation to maintain your "Certified" status badge on the marketplace.</p>
                
                <div class="space-y-4">
                    <div class="border border-slate-150 rounded-xl p-4 flex justify-between items-center bg-slate-50/50">
                        <div>
                            <p class="text-slate-700 text-sm font-bold">Handyman License</p>
                            <p class="text-slate-400 text-xxs mt-0.5">Verified ✓</p>
                        </div>
                        <i data-lucide="shield-check" class="w-6 h-6 text-green-500"></i>
                    </div>

                    <div class="border border-slate-150 rounded-xl p-4 flex justify-between items-center bg-slate-50/50">
                        <div>
                            <p class="text-slate-700 text-sm font-bold">Insurance Document</p>
                            <p class="text-slate-400 text-xxs mt-0.5">Verified ✓</p>
                        </div>
                        <i data-lucide="shield-check" class="w-6 h-6 text-green-500"></i>
                    </div>

                    @if(session('certificates'))
                        @foreach(session('certificates') as $cert)
                            <div class="border border-slate-150 rounded-xl p-4 flex justify-between items-center bg-slate-50/50">
                                <div>
                                    <p class="text-slate-700 text-sm font-bold">{{ $cert['name'] }}</p>
                                    <p class="text-amber-500 text-xxs mt-0.5 font-semibold">Pending Verification</p>
                                </div>
                                <i data-lucide="clock" class="w-6.5 h-6.5 text-amber-500 animate-pulse"></i>
                            </div>
                        @endforeach
                    @endif

                    <form action="/pro/certificate/upload" method="POST" enctype="multipart/form-data" class="space-y-4">
                        @csrf
                        <div class="border-2 border-dashed border-slate-200 rounded-xl p-6 text-center hover:border-brand-400 transition-colors bg-slate-50/20 relative cursor-pointer">
                            <input type="file" name="certificate" required class="absolute inset-0 opacity-0 cursor-pointer" onchange="this.form.submit()">
                            <i data-lucide="upload-cloud" class="w-8 h-8 text-slate-400 mx-auto mb-2"></i>
                            <span class="text-xs font-semibold text-slate-600 block">Upload New Certificate</span>
                            <p class="text-[10px] text-slate-400 mt-1">PDF, PNG, JPG up to 10MB</p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Tab 2: Service Offerings CRUD -->
    <div x-show="activeTab === 'services'" x-cloak x-transition class="grid lg:grid-cols-3 gap-8">
        <!-- Left: Service List -->
        <div class="lg:col-span-2 bg-white rounded-2xl border border-slate-100 shadow-sm p-6">
            <h3 class="text-slate-900 font-bold text-lg mb-4">My Custom Offerings</h3>
            
            @if($services->isEmpty())
                <div class="text-center py-12 border border-dashed border-slate-200 rounded-xl bg-slate-50/50">
                    <i data-lucide="package" class="w-12 h-12 text-slate-300 mx-auto mb-2"></i>
                    <p class="text-slate-500 font-medium">No custom services listed</p>
                    <p class="text-xs text-slate-400 mt-1">Add details on the right to list specific price points for clients.</p>
                </div>
            @else
                <div class="space-y-4">
                    @foreach($services as $serv)
                        <div class="border border-slate-100 rounded-xl p-4 flex justify-between items-start hover:border-brand-100 transition-all">
                            <div class="space-y-1">
                                <h4 class="text-slate-900 font-bold capitalize">{{ $serv->name }}</h4>
                                <p class="text-slate-500 text-xs">{{ $serv->description }}</p>
                                <p class="text-brand-600 text-sm font-bold">RM {{ $serv->price_min }} - RM {{ $serv->price_max }}</p>
                            </div>
                            <form action="/pro/services/{{ $serv->id }}/delete" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:text-red-700 p-2 hover:bg-red-50 rounded-lg transition-colors">
                                    <i data-lucide="trash-2" class="w-5 h-5"></i>
                                </button>
                            </form>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        <!-- Right: Add New Service Form -->
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6">
            <h3 class="text-slate-900 font-bold text-lg mb-4">Add Custom Offering</h3>
            <form action="/pro/services/add" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label for="name" class="block text-sm font-semibold text-slate-700">Service Name</label>
                    <select id="name" name="name" required
                            class="mt-1 block w-full px-3 py-2 border border-slate-300 rounded-lg text-sm bg-white outline-none focus:ring-1 focus:ring-brand-500 focus:border-brand-500">
                        <option value="Leak Repairs & Faucet Installation">Leak Repairs & Faucet Installation</option>
                        <option value="Drain Cleaning & Pipe Repairs">Drain Cleaning & Pipe Repairs</option>
                        <option value="Toilet Repair & Installation">Toilet Repair & Installation</option>
                        <option value="Interior Painting">Interior Painting</option>
                        <option value="Cabinet & Trim Painting">Cabinet & Trim Painting</option>
                        <option value="Dishwasher Repair & Installation">Dishwasher Repair & Installation</option>
                        <option value="Washing Machine & Dryer Services">Washing Machine & Dryer Services</option>
                        <option value="Refrigerator Repair">Refrigerator Repair</option>
                    </select>
                </div>

                <div>
                    <label for="description" class="block text-sm font-semibold text-slate-700">Brief Description</label>
                    <input type="text" id="description" name="description" placeholder="e.g. Unclog pipe and install replacement filters"
                           class="mt-1 block w-full px-3 py-2 border border-slate-300 rounded-lg text-sm outline-none focus:ring-1 focus:ring-brand-500 focus:border-brand-500">
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="price_min" class="block text-sm font-semibold text-slate-700">Min Price (RM)</label>
                        <input type="number" id="price_min" name="price_min" required value="75"
                               class="mt-1 block w-full px-3 py-2 border border-slate-300 rounded-lg text-sm outline-none focus:ring-1 focus:ring-brand-500 focus:border-brand-500">
                    </div>
                    <div>
                        <label for="price_max" class="block text-sm font-semibold text-slate-700">Max Price (RM)</label>
                        <input type="number" id="price_max" name="price_max" required value="120"
                               class="mt-1 block w-full px-3 py-2 border border-slate-300 rounded-lg text-sm outline-none focus:ring-1 focus:ring-brand-500 focus:border-brand-500">
                    </div>
                </div>

                <button type="submit" class="w-full bg-brand-600 hover:bg-brand-700 text-white font-semibold py-2.5 px-4 rounded-lg transition-colors shadow-md shadow-brand-500/10 text-sm">
                    Add Offering
                </button>
            </form>
        </div>
    </div>

    <!-- Tab 3: Bookings List -->
    <div x-show="activeTab === 'bookings'" x-cloak x-transition>
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6">
            <h3 class="text-slate-900 font-bold text-lg mb-4">Assigned Bookings</h3>
            
            @if($bookings->isEmpty())
                <div class="text-center py-12 border border-dashed border-slate-200 rounded-xl bg-slate-50/50">
                    <i data-lucide="calendar" class="w-12 h-12 text-slate-300 mx-auto mb-2"></i>
                    <p class="text-slate-500 font-medium">No bookings assigned yet</p>
                    <p class="text-xs text-slate-400 mt-1">Once clients select you on the marketplace, requests will display here.</p>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm border-collapse">
                        <thead>
                            <tr class="border-b border-slate-200 text-slate-400 uppercase tracking-wider text-xs font-semibold">
                                <th class="pb-3 pr-4">Client Name</th>
                                <th class="pb-3 pr-4">Service Type</th>
                                <th class="pb-3 pr-4">Scheduled Date & Time</th>
                                <th class="pb-3 pr-4">Deposit / Total</th>
                                <th class="pb-3 pr-4">Status</th>
                                <th class="pb-3">Action</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 text-slate-600">
                            @foreach($bookings as $book)
                                <tr>
                                    <td class="py-4 pr-4 font-bold text-slate-800">{{ $book->customer->name }}</td>
                                    <td class="py-4 pr-4">
                                        <p class="capitalize font-semibold text-slate-700 leading-snug">{{ $book->service_name }}</p>
                                        <p class="text-slate-400 text-xxs line-clamp-1 mt-0.5">{{ $book->description }}</p>
                                        @if($book->photo_paths && count($book->photo_paths) > 0)
                                            <div class="flex space-x-1.5 mt-1.5">
                                                @foreach($book->photo_paths as $photo)
                                                    <a href="{{ asset('images/' . $photo) }}" target="_blank" class="block w-6 h-6 rounded border border-slate-200 overflow-hidden hover:scale-105 transition-transform">
                                                        <img src="{{ asset('images/' . $photo) }}" class="w-full h-full object-cover">
                                                    </a>
                                                @endforeach
                                            </div>
                                        @endif
                                    </td>
                                    <td class="py-4 pr-4">
                                        <div class="flex items-center space-x-1.5">
                                            <i data-lucide="calendar" class="w-3.5 h-3.5 text-slate-400"></i>
                                            <span>{{ $book->booking_date }}</span>
                                        </div>
                                        <span class="text-xs capitalize font-medium text-slate-400">{{ $book->booking_time }}</span>
                                    </td>
                                    <td class="py-4 pr-4">
                                        <p class="font-bold text-slate-800">{{ $book->total_estimated_cost }}</p>
                                        <p class="text-xs text-brand-600 font-medium">Deposit: RM {{ $book->deposit_amount }}</p>
                                    </td>
                                    <td class="py-4 pr-4">
                                        <span class="px-2.5 py-0.5 rounded-full text-xxs font-bold uppercase tracking-wider
                                            @if($book->status === 'completed') bg-emerald-100 text-emerald-700
                                            @elseif($book->status === 'confirmed') bg-indigo-100 text-indigo-700
                                            @else bg-amber-100 text-amber-700 @endif">
                                            {{ $book->status }}
                                        </span>
                                    </td>
                                    <td class="py-4 flex items-center space-x-2">
                                        <a href="/chat/{{ $book->customer_id }}" class="bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold px-3 py-1.5 rounded-lg transition-colors flex items-center space-x-1">
                                            <i data-lucide="message-square" class="w-3.5 h-3.5 text-slate-500"></i>
                                            <span>Chat</span>
                                        </a>
                                        @if($book->status === 'pending')
                                            <form action="/pro/bookings/{{ $book->id }}/accept" method="POST" class="inline">
                                                @csrf
                                                <button type="submit" class="bg-brand-600 hover:bg-brand-700 text-white text-xs font-bold px-3 py-1.5 rounded-lg transition-colors flex items-center space-x-1">
                                                    <i data-lucide="check-circle" class="w-3.5 h-3.5 text-brand-200"></i>
                                                    <span>Accept</span>
                                                </button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>

    <!-- Tab 4: Earnings Summary -->
    <div x-show="activeTab === 'earnings'" x-cloak x-transition class="space-y-6">
        <div class="grid md:grid-cols-3 gap-6">
            <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6">
                <p class="text-slate-400 text-xs font-semibold uppercase tracking-wider mb-1">Total Earnings</p>
                <p class="text-3xl font-black text-slate-900">RM {{ number_format($stats['totalEarnings']) }}</p>
                <p class="text-xs text-green-500 mt-2">↑ 12% increase from last month</p>
            </div>
            <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6">
                <p class="text-slate-400 text-xs font-semibold uppercase tracking-wider mb-1">Payout Balance</p>
                <p class="text-3xl font-black text-slate-900">RM {{ number_format($stats['payoutBalance']) }}</p>
                <p class="text-xs text-slate-400 mt-2">Instant withdrawals available 24/7</p>
            </div>
            <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6">
                <p class="text-slate-400 text-xs font-semibold uppercase tracking-wider mb-1">Completed Jobs</p>
                <p class="text-3xl font-black text-slate-900">{{ $stats['completedJobs'] }}</p>
                <p class="text-xs text-slate-400 mt-2">Maintain rating above 4.5 to keep badge</p>
            </div>
        </div>

        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6">
            <h3 class="text-slate-900 font-bold text-lg mb-4">Simulated Payout Account</h3>
            <div class="border border-slate-150 rounded-xl p-5 flex flex-col md:flex-row justify-between items-start md:items-center bg-slate-50/50 gap-4">
                <div class="space-y-1">
                    <p class="text-slate-900 font-bold">Maybank Savings Account</p>
                    <p class="text-xs text-slate-400 font-medium">Account: **** **** 8940</p>
                </div>
                <form action="/pro/withdraw" method="POST" class="inline">
                    @csrf
                    <button type="submit" @if($stats['payoutBalance'] <= 0) disabled class="bg-slate-400 text-white font-semibold text-xs px-5 py-2.5 rounded-lg cursor-not-allowed" @else class="bg-brand-600 hover:bg-brand-700 text-white font-semibold text-xs px-5 py-2.5 rounded-lg transition-all shadow-md shadow-brand-500/10" @endif>
                        Withdraw Balance Now
                    </button>
                </form>
            </div>
        </div>
    </div>
    </div>
</div>
@endsection
