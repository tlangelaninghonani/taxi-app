<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\RideAuth;
use App\Models\DriveAuth;
use App\Models\RideData;
use App\Models\DriveData;

class DataController extends Controller
{
    public function rateIndex($id){
        $driveAuth = DriveAuth::find($id);
        $driveData = DriveData::where("drive_id", $driveAuth->id)->first();

        return view("ride_ratings", [
            "driveAuth" => $driveAuth,
            "driveData" => $driveData,
        ]);
    }
    public function rate(Request $req, $id){
        $driveAuth = DriveAuth::find($id);
        $driveData = DriveData::where("drive_id", $driveAuth->id)->first();

        $driveData->drive_ratings = $req->ratings;

        $driveData->save();

        return redirect("/ride/dashboard");
    }
    public function driveRequestIndex($id){
        if(! Session::has("hasLogged")){
            return redirect("/signin");
        }

        $drive_id =  intval(Session::get("drive_id"));

        $driveAuth = DriveAuth::findorfail($drive_id);
        $driveData = DriveData::where("drive_id", $drive_id)->first();

        $rideAuth = RideAuth::find($id);
        $rideData = RideData::where("ride_id", $rideAuth->id)->first();

        $rideRequest = json_decode($rideData->ride_requests, true)[$driveAuth->id];

        return view("drive_request", [
            "rideAuth" => $rideAuth,
            "rideData" => $rideData,
            "rideRequest" => $rideRequest
        ]);
    }

    public function driveRequestAccept(Request $req, $id){
        $rideAuth = RideAuth::find($id);
        $rideData = RideData::where("ride_id", $rideAuth->id)->first();

        $drive_id =  intval(Session::get("drive_id"));

        $driveAuth = DriveAuth::findorfail($drive_id);
        $driveData = DriveData::where("drive_id", $drive_id)->first();

        $rideRequests = json_decode($rideData->ride_requests, true);

        $rideRequest = $rideRequests[$driveAuth->id];
        $rideRequest["ride_accepted"] = true;

        $rideRequests[$driveAuth->id] = $rideRequest;

        $rideData->ride_requests = json_encode($rideRequests);

        $rideData->save();

        return redirect("/drive/dashboard");
    }

    /*public function driveOfferAccept(Request $req, $id){
        $rideAuth = RideAuth::find($id);
        $rideData = RideData::where("ride_id", $rideAuth->id)->first();

        $drive_id =  intval(Session::get("drive_id"));

        $driveAuth = DriveAuth::findorfail($drive_id);
        $driveData = DriveData::where("drive_id", $drive_id)->first();

        $allOffers = json_decode($rideData->drive_offers, true);
        $allOffers[$rideData->ride_offer_track] = array(
            $driveAuth->id => array(
                "drive_offer_ride_from" => $req->ridefrom,
                "drive_offer_ride_to" => $req->ride_to,
                "drive_offer_ride_date_time" => $req->ridedatetime,
                "charges" => $req->charge,
            ),
        );

       

        $rideData->drive_offers = json_encode($allOffers);

        $rideData->ride_offer_track += 1;

        $rideData->save();

        $allRideOffers = json_decode($driveData->ride_offers);
        $allRideOffers[] = $req->planid;

        $driveData->ride_offers = json_encode($allRideOffers);

        $driveData->save();

        return redirect("/drive/dashboard");
    }*/

    public function driveOnTrip(Request $req, $id){
        $rideAuth = RideAuth::find($id);
        $rideData = RideData::where("ride_id", $rideAuth->id)->first();

        $drive_id =  intval(Session::get("drive_id"));

        $driveAuth = DriveAuth::findorfail($drive_id);
        $driveData = DriveData::where("drive_id", $drive_id)->first();

        $rideData->ride_on_trip = true;
        $driveData->drive_on_trip = true;

        $driveData->drive_trip = array(
            "ride_id" => $rideAuth->id,
            "drive_from" => $req->ridefrom,
            "drive_to" => $req->rideto,
            "drive_from_lat" => $req->ridefromlat,
            "drive_from_lng" => $req->ridefromlng,
            "drive_to_lat" => $req->ridetolat,
            "drive_to_lng" => $req->ridetolng,
            "drive_distance" => $req->ridedistance,
            "drive_duration" => $req->rideduration,
            "drive_charges" => $req->ridecharges
        );

        $rideData->ride_trip = array(
            "drive_id" => $driveAuth->id,
            "ride_from" => $req->ridefrom,
            "ride_to" => $req->rideto,
            "ride_from_lat" => $req->ridefromlat,
            "ride_from_lng" => $req->ridefromlng,
            "ride_to_lat" => $req->ridetolat,
            "ride_to_lng" => $req->ridetolng,
            "ride_distance" => $req->ridedistance,
            "ride_duration" => $req->rideduration,
            "ride_charges" => $req->ridecharges
        );

        $rideData->save();
        $driveData->save();

        return redirect("/drive/dashboard");
    }

