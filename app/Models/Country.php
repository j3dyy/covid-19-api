<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    use HasFactory;

    protected $fillable = [
      'code','name'
    ];

    public $timestamps = false;

    public function statistics()
    {
        return $this->hasMany(CountryStatistic::class,'country_id')
            ->orderBy('created_at','DESC');
    }

    public function latestStatistic()
    {
        return $this->hasOne(CountryStatistic::class)
//            ->where('created_at','>=', Carbon::now()->subHour(1));
            ->where('created_at','>=', Carbon::now()->subMinutes(58));
    }
}
