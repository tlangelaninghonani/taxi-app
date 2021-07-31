<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\RideAuth;
use App\Models\DriveAuth;
use App\Models\RideData;
use App\Models\DriveData;


class RideDashboardController extends Controller
{
    public function index(){
        if(! Session::has("hasLogged")){
            return redirect("/signin");
        }
        $ride_id =  intval(Session::get("ride_id"));

        $rideAuth = RideAuth::findorfail($ride_id);
        $rideData = RideData::where("ride_id", $ride_id)->first();

        $driveAuths = DriveAuth::all();
        $driveData = new DriveData(); 
        
        $rideRequest = null;

        $rideTrip = json_decode($rideData->ride_trip, true);

        if($rideData->ride_on_trip == true){
            $driveAuth = DriveAuth::find($rideTrip["drive_id"]);
            $driveData = DriveData::where("drive_id", $driveAuth->id)->first();

            if($driveData->drive_on_trip == false){
                return view("ride_ratings", [
                    "driveAuth" => $driveAuth,
                    "driveData" => $driveData,
                ]);
            }
        }

        return view("ride_dashboard", [
            "rideAuth" => $rideAuth,
            "rideData" => $rideData,
            "driveAuths" => $driveAuths,
            "driveData" => $driveData,
            "driveAuth" => new DriveAuth(),
            "rideRequest" => $rideRequest,
            "rideTrip" => $rideTrip
        ]);
    }
}
