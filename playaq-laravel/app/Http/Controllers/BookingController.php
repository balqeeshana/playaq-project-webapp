<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\ProfessionalProfile;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    /**
     * Show the booking creation form.
     */
    public function create(Request $request)
    {
        $proId = $request->query('professional_id');
        if (!$proId) {
            return redirect('/')->with('error', 'Please select a professional first.');
        }

        $pro = ProfessionalProfile::with('user', 'services')->findOrFail($proId);

        // Check if user is booking themselves
        if (Auth::check() && Auth::id() === $pro->user_id) {
            return redirect('/')->with('error', 'You cannot book your own services.');
        }

        return view('booking.create', [
            'pro' => $pro,
        ]);
    }

    /**
     * Store the booking in database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'professional_profile_id' => ['required', 'exists:professional_profiles,id'],
            'service_name' => ['required', 'string'],
            'description' => ['required', 'string'],
            'booking_date' => ['required', 'date', 'after:today'],
            'booking_time' => ['required', 'string', 'in:morning,afternoon,evening'],
        ]);

        $pro = ProfessionalProfile::findOrFail($request->professional_profile_id);

        // Try to find matching service price range, or use default ranges based on specialty
        $service = Service::where('professional_profile_id', $pro->id)
            ->where('name', $request->service_name)
            ->first();

        if ($service) {
            $priceMin = $service->price_min;
            $priceMax = $service->price_max;
        } else {
            // Default pricing ranges
            switch ($pro->specialty) {
                case 'plumbing':
                    $priceMin = 75;
                    $priceMax = 120;
                    break;
                case 'painting':
                    $priceMin = 200;
                    $priceMax = 500;
                    break;
                case 'appliance-repair':
                    $priceMin = 65;
                    $priceMax = 150;
                    break;
                case 'appliance-installation':
                    $priceMin = 70;
                    $priceMax = 130;
                    break;
                default:
                    $priceMin = 50;
                    $priceMax = 100;
            }
        }

        // Calculate 30% deposit
        $avgPrice = ($priceMin + $priceMax) / 2;
        $depositAmount = round($avgPrice * 0.3);

        $photoPaths = [];
        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $file) {
                $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('images'), $filename);
                $photoPaths[] = $filename;
            }
        }

        $booking = Booking::create([
            'customer_id' => Auth::id(),
            'professional_profile_id' => $pro->id,
            'service_name' => $request->service_name,
            'description' => $request->description,
            'booking_date' => $request->booking_date,
            'booking_time' => $request->booking_time,
            'deposit_amount' => $depositAmount,
            'total_estimated_cost' => "RM {$priceMin} - RM {$priceMax}",
            'status' => 'pending',
            'photo_paths' => $photoPaths
        ]);

        return redirect()->route('customer.dashboard')
            ->with('success', "Booking created successfully! Deposit of RM {$depositAmount} paid via simulated secure payment gateway.");
    }

    /**
     * Show final balance payment form.
     */
    public function showPayBalanceForm($id)
    {
        $booking = Booking::with('professionalProfile.user')->findOrFail($id);

        if ($booking->customer_id !== Auth::id()) {
            abort(403);
        }

        // Parse estimated pricing to compute remaining balance
        preg_match_all('/\d+/', $booking->total_estimated_cost, $matches);
        $total = 0;
        if (!empty($matches[0])) {
            $total = array_sum($matches[0]) / count($matches[0]);
        } else {
            $total = $booking->deposit_amount / 0.3;
        }
        $remainingBalance = max(0, $total - $booking->deposit_amount);

        return view('booking.pay_balance', [
            'booking' => $booking,
            'totalCost' => $total,
            'remainingBalance' => $remainingBalance
        ]);
    }

    /**
     * Process final balance payment.
     */
    public function payBalance(Request $request, $id)
    {
        $booking = Booking::findOrFail($id);

        if ($booking->customer_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'payment_method' => ['required', 'string'],
        ]);

        $booking->update([
            'status' => 'completed'
        ]);

        // Update professional earnings and completed jobs counts
        $pro = ProfessionalProfile::findOrFail($booking->professional_profile_id);
        preg_match_all('/\d+/', $booking->total_estimated_cost, $matches);
        $total = 0;
        if (!empty($matches[0])) {
            $total = array_sum($matches[0]) / count($matches[0]);
        } else {
            $total = $booking->deposit_amount / 0.3;
        }

        $pro->update([
            'total_earnings' => $pro->total_earnings + $total,
            'payout_balance' => $pro->payout_balance + ($total * 0.7),
            'completed_jobs' => $pro->completed_jobs + 1
        ]);

        return redirect()->route('customer.dashboard')
            ->with('success', 'Final payment processed successfully! Thank you for using PLAYAQ. Please take a moment to leave a review below.');
    }

    /**
     * Accept a booking (Professional action).
     */
    public function acceptBooking($id)
    {
        $booking = Booking::findOrFail($id);
        $pro = Auth::user()->professionalProfile;

        if (!$pro || $booking->professional_profile_id !== $pro->id) {
            abort(403);
        }

        $booking->update([
            'status' => 'confirmed'
        ]);

        return back()->with('success', 'Booking successfully accepted & scheduled.');
    }

    /**
     * Show customer dashboard.
     */
    public function customerDashboard()
    {
        $bookings = Booking::with('professionalProfile.user')
            ->where('customer_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('customer.dashboard', [
            'bookings' => $bookings,
        ]);
    }

    /**
     * Submit rating and review comment.
     */
    public function rateBooking(Request $request, $id)
    {
        $booking = Booking::findOrFail($id);

        if ($booking->customer_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'rating' => ['required', 'integer', 'min:1', 'max:5'],
            'review_comment' => ['required', 'string'],
        ]);

        $booking->update([
            'rating' => $request->rating,
            'review_comment' => $request->review_comment,
        ]);

        // Recalculate average rating and increment completed jobs for the professional
        $pro = ProfessionalProfile::findOrFail($booking->professional_profile_id);
        
        $allRatings = Booking::where('professional_profile_id', $pro->id)
            ->whereNotNull('rating')
            ->pluck('rating');

        $avgRating = $allRatings->avg() ?: 5.0;
        $completedJobs = Booking::where('professional_profile_id', $pro->id)
            ->where('status', 'completed')
            ->count();

        $pro->update([
            'rating' => $avgRating,
            'completed_jobs' => $completedJobs,
        ]);

        return back()->with('success', 'Thank you for your rating and review! It has been posted to the professional profile.');
    }

    /**
     * Show instant booking form.
     */
    public function showInstantBookingForm()
    {
        $professionals = ProfessionalProfile::with('services', 'user')->get();
        return view('booking.instant', [
            'professionals' => $professionals,
        ]);
    }
}
