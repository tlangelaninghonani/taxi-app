<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use App\Models\RideAuth;
use App\Models\DriveAuth;
use App\Models\RideData;
use App\Models\DriveData;

class SigninController extends Controller
{
    public function index(){
        return view("signin");
    }

    public function driveSigninIndex(){
        if(Session::has("drive_id")){
            return redirect("/drive/dashboard");
        }
        return view("drive_signin");
    }

    public function driveSignin(Request $req){
        Session::flush();

        $drive = driveAuth::where("drive_phone", $req->phone)->first();
        if($drive){
            if(Hash::check($req->password, $drive->drive_password)){
                Session::put("drive_id", $drive->id);
                Session::put("hasLogged", true);
                return redirect("/drive/dashboard");
            }
            
        }
        Session::put("error", true);
        return back();
    }

    public function rideSigninIndex(){
        if(Session::has("ride_id")){
            return redirect("/ride/dashboard");
        }
        return view("ride_signin");
    }

    public function rideSignin(Request $req){
        Session::flush();

        $ride = RideAuth::where("ride_phone", $req->phone)->first();
        if($ride){
            if(Hash::check($req->password, $ride->ride_password)){
                Session::put("ride_id", $ride->id);
                Session::put("hasLogged", true);
                return redirect("/ride/dashboard");
            }
            
        }
        Session::put("error", true);
        return back();
    }
}
