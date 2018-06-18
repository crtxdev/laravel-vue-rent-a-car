<?php

namespace App\Http\Controllers\Admin;

use \Illuminate\Http\Request;
use \App\Models\Location;

class LocationsController extends CrudController
{

  public function datatable(Request $request)
  {

    $queryBuilder = Location::whereNotNull('_id');

    $datatable = datatables($queryBuilder);

    $datatable->addColumn('actions', function($data){
      $actions = [];
      if(auth()->user()->hasPermission('view locations')){
        $actions['view'] = [
          'icon' => 'eye',
          'route' => [
            'name' => 'locations.view',
            'params' => [
              'id' => $data['_id']
            ]
          ]
        ];
      }
      if(auth()->user()->hasPermission('edit locations')){
        $actions['edit'] = [
          'icon' => 'pencil-alt',
          'route' => [
            'name' => 'locations.edit',
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
