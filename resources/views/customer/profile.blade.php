@extends('layouts.app')

@section('title', 'My Profile - PLAYAQ')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <!-- Header -->
    <div class="bg-gradient-to-r from-brand-600 to-indigo-600 rounded-2xl p-8 text-white shadow-xl mb-8 flex justify-between items-center">
        <div>
            <h1 class="text-white text-3xl font-extrabold tracking-tight">Manage My Profile</h1>
            <p class="text-indigo-100 mt-1">Keep your contact details up to date for smooth handyman dispatch</p>
        </div>
        <div class="w-12 h-12 bg-white/20 rounded-full flex items-center justify-center text-white">
            <i data-lucide="user" class="w-6 h-6"></i>
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

    <div class="bg-white rounded-2xl border border-slate-100 shadow-xl overflow-hidden p-8">
        <form action="/profile/update" method="POST" class="space-y-6">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Name -->
                <div>
                    <label for="name" class="block text-sm font-semibold text-slate-700">Full Name</label>
                    <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" required
                           class="mt-2 block w-full px-4 py-3 border border-slate-200 focus:border-brand-500 rounded-xl outline-none transition-colors sm:text-sm">
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-semibold text-slate-700">Email Address</label>
                    <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" required
                           class="mt-2 block w-full px-4 py-3 border border-slate-200 focus:border-brand-500 rounded-xl outline-none transition-colors sm:text-sm">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Phone Number -->
                <div>
                    <label for="phone" class="block text-sm font-semibold text-slate-700">Phone Number</label>
                    <input type="text" id="phone" name="phone" value="{{ old('phone', $user->phone) }}" placeholder="+60 12-345 6789"
                           class="mt-2 block w-full px-4 py-3 border border-slate-200 focus:border-brand-500 rounded-xl outline-none transition-colors sm:text-sm">
                </div>

                <!-- Address -->
                <div>
                    <label for="address" class="block text-sm font-semibold text-slate-700">Address / Location</label>
                    <input type="text" id="address" name="address" value="{{ old('address', $user->address) }}" placeholder="e.g. Unit 12-3, Block A, Petaling Jaya"
                           class="mt-2 block w-full px-4 py-3 border border-slate-200 focus:border-brand-500 rounded-xl outline-none transition-colors sm:text-sm">
                </div>
            </div>

            <!-- Buttons -->
            <div class="pt-6 border-t border-slate-100 flex justify-between items-center">
                <a href="/dashboard" class="text-slate-600 hover:text-slate-800 font-semibold text-sm">
                    Back to Bookings
                </a>
                <button type="submit" class="bg-brand-600 hover:bg-brand-700 text-white font-semibold py-3 px-8 rounded-xl transition-colors shadow-md shadow-brand-500/15">
                    Save Profile Settings
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
