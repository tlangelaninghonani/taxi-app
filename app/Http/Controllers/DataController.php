<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use App\Models\RideAuth;
use App\Models\DriveAuth;
use App\Models\RideData;
use App\Models\DriveData;
use App\Models\Chat;
use App\Models\RideRequest;
use App\Models\History;
use App\Models\Review;
use App\Models\Plan;
use App\Models\Offer;
use App\Models\Notification;

class DataController extends Controller
{

    public function driveReviewView($id){

        $review = Review::find($id);

        $driveAuth = DriveAuth::findorfail($review->drive_id);
        $driveData = DriveData::where("drive_id", $driveAuth->id)->first();

        $rideAuth = RideAuth::find($review->ride_id);
        $rideData = RideData::where("ride_id", $rideAuth->id)->first();

        return view("drive_review_view", [
            "driveAuth" => $driveAuth,
            "driveData" => $driveData,
            "rideAuth" => $rideAuth,
            "rideData" => $rideData,
            "review" => $review
        ]);
    }
    public function driveReviewsIndex(){
        $drive_id =  intval(Session::get("drive_id"));

        $driveAuth = DriveAuth::findorfail($drive_id);
        $driveData = DriveData::where("drive_id", $drive_id)->first();

        return view("drive_reviews", [
            "driveAuth" => $driveAuth,
            "driveData" => $driveData,
            "rideAuth" => new RideAuth(),
            "rideData" => new RideData(),
            "reviews" => new Review(),
        ]);
    }

    public function rate(Request $req, $id){
        $request = RideRequest::find($id);

        $driveAuth = DriveAuth::find($request->drive_id);
        $driveData = DriveData::where("drive_id", $driveAuth->id)->first();

        $rideAuth = RideAuth::findorfail($request->ride_id);
        $rideData = RideData::where("ride_id", $rideAuth->id)->first();

        $review = new Review();
        $review->drive_id = $request->drive_id;
        $review->ride_id = $request->ride_id;
        $review->ride_from = $request->ride_from;
        $review->ride_to = $request->ride_to;
        $review->ride_from_lat = $request->ride_from_lat;
        $review->ride_from_lng = $request->ride_from_lng;
        $review->ride_to_lat = $request->ride_to_lat;
        $review->ride_to_lng = $request->ride_to_lng;
        $review->ride_distance = $request->ride_distance;
        $review->ride_duration = $request->ride_duration;
        $review->ride_charges = $request->ride_charges;
        
        $reviews = Review::where("drive_id", $driveAuth->id)->get();

        if(sizeof($reviews) > 0){
            $ratings = 0;
            foreach($reviews as $review){
                $ratings += $review->ratings;
            }
            $totalRatings = intval(floor($ratings/sizeof($reviews)));
            $review->ratings = $req->ratings;
            $driveData->drive_ratings = $totalRatings;
        }else{
            $review->ratings = $req->ratings;
            $driveData->drive_ratings = $req->ratings;
        }
        $review->comment = $req->comment;

        $review->save();
        $driveData->save();

        DB::table("ride_requests")->where("id", $request->id)->delete();

        return redirect("/ride/dashboard");
    }
    public function driveRequestIndex($id){
        if(! Session::has("hasLogged")){
            return redirect("/signin");
        }

        $request = RideRequest::find($id);

        $driveAuth = DriveAuth::findorfail($request->drive_id);
        $driveData = DriveData::where("drive_id", $driveAuth->id)->first();

        $rideAuth = RideAuth::find($request->ride_id);
        $rideData = RideData::where("ride_id", $rideAuth->id)->first();


        return view("drive_request", [
            "rideAuth" => $rideAuth,
            "rideData" => $rideData,
            "request" => $request,
        ]);
    }

