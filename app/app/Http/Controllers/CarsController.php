<?php

namespace App\Http\Controllers;

use \App\Models\Car;
use Cache;

class CarsController extends Controller
{

  public function fetch()
  {

    $cacheKey = 'cars';

    if(Cache::has($cacheKey)){
      $cars = Cache::get($cacheKey);
    } else {
      $cars = Car::all();
      Cache::forever($cacheKey, $cars);
    }

    return response()->json($cars);

  }

}
