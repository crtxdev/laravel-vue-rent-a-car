<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\SoftDeletes;
use Carbon\Carbon;

class PopularBooking extends Model
{

  use SoftDeletes;

  public function location()
  {
    return $this->belongsTo(Location::class)->withTrashed();
  }

  public function car()
  {
    return $this->belongsTo(Car::class)->withTrashed();
  }

}