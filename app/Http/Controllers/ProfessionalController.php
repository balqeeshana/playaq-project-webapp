<?php

namespace App\Http\Controllers;

use App\Models\ProfessionalProfile;
use App\Models\Service;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfessionalController extends Controller
{
    /**
     * Show professional dashboard.
     */
    public function index()
    {
        $user = Auth::user();
        $pro = ProfessionalProfile::with('services', 'bookings.customer')->where('user_id', $user->id)->first();

        if (!$pro) {
            // If they are not a professional, redirect to homepage
            return redirect('/')->with('error', 'Only professionals can access the pro dashboard.');
        }

        // Aggregate statistics using database fields
        $totalEarnings = $pro->total_earnings;
        $payoutBalance = $pro->payout_balance;
        $monthlyEarnings = round($totalEarnings * 0.2); // mock this month's ratio
        $completedJobsCount = $pro->completed_jobs;
        $pendingBookingsCount = $pro->bookings()->where('status', 'pending')->count();

        return view('professional.dashboard', [
            'pro' => $pro,
            'services' => $pro->services,
            'bookings' => $pro->bookings()->orderBy('created_at', 'desc')->get(),
            'stats' => [
                'totalEarnings' => $totalEarnings,
                'payoutBalance' => $payoutBalance,
                'monthlyEarnings' => $monthlyEarnings,
                'completedJobs' => $completedJobsCount,
                'avgRating' => $pro->rating,
                'pendingBookings' => $pendingBookingsCount,
            ]
        ]);
    }

    /**
     * Update professional profile bio and info.
     */
    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        $pro = ProfessionalProfile::where('user_id', $user->id)->firstOrFail();

        $request->validate([
            'business_name' => ['required', 'string', 'max:255'],
            'bio' => ['required', 'string'],
            'experience_years' => ['required', 'integer', 'min:0'],
            'location' => ['required', 'string'],
            'phone' => ['required', 'string'],
        ]);

        $pro->update($request->only('business_name', 'bio', 'experience_years', 'location', 'phone'));

        return back()->with('success', 'Profile updated successfully!');
    }

    /**
     * Add a service offering.
     */
    public function addService(Request $request)
    {
        $user = Auth::user();
        $pro = ProfessionalProfile::where('user_id', $user->id)->firstOrFail();

        $request->validate([
            'name' => ['required', 'string'],
            'description' => ['nullable', 'string'],
            'price_min' => ['required', 'numeric', 'min:0'],
            'price_max' => ['required', 'numeric', 'gte:price_min'],
        ]);

        Service::create([
            'professional_profile_id' => $pro->id,
            'name' => $request->name,
            'description' => $request->description,
            'price_min' => $request->price_min,
            'price_max' => $request->price_max,
        ]);

        return back()->with('success', 'Service added successfully!');
    }

    /**
     * Remove a service offering.
     */
    public function deleteService($id)
    {
        $user = Auth::user();
        $pro = ProfessionalProfile::where('user_id', $user->id)->firstOrFail();
        
        $service = Service::where('professional_profile_id', $pro->id)->findOrFail($id);
        $service->delete();

        return back()->with('success', 'Service removed successfully!');
    }

    /**
     * Withdraw payout balance to zero instantly.
     */
    public function withdraw()
    {
        $user = Auth::user();
        $pro = ProfessionalProfile::where('user_id', $user->id)->firstOrFail();
        $amount = $pro->payout_balance;

        if ($amount <= 0) {
            return back()->with('error', 'You have no payout balance to withdraw.');
        }

        $pro->update([
            'payout_balance' => 0
        ]);

        return back()->with('success', 'Payout request received! RM ' . number_format($amount, 2) . ' will be credited to your bank account instantly.');
    }

    /**
     * Upload a new certificate (simulated functional upload).
     */
    public function uploadCertificate(Request $request)
    {
        $request->validate([
            'certificate' => ['required', 'file', 'mimes:pdf,png,jpg,jpeg', 'max:10240'],
        ]);

        $fileName = $request->file('certificate')->getClientOriginalName();
        
        $certs = session('certificates', []);
        $certs[] = [
            'name' => $fileName,
            'verified' => false,
            'date' => now()->format('Y-m-d')
        ];
        session(['certificates' => $certs]);

        return back()->with('success', 'Certificate "' . $fileName . '" uploaded successfully! Our team will verify it within 24 hours.');
    }
}
