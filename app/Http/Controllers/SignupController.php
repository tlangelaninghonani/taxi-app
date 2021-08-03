<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RideAuth;
use App\Models\RideData;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class SignupController extends Controller
{
    public function ridePersonalIndex(){
        return view("ride_signup_personal");
    }

    public function ridePersonal(Request $req){
        Session::put("firstname", ucwords($req->firstname));
        Session::put("lastname", ucwords($req->lastname));
        Session::put("phone", $req->phone);
        Session::put("gender", ucwords($req->gender));
        if(RideAuth::where("ride_first_name", Session::get("firstname"))
        ->where("ride_last_name", Session::get("lastname"))
        ->where("ride_phone", $req->phone)->exists()){
            Session::put("error", true);
            return back();
        }
        if(RideAuth::where("ride_phone", $req->phone)->exists()){
            Session::put("error", true);
            return back();
        }
        return view("ride_signup_password");
    }

    public function rideSignup(Request $req){
        $ride = new RideAuth();
        $ride->ride_first_name = Session::get("firstname");
        $ride->ride_last_name = Session::get("lastname");
        $ride->ride_phone = Session::get("phone");
        $ride->ride_gender = Session::get("gender");
        $ride->ride_password = Hash::make($req->password);

        $ride->save();

        $rideData = new RideData();
        $rideData->ride_id = $ride->id;
        $rideData->ride_profile_image = "";
        $rideData->ride_balance = 0.00;

        $rideData->save();

        Session::put("ride_id", $ride->id);
        Session::put("hasLogged", true);
        return redirect("/ride/dashboard");
    }
}
