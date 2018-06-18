<?php

namespace App\Http\Controllers\Admin\Contracts;

use \Illuminate\Http\Request;

interface CrudControllerContract
{

  public function get(Request $request, $id);

  public function update(Request $request, $id);

  public function delete(Request $request, $id);

}
