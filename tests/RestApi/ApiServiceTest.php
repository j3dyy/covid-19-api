<?php

namespace Tests\RestApi;

use Tests\TestCase;

class ApiServiceTest extends TestCase
{

    function testCountriesEndpointStatus(){
        $response = $this->json('get','api/statistics/countries');

        $response->assertUnauthorized();


        $response = $this->json('get','api/statistics/countries', headers: $this->authHeader() );

        $response->assertSuccessful();

    }

    function testCountryStatistic(){
        $response = $this->json('get','api/statistics/countries');

        $response->assertUnauthorized();

        $response = $this->json('get','api/statistics/country/AF', headers: $this->authHeader());

        $response->assertSuccessful();
    }

    private function authHeader(){
        return [
            'Authorization'=>'Bearer 1|kscAjPgpXvYoBer7WutEpXZ1Lfkc62CmK024KLzR'
        ];
    }
}
