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
Route::get("/drive/{id}/request/instant", [App\Http\Controllers\DataController::class, "driveRequestInstantIndex"]);
Route::post("/drive/{id}/request/instant/accept", [App\Http\Controllers\DataController::class, "driveRequestInstantAccept"]);
Route::post("/drive/{id}/request/accept", [App\Http\Controllers\DataController::class, "driveRequestAccept"]);
Route::post("/drive/{id}/request/trip/end", [App\Http\Controllers\DataController::class, "driveRequestTripEnd"]);
Route::get("/drive/riders", [App\Http\Controllers\DataController::class, "ridersIndex"]);
Route::get("/drive/history", [App\Http\Controllers\DataController::class, "driveHistoryIndex"]);
Route::get("/drive/{id}/request/accepted", [App\Http\Controllers\DataController::class, "driveRequestAcceptedIndex"]);
Route::post("/drive/{id}/request/pickup/confirm", [App\Http\Controllers\DataController::class, "driveConfirmPickup"]);
Route::post("/drive/{id}/request/trip/start", [App\Http\Controllers\DataController::class, "driveOnTrip"]);
Route::get("/drive/{id}/riders/plans", [App\Http\Controllers\DataController::class, "driveRidersPlansIndex"]);
Route::post("/drive/{id}/offer", [App\Http\Controllers\DataController::class, "driveOffer"]);
Route::post("/drive/{id}/offer/cancel", [App\Http\Controllers\DataController::class, "driveOfferCancel"]);
Route::get("/drive/profile", [App\Http\Controllers\DataController::class, "driveProfileIndex"]);
Route::post("/drive/profile/update", [App\Http\Controllers\DataController::class, "driveProfileUpdate"]);
Route::get("/drive/reviews", [App\Http\Controllers\DataController::class, "driveReviewsIndex"]);
Route::get("/drive/review/{id}/view", [App\Http\Controllers\DataController::class, "driveReviewView"]);
Route::get("/drive/offers", [App\Http\Controllers\DataController::class, "driveOffersIndex"]);
Route::get("/drive/signup/personal", [App\Http\Controllers\SignupController::class, "drivePersonalIndex"]);
Route::post("/drive/signup/personal", [App\Http\Controllers\SignupController::class, "drivePersonal"]);
Route::post("/drive/signup/cities", [App\Http\Controllers\SignupController::class, "driveCities"]);
Route::post("/drive/edit/cities", [App\Http\Controllers\DataController::class, "driveEditCities"]);
Route::post("/drive/signup/vehicle", [App\Http\Controllers\SignupController::class, "driveVehicle"]);
Route::post("/drive/signup", [App\Http\Controllers\SignupController::class, "driveSignup"]);
Route::post("/drive/profile/upload/image", [App\Http\Controllers\DataController::class, "driveProfilePictureEdit"]);
Route::get("/drive/chats", [App\Http\Controllers\DataController::class, "driveChatsIndex"]);
Route::post("/drive/{id}/chat", [App\Http\Controllers\DataController::class, "driveChatIndex"]);
Route::post("/drive/{id}/chat/message", [App\Http\Controllers\DataController::class, "driveChat"]);
Route::get("/drive/{id}/getchats", [App\Http\Controllers\DataController::class, "driveGetChats"]);
Route::get("/drive/getrequests", [App\Http\Controllers\DriveDashboardController::class, "driveGetRequests"]);
Route::post("/drive/{id}/request/instant/drive", [App\Http\Controllers\DataController::class, "driveRequestInstantDrive"]);
Route::post("/drive/{id}/request/instant/cancel", [App\Http\Controllers\DataController::class, "driveRequestInstantCancel"]);

Route::get("/ride/dashboard", [App\Http\Controllers\RideDashboardController::class, "index"]);
Route::get("/ride/signin", [App\Http\Controllers\SigninController::class, "rideSigninIndex"]);
Route::post("/ride/signin", [App\Http\Controllers\SigninController::class, "rideSignin"]);
Route::get("/ride/{id}/request", [App\Http\Controllers\DataController::class, "rideRequestIndex"]);
Route::post("/ride/request/instant", [App\Http\Controllers\DataController::class, "rideRequestInstant"]);
Route::post("/ride/{id}/request", [App\Http\Controllers\DataController::class, "rideRequest"]);
Route::match(array("POST", "GET"), "/ride/{id}/request/trip/end", [App\Http\Controllers\DataController::class, "rideRequestTripEnd"]);
Route::post("/ride/{id}/rate", [App\Http\Controllers\DataController::class, "rate"]);
Route::get("/ride/drivers", [App\Http\Controllers\DataController::class, "driversIndex"]);
Route::get("/ride/plans", [App\Http\Controllers\DataController::class, "ridePlansIndex"]);
Route::post("/ride/plans", [App\Http\Controllers\DataController::class, "ridePlans"]);
Route::get("/ride/{id}/plans/view", [App\Http\Controllers\DataController::class, "ridePlanIndex"]);
Route::post("/ride/{id}/plans/cancel", [App\Http\Controllers\DataController::class, "ridePlanCancel"]);
Route::get("/ride/history", [App\Http\Controllers\DataController::class, "rideHistoryIndex"]);
Route::get("/ride/{id}/request/accepted", [App\Http\Controllers\DataController::class, "rideRequestAcceptedIndex"]);
Route::get("/ride/{id}/request/pending", [App\Http\Controllers\DataController::class, "rideRequestPendingIndex"]);
Route::post("/ride/{id}/request/pickup", [App\Http\Controllers\DataController::class, "rideRequestPickup"]);
Route::post("/ride/{id}/request/cancel", [App\Http\Controllers\DataController::class, "rideRequestCancel"]);
Route::post("/ride/{id}/request/instant/next", [App\Http\Controllers\DataController::class, "rideRequestInstantNext"]);
Route::post("/ride/{id}/request/instant/cancel", [App\Http\Controllers\DataController::class, "rideRequestInstantCancel"]);
Route::get("/ride/offers", [App\Http\Controllers\DataController::class, "rideOffersIndex"]);
Route::get("/ride/profile", [App\Http\Controllers\DataController::class, "rideProfileIndex"]);
Route::post("/ride/profile/update", [App\Http\Controllers\DataController::class, "rideProfileUpdate"]);
Route::get("/ride/signup/personal", [App\Http\Controllers\SignupController::class, "ridePersonalIndex"]);
Route::post("/ride/signup/personal", [App\Http\Controllers\SignupController::class, "ridePersonal"]);
Route::post("/ride/signup", [App\Http\Controllers\SignupController::class, "rideSignup"]);
Route::post("/ride/profile/upload/image", [App\Http\Controllers\DataController::class, "rideProfilePictureEdit"]);
Route::get("/ride/chats", [App\Http\Controllers\DataController::class, "rideChatsIndex"]);
Route::post("/ride/{id}/chat", [App\Http\Controllers\DataController::class, "rideChatIndex"]);
Route::post("/ride/{id}/chat/message", [App\Http\Controllers\DataController::class, "rideChat"]);
Route::get("/ride/{id}/getchats", [App\Http\Controllers\DataController::class, "rideGetChats"]);
Route::get("/ride/notifications", [App\Http\Controllers\DataController::class, "rideNotifications"]);












