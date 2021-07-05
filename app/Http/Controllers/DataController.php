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

        $rideAuth = RideAuth::find($id);
        $rideData = RideData::where("ride_id", $rideAuth->id)->first();

        return view("drive_request", [
            "rideAuth" => $rideAuth,
            "rideData" => $rideData,
        ]);
    }

    public function driveRequestAccept(Request $req, $id){
        $rideAuth = RideAuth::find($id);
        $rideData = RideData::where("ride_id", $rideAuth->id)->first();

        $drive_id =  intval(Session::get("drive_id"));

        $driveAuth = DriveAuth::findorfail($drive_id);
        $driveData = DriveData::where("drive_id", $drive_id)->first();

        $driveData->ride_accepted = true;

        $driveData->on_trip_ride_id = $rideAuth->id;

        $charges = json_decode($driveData->trip_charge, true);

        $charges[$rideAuth->id] = $req->charge;
        
        $driveData->trip_charge = json_encode($charges);

        $driveData->save();

        $driveData->ride_from = $rideData->ridefrom;
        $driveData->ride_to = $rideData->rideto;

        $rideData->drive_accepted = true;

        $rideData->on_trip_drive_id = $driveAuth->id;

        $rideData->save();

        return redirect("/drive/dashboard");
    }

    public function driveOfferAccept(Request $req, $id){
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
    }

    public function driveOnTrip(Request $req, $id){
        $rideAuth = RideAuth::find($id);
        $rideData = RideData::where("ride_id", $rideAuth->id)->first();

        $drive_id =  intval(Session::get("drive_id"));

        $driveAuth = DriveAuth::findorfail($drive_id);
        $driveData = DriveData::where("drive_id", $drive_id)->first();

        $rideData->on_trip = true;
        $driveData->on_trip = true;

        $rideData->on_trip_drive_id = $driveAuth->id;
        $driveData->on_trip_ride_id = $rideAuth->id;

        $rideData->ride_balance -= intval($req->charges);

        if($rideData->ride_balance < 1){
            $rideData->ride_balance = 0.00;
        }

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

        $driveData->on_trip = false;
        $driveData->ride_accepted = false;
        $driveData->confirm_pickup = false;

        $rideRequests = json_decode($driveData->ride_requests, true);

        $updatedRideRquests = array();
        foreach($rideRequests as $rideRequestID){
            if($rideRequestID != $rideAuth->id){
                $updatedRideRquests[] = $rideRequestID;
            }
        }

        $driveData->ride_requests = json_encode($updatedRideRquests);

        $allHistory = json_decode($driveData->drive_history_ride_id, true);

        $allHistory[$rideAuth->id] = array(
            "ride_from" => $rideData->ride_from,
            "ride_to" => $rideData->ride_to,
        );

        $driveData->drive_history_ride_id = json_encode($allHistory);


        $driveData->save();

        $rideData->on_trip = false;
        $rideData->drive_accepted = false;
        $rideData->pick_up_requested = false;
        
        $rideRequests = json_decode($rideData->drive_requests, true);

        $updatedRideRquests = array();
        foreach($rideRequests as $rideRequestID){
            if($rideRequestID != $driveAuth->id){
                $updatedRideRquests[] = $rideRequestID;
            }
        }

        $rideData->drive_requests = json_encode($updatedRideRquests);

        $allHistory = json_decode($rideData->ride_history_drive_id, true);

        $allHistory[] = $driveAuth->id;

        $rideData->ride_history_drive_id = json_encode($allHistory);

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

        return view("drive_view_ride_plans", [
            "rideAuth" => $rideAuth,
            "rideData" => $rideData,
            "driveAuth" => $driveAuth,
            "driveData" => $driveData,
        ]);
    }

    public function driveOfferIndex(Request $req, $id){
        if(! Session::has("hasLogged")){
            return redirect("/signin");
        }
        $rideAuth = RideAuth::find($id);
        $rideData = RideData::where("ride_id", $rideAuth->id)->first();

        $drive_id =  intval(Session::get("drive_id"));

        $driveAuth = DriveAuth::findorfail($drive_id);
        $driveData = DriveData::where("drive_id", $drive_id)->first();

        $drive_offer_ride_from = $req->ridefrom;
        $drive_offer_ride_to = $req->rideto;
        $drive_offer_ride_date_time = $req->ridedatetime;
        $plan_id = $req->planid;

        return view("drive_offer", [
            "rideAuth" => $rideAuth,
            "rideData" => $rideData,
            "driveAuth" => $driveAuth,
            "driveData" => $driveData,
            "drive_offer_ride_from" => $drive_offer_ride_from,
            "drive_offer_ride_to" => $drive_offer_ride_to,
            "drive_offer_ride_date_time" => $drive_offer_ride_date_time,
            "plan_id" => $plan_id,
        ]);
    }



    public function ridePlans(Request $req){
        $ride_id =  intval(Session::get("ride_id"));

        $rideAuth = RideAuth::findorfail($ride_id);
        $rideData = RideData::where("ride_id", $ride_id)->first();

        $rideData->riding_later = true;

        $allPlans = json_decode($rideData->ride_plans, true);

        $allPlans[$rideData->ride_later_track] = array(
            "riding_later_from" => $req->ridinglaterfrom,
            "riding_later_to" => $req->ridinglaterto,
            "riding_later_date" => $req->ridinglaterdate,
            "riding_later_time" => $req->ridinglatertime,
            "riding_later_meridiem" => $req->ridinglatermeridiem,
        );

        $rideData->ride_plans = json_encode($allPlans);

        $rideData->ride_later_track += 1;

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

        $driveData->on_trip = false;

        $rideRequests = json_decode($driveData->ride_requests, true);

        $updatedRideRquests = array();
        foreach($rideRequests as $rideRequestID){
            if($rideRequestID != $rideAuth->id){
                $updatedRideRquests[] = $rideRequestID;
            }
        }

        $driveData->ride_requests = json_encode($updatedRideRquests);

        $allHistory = json_decode($driveData->drive_history_ride_id, true);

        $allHistory[$rideAuth->id] = array(
            "ride_from" => $rideData->ride_from,
            "ride_to" => $rideData->ride_to,
        );

        $driveData->drive_history_ride_id = json_encode($allHistory);

        $driveData->save();

        $rideData->on_trip = false;

        $allHistory = json_decode($rideData->ride_history_drive_id, true);

        $allHistory[] = $driveAuth->id;

        $rideData->ride_history_drive_id = json_encode($allHistory);

        $rideRequests = json_decode($rideData->drive_requests, true);
    
        $updatedRideRquests = array();
        foreach($rideRequests as $rideRequestID){
            if($rideRequestID != $driveAuth->id){
                $updatedRideRquests[] = $rideRequestID;
            }
        }


        $rideData->drive_requests = json_encode($updatedRideRquests);

        $rideData->save();

        return view("ride_ratings", [
            "driveAuth" => $driveAuth,
            "driveData" => $driveData,
        ]);;
    }

    public function rideRequestIndex($id){
        if(! Session::has("hasLogged")){
            return redirect("/signin");
        }
        
        $driveAuth = DriveAuth::find($id);
        $driveData = DriveData::where("drive_id", $driveAuth->id)->first();

        return view("ride_request", [
            "driveAuth" => $driveAuth,
            "driveData" => $driveData,
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

        $charges = 0;

        foreach(json_decode($driveData->trip_charge) as $k => $v){
            if($k == $rideAuth->id){
                $charges = $v;
            }
        }

        return view("ride_request_accepted", [
            "driveAuth" => $driveAuth,
            "driveData" => $driveData,
            "rideAuth" => $rideAuth,
            "rideData" => $rideData,
            "charges" => $charges,
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

        $charges = 0;

        foreach(json_decode($driveData->trip_charge) as $k => $v){
            if($k == $rideAuth->id){
                $charges = $v;
            }
        }

        return view("drive_request_accepted", [
            "driveAuth" => $driveAuth,
            "driveData" => $driveData,
            "rideAuth" => $rideAuth,
            "rideData" => $rideData,
            "charges" => $charges,
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

        $driveRequests = json_decode($rideData->drive_requests, true);
        $driveRequests[] = $driveAuth->id;

        $rideData->drive_requests = json_encode($driveRequests);

        $rideRequests = json_decode($driveData->ride_requests, true);
        $rideRequests[] = $ride_id;

        $driveData->ride_requests = json_encode($rideRequests);

        $driveData->save();

        $rideData->ride_from = ucwords($req->ridefrom);
        $rideData->ride_to = ucwords($req->rideto);

        $rideData->save();

        return redirect("/ride/dashboard");
    }
}
