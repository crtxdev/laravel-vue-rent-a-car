<?php

namespace App\Http\Controllers\Admin;

use \App\Http\Controllers\Controller;
use \Illuminate\Http\Request;
use \App\Models\PopularBooking;
use \Carbon\Carbon;
use Cache;

class PopularBookingsController extends Controller
{

  public function datatable(Request $request)
  {

    $queryBuilder = PopularBooking::with('car', 'location')->whereNotNull('_id');

    $datatable = datatables($queryBuilder);

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

    $response = $datatable->make(true);

    return $response;

  }

  public function report(Request $request)
  {
    $data = $request->validate([
      'period' => 'numeric',
      'count' => 'numeric'
    ]);
    $finder = new \App\Services\PopularBookingsFinder($data['period'], $data['count']);
    $results = $finder->results();
    $headings = [
      trans('db.location'),
      trans('db.car'),
      trans('db.popular_bookings_count')
    ];
    $data = $results->map(function($result){
      return [
        $result->location->city . ' - ' . $result->location->address,
        $result->car->model,
        $result->count
      ];
    });
    $csv = new \App\Services\CsvGenerator($headings, $data, 'csv/popular_bookings.csv');
    $csvPath = url($csv->generate());
    return response()->json([
      'success' => true,
      'url' => $csvPath
    ]);
  }

  public function get(Request $request, $id)
  {
    return response()->json(PopularBooking::with('location', 'car')->findOrFail($id));
  }

}
