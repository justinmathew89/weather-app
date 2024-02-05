<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory;

    protected $table="city_lists";

    public $latitude;
    public $longitude;
    public $city_name;
    public $id;
    public $country;

    protected $fillable = [
        'city_name',
        'latitude',
        'longitude',
        'country'
    ];

}
