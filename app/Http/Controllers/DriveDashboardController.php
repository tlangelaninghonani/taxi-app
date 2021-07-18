<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\RideAuth;
use App\Models\DriveAuth;
use App\Models\RideData;
use App\Models\DriveData;

class DriveDashboardController extends Controller
{
    public function index(){
        if(! Session::has("hasLogged")){
            return redirect("/signin");
        }
        $drive_id =  intval(Session::get("drive_id"));

        $driveAuth = DriveAuth::findorfail($drive_id);
        $driveData = DriveData::where("drive_id", $drive_id)->first();

        $rideData = new RideData();

        $rideRequest = null;
        foreach($rideData::all() as $ride){
            foreach(json_decode($ride->ride_requests, true) as $driveId => $requestData){
                if($driveId == $driveAuth->id){
                    $rideRequest = json_decode($ride->ride_requests, true)[$driveId];
                    break;
                }
            }
        }

        return view("drive_dashboard", [
            "driveAuth" => $driveAuth,
            "driveData" => $driveData,
            "rideAuth" => new RideAuth(),
            "rideData" => new RideData(),
            "rideRequest" => $rideRequest
        ]);
    }
}
