<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\CountryStatistic;
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

    /**
     * @param string $country_code
     * @return JsonResponse
     */
    public function country(string $country_code){
        $country = Country::where('code','=', $country_code)->first();

        $statistics = CountryStatistic::where('country_id','=',$country->id)
            ->orderBy('created_at','DESC')
            ->orderBy('recovered','DESC')
            ->paginate(10);

        $summaryData = [
            'deaths'=>$country->statistics()->sum('deaths'),
            'recovered'=>$country->statistics()->sum('recovered'),
            'confirmed'=>$country->statistics()->sum('confirmed')
        ];

        return response()->json([
            'country'       =>  $country,
            'data'          =>  $statistics,
            'summaryData'   => $summaryData
        ]);
    }
}