    public function driveRequestAccept($id){
        
        $request = RideRequest::find($id);

        $rideAuth = RideAuth::find($request->ride_id);
        $rideData = RideData::where("ride_id", $rideAuth->id)->first();

        $drive_id =  intval(Session::get("drive_id"));

        $driveAuth = DriveAuth::findorfail($drive_id);
        $driveData = DriveData::where("drive_id", $drive_id)->first();

        $request = RideRequest::find($id);
        $request->ride_accepted = true;


        $request->save();


        return redirect("/drive/dashboard");
    }

    public function rideRequestChats(Request $req, $id){
        $driveAuth = DriveAuth::find($id);
        $driveData = DriveData::where("drive_id", $driveAuth->id)->first();

        $ride_id =  intval(Session::get("ride_id"));

        $rideAuth = RideAuth::findorfail($ride_id);
        $rideData = RideData::where("ride_id", $ride_id)->first();

        

        return back();
    }

    public function driveOnTrip($id){
        $request = RideRequest::find($id);
        $rideData = RideData::where("ride_id", $request->ride_id)->first();
        $driveData = DriveData::where("drive_id", $request->drive_id)->first();

        $rideData->ride_on_trip = true;
        $driveData->drive_on_trip = true;

        $request->on_trip = true;

        $request->save();

        $rideData->save();
        $driveData->save();

        return redirect("/drive/dashboard");
    }

