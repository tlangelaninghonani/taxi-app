<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="stylesheet" href="{{ $links['css'] }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="{{ $links['js'] }}"></script>
    <title>Ride</title>
</head>
<style>
    a{
        text-decoration: none;
        color: black;
    }
</style>
<body>
    <div class="container">
        <!--<p>
            <a href="/signout">
                <button>Sign out</button>
            </a>
        </p>-->
        <div class="menu display-none" id="menu">
            <div class="text-align-right">
                <span class="material-icons-round" onclick="closePopup('menu')">
                close
                </span>
            </div>
            <p>
                <a href="/ride/profile">
                    <span>My account</span>
                </a>
            </p>
            <p>
                <a href="/signout">
                    <span> Sign out</span>
                </a>
            </p>
        </div>
        <div class="nav">
           <div class="display-flex">
                <span class="material-icons-round">
                apartment
                </span>
                <span class="app-name">InterCityRides</span>
           </div>
           <div class="display-flex-normal">
                <span class="material-icons-round " onclick="closePopup('menu')">
                more_vert
                </span>
           </div>
        </div>
        <p>
            <div class="display-center border-bottom-curved">
                <div class="text-align-center">
                    @if($rideData->ride_profile_image == "")
                        <span class="material-icons-round empty-profile-large">
                        account_circle
                        </span><br>
                    @else
                        <img class="profile-image-large" src="{{ $rideData->ride_profile_image }}" alt=""><br>
                    @endif
                    <span class="title">{{ $rideAuth->ride_first_name." ".$rideAuth->ride_last_name }}</span><br>
                    <div class="display-flex-center gender">
                        @if($rideAuth->ride_gender == "Male")
                            <span>Gender <strong>{{ $rideAuth->ride_gender }}</strong></span>
                        @elseif($rideAuth->ride_gender == "Female")
                            <span>Gender <strong>{{ $rideAuth->ride_gender }}</strong></span>
                        @else
                            <span>Gender <strong>{{ $rideAuth->ride_gender }}</strong></span>
                        @endif
                    </div>
                    <div class="display-flex-center">
                        <span>Phone <strong>{{ $rideAuth->ride_phone }}</strong></span>
                    </div>
                </div>
            </div>
        </p>
        @if($rideData->ride_on_trip == false)
            @if($requests::where("ride_id", $rideAuth->id)->count() > 0)
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
                        @foreach($requests::where("ride_accepted", false)->where("ride_id", $rideAuth->id)->get() as $request)   
                            <div class="display-none">
                                {{ $driveA = $driveAuth::find($request->drive_id) }}
                                {{ $driveD = $driveData::where("drive_id", $driveA->id)->first() }}
                            </div>
                            <p>
                                <div class="display-flex-normal gap-10" onclick="redirectTo('/ride/{{ $request->id }}/request/pending')">
                                    <div>
                                        @if($driveD->drive_profile_image == "")
                                        <span class="material-icons-round empty-profile-medium">
                                        account_circle
                                        </span><br>
                                        @else
                                        <img class="profile-image" src="{{ $driveD->drive_profile_image }}" alt="">
                                        @endif
                                    </div>
                                    <div class="trunc-text">
                                        <span class="title">{{ $driveA->drive_first_name." ".$driveA->drive_last_name }}</span><br>
                                        <div class="trunc-text">
                                            <span>Drives <strong>{{ $driveD->drive_vehicle }} - </strong></span>
                                            <strong>{{ $driveD->drive_vehicle_type }}</strong>
                                        </div>
                                        <div class="display-flex-normal gender">
                                            @if($driveA->drive_gender == "Male")
                                                <span>Gender <strong>{{ $driveA->drive_gender }}</strong></span>
                                            @elseif($driveA->drive_gender == "Female")
                                                <span>Gender <strong>{{ $driveA->drive_gender }}</strong></span>
                                            @else
                                                <span>Gender <strong>{{ $driveA->drive_gender }}</strong></span>
                                            @endif
                                        </div>
                                        <div class="rating-stars-small">
                                            @for($i = 1; $i <= 5; $i++)
                                                @if($i <= floor($driveD->drive_ratings))
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
                        @endforeach
                        <p>
                            @if($requests::where("ride_accepted", false)->where("ride_id", $rideAuth->id)->count() == 0)
                                <div class="text-align-center">
                                    <span>No requests</span>
                                </div>
                            @endif
                        </p>
                    </div>
                    <div id="requestsaccepted" class="display-none app-padding" style="padding-top: 0">
                    @foreach($requests::where("ride_accepted", true)->where("ride_id", $rideAuth->id)->get() as $request)   
                            <div class="display-none">
                                {{ $driveA = $driveAuth::find($request->drive_id) }}
                                {{ $driveD = $driveData::where("drive_id", $driveA->id)->first() }}
                            </div>
                            <p>
                                <div class="display-flex-normal gap-10" onclick="redirectTo('/ride/{{ $request->id }}/request/accepted')">
                                    <div>
                                        @if($driveD->drive_profile_image == "")
                                        <span class="material-icons-round empty-profile-medium">
                                        account_circle
                                        </span><br>
                                        @else
                                        <img class="profile-image" src="{{ $driveD->drive_profile_image }}" alt="">
                                        @endif
                                    </div>
                                    <div class="trunc-text">
                                        <span class="title">{{ $driveA->drive_first_name." ".$driveA->drive_last_name }}</span><br>
                                        <div class="trunc-text">
                                            <span>Drives <strong>{{ $driveD->drive_vehicle }} - </strong></span>
                                            <strong>{{ $driveD->drive_vehicle_type }}</strong>
                                        </div>
                                        <div class="display-flex-normal gender">
                                            @if($driveA->drive_gender == "Male")
                                                <span>Gender <strong>{{ $driveA->drive_gender }}</strong></span>
                                            @elseif($driveA->drive_gender == "Female")
                                                <span>Gender <strong>{{ $driveA->drive_gender }}</strong></span>
                                            @else
                                                <span>Gender <strong>{{ $driveA->drive_gender }}</strong></span>
                                            @endif
                                        </div>
                                        <div class="rating-stars-small">
                                            @for($i = 1; $i <= 5; $i++)
                                                @if($i <= floor($driveD->drive_ratings))
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
                        @endforeach
                        <p>
                            @if($requests::where("ride_accepted", true)->where("ride_id", $rideAuth->id)->count() == 0)
                                <div class="text-align-center">
                                    <span>No accepted requests or offers</span>
                                </div>
                            @endif
                        </p>
                    </div>
                    <script
                    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCNarbofdMvrgaKRZ9e_LvJD2miCEOS6D0&callback=initMapCurrentLoc&libraries=&v=weekly"
                    async
                    ></script>
                </div>
            @else
                <div class="curved-top padding-none">
                    <div id="map"></div>
                    <div class="app-padding">
                        <p>
                            <div class="text-align-center">
                                <span class="title">Hello {{ $rideAuth->ride_first_name }}, where are you going today?</span>
                            </div>
                        </p>
                        <p>
                            <a href="/ride/drivers">
                                <button>See drivers</button>
                            </a>
                        </p>
                    </div>
                    <script
                    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCNarbofdMvrgaKRZ9e_LvJD2miCEOS6D0&callback=initMapCurrentLoc&libraries=&v=weekly"
                    async
                    ></script>
                </div>
            @endif
        @else
            <div class="display-none">
                {{ $driveAuth = $driveAuth::find($trip->drive_id) }}
                {{ $driveData = $driveData::where("drive_id", $driveAuth->id)->first() }}
            </div>
            <div class="curved-top padding-none">
                <!--<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d116716.15173817966!2d29.381065563392927!3d-23.91160360229813!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x1ec6d8401183307b%3A0xa720ddd4b18e4df7!2sPolokwane!5e0!3m2!1sen!2sza!4v1626522553343!5m2!1sen!2sza" width="100%" height="300" style="border:0;" allowfullscreen="" loading="lazy"></iframe>-->
                <div id="map"></div>
                <div class="curved-top-padding">
                    <p>
                        <div class="text-align-center">
                            <span class="title">On trip wth {{ $driveAuth->drive_first_name." ".$driveAuth->drive_last_name }}...</span><br>
                        </div>
                        <div id="tripinfo" class="text-align-center ">
                        <p>
                            <span class="title">Picked-up</span><br>
                            <span>{{ $trip->ride_from }}</span><br>
                            <span class="title">Dropping</span><br>
                            <span>{{ $trip->ride_to }}</span>
                        </p>
                        <p>
                            <span>Distance <strong id="tripdistance">{{ $trip->ride_distance }}</strong></span><br>
                            <span>Estimated time <strong id="triptime">{{ $trip->ride_duration }}</strong></span><br>
                            <span class="title">Charges R<strong class="title" id="tripcharges">{{$trip->ride_charges }}</strong></span>
                        </p>
                    </div>
                    <form action="/ride/{{ $trip->id }}/request/trip/end" method="POST">
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
            <a href="/ride/dashboard">
                <span class="material-icons-round">
                home
                </span><br>
                <span class="title-small">Home</span>
            </a>
        </div>
        <div class="bottom-controls-item">
            <a href="/ride/history">
                <span class="material-icons-round">
                watch_later
                </span><br>
                <span class="title-small">History</span>
            </a>
        </div>
        <div class="bottom-controls-item">
            <a href="/ride/plans">
                <span class="material-icons-round">
                travel_explore
                </span><br>
                <span class="title-small">Plans</span>
            </a>
        </div>
        <div class="bottom-controls-item">
            <a href="/ride/drivers">
                <span class="material-icons-round">
                local_taxi
                </span><br>
                <span class="title-small">Drivers</span>
            </a>
        </div>
        <div class="bottom-controls-item">
            <a href="/ride/offers">
                <span class="material-icons-round">
                local_offer
                </span><br>
                <span class="title-small">Offers</span>
            </a>
        </div>
        <div class="bottom-controls-item">
            <a href="/ride/chats">
                <span class="material-icons-round">
                question_answer
                </span><br>
                <span class="title-small">Chats</span>
            </a>
        </div>
    </div>
</body>
</html>