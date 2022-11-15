<?php

namespace App\Http\Client;

use GuzzleHttp\Promise\PromiseInterface;
use Illuminate\Http\Client\Pool;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;

class DevTestApi
{
    protected string $endpoint = 'https://devtest.ge/';

    public function getCountries(): mixed {
        $resp = Http::get($this->endpoint.'countries');

        return $resp->json();
    }

    public function getStatistics(string $countrycode): mixed{

        return Http::async()->post($this->endpoint.'get-country-statistics',[
            'code' => $countrycode
        ]);

    }

    public function fetchStatistics(Collection $countries){

        $responses = [];

        $chunks = collect($countries)
            ->chunk(25);

        foreach ($chunks as $chunk){
            $chunkResponse =  Http::pool(function (Pool $pool) use($chunk){
                $this->mapCountriesForPool($chunk,$pool);
            });
            foreach ($chunkResponse as $resp){
                $responses[] = collect($resp->json());
            }
        }

        return $responses;
    }

    private function mapCountriesForPool(Collection $countries, Pool $pool){

        return $countries->map(function ($item) use ($pool) {
            return [
                $pool->post($this->endpoint.'get-country-statistics',['code' => $item->code])
            ];
        });
    }


}
