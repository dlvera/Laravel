<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Country;
use App\Models\State;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    public function getCountries()
    {
        return response()->json(Country::all());
    }

    public function getStates(Country $country)
    {
        return response()->json($country->states);
    }

    public function getCities(State $state)
    {
        return response()->json($state->cities);
    }
}