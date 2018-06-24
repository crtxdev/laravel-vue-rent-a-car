<?php

namespace App\Services;

use \App\Models\Location;
use \App\Models\Appointment;
use \App\Models\PopularBooking;

class RefreshPopularBookings
{

  public function __construct()
  {
    $this->boot();
  }

  private function boot()
  {
    PopularBooking::truncate();
    $finder = new \App\Services\PopularBookingsFinder(config('popular-bookings.period'), config('popular-bookings.count'));
    $finder->results()->map(function($booking){
      $booking->save();
    });
  }

}