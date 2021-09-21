<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\RideAuth;
use App\Models\DriveAuth;
use App\Models\RideData;
use App\Models\DriveData;
use App\Models\RideRequest;
use App\Models\InternalAdmin;
use App\Models\RideRequestInstant;
use App\Models\Notification;

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
 
        $trip = RideRequest::where("drive_id", $driveAuth->id)->where("on_trip", true)->first();

        $notifications = Notification::where("drive_id", $driveAuth->id)->first();
        $rideRequestInstant = RideRequestInstant::where("drive_id", $driveAuth->id)->first();
        

        return view("drive_dashboard", [
            "driveAuth" => $driveAuth,
            "driveData" => $driveData,
            "rideAuth" => new RideAuth(),
            "rideData" => new RideData(),
            "requests" => new RideRequest(),
            "trip" => $trip,
            "notifications" => $notifications,
            "requestInstants" => new RideRequestInstant(),
            "requestInstant" => $rideRequestInstant,
        ]);
    }


    public function driveGetRequests(){
        $drive_id =  intval(Session::get("drive_id"));
        $requests = RideRequest::where("drive_id", $drive_id)->get();
        return array(
            "requests" => $requests,
            "rideAuth" => new RideAuth(),
        );
    }
}
