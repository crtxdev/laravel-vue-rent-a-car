<?php

namespace App\Services;

use \App\Models\Location;
use \App\Models\Appointment;
use \App\Models\PopularBooking;
use \Illuminate\Support\Collection;

class PopularBookingsFinder
{

  protected $period;
  protected $count;
  private $results;

  public function __construct($period = null, $count = null)
  {
    $this->period = $period ?: config('popular-bookings.period', 30);
    $this->count = $count ?: config('popular-bookings.count', 122);
    $this->results = new Collection;
  }

  public function results()
  {
    Location::all()->map(function($location) {
        collect($location->availableCars)->map(function($carId) use ($location) {
          $booked = Appointment::ofLastNDays($this->period)->ofLocation($location->_id)->ofCar($carId)->count();
          if($booked >= $this->count) {
            $popularBooking = new PopularBooking;
            $popularBooking->location_id = $location->_id;
            $popularBooking->car_id = $carId;
            $popularBooking->count = $booked;
            $this->push($popularBooking);
          }
        });
    });
    return $this->results;
  }

  private function push(PopularBooking $booking)
  {
    $this->results->push($booking);
  }

}