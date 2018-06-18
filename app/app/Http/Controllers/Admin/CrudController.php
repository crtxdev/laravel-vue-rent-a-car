<?php

namespace App\Http\Controllers\Admin;

use \App\Http\Controllers\Controller;
use \Illuminate\Http\Request;
use \App\Http\Controllers\Admin\Contracts\CrudControllerContract;

class CrudController extends Controller implements CrudControllerContract
{

  protected $model;

  protected $unsetKeys = [ '_id', 'created_at', 'updated_at', 'deleted_at' ];

  public function __construct()
  {

    $entityPlural = str_replace('Controller', '', class_basename(static::class));
    $entitySingular = str_singular($entityPlural);
    $entityPluralLower = strtolower($entityPlural);

    $this->model = '\App\Models\\' . $entitySingular;

    $this->middleware('permission: view ' . $entityPluralLower)->only(['get', 'datatables']);
    $this->middleware('permission: edit ' . $entityPluralLower)->only(['update']);
    $this->middleware('permission: create ' . $entityPluralLower)->only(['create']);
    $this->middleware('permission: delete ' . $entityPluralLower)->only(['delete']);

  }

  public function get(Request $request, $id)
  {
    return response()->json($this->model::findOrFail($id));
  }

  public function create(Request $request)
  {
    $data = json_decode($request->getContent(), true);
    foreach($this->unsetKeys as $key){
      if(isset($data[$key])){
        unset($data[$key]);
      }
    }
    if(method_exists($this, 'preCreate')){
      $data = $this->preCreate($data);
    }
    $instance = new $this->model;
    foreach($data as $key => $val){
      $instance->$key = $val;
    }
    return response()->json($instance);
  }

  public function update(Request $request, $id)
  {
    $data = json_decode($request->getContent(), true);
    foreach($this->unsetKeys as $key){
      if(isset($data[$key])){
        unset($data[$key]);
      }
    }
    if(method_exists($this, 'preUpdate')){
      $data = $this->preUpdate($data);
    }
    $instance = $this->model::findOrFail($id);
    foreach($data as $key => $val){
      $instance->$key = $val;
    }
    $instance->save();
    return response()->json($instance);
  }

  public function delete(Request $request, $id)
  {
    $this->model::findOrFail($id)->delete();
    return response()->json([
      'deleted' => true
    ]);
  }

}
