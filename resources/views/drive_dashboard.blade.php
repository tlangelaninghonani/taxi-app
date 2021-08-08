<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="stylesheet" href="{{ $links['css'] }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="{{ $links['js'] }}"></script>
    <title>Drive</title>
</head>
<style>
    a{
        text-decoration: none;
        color: black;
    }
</style>
<body>
    <div class="container">
        <div class="nav">
           <div class="display-flex">
                <span class="material-icons-round">
                apartment
                </span>
                <span class="app-name">InterCityRides</span>
           </div>
           <div>
            <span class="material-icons-round " onclick="closePopup('menu')">
                more_vert
                </span>
           </div>
        </div>
        <div class="menu display-none" id="menu">
            <div class="text-align-right">
                <span class="material-icons-round" onclick="closePopup('menu')">
                close
                </span>
            </div>
            <p>
                <a href="/drive/profile">
                    <span>My account</span>
                </a>
            </p>
            <p>
                <a href="/signout">
                    <span> Sign out</span>
                </a>
            </p>
        </div>
        
        <p>
            <div class="display-center">
                <div class="text-align-center">
                    @if($driveData->drive_profile_image == "")
                        <span class="material-icons-round empty-profile-large">
                        account_circle
                        </span><br>
                    @else
                        <img class="profile-image-large" src="{{ $driveData->drive_profile_image }}" alt=""><br>
                    @endif
                    <span class="title">{{ $driveAuth->drive_first_name." ".$driveAuth->drive_last_name }}</span><br>
                    <div class="trunc-text">
                        <span>Drives <strong>{{ $driveData->drive_vehicle }} - </strong></span>
                        <strong>{{ $driveData->drive_vehicle_type }}</strong>
                    </div>
                    <div class="display-flex-center">
                        @if($driveAuth->drive_gender == "Male")
                            <span>Gender <strong>{{ $driveAuth->drive_gender }}</strong></span>
                        @elseif($driveAuth->drive_gender == "Female")
                            <span>Gender <strong>{{ $driveAuth->drive_gender }}</strong></span>
                        @else
                            <span>Gender <strong>{{ $driveAuth->drive_gender }}</strong></span>
                        @endif
                    </div>
                    <div class="rating-stars-small-center">
                        @for($i = 1; $i <= 5; $i++)
                            @if($i <= floor($driveData->drive_ratings))
                                <span class="material-icons-round" style="color: orange" >
                                star
                                </span>
                            @else
                                <span class="material-icons-round" >
                                star
                                </span>
                            @endif
                        @endfor
                    </div>
                </div>
            </div>
        </p>
        @if($driveData->drive_on_trip == false)
            <span class="display-none">{{ $totalRequestsFromRiders = 0 }}</span>
            @if($requests::where("drive_id", $driveAuth->id)->count() > 0)
                <div class="curved-top padding-none">
                    <div id="map"></div>
                    <p>
                        <div class="display-flex-center gap">
                            <div onclick="displayComp(this, 'requests')" class="display-flex-center-align">
                                <span class="material-icons-round">
                                local_taxi
                                </span>
                                <span>Requests</span>
                            </div>
                            <div onclick="displayComp(this, 'requestsaccepted')" class="display-flex-center-align">
                                <span class="material-icons-round">
                                check_circle
                                </span>
                                <span>Accepted & offers</span>
                            </div>
                        </div>
                    </p>
                    <div id="requests" class="app-padding" style="padding-top: 0">
                        @foreach($requests::where("drive_id", $driveAuth->id)->where("ride_accepted", false)->get() as $request)   
                            <div class="display-none">
                                {{ $rideA = $rideAuth::find($request->ride_id) }}
                                {{ $rideD = $rideData::where("ride_id", $rideA->id)->first() }}
                            </div>
                            <p>
                                <div class="display-flex-normal gap-10" onclick="redirectTo('/drive/{{ $request->id }}/request')">
                                    <div>
                                        @if($rideD->ride_profile_image == "")
                                        <span class="material-icons-round empty-profile-medium">
                                        account_circle
                                        </span><br>
                                        @else
                                        <img class="profile-image" src="{{ $rideD->ride_profile_image }}" alt="">
                                        @endif  
                                    </div>
                                    <div class="trunc-text">
                                        <span class="title">{{ $rideA->ride_first_name." ".$rideA->ride_last_name }}</span><br>
                                        <div class="display-flex-normal gender">
                                            @if($rideA->ride_gender == "Male")
                                                <span>Gender <strong>{{ $rideA->ride_gender }}</strong></span>
                                            @elseif($rideA->ride_gender == "Female")
                                                <span>Gender <strong>{{ $rideA->ride_gender }}</strong></span>
                                            @else
                                                <span>Gender <strong>{{ $rideA->ride_gender }}</strong></span>
                                            @endif
                                        </div>
                                        <span>Pick-up <strong>{{ $request->ride_from }}</strong></span><br>
                                        <span>Drop <strong>{{ $request->ride_to }}</strong></span>
                                    </div>
                                </div>
                            </p>
                        @endforeach
                        <p>
                            @if($requests::where("ride_accepted", false)->where("drive_id", $driveAuth->id)->count() == 0)
                                <div class="text-align-center">
                                    <span>No requests</span>
                                </div>
                            @endif
                        </p>
                    </div>
                    <div id="requestsaccepted" class="display-none app-padding" style="padding-top: 0">
                        @foreach($requests::where("drive_id", $driveAuth->id)->where("ride_accepted", true)->get() as $request)   
                            <div class="display-none">
                                {{ $rideA = $rideAuth::find($request->ride_id) }}
                                {{ $rideD = $rideData::where("ride_id", $rideA->id)->first() }}
                            </div>
                            <p>
                                <div class="display-flex-normal gap-10" onclick="redirectTo('/drive/{{ $request->id }}/request/accepted')">
                                    <div>
                                        @if($rideD->ride_profile_image == "")
                                        <span class="material-icons-round empty-profile-medium">
                                        account_circle
                                        </span><br>
                                        @else
                                        <img class="profile-image" src="{{ $rideD->ride_profile_image }}" alt="">
                                        @endif  
                                    </div>
                                    <div class="trunc-text">
                                        <span class="title">{{ $rideA->ride_first_name." ".$rideA->ride_last_name }}</span><br>
                                        <div class="display-flex-normal gender">
                                            @if($rideA->ride_gender == "Male")
                                                <span>Gender <strong>{{ $rideA->ride_gender }}</strong></span>
                                            @elseif($rideA->ride_gender == "Female")
                                                <span>Gender <strong>{{ $rideA->ride_gender }}</strong></span>
                                            @else
                                                <span>Gender <strong>{{ $rideA->ride_gender }}</strong></span>
                                            @endif
                                        </div>
                                        <span>Pick-up <strong>{{ $request->ride_from }}</strong></span><br>
                                        <span>Drop <strong>{{ $request->ride_to }}</strong></span>
                                    </div>
                                </div>
                            </p>
                        @endforeach
                        <p>
                            @if($requests::where("ride_accepted", true)->where("drive_id", $driveAuth->id)->count() == 0)
                                <div class="text-align-center">
                                    <span>No accepted & offers</span>
                                </div>
                            @endif
                        </p>
                    </div>
                    <script
                    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCNarbofdMvrgaKRZ9e_LvJD2miCEOS6D0&callback=initMapCurrentLocDrive&libraries=&v=weekly"
                    async
                    ></script>
                </div>
            @else
                <div class="curved-top padding-none">
                    <div id="map"></div>
                    <script
                    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCNarbofdMvrgaKRZ9e_LvJD2miCEOS6D0&callback=initMapCurrentLocDrive&libraries=&v=weekly"
                    async
                    ></script>
                </div>
            @endif
        @else
            <div class="display-none">
                {{ $rideAuth = $rideAuth::find($trip->ride_id) }}
                {{ $rideData = $rideData::where("ride_id", $rideAuth->id)->first() }}
            </div>
            <div class="curved-top padding-none">
                <!--<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d116716.15173817966!2d29.381065563392927!3d-23.91160360229813!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x1ec6d8401183307b%3A0xa720ddd4b18e4df7!2sPolokwane!5e0!3m2!1sen!2sza!4v1626522553343!5m2!1sen!2sza" width="100%" height="300" style="border:0;" allowfullscreen="" loading="lazy"></iframe>-->
                <div id="map"></div>
                <div class="app-padding">
                    <p>
                        <div class="text-align-center">
                            <span class="title">On trip with {{ $rideAuth->ride_first_name." ".$rideAuth->ride_last_name }}...</span><br>
                        </div>
                    </p>
                    <div id="tripinfo" class="text-align-center ">
                        <p>
                            <div class="text-align-center">
                                <div class="display-flex-justify-center">
                                    <span class="material-icons-round">
                                    local_taxi
                                    </span>
                                    <span class="title">Pick-up</span><br>
                                </div>
                                <span>{{ $trip->ride_from }}</span><br>
                                <div class="display-flex-justify-center">
                                    <span class="material-icons-round">
                                    my_location
                                    </span>
                                    <span class="title">Drop</span><br>
                                </div>
                                <span>{{ $trip->ride_to }}</span>
                            </div>
                        </p>
                        <p>
                            <span>Distance <strong id="tripdistance">{{ $trip->ride_distance }}</strong></span><br>
                            <span>Estimated time <strong id="triptime">{{ $trip->ride_duration }}</strong></span><br>
                            <span class="title">Charges R<strong class="title" id="tripcharges">{{$trip->ride_charges }}</strong></span>
                        </p>
                    </div>
                    <form action="/drive/{{ $trip->id }}/request/trip/end" method="POST">
                        @csrf
                        @method("POST")
                        <button>End trip</button>
                    </form>
                </div>
            </div>
            <script>
            function drawLine(){
                const map = new google.maps.Map(document.getElementById("map"), {
                center: { lat: -33.8688, lng: 151.2195 },
                zoom: 13,
                mapId: "4cce301a9d6797df",
                disableDefaultUI: true,
                fullscreenControl: true
                });

                let directionsService = new google.maps.DirectionsService();
                var directionsOptions = {
                    polylineOptions: {
                        strokeColor: 'red',
                        strokeWeight: 2,
                    }
                }
                let directionsRenderer = new google.maps.DirectionsRenderer(directionsOptions);
                directionsRenderer.setMap(map); // Existing map object displays directions
                // Create route from existing points used for markers
                const route = {
                    origin: {lat: parseFloat("{{ $trip->ride_from_lat }}"), lng: parseFloat("{{  $trip->ride_from_lng }}")},
                    destination: {lat: parseFloat("{{  $trip->ride_to_lat }}"), lng: parseFloat("{{  $trip->ride_to_lng }}")},
                    travelMode: 'DRIVING'
                }

                directionsService.route(route,
                    function(response, status) { // anonymous function to capture directions
                    if (status !== 'OK') {
                        window.alert('Directions request failed due to ' + status);
                        return;
                    } else {
                        directionsRenderer.setDirections(response); // Add route to the map
                        var directionsData = response.routes[0].legs[0]; // Get data about the mapped route
                        if (!directionsData) {
                        window.alert('Directions request failed');
                        return;
                        }
                        else {

                        }
                    }
                });
            }
            </script>
            <script
            src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCNarbofdMvrgaKRZ9e_LvJD2miCEOS6D0&callback=drawLine&libraries=places&v=weekly"
            async
            ></script>
        @endif
    </div>
    <div class="bottom-controls">
        <div class="bottom-controls-item">
            <a href="/drive/dashboard">
                <span class="material-icons-round">
                home
                </span><br>
                <span class="title-small">Home</span>
            </a>
        </div>
        <div class="bottom-controls-item">
            <a href="/drive/history">
                <span class="material-icons-round">
                watch_later
                </span><br>
                <span class="title-small">History</span>
            </a>
        </div>
        <div class="bottom-controls-item">
            <a href="/drive/reviews">
                <span class="material-icons-round">
                edit
                </span><br>
                <span class="title-small">Reviews</span>
            </a>
        </div>
        <div class="bottom-controls-item">
            <a href="/drive/riders">
                <span class="material-icons-round">
                hail
                </span><br>
                <span class="title-small">Riders</span>
            </a>
        </div>
        <div class="bottom-controls-item">
            <a href="/drive/offers">
                <span class="material-icons-round">
                local_offer
                </span><br>
                <span class="title-small">Offers</span>
            </a>
        </div>
        <div class="bottom-controls-item">
            <a href="/drive/chats">
                <span class="material-icons-round">
                question_answer
                </span><br>
                <span class="title-small">Chats</span>
            </a>
        </div>
    </div>
</body>
</html>