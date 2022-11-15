<?php

namespace App\Console\Commands;

use App\Http\Client\DevTestApi;
use App\Models\Country;
use Illuminate\Console\Command;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class FetchCountries extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fetch:countries';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetching countries from api';

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
        try{
            $jsonResponse = $devTestApi->getCountries();

            $bar = $this->output->createProgressBar(count($jsonResponse));

            foreach ($jsonResponse as $country){
                if (isset($country['name']) && isset($country['code'])){
                    $this->createCountryRecord($country);
                }

                $bar->advance();
            }
            $bar->finish();

        }catch (QueryException $exception){
            $this->line("Error occurred");
            $this->newLine();
            $this->error($exception->getMessage());
        }

        return 0;
    }

    private function createCountryRecord(array $data){
        $cRecord = new Country();
        $cRecord->code = $data['code'];
        $cRecord->name = json_encode($data['name']);
        $cRecord->save();
    }

}
