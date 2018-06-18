<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;
use App\Models\{ Car, Location, Appointment };

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        Location::all()->map(function($location){ $location->forceDelete(); });
        Car::all()->map(function($car){ $car->forceDelete(); });
        Appointment::all()->map(function($appointment){ $appointment->forceDelete(); });

        $locations = [
            'Novi Sad' => [ 'Bulevar Mihajla Pupina 24', 'Carinska 4' ],
            'Valjevo' => [ 'Pavla Beljanskog 1' ],
            'Beograd' => [ 'Pere Segedinca 1', 'Cetinjska 8', 'Dalmatinska b.b.', 'Pitagorina 78', 'Sarajevska 4' ],
            'Kragujevac' => [ 'Savska 42' ],
            'Apatin' => [ 'Sokolska 4' ],
            'Zrenjanin' => [ 'Beogradski put b.b.' ],
            'Veternik' => [ 'Ibarska 21b' ],
        ];

        $cars = [
            'Chevy Sonic',
            'Ford Fiesta',
            'Honda Fit',
            'Hyundai Accent',
            'Kia Rio',
            'Mazda 2',
            'Mitsubishi Mirage',
            'Nissan Versa',
            'Toyota Camry',
            'Dodge Charger',
            'Hyundai Elantra',
            'Chevrolet Malibu',
            'Kia Stinger',
            'Audi A4',
            'Audi A6',
            'Audi A7',
            'Audi A8',
            'Audi S5',
            'Hyundai Sonata',
            'Volkswagen Passat',
            'BMW M5',
            'BMW M3',
            'Alfa Romeo Giulia',
            'Chevrolet Cruze',
            'Subaru WRX',
            'Nissan Altima',
            'Mercedes-Benz AMG E 63',
            'Acura TLX',
        ];

        foreach($cars as $model){
            $car = new Car();
            $car->model = $model;
            $car->save();
        }

        foreach($locations as $city => $addresses){
            foreach($addresses as $address){
                $location = new Location;
                $location->city = $city;
                $location->address = $address;
                $location->save();
                $randomCars = collect(
                    Car::raw()
                    ->aggregate([
                      [ '$sample' => [ 'size' => rand(3, count($cars)) ] ]
                    ])
                    ->toArray()
                  )
                  ->map(function($car){
                      $document = $car->bsonSerialize();
                      return (string) $document->_id;
                  })
                  ->toArray();
                $location->push('availableCars', $randomCars);
            }
        }

        $faker = \Faker\Factory::create();

        foreach(range(-30, 10) as $i){

          $day = Carbon::today()->startOfDay()->addDays($i)->addHours(7);

          if($day->isWeekend()){
            continue;
          }

          $allLocations = Location::all();

          foreach($allLocations as $location){

            foreach($location->availableCars as $carId){

              $minutesFactors = $faker->randomElements(range(0, 7), rand(3, 7));

              if($day->isPast()){
                $rnd = rand(0, 100);
                if($rnd < 95){
                  $status = 'completed';
                } else {
                  $status = 'cancelled';
                }
              } else {
                // future
                $rnd = rand(0, 100);
                if($rnd < 95){
                  $status = 'reserved';
                } else {
                  $status = 'cancelled';
                }
              }

              foreach($minutesFactors as $minutesFactor){

                $appointment = new Appointment;
                $appointment->firstName = $faker->firstName;
                $appointment->lastName = $faker->lastName;
                $appointment->email = $faker->email;
                $appointment->licenseNumber = $faker->regexify('[0-9]{10}');
                $appointment->address = $faker->address;
                $appointment->zip = 12345;
                $appointment->city = $faker->city;
                $appointment->state = '';
                $appointment->country = 'Srbija';
                $appointment->location_id = $location->_id;
                $appointment->car_id = $carId;
                $appointment->datetime = $day->copy()->addMinutes(90 * $minutesFactor);
                $appointment->status = $status;
                $appointment->save();

              }

            }

          }

        }

    }
}
