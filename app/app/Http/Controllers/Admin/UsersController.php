<?php

namespace App\Http\Controllers\Admin;

use \Illuminate\Http\Request;
use \App\Models\User;

class UsersController extends CrudController
{

  public function __construct()
  {
    parent::__construct();
    $this->unsetKeys = array_merge($this->unsetKeys, ['photo_url']);
  }

  public function datatable(Request $request)
  {

    $queryBuilder = User::whereNotNull('_id');

    $datatable = datatables($queryBuilder);

    $datatable->addColumn('actions', function($data){
      $actions = [];
      if(auth()->user()->hasPermission('view users')){
        $actions['view'] = [
          'icon' => 'eye',
          'route' => [
            'name' => 'users.view',
            'params' => [
              'id' => $data['_id']
            ]
          ]
        ];
      }
      if(auth()->user()->hasPermission('edit users')){
        $actions['edit'] = [
          'icon' => 'pencil-alt',
          'route' => [
            'name' => 'users.edit',
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

  protected function preCreate(array $data)
  {
    if(isset($data['password'])){
      $data['password'] = bcrypt($data['password']);
    }
    return $data;
  }

  protected function preUpdate(array $data)
  {
    if(isset($data['password'])){
      unset($data['password']);
    }
    return $data;
  }

}