    public function driveRequestTripEnd($id){

        $request = RideRequest::find($id);
        
        $driveData = DriveData::where("drive_id", $request->drive_id)->first();

 
        $driveData->drive_on_trip = false;

        $driveData->save();
        

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
            "plans" => new Plan(),
        ]);
    }

    public function ridePlanIndex($id){
        if(! Session::has("hasLogged")){
            return redirect("/signin");
        }
        $ride_id =  intval(Session::get("ride_id"));

        $rideAuth = RideAuth::findorfail($ride_id);
        $rideData = RideData::where("ride_id", $ride_id)->first();

        $plan = Plan::find($id);

        return view("ride_view_plan", [
            "rideAuth" => $rideAuth,
            "rideData" => $rideData,
            "plan" => $plan
        ]);
    }

    public function ridePlanCancel($id){
        DB::table("plans")->where("id", $id)->delete();

        return redirect("/ride/plans");
    }

    public function driveOffersIndex(){
        if(! Session::has("hasLogged")){
            return redirect("/signin");
        }
        $drive_id =  intval(Session::get("drive_id"));

        $driveAuth = DriveAuth::findorfail($drive_id);
        $driveData = DriveData::where("drive_id", $drive_id)->first();

        return view("drive_offers", [
            "driveAuth" => $driveAuth,
            "driveData" => $driveData,
            "rideAuth" => new RideAuth(),
            "rideData" => new RideData(),
            "offers" => new Offer(),
            
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
            "offers" => new Offer(),
        ]);
    }

    public function driveRidersPlansIndex($id){
        if(! Session::has("hasLogged")){
            return redirect("/signin");
        }

        $plan = Plan::find($id);

        $rideAuth = RideAuth::find($plan->ride_id);
        $rideData = RideData::where("ride_id", $rideAuth->id)->first();

        $drive_id =  intval(Session::get("drive_id"));

        $driveAuth = DriveAuth::findorfail($drive_id);
        $driveData = DriveData::where("drive_id", $drive_id)->first();

        return view("drive_view_ride_plans", [
            "rideAuth" => $rideAuth,
            "rideData" => $rideData,
            "driveAuth" => $driveAuth,
            "driveData" => $driveData,
            "plan" => $plan,
            "offers" => new Offer(),
        ]);
    }

    public function driveOffer($id){

        if(! Session::has("hasLogged")){
            return redirect("/signin");
        }
        $plan = Plan::find($id);

        $rideAuth = RideAuth::find($plan->ride_id);
        $rideData = RideData::where("ride_id", $rideAuth->id)->first();

        $drive_id =  intval(Session::get("drive_id"));

        $driveAuth = DriveAuth::findorfail($drive_id);
        $driveData = DriveData::where("drive_id", $drive_id)->first();

        $request = new RideRequest();
        $request->drive_id = $driveAuth->id;
        $request->ride_id = $rideAuth->id;
        $request->ride_from = $plan->ride_from;
        $request->ride_to = $plan->ride_to;
        $request->ride_from_lat = $plan->ride_from_lat;
        $request->ride_from_lng = $plan->ride_from_lng;
        $request->ride_to_lat = $plan->ride_to_lat;
        $request->ride_to_lng = $plan->ride_to_lng;
        $request->ride_distance = $plan->ride_distance;
        $request->ride_duration = $plan->ride_duration;
        $request->ride_charges = $plan->ride_charges;
        $request->ride_accepted = true;
        $request->save();
 
        $offer = new Offer();
        $offer->request_id = $request->id;
        $offer->plan_id = $plan->id;
        $offer->drive_id = $driveAuth->id;
        $offer->ride_id = $plan->ride_id;
        $offer->ride_from = $plan->ride_from;
        $offer->ride_to = $plan->ride_to;
        $offer->ride_from_lat = $plan->ride_from_lat;
        $offer->ride_from_lng = $plan->ride_from_lng;
        $offer->ride_to_lat = $plan->ride_to_lat;
        $offer->ride_to_lng = $plan->ride_to_lng;
        $offer->ride_distance = $plan->ride_distance;
        $offer->ride_duration = $plan->ride_duration;
        $offer->ride_charges = $plan->ride_charges;
        $offer->ride_time = $plan->ride_time;
        $offer->ride_date = $plan->ride_date;
        $offer->ride_meridiem = $plan->ride_meridiem;

        $offer->save();

        return redirect("/drive/offers");
    }

    public function driveOfferCancel($id){
        $offer = Offer::find($id);
        DB::table("offers")->where("id", $id)->delete();
        DB::table("ride_requests")->where("id", $offer->request_id)->delete();
        return redirect("/drive/offers");
    }

    public function ridePlans(Request $req){
        $ride_id =  intval(Session::get("ride_id"));

        $rideAuth = RideAuth::findorfail($ride_id);
        $rideData = RideData::where("ride_id", $ride_id)->first();

        $plan = new Plan();
        $plan->ride_id = $rideAuth->id;
        $plan->ride_from = ucwords($req->ridefrom);
        $plan->ride_to= ucwords($req->rideto);
        $plan->ride_from_lat = json_decode($req->ridefromcoords, true)["lat"];
        $plan->ride_from_lng = json_decode($req->ridefromcoords, true)["lng"];
        $plan->ride_to_lat = json_decode($req->ridetocoords, true)["lat"];
        $plan->ride_to_lng = json_decode($req->ridetocoords, true)["lng"];
        $plan->ride_distance = $req->ridedistance;
        $plan->ride_duration = $req->rideduration;
        $plan->ride_charges = $req->ridecharges;
        $plan->ride_meridiem = $req->ridemeridiem;
        $plan->ride_date = $req->ridedate;
        $plan->ride_time = $req->ridetime;

        $plan->save();

        $rideData->save();

        return back();
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
            "history" => new History,
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
            "rideAuth" => new RideAuth(),
            "rideData" => new RideData(),
            "driveAuth" => $driveAuth,
            "driveData" => $driveData,
            "history" => new History,
        ]);
    }

    public function ridersIndex(){
        if(! Session::has("hasLogged")){
            return redirect("/signin");
        }

        return view("drive_riders", [
            "rideAuth" => new RideAuth(),
            "rideData" => new RideData(),
            "plans" => new Plan()
        ]);
    }

    public function rideRequestTripEnd(Request $req, $id){
        $request = RideRequest::find($id);

        $driveAuth = DriveAuth::find($request->drive_id);
        $driveData = DriveData::where("drive_id", $driveAuth->id)->first();

        $rideAuth = RideAuth::findorfail($request->ride_id);
        $rideData = RideData::where("ride_id", $rideAuth->id)->first();

        if($req->method() == "GET" && $rideData->ride_on_trip == false){
            return abort(404);
        }

        $history = new History();
        $history->drive_id = $request->drive_id;
        $history->ride_id = $request->ride_id;
        $history->ride_from = $request->ride_from;
        $history->ride_to = $request->ride_to;
        $history->ride_from_lat = $request->ride_from_lat;
        $history->ride_from_lng = $request->ride_from_lng;
        $history->ride_to_lat = $request->ride_to_lat;
        $history->ride_to_lng = $request->ride_to_lng;
        $history->ride_distance = $request->ride_distance;
        $history->ride_duration = $request->ride_duration;
        $history->ride_charges = $request->ride_charges;
        $history->save();

        $rideData->ride_on_trip = false;
        $driveData->drive_on_trip = false;

        $rideData->save();
        $driveData->save();

        return view("ride_ratings", [
            "driveAuth" => $driveAuth,
            "driveData" => $driveData,
            "trip" => $request,
        ]);;
    }

    public function rideProfileIndex(Request $req){
        if(! Session::has("hasLogged")){
            return redirect("/signin");
        }
        $ride_id =  intval(Session::get("ride_id"));

        $rideAuth = RideAuth::findorfail($ride_id);
        $rideData = RideData::where("ride_id", $ride_id)->first();

        return view("ride_profile", [
            "rideAuth" => $rideAuth,
            "rideData" => $rideData,
        ]);
    }

    public function rideProfilePictureEdit(Request $req){
        $ride_id =  intval(Session::get("ride_id"));

        $rideAuth = RideAuth::findorfail($ride_id);
        $rideData = RideData::where("ride_id", $ride_id)->first();

        if($req->file("image")){
            $file = $req->file("image");
            $uniqueFileName = uniqid().$file->getClientOriginalName();
            $file->move("storage/ride/profile", $uniqueFileName);
            $rideData->ride_profile_image = "/storage/ride/profile/$uniqueFileName";
        }else{
            $rideData->ride_profile_image = "";  
        }

        $rideData->save();

        return back();
    }

    public function driveProfilePictureEdit(Request $req){
        
        $drive_id =  intval(Session::get("drive_id"));

        $driveAuth = DriveAuth::findorfail($drive_id);
        $driveData = DriveData::where("drive_id", $drive_id)->first();

        if($req->file("image")){
            $file = $req->file("image");
            $uniqueFileName = uniqid().$file->getClientOriginalName();
            $file->move("storage/drive/profile", $uniqueFileName);
            $driveData->drive_profile_image = "/storage/drive/profile/$uniqueFileName";
        }else{
            $driveData->drive_profile_image = "";  
        }

        $driveData->save();

        return back();
    }

    public function rideProfileUpdate(Request $req){
        $ride_id =  intval(Session::get("ride_id"));

        $rideAuth = RideAuth::findorfail($ride_id);
        $rideData = RideData::where("ride_id", $ride_id)->first();

        $rideAuth->ride_first_name = $req->firstname;
        $rideAuth->ride_last_name = $req->lastname;
        $rideAuth->ride_phone = $req->phone;
        
        $rideAuth->save();

        return back();
    }

    public function driveProfileIndex(Request $req){
        if(! Session::has("hasLogged")){
            return redirect("/signin");
        }
        $drive_id =  intval(Session::get("drive_id"));

        $driveAuth = DriveAuth::findorfail($drive_id);
        $driveData = DriveData::where("drive_id", $drive_id)->first();

        return view("drive_profile", [
            "driveAuth" => $driveAuth,
            "driveData" => $driveData,
        ]);;
    }

    public function driveProfileUpdate(Request $req){
        $drive_id =  intval(Session::get("drive_id"));

        $driveAuth = DriveAuth::findorfail($drive_id);
        $driveData = DriveData::where("drive_id", $drive_id)->first();

        $driveAuth->drive_first_name = $req->firstname;
        $driveAuth->drive_last_name = $req->lastname;

        $driveData->drive_vehicle = $req->vehiclename;
        $driveData->drive_vehicle_type = $req->vehicletype;
        
        $driveAuth->save();
        $driveData->save();

        return back();
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

        $request = RideRequest::find($id);

        $driveAuth = DriveAuth::findorfail($request->drive_id);
        $driveData = DriveData::where("drive_id", $driveAuth->id)->first();

        $rideAuth = RideAuth::find($request->ride_id);
        $rideData = RideData::where("ride_id", $rideAuth->id)->first();
       

        if($rideData->ride_on_trip == true){
            return redirect("/ride/dashboard");
        }

        return view("ride_request_accepted", [
            "driveAuth" => $driveAuth,
            "driveData" => $driveData,
            "rideAuth" => $rideAuth,
            "rideData" => $rideData,
            "request" => $request,
        ]);
    }

    public function rideRequestPendingIndex($id){
        if(! Session::has("hasLogged")){
            return redirect("/signin");
        }
        
        $request = RideRequest::find($id);

        $driveAuth = DriveAuth::findorfail($request->drive_id);
        $driveData = DriveData::where("drive_id", $driveAuth->id)->first();

        $rideAuth = RideAuth::find($request->ride_id);
        $rideData = RideData::where("ride_id", $rideAuth->id)->first();

        $request = RideRequest::find($id);

        return view("ride_request_pending", [
            "driveAuth" => $driveAuth,
            "driveData" => $driveData,
            "rideAuth" => $rideAuth,
            "rideData" => $rideData,
            "request" => $request,
        ]);
    }

    public function driveChatsIndex(){
        if(! Session::has("hasLogged")){
            return redirect("/signin");
        }

        $drive_id =  intval(Session::get("drive_id"));

        $driveAuth = DriveAuth::findorfail($drive_id);
        $driveData = DriveData::where("drive_id", $drive_id)->first();


        return view("drive_chats", [
            "rideAuth" => new RideAuth(),
            "rideData" => new RideData(),
            "driveAuth" => $driveAuth,
            "driveData" => $driveData,
            "history" => new History(),
            "requests" => new RideRequest(),
        ]);
    }

    public function driveChatIndex($id){
        $rideAuth = RideAuth::find($id);
        $rideData = RideData::where("ride_id", $rideAuth->id)->first();

        $drive_id =  intval(Session::get("drive_id"));

        $driveAuth = DriveAuth::findorfail($drive_id);
        $driveData = DriveData::where("drive_id", $drive_id)->first();


        return view("drive_chat", [
            "driveAuth" => $driveAuth,
            "driveData" => $driveData,
            "rideAuth" => $rideAuth,
            "rideData" => $rideData,
            "chats" => new Chat(),
        ]);
    }

    public function rideChatsIndex(){
        if(! Session::has("hasLogged")){
            return redirect("/signin");
        }

        $ride_id =  intval(Session::get("ride_id"));

        $rideAuth = RideAuth::findorfail($ride_id);
        $rideData = RideData::where("ride_id", $ride_id)->first();


        return view("ride_chats", [
            "driveAuth" => new DriveAuth(),
            "driveData" => new DriveData(),
            "rideAuth" => $rideAuth,
            "rideData" => $rideData,
            "history" => new History(),
            "requests" => new RideRequest(),
        ]);
    }

    public function rideChatIndex($id){
        $driveAuth = DriveAuth::find($id);
        $driveData = DriveData::where("drive_id", $driveAuth->id)->first();

        $ride_id =  intval(Session::get("ride_id"));

        $rideAuth = RideAuth::findorfail($ride_id);
        $rideData = RideData::where("ride_id", $ride_id)->first();


        return view("ride_chat", [
            "driveAuth" => $driveAuth,
            "driveData" => $driveData,
            "rideAuth" => $rideAuth,
            "rideData" => $rideData,
            "chats" => new Chat(),
        ]);
    }

    public function rideChat(Request $req, $id){
        $driveAuth = DriveAuth::find($id);
        $driveData = DriveData::where("drive_id", $driveAuth->id)->first();

        $ride_id =  intval(Session::get("ride_id"));

        $rideAuth = RideAuth::findorfail($ride_id);
        $rideData = RideData::where("ride_id", $ride_id)->first();

        $chat = new Chat();
        $chat->drive_id = $driveAuth->id;
        $chat->ride_id = $rideAuth->id;
        $chat->from = "ride";
        $chat->chat = $req->chat;
        $chat->save();
    }

    public function driveChat(Request $req, $id){
        $rideAuth = RideAuth::find($id);
        $rideData = RideData::where("ride_id", $rideAuth->id)->first();

        $drive_id =  intval(Session::get("drive_id"));

        $driveAuth = DriveAuth::findorfail($drive_id);
        $driveData = DriveData::where("drive_id", $drive_id)->first();

        $chat = new Chat();
        $chat->drive_id = $driveAuth->id;
        $chat->ride_id = $rideAuth->id;
        $chat->from = "drive";
        $chat->chat = $req->chat;
        $chat->save();
    }

    public function driveRequestAcceptedIndex($id){
        
        if(! Session::has("hasLogged")){
            return redirect("/signin");
        }
        
        $request = RideRequest::find($id);

        $driveAuth = DriveAuth::findorfail($request->drive_id);
        $driveData = DriveData::where("drive_id", $driveAuth->id)->first();

        $rideAuth = RideAuth::find($request->ride_id);
        $rideData = RideData::where("ride_id", $rideAuth->id)->first();

        return view("drive_request_accepted", [
            "driveAuth" => $driveAuth,
            "driveData" => $driveData,
            "rideAuth" => $rideAuth,
            "rideData" => $rideData,
            "request" => $request,
        ]);
    }

    public function rideRequestPickup($id){
        $driveAuth = DriveAuth::find($id);
        $driveData = DriveData::where("drive_id", $driveAuth->id)->first();

        $ride_id =  intval(Session::get("ride_id"));

        $rideAuth = RideAuth::findorfail($ride_id);
        $rideData = RideData::where("ride_id", $ride_id)->first();

        $request = RideRequest::find($id);
        $request->pick_up_requested = true;

        $request->save();

        return back();
    }

    public function driveConfirmPickup($id){
        $rideAuth = RideAuth::find($id);
        $rideData = RideData::where("ride_id", $rideAuth->id)->first();

        $drive_id =  intval(Session::get("drive_id"));

        $driveAuth = DriveAuth::findorfail($drive_id);
        $driveData = DriveData::where("drive_id", $drive_id)->first();

        $request = RideRequest::find($id);
        $request->pick_up_confirmed = true;

        $request->save();

        return back();
    }

    public function rideRequest(Request $req, $id){
        $driveAuth = DriveAuth::find($id);
        $driveData = DriveData::where("drive_id", $driveAuth->id)->first();

        $ride_id =  intval(Session::get("ride_id"));

        $rideAuth = RideAuth::findorfail($ride_id);
        $rideData = RideData::where("ride_id", $ride_id)->first();

        $rideRequest = new RideRequest();
        $rideRequest->drive_id = $driveAuth->id;
        $rideRequest->ride_id = $rideAuth->id;
        $rideRequest->ride_from = ucwords($req->ridefrom);
        $rideRequest->ride_to = ucwords($req->rideto);
        $rideRequest->ride_from_lat = json_decode($req->ridefromcoords, true)["lat"];
        $rideRequest->ride_from_lng = json_decode($req->ridefromcoords, true)["lng"];
        $rideRequest->ride_to_lat = json_decode($req->ridetocoords, true)["lat"];
        $rideRequest->ride_to_lng = json_decode($req->ridetocoords, true)["lng"];
        $rideRequest->ride_distance = $req->ridedistance;
        $rideRequest->ride_duration = $req->rideduration;
        $rideRequest->ride_charges = $req->ridecharges;

        $rideRequest->save();

        return redirect("/ride/dashboard");
    }

    public function rideRequestCancel($id){
        DB::table("ride_requests")->where("id", $id)->delete();

        return redirect("/ride/dashboard");
    }
}