    public function driveRequestTripEnd($id){
        $rideAuth = RideAuth::find($id);
        $rideData = RideData::where("ride_id", $rideAuth->id)->first();

        $drive_id =  intval(Session::get("drive_id"));

        $driveAuth = DriveAuth::findorfail($drive_id);
        $driveData = DriveData::where("drive_id", $drive_id)->first();

        $allHistory = json_decode($driveData->drive_history, true);

        $driveTrip = json_decode($driveData->drive_trip, true);

        $allHistory[$rideAuth->id] = array(
            "drive_from" => $driveTrip["drive_from"],
            "drive_to" => $driveTrip["drive_to"],
            "drive_from_lat" => $driveTrip["drive_from_lat"],
            "drive_from_lng" => $driveTrip["drive_from_lng"],
            "drive_to_lat" => $driveTrip["drive_to_lat"],
            "drive_to_lng" => $driveTrip["drive_to_lng"],
            "drive_distance" => $driveTrip["drive_distance"],
            "drive_duration" => $driveTrip["drive_duration"],
            "drive_charges" => $driveTrip["drive_charges"]
        );

        $driveData->drive_history = json_encode($allHistory);

        $driveData->drive_trip = "";
        $driveData->drive_on_trip = false;
        $driveData->confirm_pickup = false;


        $driveData->save();
        
        $rideRequests = json_decode($rideData->ride_requests, true);

        $updatedrideRequests = array();
        foreach($rideRequests as $driveId => $requestData){
            if($driveId != $driveAuth->id){
                $updatedrideRequests[$driveId] = $rideRequests[$driveId];
            }
        }

        $rideData->ride_requests = json_encode($updatedrideRequests);

        $allHistory = json_decode($rideData->ride_history, true);

        $rideTrip = json_decode($rideData->ride_trip, true);

        $allHistory[$driveAuth->id] = array(
            "ride_from" => $rideTrip["ride_from"],
            "ride_to" => $rideTrip["ride_to"],
            "ride_from_lat" => $rideTrip["ride_from_lat"],
            "ride_from_lng" => $rideTrip["ride_from_lng"],
            "ride_to_lat" => $rideTrip["ride_to_lat"],
            "ride_to_lng" => $rideTrip["ride_to_lng"],
            "ride_distance" => $rideTrip["ride_distance"],
            "ride_duration" => $rideTrip["ride_duration"],
            "ride_charges" => $rideTrip["ride_charges"]
        );

        $rideData->ride_history = json_encode($allHistory);

        $rideData->ride_trip = "";
        $rideData->ride_on_trip = false;
        $rideData->pick_up_requested = false;

        $rideData->save();

        return redirect("/drive/dashboard");
    }

    public function driversIndex(){
        if(! Session::has("hasLogged")){
            return redirect("/signin");
        }
        $ride_id =  intval(Session::get("ride_id"));

        $rideAuth = RideAuth::findorfail($ride_id);
        $rideData = RideData::where("ride_id", $ride_id)->first();

        $driveAuths = DriveAuth::all();
        $driveData = new DriveData(); 

        return view("ride_drivers", [
            "rideAuth" => $rideAuth,
            "rideData" => $rideData,
            "driveAuths" => $driveAuths,
            "driveData" => $driveData,
        ]);
    }

    public function ridePlansIndex(){
        if(! Session::has("hasLogged")){
            return redirect("/signin");
        }
        $ride_id =  intval(Session::get("ride_id"));

        $rideAuth = RideAuth::findorfail($ride_id);
        $rideData = RideData::where("ride_id", $ride_id)->first();

        return view("ride_plans", [
            "rideAuth" => $rideAuth,
            "rideData" => $rideData,
        ]);
    }

