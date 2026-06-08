@extends('layouts.app')

@section('title', 'Supplier Partnerships - PLAYAQ')

@section('content')
<section class="py-20 bg-gradient-to-br from-brand-50 to-indigo-50/30">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Badge & Title -->
        <div class="text-center mb-12">
            <div class="inline-flex items-center px-4 py-1.5 bg-brand-100 text-brand-700 rounded-full mb-4 text-sm font-semibold shadow-sm shadow-brand-500/5">
                <i data-lucide="package" class="w-4 h-4 mr-2"></i>
                <span>Exclusive Partner Network</span>
            </div>
            <h2 class="text-slate-900 text-4xl font-extrabold tracking-tight mb-4">
                Supplier Partnerships
            </h2>
            <p class="text-slate-500 text-lg max-w-2xl mx-auto leading-relaxed">
                PLAYAQ handymen get exclusive access to discounted materials and priority supply lines from our trusted partner merchants in Malaysia, guaranteeing consistent quality for every project.
            </p>
        </div>

        <!-- Benefits Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-16">
            <div class="bg-white p-6 rounded-xl border border-slate-100 shadow-sm hover:shadow-md transition-shadow">
                <div class="w-12 h-12 bg-brand-100 rounded-lg flex items-center justify-center mb-4 text-brand-600">
                    <i data-lucide="percent" class="w-6 h-6"></i>
                </div>
                <h3 class="text-slate-900 font-bold mb-2">Better Pricing</h3>
                <p class="text-slate-500 text-sm leading-relaxed">Access negotiated wholesale prices on high-quality components, building parts, and tools.</p>
            </div>
            <div class="bg-white p-6 rounded-xl border border-slate-100 shadow-sm hover:shadow-md transition-shadow">
                <div class="w-12 h-12 bg-brand-100 rounded-lg flex items-center justify-center mb-4 text-brand-600">
                    <i data-lucide="check-square" class="w-6 h-6"></i>
                </div>
                <h3 class="text-slate-900 font-bold mb-2">Quality Guaranteed</h3>
                <p class="text-slate-500 text-sm leading-relaxed">All products and supplies come with merchant-backed warranties and certifications.</p>
            </div>
            <div class="bg-white p-6 rounded-xl border border-slate-100 shadow-sm hover:shadow-md transition-shadow">
                <div class="w-12 h-12 bg-brand-100 rounded-lg flex items-center justify-center mb-4 text-brand-600">
                    <i data-lucide="truck" class="w-6 h-6"></i>
                </div>
                <h3 class="text-slate-900 font-bold mb-2">Fast Delivery</h3>
                <p class="text-slate-500 text-sm leading-relaxed">Enjoy priority same-day shipping and dedicated express pickup lanes at supplier depots.</p>
            </div>
            <div class="bg-white p-6 rounded-xl border border-slate-100 shadow-sm hover:shadow-md transition-shadow">
                <div class="w-12 h-12 bg-brand-100 rounded-lg flex items-center justify-center mb-4 text-brand-600">
                    <i data-lucide="layers" class="w-6 h-6"></i>
                </div>
                <h3 class="text-slate-900 font-bold mb-2">Wide Selection</h3>
                <p class="text-slate-500 text-sm leading-relaxed">Search through extensive hardware catalogs of tools, appliances, and industrial parts.</p>
            </div>
        </div>

        <!-- Partner Suppliers Grid -->
        <div class="bg-white rounded-2xl shadow-xl shadow-slate-100/50 p-8 border border-slate-100">
            <h3 class="text-slate-900 text-2xl font-bold mb-8 text-center">Our Malaysia Partner Network</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <div class="border border-slate-150 rounded-xl p-5 hover:border-brand-200 hover:bg-brand-50/20 transition-all">
                    <h4 class="text-slate-950 font-bold text-lg mb-1">FL Home Centre Sdn Bhd</h4>
                    <p class="text-slate-500 text-sm">Building Materials & Tools</p>
                </div>
                <div class="border border-slate-150 rounded-xl p-5 hover:border-brand-200 hover:bg-brand-50/20 transition-all">
                    <h4 class="text-slate-950 font-bold text-lg mb-1">APE INDUSTRIAL SUPPLIES</h4>
                    <p class="text-slate-500 text-sm">Plumbing Supplies & Fittings</p>
                </div>
                <div class="border border-slate-150 rounded-xl p-5 hover:border-brand-200 hover:bg-brand-50/20 transition-all">
                    <h4 class="text-slate-950 font-bold text-lg mb-1">K.E INDUSTRIAL SUPPLY</h4>
                    <p class="text-slate-500 text-sm">Paints, Coatings & Brushes</p>
                </div>
                <div class="border border-slate-150 rounded-xl p-5 hover:border-brand-200 hover:bg-brand-50/20 transition-all">
                    <h4 class="text-slate-950 font-bold text-lg mb-1">Lepcon Tools (M) Sdn Bhd</h4>
                    <p class="text-slate-500 text-sm">Power Tools & Safety Gear</p>
                </div>
                <div class="border border-slate-150 rounded-xl p-5 hover:border-brand-200 hover:bg-brand-50/20 transition-all">
                    <h4 class="text-slate-950 font-bold text-lg mb-1">Industrial Hardware Supply</h4>
                    <p class="text-slate-500 text-sm">Appliance Components & Parts</p>
                </div>
                <div class="border border-slate-150 rounded-xl p-5 hover:border-brand-200 hover:bg-brand-50/20 transition-all">
                    <h4 class="text-slate-950 font-bold text-lg mb-1">Man Kian Hardware & Trading</h4>
                    <p class="text-slate-500 text-sm">General Fasteners & Hardware</p>
                </div>
            </div>

            <!-- Call to Action -->
            <div class="mt-12 text-center border-t border-slate-100 pt-8">
                <p class="text-slate-500 text-sm mb-4">
                    * Available exclusively to verified and active PLAYAQ professional handymen.
                </p>
                @auth
                    @if(Auth::user()->isProfessional())
                        <div class="inline-flex items-center space-x-2 bg-emerald-50 text-emerald-800 px-5 py-2.5 rounded-lg border border-emerald-250 text-sm font-semibold">
                            <i data-lucide="check-circle" class="w-5 h-5 text-emerald-600"></i>
                            <span>You are eligible for partner discounts! Access catalogs via dashboard.</span>
                        </div>
                    @else
                        <span class="text-slate-400 text-sm font-medium">Log in as a Professional account to apply.</span>
                    @endif
                @else
                    <a href="/register?role=professional" class="inline-flex items-center space-x-1.5 bg-brand-600 hover:bg-brand-700 text-white font-semibold py-3 px-8 rounded-xl transition-all shadow-md shadow-brand-500/25">
                        <i data-lucide="user-plus" class="w-4 h-4 text-brand-200"></i>
                        <span>Register as Pro</span>
                    </a>
                @endauth
            </div>
        </div>
    </div>
</section>
@endsection
