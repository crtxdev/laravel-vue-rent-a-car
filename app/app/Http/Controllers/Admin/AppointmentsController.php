<?php

namespace App\Http\Controllers\Admin;

use \Illuminate\Http\Request;
use \App\Models\Appointment;
use \Carbon\Carbon;
use Cache;

class AppointmentsController extends CrudController
{

  public function datatable(Request $request)
  {

    $queryBuilder = Appointment::with('car', 'location')->whereNotNull('_id');

    $datatable = datatables($queryBuilder);

    $datatable->filter(function($query) use ($request){
      if($carFilter = $request->input('filters.car')){
        $query->ofCar($carFilter);
      }
      if($locationFilter = $request->input('filters.location')){
        $query->ofLocation($locationFilter);
      }
      if($dateFilter = $request->input('filters.datetime')){
        $query->ofDate(Carbon::parse($dateFilter));
      }
    });

    $datatable->addColumn('car', function($data){
      if(isset($data['car']['model'])){
        return $data['car']['model'];
      }
      return '-';
    });

    $datatable->addColumn('location', function($data){
      if(isset($data['location']['city']) && isset($data['location']['address'])){
        return $data['location']['city'] . ' - ' . $data['location']['address'];
      }
      return '-';
    });

    $datatable->addColumn('actions', function($data){
      $actions = [];
      if(auth()->user()->hasPermission('view appointments')){
        $actions['view'] = [
          'icon' => 'eye',
          'route' => [
            'name' => 'appointments.view',
            'params' => [
              'id' => $data['_id']
            ]
          ]
        ];
      }
      if(auth()->user()->hasPermission('edit appointments')){
        $actions['edit'] = [
          'icon' => 'pencil-alt',
          'route' => [
            'name' => 'appointments.edit',
            'params' => [
              'id' => $data['_id']
            ]
          ]
        ];
      }
      return $actions;
    });

    $datatable->rawColumns(['actions']);

    $response = $datatable->make(true);

    return $response;

  }

  public function get(Request $request, $id)
  {
    return response()->json(Appointment::with('location', 'car')->findOrFail($id));
  }

}
