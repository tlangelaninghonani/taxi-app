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
        return view("drive_signin");
    }

    public function driveSignin(Request $req){
        Session::flush();

        $firstName = ucwords($req->firstname);
        $lastName = ucwords($req->lastname);

        $drive = driveAuth::where("drive_first_name", $firstName)->where("drive_last_name", $lastName)->first();
        if($drive){
            if(Hash::check($req->password, $drive->drive_password)){
                Session::put("drive_id", $drive->id);
                Session::put("hasLogged", true);
                return redirect("/drive/dashboard");
            }
            
        }
    }

    public function rideSigninIndex(){
        return view("ride_signin");
    }

    public function rideSignin(Request $req){
        Session::flush();

        $firstName = ucwords($req->firstname);
        $lastName = ucwords($req->lastname);

        $ride = RideAuth::where("ride_first_name", $firstName)->where("ride_last_name", $lastName)->first();
        if($ride){
            if(Hash::check($req->password, $ride->ride_password)){
                Session::put("ride_id", $ride->id);
                Session::put("hasLogged", true);
                return redirect("/ride/dashboard");
            }
            
        }
        
    }
}
