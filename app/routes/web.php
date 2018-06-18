<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('{path}', function ($path = '') {
  return view(starts_with($path, 'admin') && auth()->check() && auth()->user()->hasPermission('admin panel') ? 'admin' : 'index');
})->where('path', '(.*)');
