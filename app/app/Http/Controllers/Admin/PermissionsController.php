<?php

namespace App\Http\Controllers\Admin;

use \App\Http\Controllers\Controller;
use \Illuminate\Http\Request;

class PermissionsController extends Controller
{

  public function getAll(Request $request)
  {

    return response()->json(config('permissions.permissions'));

  }

}
