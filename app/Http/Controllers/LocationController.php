<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Location;


class LocationController extends Controller
{
    public function show()
    {
    return view('User.location');
    }
}

