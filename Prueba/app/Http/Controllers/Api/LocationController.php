<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\State;
use App\Models\City;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    public function countries()
    {
        return response()->json(Country::all());
    }

    public function states($countryId)
    {
        return response()->json(State::where('country_id', $countryId)->get());
    }

    public function cities($stateId)
    {
        return response()->json(City::where('state_id', $stateId)->get());
    }

    public function cityByCode($code)
    {
        $city = City::where('code', $code)->first();
        
        if (!$city) {
            return response()->json(['error' => 'Ciudad no encontrada'], 404);
        }

        return response()->json([
            'city' => $city,
            'state' => $city->state,
            'country' => $city->state->country
        ]);
    }
}