    public function rideOffersIndex(){
        if(! Session::has("hasLogged")){
            return redirect("/signin");
        }
        

        $ride_id =  intval(Session::get("ride_id"));

        $rideAuth = RideAuth::findorfail($ride_id);
        $rideData = RideData::where("ride_id", $ride_id)->first();

        return view("ride_offers", [
            "rideAuth" => $rideAuth,
            "rideData" => $rideData,
            "driveAuth" => new DriveAuth(),
            "driveData" => new DriveData(),
        ]);
    }

    public function driveRidersPlansIndex($id){
        if(! Session::has("hasLogged")){
            return redirect("/signin");
        }
        $rideAuth = RideAuth::find($id);
        $rideData = RideData::where("ride_id", $rideAuth->id)->first();

        $drive_id =  intval(Session::get("drive_id"));

        $driveAuth = DriveAuth::findorfail($drive_id);
        $driveData = DriveData::where("drive_id", $drive_id)->first();

        $ridePlansData = array();
        $counter = 0;

        foreach(json_decode($rideData->ride_plans, true) as $ridePlans) {
            $counter++;
            if($counter < 2){
                $ridePlansData[$counter] = array(
                    "originLat" => json_decode($ridePlans["ride_from_coords"], true)["lat"],
                    "originLng" => json_decode($ridePlans["ride_from_coords"], true)["lng"],
                    "destLat" => json_decode($ridePlans["ride_to_coords"], true)["lat"],
                    "destLng" => json_decode($ridePlans["ride_to_coords"], true)["lng"],
                );
            }else{
                if($counter < sizeof(json_decode($rideData->ride_plans, true))){
                    $ridePlansData[$counter] = array(
                        "originLat" => json_decode($ridePlans["ride_from_coords"], true)["lat"],
                        "originLng" => json_decode($ridePlans["ride_from_coords"], true)["lng"],
                        "destLat" => json_decode($ridePlans["ride_to_coords"], true)["lat"],
                        "destLng" => json_decode($ridePlans["ride_to_coords"], true)["lng"],
                    );
                }else{
                    $ridePlansData[$counter] = array(
                        "originLat" => json_decode($ridePlans["ride_from_coords"], true)["lat"],
                        "originLng" => json_decode($ridePlans["ride_from_coords"], true)["lng"],
                        "destLat" => json_decode($ridePlans["ride_to_coords"], true)["lat"],
                        "destLng" => json_decode($ridePlans["ride_to_coords"], true)["lng"],
                    );
                }
            }
        }

        return view("drive_view_ride_plans", [
            "rideAuth" => $rideAuth,
            "rideData" => $rideData,
            "driveAuth" => $driveAuth,
            "driveData" => $driveData,
            "ridePlansData" => $ridePlansData,
        ]);
    }

    public function driveOffer(Request $req, $id, $planCounter){
        if(! Session::has("hasLogged")){
            return redirect("/signin");
        }
        $planCounter--;
        $rideAuth = RideAuth::find($id);
        $rideData = RideData::where("ride_id", $rideAuth->id)->first();

        $drive_id =  intval(Session::get("drive_id"));

        $driveAuth = DriveAuth::findorfail($drive_id);
        $driveData = DriveData::where("drive_id", $drive_id)->first();

        $allPlans = json_decode($rideData->ride_plans, true);
        $planToOffer = $allPlans[$planCounter];
        $planToOffer["ride_accepted"] = true;
        $planToOffer["driver_id"] = $driveAuth->id;
        $allPlans[$planCounter] = $planToOffer;

        $rideData->ride_plans = json_encode($allPlans);

        $rideData->save();

        return redirect("/drive/riders");
    }

    public function ridePlans(Request $req){
        $ride_id =  intval(Session::get("ride_id"));

        $rideAuth = RideAuth::findorfail($ride_id);
        $rideData = RideData::where("ride_id", $ride_id)->first();

        $allPlans = json_decode($rideData->ride_plans, true);

        $allPlans[] = array(
            "ride_id" => $rideAuth->id,
            "ride_from" => ucwords($req->ridefrom),
            "ride_to" => ucwords($req->rideto),
            "ride_from_coords" => $req->ridefromcoords,
            "ride_to_coords" => $req->ridetocoords,
            "ride_distance" => $req->ridedistance,
            "ride_duration" => $req->rideduration,
            "ride_charges" => $req->ridecharges,
            "ride_time" =>$req->ridetime,
            "ride_date" => $req->ridedate,
            "ride_meridiem" => $req->ridemeridiem,
            "ride_accepted" => false
        );

        $rideData->ride_plans = json_encode($allPlans);

        $rideData->save();

        return redirect("/ride/dashboard");
    }

