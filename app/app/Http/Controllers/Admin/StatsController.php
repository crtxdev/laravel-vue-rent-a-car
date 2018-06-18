<?php

namespace App\Http\Controllers\Admin;

use \App\Http\Controllers\Controller;
use \Illuminate\Http\Request;
use \App\Models\Location;
use \App\Models\Car;
use \App\Models\Appointment;
use \Carbon\Carbon;

class StatsController extends Controller
{

  public function get(Request $request)
  {

    $methods = [ 'totalCars', 'totalLocations', 'totalAppointments', 'lastWeekAppointments' ];
    $data = [];

    foreach($methods as $method){
      $classMethod = 'query' . studly_case($method);
      $data[$method] = $this->$classMethod();
    }

    return response()->json($data);

  }

  private function queryTotalCars()
  {
    return Car::count();
  }

  private function queryTotalLocations()
  {
    return Location::count();
  }

  private function queryTotalAppointments()
  {
    return Appointment::count();
  }

  private function queryLastWeekAppointments()
  {
    $data = [];
    for($i=0; $i<=7; $i++){
      $date = Carbon::now()->subDays($i);
      if($date->isWeekend()){
        continue;
      }
      $dateStr = $date->format('Y-m-d');
      $data[$dateStr] = [
        Appointment::STATUS_RESERVED   => 0,
        Appointment::STATUS_COMPLETED  => 0,
        Appointment::STATUS_CANCELLED  => 0,
      ];
    }
    Appointment::ofLastWeek()->get()->map(function($appointment) use (&$data) {
      $date = $appointment->datetime->format('Y-m-d');
      $data[$date][$appointment->status]++;
    });
    $data = array_reverse($data);
    return $data;
  }

}