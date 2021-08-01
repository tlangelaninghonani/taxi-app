<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get("/signout", function(){
    Session::flush();
    return redirect("/");
});

Route::get("/signin", [App\Http\Controllers\SigninController::class, "index"]);

Route::get("/drive/dashboard", [App\Http\Controllers\DriveDashboardController::class, "index"]);
Route::get("/drive/signin", [App\Http\Controllers\SigninController::class, "driveSigninIndex"]);
Route::post("/drive/signin", [App\Http\Controllers\SigninController::class, "driveSignin"]);
Route::get("/drive/{id}/request", [App\Http\Controllers\DataController::class, "driveRequestIndex"]);
Route::post("/drive/{id}/request/accept", [App\Http\Controllers\DataController::class, "driveRequestAccept"]);
Route::post("/drive/{id}/request/trip/end", [App\Http\Controllers\DataController::class, "driveRequestTripEnd"]);
Route::get("/drive/riders", [App\Http\Controllers\DataController::class, "ridersIndex"]);
Route::get("/drive/history", [App\Http\Controllers\DataController::class, "driveHistoryIndex"]);
Route::get("/drive/{id}/request/accepted", [App\Http\Controllers\DataController::class, "driveRequestAcceptedIndex"]);
Route::post("/drive/{id}/request/pickup/confirm", [App\Http\Controllers\DataController::class, "driveConfirmPickup"]);
Route::post("/drive/{id}/request/trip/start", [App\Http\Controllers\DataController::class, "driveOnTrip"]);
Route::get("/drive/riders/{id}/plans", [App\Http\Controllers\DataController::class, "driveRidersPlansIndex"]);
Route::post("/drive/{id}/{planCounter}/offer", [App\Http\Controllers\DataController::class, "driveOffer"]);
//Route::post("/drive/{id}/offer/accept", [App\Http\Controllers\DataController::class, "driveOfferAccept"]);
Route::get("/drive/profile", [App\Http\Controllers\DataController::class, "driveProfileIndex"]);
Route::post("/drive/profile/update", [App\Http\Controllers\DataController::class, "driveProfileUpdate"]);


Route::get("/ride/dashboard", [App\Http\Controllers\RideDashboardController::class, "index"]);
Route::get("/ride/signin", [App\Http\Controllers\SigninController::class, "rideSigninIndex"]);
Route::post("/ride/signin", [App\Http\Controllers\SigninController::class, "rideSignin"]);
Route::get("/ride/{id}/request", [App\Http\Controllers\DataController::class, "rideRequestIndex"]);
Route::post("/ride/{id}/request", [App\Http\Controllers\DataController::class, "rideRequest"]);
Route::match(array("POST", "GET"), "/ride/{id}/request/trip/end", [App\Http\Controllers\DataController::class, "rideRequestTripEnd"]);
Route::get("/ride/{id}/rate", [App\Http\Controllers\DataController::class, "rateIndex"]);
Route::post("/ride/{id}/rate", [App\Http\Controllers\DataController::class, "rate"]);
Route::get("/ride/drivers", [App\Http\Controllers\DataController::class, "driversIndex"]);
Route::get("/ride/plans", [App\Http\Controllers\DataController::class, "ridePlansIndex"]);
Route::post("/ride/plans", [App\Http\Controllers\DataController::class, "ridePlans"]);
Route::get("/ride/history", [App\Http\Controllers\DataController::class, "rideHistoryIndex"]);
Route::get("/ride/{id}/request/accepted", [App\Http\Controllers\DataController::class, "rideRequestAcceptedIndex"]);
Route::post("/ride/{id}/request/pickup", [App\Http\Controllers\DataController::class, "rideRequestPickup"]);
Route::get("/ride/offers", [App\Http\Controllers\DataController::class, "rideOffersIndex"]);
Route::get("/ride/profile", [App\Http\Controllers\DataController::class, "rideProfileIndex"]);
Route::post("/ride/profile/update", [App\Http\Controllers\DataController::class, "rideProfileUpdate"]);


















