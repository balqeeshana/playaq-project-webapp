<!DOCTYPE html>
<html lang="en" class="h-full bg-slate-50">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'PLAYAQ - Handyman Booking & Services')</title>
    <!-- Tailwind CSS Play CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brand: {
                            50: '#f5f3ff',
                            100: '#ede9fe',
                            200: '#ddd6fe',
                            500: '#6366f1',
                            600: '#4f46e5',
                            700: '#4338ca',
                            900: '#312e81',
                        }
                    }
                }
            }
        }
    </script>
    <!-- Alpine.js for interactive state -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Outfit', sans-serif;
        }
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="flex flex-col min-h-screen text-slate-800">

    <!-- Global Header -->
    <header class="sticky top-0 bg-white/80 backdrop-blur-md border-b border-slate-100 z-40">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <!-- Logo -->
                <div class="flex items-center space-x-2">
                    <a href="/" class="flex items-center space-x-3">
                        <img src="{{ asset('images/logo.png') }}" alt="PLAYAQ Logo" class="w-10 h-10 object-contain">
                        <span class="text-2xl font-black bg-gradient-to-r from-brand-600 to-indigo-600 bg-clip-text text-transparent tracking-tight">PLAYAQ</span>
                    </a>
                </div>

                <!-- Navigation Links -->
                <nav class="hidden md:flex items-center space-x-8">
                    <a href="/" class="text-slate-600 hover:text-brand-600 font-medium transition-colors">Find Pros</a>
                    <a href="/supplier-partnerships" class="text-slate-600 hover:text-brand-600 font-medium transition-colors">Suppliers</a>
                </nav>

                <!-- Auth Buttons / User Menu -->
                <div class="flex items-center space-x-4">
                    <!-- Book Now Button -->
                    @if(!Auth::check() || !Auth::user()->isProfessional())
                        <a href="/instant-booking" class="bg-brand-600 hover:bg-brand-700 text-white px-4 py-2 rounded-full text-sm font-semibold transition-all shadow-md shadow-brand-500/10 hover:shadow-brand-500/20 flex items-center space-x-1.5 shrink-0">
                            <i data-lucide="plus-circle" class="w-4 h-4 text-brand-200"></i>
                            <span>Book Now</span>
                        </a>
                    @endif

                    @auth
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open" @click.outside="open = false" class="flex items-center space-x-2 bg-slate-100 hover:bg-slate-200 px-4 py-2 rounded-full font-medium transition-all text-slate-700">
                                <i data-lucide="user" class="w-4 h-4 text-slate-600"></i>
                                <span>{{ Auth::user()->name }}</span>
                                <i data-lucide="chevron-down" class="w-4 h-4 transition-transform duration-200" :class="open ? 'rotate-180' : ''"></i>
                            </button>
                            
                            <div x-show="open" x-cloak class="absolute right-0 mt-2 w-56 bg-white border border-slate-100 rounded-xl shadow-xl z-50 py-1"
                                 x-transition:enter="transition ease-out duration-100"
                                 x-transition:enter-start="transform opacity-0 scale-95"
                                 x-transition:enter-end="transform opacity-100 scale-100">
                                @if(Auth::user()->isProfessional())
                                    <a href="/pro/dashboard" class="flex items-center space-x-2 px-4 py-2 text-slate-700 hover:bg-slate-50 transition-colors">
                                        <i data-lucide="layout-dashboard" class="w-4 h-4 text-slate-500"></i>
                                        <span>Pro Dashboard</span>
                                    </a>
                                @else
                                    <a href="/profile" class="flex items-center space-x-2 px-4 py-2 text-slate-700 hover:bg-slate-50 transition-colors">
                                        <i data-lucide="user" class="w-4 h-4 text-slate-500"></i>
                                        <span>My Profile</span>
                                    </a>
                                    <a href="/dashboard" class="flex items-center space-x-2 px-4 py-2 text-slate-700 hover:bg-slate-50 transition-colors">
                                        <i data-lucide="calendar" class="w-4 h-4 text-slate-500"></i>
                                        <span>My Bookings</span>
                                    </a>
                                @endif
                                <hr class="border-slate-100 my-1">
                                <form action="/logout" method="POST" class="w-full">
                                    @csrf
                                    <button type="submit" class="w-full flex items-center space-x-2 px-4 py-2 text-red-600 hover:bg-red-50 transition-colors text-left">
                                        <i data-lucide="log-out" class="w-4 h-4"></i>
                                        <span>Sign Out</span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    @else
                        <a href="/login" class="text-slate-600 hover:text-brand-600 font-semibold transition-colors">Log In</a>
                        <a href="/register" class="bg-brand-600 hover:bg-brand-700 text-white px-5 py-2.5 rounded-full font-semibold transition-all shadow-md shadow-brand-500/20 hover:shadow-brand-500/35">Join PLAYAQ</a>
                    @endauth
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content Area -->
    <main class="flex-grow">
        @yield('content')
    </main>

    <!-- Global Footer -->
    <footer class="bg-slate-900 text-slate-400 py-12 border-t border-slate-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid md:grid-cols-4 gap-8">
                <div>
                    <div class="flex items-center space-x-3 mb-4">
                        <img src="{{ asset('images/logo.png') }}" alt="PLAYAQ Logo" class="w-8 h-8 object-contain">
                        <span class="text-xl font-bold text-white tracking-tight">PLAYAQ</span>
                    </div>
                    <p class="text-sm">"Quality You Can Trust, Service You Deserve"</p>
                </div>
                <div>
                    <h4 class="text-white font-semibold mb-4">Our Services</h4>
                    <ul class="space-y-2 text-sm">
                        <li>Plumbing Services</li>
                        <li>Appliance Repair</li>
                        <li>Appliance Installation</li>
                        <li>Painting Services</li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-white font-semibold mb-4">For Professionals</h4>
                    <ul class="space-y-2 text-sm">
                        <li><a href="/register?role=professional" class="hover:text-white transition-colors">Become a Handyman</a></li>
                        <li>Supplier Partnerships</li>
                        <li>Community Guidelines</li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-white font-semibold mb-4">Contact & Locations</h4>
                    <p class="text-sm mb-2">Available across Klang Valley, Malaysia</p>
                    <p class="text-sm">Email: support@playaq.com</p>
                </div>
            </div>
            <hr class="border-slate-800 my-8">
            <div class="flex justify-between items-center text-sm">
                <p>&copy; 2026 PLAYAQ. All rights reserved.</p>
                <div class="flex space-x-6">
                    <span class="hover:text-white cursor-pointer transition-colors">Terms of Service</span>
                    <span class="hover:text-white cursor-pointer transition-colors">Privacy Policy</span>
                </div>
            </div>
        </div>
    </footer>



    <script>
        // Initialize Lucide icons on page load
        document.addEventListener('DOMContentLoaded', () => {
            lucide.createIcons();
        });
    </script>
</body>
</html>
