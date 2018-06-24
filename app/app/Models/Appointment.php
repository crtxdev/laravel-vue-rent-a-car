<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\SoftDeletes;
use Carbon\Carbon;

class Appointment extends Model
{

  use SoftDeletes;

  protected $dates = [ 'created_at', 'updated_at', 'deleted_at', 'datetime' ];

  const STATUS_RESERVED = 'reserved';
  const STATUS_COMPLETED = 'completed';
  const STATUS_CANCELLED = 'cancelled';

  public function scopeOfDate($query, Carbon $date)
  {
    $dateStart = $date->copy();
    $dateEnd = $date->copy()->addHours(23)->addMinutes(59);
    return $query->where('datetime', '>=', $dateStart)->where('datetime', '<', $dateEnd);
  }

  public function scopeOfDateRange($query, Carbon $start, Carbon $end)
  {
    return $query->where('datetime', '>=', $start)->where('datetime', '<=', $end);
  }

  public function scopeOfLastWeek($query)
  {
    return $this->scopeOfDateRange($query, Carbon::today()->startOfDay()->subDays(7), Carbon::now()->endOfDay());
  }

  public function scopeOfLastMonth($query)
  {
    return $this->scopeOfDateRange($query, Carbon::today()->startOfDay()->subDays(30), Carbon::now()->endOfDay());
  }

  public function scopeOfLastNDays($query, $days)
  {
    return $this->scopeOfDateRange($query, Carbon::today()->startOfDay()->subDays($days), Carbon::now()->endOfDay());
  }

  public function scopeOfLocation($query, $locationId)
  {
    return $query->where('location_id', $locationId);
  }

  public function scopeOfCar($query, $carId)
  {
    return $query->where('car_id', $carId);
  }

  public function location()
  {
    return $this->belongsTo(Location::class)->withTrashed();
  }

  public function car()
  {
    return $this->belongsTo(Car::class)->withTrashed();
  }

}
