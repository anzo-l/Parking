<?php

namespace App\Http\Controllers;

use App\Models\ParkingSpace;
use App\Models\Reservation;
use App\Models\ListeAttente;

class AdminController extends Controller
{
    public function index()
    {
        $places = ParkingSpace::all();
        $reservations = Reservation::with(['user', 'parking_space'])->get();
        $waitlist = ListeAttente::with('user')->orderBy('position')->get();

        return view('admin', [
            'places' => $places,
            'reservations' => $reservations,
            'waitlist' => $waitlist,
        ]);
    }
}
