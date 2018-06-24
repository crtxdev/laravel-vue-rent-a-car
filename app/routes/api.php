<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['middleware' => 'auth:api'], function () {
    Route::post('logout', 'Auth\LoginController@logout');

    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::patch('settings/profile', 'Settings\ProfileController@update');
    Route::patch('settings/password', 'Settings\PasswordController@update');
});

Route::group(['middleware' => 'guest:api'], function () {
    Route::post('login', 'Auth\LoginController@login');
    Route::post('register', 'Auth\RegisterController@register');
    Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail');
    Route::post('password/reset', 'Auth\ResetPasswordController@reset');
});

Route::get('locations', 'LocationsController@fetch');
Route::get('cars', 'CarsController@fetch');
Route::get('appointments/{locationId}/{carId}/{date}', 'AppointmentsController@fetch');
Route::post('appointments/{locationId}/{carId}/{datetime}', 'AppointmentsController@create');

Route::group([
  'middleware' => 'admin',
  'prefix' => 'admin',
  'namespace' => '\Admin',
], function(){

  Route::get('permissions', 'PermissionsController@getAll');

  $entities = [ 'user', 'location', 'appointment', 'car' ];
  foreach($entities as $entity){
    $entityPlural = str_plural($entity);
    $controller = studly_case($entityPlural) . 'Controller';
    Route::group([ 'prefix' => $entityPlural ], function() use ($controller) {
      Route::get('/', $controller . '@datatable');
      Route::post('/', $controller . '@create');
      Route::get('{id}', $controller . '@get');
      Route::put('{id}', $controller . '@update');
      Route::delete('{id}', $controller . '@delete');
    });
  }

  Route::group([ 'prefix' => 'popular-bookings' ], function(){
    Route::get('/', 'PopularBookingsController@datatable');
    Route::get('report', 'PopularBookingsController@report');
  });

  Route::get('stats', 'StatsController@get');

});
