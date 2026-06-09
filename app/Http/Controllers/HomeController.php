<?php

namespace App\Http\Controllers;

use App\Models\ProfessionalProfile;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Klang Valley locations.
     */
    protected $locations = [
        'Shah Alam',
        'Kuala Lumpur',
        'Petaling Jaya',
        'Klang',
        'Setia Alam',
        'Subang Jaya',
        'Puchong',
        'Cheras',
        'Ampang',
        'Cyberjaya',
        'Putrajaya',
        'Kajang',
        'Bangi',
        'Seri Kembangan',
        'Banting'
    ];

    /**
     * Display landing page and search professionals.
     */
    public function index(Request $request)
    {
        $service = $request->query('service');
        $location = $request->query('location');

        $query = ProfessionalProfile::with('user', 'services');

        if ($service) {
            $query->where('specialty', $service);
        }

        if ($location) {
            $query->where('location', $location);
        }

        $professionals = $query->get();

        return view('home', [
            'professionals' => $professionals,
            'locations' => $this->locations,
            'selectedService' => $service,
            'selectedLocation' => $location,
        ]);
    }
}
