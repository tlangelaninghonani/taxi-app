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
        $driveAuth->drive_password = Hash::make("jamesatikinson@393");
        $driveAuth->drive_gender = ucwords("male");
        $driveAuth->drive_phone = "0677228944";
        $driveAuth->save();

        $driveData = new DriveData();
        $driveData->drive_id = $driveAuth->id;
        $driveData->drive_vehicle = ucwords("chevrolet blazer");
        $driveData->drive_profile_image = "";
        $driveData->drive_vehicle_type = ucwords("sedan");
        $driveData->drive_vehicle_plate = strtoupper("sdf 156 gp");
        $driveData->drive_vehicle_color = ucwords("black");
        $driveData->drive_ratings = rand(0, 6);
        $driveData->save();



        $driveAuth = new DriveAuth();
        $driveAuth->drive_first_name = ucwords("rowan");
        $driveAuth->drive_last_name = ucwords("bond");
        $driveAuth->drive_password = Hash::make("rowanbond@393");
        $driveAuth->drive_gender = ucwords("male");
        $driveAuth->drive_phone = "0826524562";
        $driveAuth->save();

        $driveData = new DriveData();
        $driveData->drive_id = $driveAuth->id;
        $driveData->drive_vehicle = ucwords("Mercedes Minivan");
        $driveData->drive_profile_image = "https://st.depositphotos.com/1269204/1219/i/600/depositphotos_12196477-stock-photo-smiling-men-isolated-on-the.jpg";
        $driveData->drive_vehicle_type = ucwords("minivan");
        $driveData->drive_vehicle_plate = strtoupper("jhf 895 l");
        $driveData->drive_vehicle_color = ucwords("Red");
        $driveData->drive_ratings = rand(0, 6);
        $driveData->save();



        $driveAuth = new DriveAuth();
        $driveAuth->drive_first_name = ucwords("marry");
        $driveAuth->drive_last_name = ucwords("smith");
        $driveAuth->drive_password = Hash::make("marrysmith@393");
        $driveAuth->drive_gender = ucwords("female");
        $driveAuth->drive_phone = "0769851235";
        $driveAuth->save();

        $driveData = new DriveData();
        $driveData->drive_id = $driveAuth->id;
        $driveData->drive_vehicle = ucwords("Ford Ranger");
        $driveData->drive_profile_image = "https://ichef.bbci.co.uk/news/976/cpsprodpb/FD27/production/_101970846_aubreyblanche.jpg";
        $driveData->drive_vehicle_type = ucwords("Pick-up Truck");
        $driveData->drive_vehicle_plate = strtoupper("hh 22 np");
        $driveData->drive_vehicle_color = ucwords("gray");
        $driveData->drive_ratings = rand(0, 6);
        $driveData->save();



        $driveAuth = new DriveAuth();
        $driveAuth->drive_first_name = ucwords("patrick");
        $driveAuth->drive_last_name = ucwords("jablonsky");
        $driveAuth->drive_password = Hash::make("patrickjablonsky@393");
        $driveAuth->drive_gender = ucwords("other");
        $driveAuth->drive_phone = "0729856523";
        $driveAuth->save();

        $driveData = new DriveData();
        $driveData->drive_id = $driveAuth->id;
        $driveData->drive_vehicle = ucwords("toyota prius");
        $driveData->drive_profile_image = "";
        $driveData->drive_vehicle_type = ucwords("electric hatchback");
        $driveData->drive_vehicle_plate = strtoupper("idf 566 l");
        $driveData->drive_vehicle_color = ucwords("gray");
        $driveData->drive_ratings = rand(0, 6);
        $driveData->save();


        $driveAuth = new DriveAuth();
        $driveAuth->drive_first_name = ucwords("isabelle");
        $driveAuth->drive_last_name = ucwords("gordons");
        $driveAuth->drive_password = Hash::make("isabellegordons@393");
        $driveAuth->drive_gender = ucwords("female");
        $driveAuth->drive_phone = "0695625623";
        $driveAuth->save();

        $driveData = new DriveData();
        $driveData->drive_id = $driveAuth->id;
        $driveData->drive_vehicle = ucwords("polo vivo");
        $driveData->drive_profile_image = "https://i.pinimg.com/originals/8b/56/b7/8b56b72767b137213fbb7965dbebd2c3.jpg";
        $driveData->drive_vehicle_type = ucwords("hatchback");
        $driveData->drive_vehicle_plate = strtoupper("jyp 582 nw");
        $driveData->drive_vehicle_color = ucwords("silver");
        $driveData->drive_ratings = rand(0, 6);
        $driveData->save();
        
    }
}
