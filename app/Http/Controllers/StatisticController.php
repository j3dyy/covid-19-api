<?php

namespace App\Http\Controllers;

use App\Models\Country;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class StatisticController extends Controller
{

    public function displayList(): JsonResponse
    {
        $countries = Country::with('latestStatistic')->get();

        return response()->json([
            'data'  =>  $countries
        ]);
    }

    public function country(string $country_code){
        $country = Country::with('statistics')->where('code','=', $country_code)->first();

        $summaryData = [
            'deaths'=>$country->statistics()->sum('deaths'),
            'recovered'=>$country->statistics()->sum('recovered'),
            'confirmed'=>$country->statistics()->sum('confirmed')
        ];

        return response()->json([
            'data'  =>  $country,
            'summaryData' => $summaryData
        ]);
    }
}