    public function rideHistoryIndex(){
        if(! Session::has("hasLogged")){
            return redirect("/signin");
        }
        $ride_id =  intval(Session::get("ride_id"));

        $rideAuth = RideAuth::findorfail($ride_id);
        $rideData = RideData::where("ride_id", $ride_id)->first();
        return view("ride_history", [
            "rideAuth" => $rideAuth,
            "rideData" => $rideData,
            "driveAuth" => new DriveAuth(),
            "driveData" => new DriveData(),
        ]);
    }

    public function driveHistoryIndex(){
        if(! Session::has("hasLogged")){
            return redirect("/signin");
        }
        $drive_id =  intval(Session::get("drive_id"));

        $driveAuth = DriveAuth::findorfail($drive_id);
        $driveData = DriveData::where("drive_id", $drive_id)->first();

        return view("drive_history", [
            "rideAuth" => $driveAuth,
            "rideData" => $driveData,
            "rideAuth" => new RideAuth(),
            "rideData" => new RideData(),
            "driveAuth" => $driveAuth,
            "driveData" => $driveData,
        ]);
    }

    public function ridersIndex(){
        if(! Session::has("hasLogged")){
            return redirect("/signin");
        }

        $rideAuth = RideAuth::all();
        $rideData = new RideData();

        return view("drive_riders", [
            "rideAuths" => $rideAuth,
            "rideData" => $rideData,
        ]);
    }

    public function rideRequestTripEnd($id){
        $driveAuth = DriveAuth::find($id);
        $driveData = DriveData::where("drive_id", $driveAuth->id)->first();

        $ride_id =  intval(Session::get("ride_id"));

        $rideAuth = RideAuth::findorfail($ride_id);
        $rideData = RideData::where("ride_id", $ride_id)->first();

        $allHistory = json_decode($driveData->drive_history, true);

        $driveTrip = json_decode($driveData->drive_trip, true);

        $allHistory[$rideAuth->id] = array(
            "drive_from" => $driveTrip["drive_from"],
            "drive_to" => $driveTrip["drive_to"],
            "drive_from_lat" => $driveTrip["drive_from_lat"],
            "drive_from_lng" => $driveTrip["drive_from_lng"],
            "drive_to_lat" => $driveTrip["drive_to_lat"],
            "drive_to_lng" => $driveTrip["drive_to_lng"],
            "drive_distance" => $driveTrip["drive_distance"],
            "drive_duration" => $driveTrip["drive_duration"],
            "drive_charges" => $driveTrip["drive_charges"]
        );

        $driveData->drive_history = json_encode($allHistory);

        $driveData->drive_trip = "";
        $driveData->drive_on_trip = false;
        $driveData->confirm_pickup = false;


        $driveData->save();
        
        $rideRequests = json_decode($rideData->ride_requests, true);

        $updatedrideRequests = array();
        foreach($rideRequests as $driveId => $requestData){
            if($driveId != $driveAuth->id){
                $updatedrideRequests[$driveId] = $rideRequests[$driveId];
            }
        }

        $rideData->ride_requests = json_encode($updatedrideRequests);

        $allHistory = json_decode($rideData->ride_history, true);

        $rideTrip = json_decode($rideData->ride_trip, true);

        $allHistory[$driveAuth->id] = array(
            "ride_from" => $rideTrip["ride_from"],
            "ride_to" => $rideTrip["ride_to"],
            "ride_from_lat" => $rideTrip["ride_from_lat"],
            "ride_from_lng" => $rideTrip["ride_from_lng"],
            "ride_to_lat" => $rideTrip["ride_to_lat"],
            "ride_to_lng" => $rideTrip["ride_to_lng"],
            "ride_distance" => $rideTrip["ride_distance"],
            "ride_duration" => $rideTrip["ride_duration"],
            "ride_charges" => $rideTrip["ride_charges"]
        );

        $rideData->ride_history = json_encode($allHistory);

        $rideData->ride_trip = "";
        $rideData->ride_on_trip = false;
        $rideData->pick_up_requested = false;

        $rideData->save();

        $rideData->save();

        return view("ride_ratings", [
            "driveAuth" => $driveAuth,
            "driveData" => $driveData,
        ]);;
    }

