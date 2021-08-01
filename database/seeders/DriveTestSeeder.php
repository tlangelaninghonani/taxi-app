<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\DriveAuth;
use App\Models\DriveData;

class DriveTestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $driveAuth = new DriveAuth();
        $driveAuth->drive_first_name = ucwords("james");
        $driveAuth->drive_last_name = ucwords("atikinson");
        $driveAuth->drive_password = Hash::make("0783938959");
        $driveAuth->save();

        $driveData = new DriveData();
        $driveData->drive_id = $driveAuth->id;
        $driveData->drive_vehicle = ucwords("chevrolet blazer");
        $driveData->drive_profile_image = "https://www.avoo.uk/images/home/profile-3.jpg";
        $driveData->drive_vehicle_type = ucwords("sedan");
        $driveData->drive_ratings = 3.5;
        $driveData->save();



        $driveAuth = new DriveAuth();
        $driveAuth->drive_first_name = ucwords("rowan");
        $driveAuth->drive_last_name = ucwords("bond");
        $driveAuth->drive_password = Hash::make("0783938959");
        $driveAuth->save();

        $driveData = new DriveData();
        $driveData->drive_id = $driveAuth->id;
        $driveData->drive_vehicle = ucwords("Mercedes Minivan");
        $driveData->drive_profile_image = "https://st.depositphotos.com/1269204/1219/i/600/depositphotos_12196477-stock-photo-smiling-men-isolated-on-the.jpg";
        $driveData->drive_vehicle_type = ucwords("minivan");
        $driveData->drive_ratings = 2.1;
        $driveData->save();



        $driveAuth = new DriveAuth();
        $driveAuth->drive_first_name = ucwords("marry");
        $driveAuth->drive_last_name = ucwords("smith");
        $driveAuth->drive_password = Hash::make("0783938959");
        $driveAuth->save();

        $driveData = new DriveData();
        $driveData->drive_id = $driveAuth->id;
        $driveData->drive_vehicle = ucwords("Ford Ranger");
        $driveData->drive_profile_image = "https://ichef.bbci.co.uk/news/976/cpsprodpb/FD27/production/_101970846_aubreyblanche.jpg";
        $driveData->drive_vehicle_type = ucwords("Pick-up Truck");
        $driveData->drive_ratings = 2.1;
        $driveData->save();



        $driveAuth = new DriveAuth();
        $driveAuth->drive_first_name = ucwords("patrick");
        $driveAuth->drive_last_name = ucwords("jablonsky");
        $driveAuth->drive_password = Hash::make("0783938959");
        $driveAuth->save();

        $driveData = new DriveData();
        $driveData->drive_id = $driveAuth->id;
        $driveData->drive_vehicle = ucwords("toyota prius");
        $driveData->drive_profile_image = "https://i2.wp.com/www.thenewsnigeria.com.ng/wp-content/uploads/2020/09/Ray-Brown.jpeg?ssl=1";
        $driveData->drive_vehicle_type = ucwords("electric hatchback");
        $driveData->drive_ratings = 4.9;
        $driveData->save();


        $driveAuth = new DriveAuth();
        $driveAuth->drive_first_name = ucwords("isabelle");
        $driveAuth->drive_last_name = ucwords("gordons");
        $driveAuth->drive_password = Hash::make("0783938959");
        $driveAuth->save();

        $driveData = new DriveData();
        $driveData->drive_id = $driveAuth->id;
        $driveData->drive_vehicle = ucwords("polo vivo");
        $driveData->drive_profile_image = "https://i.pinimg.com/originals/8b/56/b7/8b56b72767b137213fbb7965dbebd2c3.jpg";
        $driveData->drive_vehicle_type = ucwords("electric hatchback");
        $driveData->drive_ratings = 4.9;
        $driveData->save();
        
    }
}
