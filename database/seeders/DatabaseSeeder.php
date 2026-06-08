<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\ProfessionalProfile;
use App\Models\Service;
use App\Models\Booking;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Create a Default Customer
        $customer = User::create([
            'name' => 'John Doe',
            'email' => 'customer@playaq.com',
            'password' => Hash::make('password'),
            'role' => 'customer',
        ]);

        // 2. Create Professionals Data
        $professionals = [
            [
                'name' => 'Kim Saiful',
                'email' => 'saiful@playaq.com',
                'business_name' => 'Kim Saiful Plumbing Services',
                'specialty' => 'plumbing',
                'bio' => 'Professional plumber with 10+ years of experience in leak repairs, pipe replacements, drain unclogging, and kitchen/bathroom fixture installation in the Klang Valley.',
                'experience' => 10,
                'location' => 'Kuala Lumpur',
                'phone' => '+60 12-345 6789',
                'rating' => 4.9,
                'jobs' => 234,
                'image_path' => 'saiful.jpg',
                'total_earnings' => 450,
                'payout_balance' => 315,
                'services' => [
                    ['name' => 'Leak Repairs & Faucet Installation', 'desc' => 'Professional leak detection and repair, faucet and fixture installation', 'min' => 75, 'max' => 120],
                    ['name' => 'Drain Cleaning & Pipe Repairs', 'desc' => 'Unclog drains, clean sewer lines, repair and replace damaged pipes', 'min' => 65, 'max' => 110],
                    ['name' => 'Toilet Repair & Installation', 'desc' => 'Repair flushing issues or install new toilets', 'min' => 80, 'max' => 150]
                ]
            ],
            [
                'name' => 'Nikuku Minaj',
                'email' => 'nikuku@playaq.com',
                'business_name' => 'Nikuku Minaj Custom Painting',
                'specialty' => 'painting',
                'bio' => 'Certified painters specializing in interior/exterior residential painting, cabinet painting, wall repair, and texture finishes. Based in Petaling Jaya.',
                'experience' => 8,
                'location' => 'Petaling Jaya',
                'phone' => '+60 17-654 3210',
                'rating' => 5.0,
                'jobs' => 189,
                'image_path' => 'nikuku.jpg',
                'total_earnings' => 450,
                'payout_balance' => 315,
                'services' => [
                    ['name' => 'Interior Painting', 'desc' => 'Room wall and ceiling painting with premium paints included', 'min' => 200, 'max' => 500],
                    ['name' => 'Exterior Painting', 'desc' => 'Detailed exterior wall painting with weather-resistant coat', 'min' => 400, 'max' => 900],
                    ['name' => 'Cabinet & Trim Painting', 'desc' => 'Precision cabinet and trim coloring for a sleek modern finish', 'min' => 150, 'max' => 300]
                ]
            ],
            [
                'name' => 'David Beckham',
                'email' => 'david@playaq.com',
                'business_name' => 'David Beckham Appliance Repairs',
                'specialty' => 'appliance-repair',
                'bio' => 'Fast, certified technician for home appliance repairs in Shah Alam. Specializing in washing machines, dry cleaners, refrigerators, dishwashers, and ovens.',
                'experience' => 12,
                'location' => 'Shah Alam',
                'phone' => '+60 11-234 5678',
                'rating' => 4.8,
                'jobs' => 312,
                'image_path' => 'beckham.jpg',
                'total_earnings' => 450,
                'payout_balance' => 315,
                'services' => [
                    ['name' => 'Refrigerator Repair', 'desc' => 'Fix cooling issues, replace compressors, and repair internal electricals', 'min' => 85, 'max' => 200],
                    ['name' => 'Washing Machine Repair', 'desc' => 'Fix drainage, motor spinning errors, and drum replacement', 'min' => 65, 'max' => 150],
                    ['name' => 'Dishwasher Repair', 'desc' => 'Repair leakage, spray arm, and control boards', 'min' => 70, 'max' => 130]
                ]
            ],
            [
                'name' => 'Jennifer Tan',
                'email' => 'jennifer@playaq.com',
                'business_name' => 'Jennifer Tan Appliance Installations',
                'specialty' => 'appliance-installation',
                'bio' => 'Experienced appliance installer in Subang Jaya. We unpack, connect, align, and test all major kitchen and laundry appliances with manufacturer warranty support.',
                'experience' => 6,
                'location' => 'Subang Jaya',
                'phone' => '+60 19-876 5432',
                'rating' => 4.9,
                'jobs' => 167,
                'image_path' => 'tan.jpg',
                'total_earnings' => 450,
                'payout_balance' => 315,
                'services' => [
                    ['name' => 'Dishwasher Installation', 'desc' => 'Complete plumbing connection and cabinet alignment', 'min' => 70, 'max' => 130],
                    ['name' => 'Washing Machine & Dryer setup', 'desc' => 'Align water inlet, outlet hoses, and drum balancing', 'min' => 60, 'max' => 110],
                    ['name' => 'Oven & Stove installation', 'desc' => 'Secure electrical wiring connections and safety check', 'min' => 80, 'max' => 150]
                ]
            ]
        ];

        foreach ($professionals as $data) {
            // Create User
            $proUser = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make('password'),
                'role' => 'professional',
            ]);

            // Create Profile
            $profile = ProfessionalProfile::create([
                'user_id' => $proUser->id,
                'business_name' => $data['business_name'],
                'specialty' => $data['specialty'],
                'bio' => $data['bio'],
                'experience_years' => $data['experience'],
                'location' => $data['location'],
                'phone' => $data['phone'],
                'rating' => $data['rating'],
                'completed_jobs' => $data['jobs'],
                'image_path' => $data['image_path'],
                'total_earnings' => $data['total_earnings'],
                'payout_balance' => $data['payout_balance'],
            ]);

            // Create Services
            foreach ($data['services'] as $serv) {
                Service::create([
                    'professional_profile_id' => $profile->id,
                    'name' => $serv['name'],
                    'description' => $serv['desc'],
                    'price_min' => $serv['min'],
                    'price_max' => $serv['max'],
                ]);
            }

            // Create a mock active/confirmed booking for Nikuku Minaj
            if ($data['name'] === 'Nikuku Minaj') {
                Booking::create([
                    'customer_id' => $customer->id,
                    'professional_profile_id' => $profile->id,
                    'service_name' => 'Interior Painting',
                    'description' => 'Need to repaint our kitchen walls in white colour.',
                    'booking_date' => date('Y-m-d', strtotime('+3 days')),
                    'booking_time' => 'morning',
                    'deposit_amount' => 105, // 30% of average (200+500)/2 = 350 -> 105
                    'total_estimated_cost' => 'RM 200 - RM 500',
                    'status' => 'confirmed'
                ]);
            }

            // Create a mock completed booking for David Beckham
            if ($data['name'] === 'David Beckham') {
                Booking::create([
                    'customer_id' => $customer->id,
                    'professional_profile_id' => $profile->id,
                    'service_name' => 'Dishwasher Repair',
                    'description' => 'Water is not draining from the washer.',
                    'booking_date' => date('Y-m-d', strtotime('-5 days')),
                    'booking_time' => 'afternoon',
                    'deposit_amount' => 30, // 30% of average (70+130)/2 = 100 -> 30
                    'total_estimated_cost' => 'RM 70 - RM 130',
                    'status' => 'completed'
                ]);
            }
        }
    }
}
