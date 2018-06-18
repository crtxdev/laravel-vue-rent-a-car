<?php

namespace App\Observers;

use App\Models\Appointment;
use App\Models\Location;

class LocationObserver
{

    public function deleting(Location $location)
    {

      Appointment::where('location_id', $location->_id)->delete();

    }

}
