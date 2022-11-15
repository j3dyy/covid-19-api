<?php

namespace App\Console\Commands;

use App\Http\Client\DevTestApi;
use App\Models\Country;
use App\Models\CountryStatistic;
use Illuminate\Console\Command;

class FetchStatistics extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fetch:statistics';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetching Country statistics from api';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(DevTestApi $devTestApi)
    {
        $countries = Country::with('latestStatistic')->get();
        $responses = $devTestApi->fetchStatistics($countries);
        $bar = $this->output->createProgressBar(count($responses));

        foreach ($responses as $statisticData){
            if (!$statisticData->isEmpty()){
                $country = $countries->where('code','=', $statisticData->get('code') )->first();
                if ($country->latestStatistic == null){
                    $country->latestStatistic = new CountryStatistic(['country_id'=>$country->id]);
                }
                $country->latestStatistic->fill(
                    $statisticData->only('confirmed','recovered','deaths')->toArray()
                )->save();
                $bar->advance();
            }
        }
        $bar->finish();

        return 0;
    }

}
