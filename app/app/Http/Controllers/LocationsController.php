<?php

namespace App\Http\Controllers;

use \App\Models\Location;
use Cache;

class LocationsController extends Controller
{

  public function fetch()
  {

    $cacheKey = 'locations';

    if(Cache::has($cacheKey)){
      $locations = Cache::get($cacheKey);
    } else {
      $locations = Location::all();
      Cache::forever($cacheKey, $locations);
    }

    return response()->json($locations);

  }

}