    public function driveProfile(){
        $drive_id =  intval(Session::get("drive_id"));

        $driveAuth = DriveAuth::findorfail($drive_id);
        $driveData = DriveData::where("drive_id", $drive_id)->first();

        return view("drive_profile", [
            "driveAuth" => $driveAuth,
            "driveData" => $driveData
        ]);
    }

    public function rideRequestIndex($id){
        if(! Session::has("hasLogged")){
            return redirect("/signin");
        }
        
        $driveAuth = DriveAuth::find($id);
        $driveData = DriveData::where("drive_id", $driveAuth->id)->first();

        $ride_id =  intval(Session::get("ride_id"));

        $rideAuth = RideAuth::findorfail($ride_id);
        $rideData = RideData::where("ride_id", $ride_id)->first();

        return view("ride_request", [
            "driveAuth" => $driveAuth,
            "driveData" => $driveData,
            "rideData" => $rideData,
        ]);
    }

    public function rideRequestAcceptedIndex($id){
        if(! Session::has("hasLogged")){
            return redirect("/signin");
        }
        
        $driveAuth = DriveAuth::find($id);
        $driveData = DriveData::where("drive_id", $driveAuth->id)->first();

        $ride_id =  intval(Session::get("ride_id"));

        $rideAuth = RideAuth::findorfail($ride_id);
        $rideData = RideData::where("ride_id", $ride_id)->first();

        $rideRequest = json_decode($rideData->ride_requests, true)[$driveAuth->id];

        return view("ride_request_accepted", [
            "driveAuth" => $driveAuth,
            "driveData" => $driveData,
            "rideAuth" => $rideAuth,
            "rideData" => $rideData,
            "rideRequest" => $rideRequest
        ]);
    }

    public function driveRequestAcceptedIndex($id){
        if(! Session::has("hasLogged")){
            return redirect("/signin");
        }
        
        $rideAuth = RideAuth::find($id);
        $rideData = RideData::where("ride_id", $rideAuth->id)->first();

        $drive_id =  intval(Session::get("drive_id"));

        $driveAuth = DriveAuth::findorfail($drive_id);
        $driveData = DriveData::where("drive_id", $drive_id)->first();

        $rideRequest = json_decode($rideData->ride_requests, true)[$driveAuth->id];

        return view("drive_request_accepted", [
            "driveAuth" => $driveAuth,
            "driveData" => $driveData,
            "rideAuth" => $rideAuth,
            "rideData" => $rideData,
            "rideRequest" => $rideRequest
        ]);
    }

    public function rideRequestPickup($id){
        $driveAuth = DriveAuth::find($id);
        $driveData = DriveData::where("drive_id", $driveAuth->id)->first();

        $ride_id =  intval(Session::get("ride_id"));

        $rideAuth = RideAuth::findorfail($ride_id);
        $rideData = RideData::where("ride_id", $ride_id)->first();

        $rideData->pick_up_requested = true;

        $rideData->save();

        return back();
    }

    public function driveConfirmPickup($id){
        $rideAuth = RideAuth::find($id);
        $rideData = RideData::where("ride_id", $rideAuth->id)->first();

        $drive_id =  intval(Session::get("drive_id"));

        $driveAuth = DriveAuth::findorfail($drive_id);
        $driveData = DriveData::where("drive_id", $drive_id)->first();

        $driveData->confirm_pickup = true;

        $driveData->save();

        return back();
    }

    public function rideRequest(Request $req, $id){
        $driveAuth = DriveAuth::find($id);
        $driveData = DriveData::where("drive_id", $driveAuth->id)->first();

        $ride_id =  intval(Session::get("ride_id"));

        $rideAuth = RideAuth::findorfail($ride_id);
        $rideData = RideData::where("ride_id", $ride_id)->first();

        $rideRequests = json_decode($rideData->ride_requests, true);
        $rideRequests[$driveAuth->id] = array(
            "ride_id" => $rideAuth->id,
            "ride_from" => ucwords($req->ridefrom),
            "ride_to" => ucwords($req->rideto),
            "ride_from_coords" => $req->ridefromcoords,
            "ride_to_coords" => $req->ridetocoords,
            "ride_distance" => $req->ridedistance,
            "ride_time" => $req->ridetime,
            "ride_charges" => $req->ridecharges,
            "ride_accepted" => false
        );

        $rideData->ride_requests = json_encode($rideRequests);
        $rideData->save();

        return redirect("/ride/dashboard");
    }
}
