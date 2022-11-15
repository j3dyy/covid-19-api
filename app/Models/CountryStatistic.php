<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CountryStatistic extends Model
{
    use HasFactory;

    protected $fillable = [
      'country_id',
      'confirmed',
      'recovered',
      'deaths'
    ];

    protected $hidden = [
        'updated_at',
        'country_id'
    ];

    public function country(){
        return $this->belongsTo(Country::class);
    }
}
