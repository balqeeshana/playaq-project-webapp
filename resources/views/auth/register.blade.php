@extends('layouts.app')

@section('title', 'Sign Up - PLAYAQ')

@section('content')
<div class="min-h-[80vh] flex flex-col justify-center py-12 sm:px-6 lg:px-8 bg-gradient-to-br from-indigo-50/50 via-white to-purple-50/50"
     x-data="{ role: '{{ old('role', 'customer') }}' }">
    <div class="sm:mx-auto sm:w-full sm:max-w-md">
        <h2 class="mt-6 text-center text-3xl font-extrabold text-slate-900 tracking-tight">
            Create Your PLAYAQ Account
        </h2>
        <p class="mt-2 text-center text-sm text-slate-600">
            Already have an account?
            <a href="/login" class="font-medium text-brand-600 hover:text-brand-500">
                Sign In
            </a>
        </p>
    </div>

    <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
        <div class="bg-white py-8 px-4 shadow-xl shadow-slate-100/50 sm:rounded-xl sm:px-10 border border-slate-100">
            @if ($errors->any())
                <div class="mb-4 bg-red-50 border-l-4 border-red-400 p-4 rounded-md">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <i data-lucide="alert-circle" class="h-5 w-5 text-red-400"></i>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-red-800">
                                There were {{ $errors->count() }} errors with your submission:
                            </h3>
                            <ul class="mt-2 text-sm text-red-700 list-disc pl-5 space-y-1">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif

            <form class="space-y-6" action="/register" method="POST">
                @csrf
                
                <!-- Role Selection -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">I want to register as a:</label>
                    <div class="grid grid-cols-2 gap-4">
                        <label class="flex flex-col items-center justify-center border-2 rounded-xl p-4 cursor-pointer transition-all"
                               :class="role === 'customer' ? 'border-brand-600 bg-brand-50/50 text-brand-700' : 'border-slate-200 hover:border-brand-300 text-slate-600'">
                            <input type="radio" name="role" value="customer" x-model="role" class="sr-only">
                            <i data-lucide="user" class="w-6 h-6 mb-2"></i>
                            <span class="font-semibold text-sm">Customer</span>
                            <span class="text-xs text-slate-500 mt-1 text-center">Looking for help</span>
                        </label>
                        <label class="flex flex-col items-center justify-center border-2 rounded-xl p-4 cursor-pointer transition-all"
                               :class="role === 'professional' ? 'border-brand-600 bg-brand-50/50 text-brand-700' : 'border-slate-200 hover:border-brand-300 text-slate-600'">
                            <input type="radio" name="role" value="professional" x-model="role" class="sr-only">
                            <i data-lucide="wrench" class="w-6 h-6 mb-2"></i>
                            <span class="font-semibold text-sm">Handyman</span>
                            <span class="text-xs text-slate-500 mt-1 text-center">Offering services</span>
                        </label>
                    </div>
                </div>

                <div>
                    <label for="name" class="block text-sm font-medium text-slate-700">Full Name</label>
                    <div class="mt-1 relative rounded-md shadow-sm">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i data-lucide="user" class="h-5 w-5 text-slate-400"></i>
                        </div>
                        <input id="name" name="name" type="text" autocomplete="name" required value="{{ old('name') }}"
                               class="block w-full pl-10 pr-3 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-brand-500 focus:border-brand-500 sm:text-sm"
                               placeholder="John Doe">
                    </div>
                </div>

                <div>
                    <label for="email" class="block text-sm font-medium text-slate-700">Email Address</label>
                    <div class="mt-1 relative rounded-md shadow-sm">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i data-lucide="mail" class="h-5 w-5 text-slate-400"></i>
                        </div>
                        <input id="email" name="email" type="email" autocomplete="email" required value="{{ old('email') }}"
                               class="block w-full pl-10 pr-3 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-brand-500 focus:border-brand-500 sm:text-sm"
                               placeholder="you@example.com">
                    </div>
                </div>

                <!-- Professional Fields -->
                <div x-show="role === 'professional'" x-transition class="space-y-6">
                    <div>
                        <label for="business_name" class="block text-sm font-medium text-slate-700">Business Name</label>
                        <div class="mt-1 relative rounded-md shadow-sm">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i data-lucide="briefcase" class="h-5 w-5 text-slate-400"></i>
                            </div>
                            <input id="business_name" name="business_name" type="text" value="{{ old('business_name') }}"
                                   class="block w-full pl-10 pr-3 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-brand-500 focus:border-brand-500 sm:text-sm"
                                   placeholder="e.g. Mike Thompson Handyman Services">
                        </div>
                    </div>

                    <div>
                        <label for="specialty" class="block text-sm font-medium text-slate-700">Primary Specialty</label>
                        <div class="mt-1">
                            <select id="specialty" name="specialty"
                                    class="block w-full px-3 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-brand-500 focus:border-brand-500 sm:text-sm bg-white">
                                <option value="plumbing" {{ old('specialty') === 'plumbing' ? 'selected' : '' }}>Plumbing Services</option>
                                <option value="painting" {{ old('specialty') === 'painting' ? 'selected' : '' }}>Painting Services</option>
                                <option value="appliance-repair" {{ old('specialty') === 'appliance-repair' ? 'selected' : '' }}>Appliance Repair</option>
                                <option value="appliance-installation" {{ old('specialty') === 'appliance-installation' ? 'selected' : '' }}>Appliance Installation</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-slate-700">Password</label>
                    <div class="mt-1 relative rounded-md shadow-sm">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i data-lucide="lock" class="h-5 w-5 text-slate-400"></i>
                        </div>
                        <input id="password" name="password" type="password" autocomplete="new-password" required
                               class="block w-full pl-10 pr-3 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-brand-500 focus:border-brand-500 sm:text-sm"
                               placeholder="Min 8 characters">
                    </div>
                </div>

                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-slate-700">Confirm Password</label>
                    <div class="mt-1 relative rounded-md shadow-sm">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i data-lucide="lock" class="h-5 w-5 text-slate-400"></i>
                        </div>
                        <input id="password_confirmation" name="password_confirmation" type="password" autocomplete="new-password" required
                               class="block w-full pl-10 pr-3 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-brand-500 focus:border-brand-500 sm:text-sm"
                               placeholder="••••••••">
                    </div>
                </div>

                <div>
                    <button type="submit"
                            class="w-full flex justify-center py-2.5 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-brand-600 hover:bg-brand-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand-500 transition-all animate-fade-in">
                        Sign Up & Start
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
