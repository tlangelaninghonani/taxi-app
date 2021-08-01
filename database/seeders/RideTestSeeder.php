<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\RideAuth;
use App\Models\RideData;

class RideTestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $rideAuth = new RideAuth();
        $rideAuth->ride_first_name = ucwords("tlangelani");
        $rideAuth->ride_last_name = ucwords("nghonani");
        $rideAuth->ride_password = Hash::make("0783938959");

        $rideAuth->save();

        $rideData = new RideData();
        $rideData->ride_id = $rideAuth->id;
        $rideData->ride_profile_image = "https://www.telegraph.co.uk/multimedia/archive/03491/Vladimir_Putin_1_3491835k.jpg";
        $rideData->ride_balance = 200.00;

        $rideData->save();



        $rideAuth = new RideAuth();
        $rideAuth->ride_first_name = ucwords("john");
        $rideAuth->ride_last_name = ucwords("doe");
        $rideAuth->ride_password = Hash::make("0783938959");

        $rideAuth->save();

        $rideData = new RideData();
        $rideData->ride_id = $rideAuth->id;
        $rideData->ride_profile_image = "https://upload.wikimedia.org/wikipedia/commons/a/a0/Andrzej_Person_Kancelaria_Senatu.jpg";
        $rideData->ride_balance = 500.00;

        $rideData->save();



        $rideAuth = new RideAuth();
        $rideAuth->ride_first_name = ucwords("alan");
        $rideAuth->ride_last_name = ucwords("mathew");
        $rideAuth->ride_password = Hash::make("0783938959");

        $rideAuth->save();

        $rideData = new RideData();
        $rideData->ride_id = $rideAuth->id;
        $rideData->ride_profile_image = "https://blogs-images.forbes.com/danschawbel/files/2017/12/Dan-Schawbel_avatar_1512422077-400x400.jpg";
        $rideData->ride_balance = 350.00;

        $rideData->save();
    }
}
