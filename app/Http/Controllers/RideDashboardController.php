<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\RideAuth;
use App\Models\DriveAuth;
use App\Models\RideData;
use App\Models\DriveData;
use App\Models\RideRequest;
use App\Models\RideRequestInstant;
use App\Models\Notification;

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

        $trip = RideRequest::where("ride_id", $rideAuth->id)->where("on_trip", true)->first();

        if($rideData->ride_on_trip == true){
            $driveOnTrip = DriveData::find($trip->drive_id);
            if(! $driveOnTrip->drive_on_trip){
                $trip_id = $trip->id;
                return redirect("/ride/$trip_id/request/trip/end");
            }
        }

        $notifications = Notification::where("ride_id", $rideAuth->id)->get();
        $rideRequestInstant = RideRequestInstant::where("ride_id", $rideAuth->id)->first();
        $request = RideRequest::where("ride_id", $rideAuth->id)->where("on_trip")->first();

        return view("ride_dashboard", [
            "rideAuth" => $rideAuth,
            "rideData" => $rideData,
            "driveAuths" => $driveAuths,
            "driveData" => $driveData,
            "driveAuth" => new DriveAuth(),
            "request" => $request,
            "trip" => $trip,
            "notifications" => $notifications,
            "requestInstant" => $rideRequestInstant,
        ]);
    }
}
