<?php

namespace App\Http\Controllers;

use App\Models\Apartment;

class ApartmentController extends Controller
{
    public function show($id)
    {
        $apartment = Apartment::findOrFail($id);

        return view('landing.apartment-details', compact('apartment'));
    }
}
