<?php

namespace App\Observers;

use App\Models\Car;
use App\Models\Appointment;
use App\Models\Location;

class CarObserver
{

    public function deleting(Car $car)
    {

      Location::whereRaw([
        'availableCars' => [
          '$in' => [
            $car->_id
          ]
        ]
      ])
      ->get()
      ->map(function($location) use ($car){

        $location->availableCars = collect($location->availableCars)->reject(function($locationCarId) use ($car) {
          if($locationCarId == $car->_id){
            return true;
          }
          return false;
        })
        ->toArray();

        $location->save();

      });

      Appointment::where('car_id', $car->_id)->delete();

    }

}
