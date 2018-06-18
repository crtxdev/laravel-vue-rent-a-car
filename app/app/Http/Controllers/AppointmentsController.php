<?php

namespace App\Http\Controllers;

use \Illuminate\Http\Request;
use \App\Models\Appointment;
use \Carbon\Carbon;
use Cache;

class AppointmentsController extends Controller
{

  public function fetch(Request $request, $locationId, $carId, $date)
  {

    $date = Carbon::parse($date);

    $cacheKey = 'appointments_' . $locationId . '_' . $carId . '_' . $date->format('Y-m-d');

    if(Cache::has($cacheKey)){
      $appointments = Cache::get($cacheKey);
    } else {
      $appointments = Appointment::ofCar($carId)
                                  ->ofLocation($locationId)
                                  ->ofDate($date)
                                  ->select('_id', 'location_id', 'car_id', 'datetime')
                                  ->get()
                                  ->toArray();
      Cache::forever($cacheKey, $appointments);
    }

    return response()->json($appointments);

  }

  public function create(Request $request, $locationId, $carId, $datetime)
  {

    $data = $request->validate([
      'firstName' => 'required|max:100',
      'lastName' => 'required|max:100',
      'email' => 'required|email|max:100',
      'licenseNumber' => 'required|max:100',
      'address' => 'required|max:100',
      'zip' => 'required|max:6',
      'city' => 'required|max:100',
      'state' => 'max:100',
      'country' => 'required|max:100'
    ]);

    $datetime = Carbon::parse($datetime);
    $data['datetime'] = $datetime;

    $appointment = new Appointment;
    foreach($data as $key => $val){
      $appointment->$key = $val;
    }
    $appointment->location_id = $locationId;
    $appointment->car_id = $carId;
    $appointment->status = 'reserved';
    $appointment->save();

    Cache::forget('appointments_' . $locationId . '_' . $carId . '_' . $datetime->format('Y-m-d'));

    return response()->json([
      'success' => true,
      'id' => $appointment->id
    ]);

  }

}
