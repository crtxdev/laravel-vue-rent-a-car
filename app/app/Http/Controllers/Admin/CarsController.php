<?php

namespace App\Http\Controllers\Admin;

use \Illuminate\Http\Request;
use \App\Models\Car;

class CarsController extends CrudController
{

  public function datatable(Request $request)
  {

    $queryBuilder = Car::whereNotNull('_id');

    $datatable = datatables($queryBuilder);

    $datatable->addColumn('actions', function($data){
      $actions = [];
      if(auth()->user()->hasPermission('view cars')){
        $actions['view'] = [
          'icon' => 'eye',
          'route' => [
            'name' => 'cars.view',
            'params' => [
              'id' => $data['_id']
            ]
          ]
        ];
      }
      if(auth()->user()->hasPermission('edit cars')){
        $actions['edit'] = [
          'icon' => 'pencil-alt',
          'route' => [
            'name' => 'cars.edit',
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

}
