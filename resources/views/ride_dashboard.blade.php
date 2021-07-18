<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="stylesheet" href="{{ $links['css'] }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
                <span>Profile</span>
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
           <span class="material-icons-round items-menu-icon" onclick="closePopup('menu')">
            more_vert
            </span>
        </div>
        <p>
            <div class="display-center border-bottom-curved">
                <div class="text-align-center">
                    <img class="profile-image-large" src="{{ $rideData->ride_profile_image }}" alt=""><br>
                    <span class="title">{{ $rideAuth->ride_first_name." ".$rideAuth->ride_last_name }}</span><br>
                    <span>Balance R{{ $rideData->ride_balance }}</span>
                </div>
            </div>
        </p>
        @if($rideData->ride_on_trip == false)
            <span class="display-none">{{ $totalRequestsFromRiders = 0 }}</span>
             <p>
                <span class="title border-bottom" onclick="displayComp(this, 'requests')">Requests</span>
                <span class="title f-right" onclick="displayComp(this, 'requestsaccepted')">Accepted</span>
            </p>
            <div class="curved-top">
                <div id="requests">
                    <div class="display-none">
                    {{ $requests_count = 0 }}
                    </div>
                    <p>
                        <div class="display-flex-justify-center">
                            <div>
                                <span class="material-icons-round">
                                waving_hand
                                </span>
                            </div>
                            <div>
                                <span class="title">Requests to drivers</span>
                            </div>
                        </div>
                    </p>
                    <p>
                        @foreach($driveData::all() as $drive)
                            @if(sizeof(json_decode($rideData->ride_requests, true)) > 0)
                                @foreach(json_decode($rideData->ride_requests, true) as $driveId => $requestData)
                                    @if($driveId == $drive->id)
                                        @if($requestData["ride_accepted"] == false)
                                            <span class="display-none">{{ $totalRequestsFromRiders++ }}</span>    
                                            <div class="display-none">
                                                {{ $requests_count++ }}
                                                {{ $drive_first_name = $driveAuth->find($drive->drive_id)->drive_first_name }}
                                                {{ $drive_last_name = $driveAuth->find($drive->drive_id)->drive_last_name }}
                                            </div>
                                            <p>
                                                <a class="display-flex" href="">
                                                    <div>
                                                        <div>
                                                            <img class="profile-image" src="{{ $drive->drive_profile_image }}" alt="">
                                                        </div>
                                                        <div class="trunc-text">
                                                            <span class="title">{{ $drive_first_name." ".$drive_last_name }}</span><br>
                                                            <span>{{ $drive->drive_vehicle }}</span><br>
                                                            <span>Rated {{ $drive->drive_ratings }}</span>
                                                        </div>
                                                    </div>
                                                </a>
                                            </p>
                                        @endif
                                    @endif
                                @endforeach
                            @endif
                        @endforeach
                    </p>
                    <p>
                        @if($requests_count == 0)
                            <div class="text-align-center">
                                <span>No requests</span>
                            </div>
                        @endif
                    </p>
                </div>
                <div id="requestsaccepted" class="display-none">
                    <div class="display-none">
                    {{ $accepted_requests_count = 0 }}
                    </div>
                    <p>
                        <div class="display-flex-justify-center">
                            <div>
                                <span class="material-icons-round">
                                check_circle
                                </span>
                            </div>
                            <div>
                                <span class="title">Accepted requests</span>
                            </div>
                        </div>
                    </p>
                    <p>
                        @foreach($driveData::all() as $drive)
                            @if(sizeof(json_decode($rideData->ride_requests, true)) > 0)
                                @foreach(json_decode($rideData->ride_requests, true) as $driveId => $requestData)
                                    @if($driveId == $drive->id)
                                        @if($requestData["ride_accepted"] == true)
                                            <span class="display-none">{{ $totalRequestsFromRiders++ }}</span>    
                                            <div class="display-none">
                                                {{ $requests_count++ }}
                                                {{ $drive_first_name = $driveAuth->find($drive->drive_id)->drive_first_name }}
                                                {{ $drive_last_name = $driveAuth->find($drive->drive_id)->drive_last_name }}
                                            </div>
                                            <p>
                                                <a class="display-flex" href="/ride/{{ $drive->drive_id }}/request/accepted">
                                                    <div>
                                                        <div>
                                                            <img class="profile-image" src="{{ $drive->drive_profile_image }}" alt="">
                                                        </div>
                                                        <div class="trunc-text">
                                                            <span class="title">{{ $drive_first_name." ".$drive_last_name }}</span><br>
                                                            <span>{{ $drive->drive_vehicle }}</span><br>
                                                            <span>Rated {{ $drive->drive_ratings }}</span>
                                                        </div>
                                                    </div>
                                                </a>
                                            </p>
                                        @endif
                                    @endif
                                @endforeach
                            @endif
                        @endforeach
                    </p>
                    <p>
                        @if($accepted_requests_count == 0)
                            <div class="text-align-center">
                                <span>No accepted requests</span>
                            </div>
                        @endif
                    </p>
                </div>
            </div>
            @if($totalRequestsFromRiders == 0)
                <div class="curved-top padding-none">
                    <div id="map"></div>
                    <script
                    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCNarbofdMvrgaKRZ9e_LvJD2miCEOS6D0&callback=initMapCurrentLoc&libraries=&v=weekly"
                    async
                    ></script>
                </div>
            @endif
        @else
            <div class="display-none">
                {{ $driveAuth = $driveAuth::find($rideData->ride_on_trip_drive_id) }}
                {{ $driveData = $driveData::where("drive_id", $driveAuth->id)->first() }}
            </div>
            <div class="curved-top padding-none">
                <p>
                    <!--<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d116716.15173817966!2d29.381065563392927!3d-23.91160360229813!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x1ec6d8401183307b%3A0xa720ddd4b18e4df7!2sPolokwane!5e0!3m2!1sen!2sza!4v1626522553343!5m2!1sen!2sza" width="100%" height="300" style="border:0;" allowfullscreen="" loading="lazy"></iframe>-->
                    <div id="map"></div>
                </p>
                <div class="curved-top-padding">
                    <p>
                        <div class="text-align-center">
                            <span class="title">On trip wth {{ $driveAuth->drive_first_name." ".$driveAuth->drive_last_name }}</span><br>
                        </div>
                        <div id="tripinfo" class="text-align-center ">
                            <p>
                                <span>From <strong>{{ $rideRequest["ride_from"] }}</strong></span><br>
                                <span>To <strong>{{ $rideRequest["ride_to"] }}</strong></span>
                            </p>
                            <p>
                                <span>Distance <strong id="tripdistance">{{ $rideRequest["ride_distance"] }}</strong></span><br>
                                <span>Estimated time <strong id="triptime">{{ $rideRequest["ride_time"] }}</strong></span><br>
                                <span class="title">Charges R<strong class="title" id="tripcharges">{{ $rideRequest["ride_charges"] }}</strong></span>
                            </p>
                        </div>
                    </p>
                    <p>
                        <form action="/ride/{{ $driveData::find($rideData->ride_on_trip_drive_id)->id }}/request/trip/end" method="POST">
                            @csrf
                            @method("POST")
                            <button>End trip</button>
                        </form>
                    </p>
                </div>
            </div>
            <script>
            function drawLine(){
                const map = new google.maps.Map(document.getElementById("map"), {
                center: { lat: -33.8688, lng: 151.2195 },
                zoom: 13,
                mapId: "4cce301a9d6797df"
                });

                let directionsService = new google.maps.DirectionsService();
                directionsRenderer = new google.maps.DirectionsRenderer();
                directionsRenderer.setMap(map); // Existing map object displays directions
                // Create route from existing points used for markers
                const route = {
                    origin: {lat: parseFloat("{{ json_decode($rideRequest['ride_from_coords'], true)['lat'] }}"), lng: parseFloat("{{ json_decode($rideRequest['ride_from_coords'], true)['lng'] }}")},
                    destination: {lat: parseFloat("{{ json_decode($rideRequest['ride_to_coords'], true)['lat'] }}"), lng: parseFloat("{{ json_decode($rideRequest['ride_to_coords'], true)['lng'] }}")},
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
            <a href="">
                <span class="material-icons-round">
                home
                </span><br>
                <span>Home</span>
            </a>
        </div>
        <div class="bottom-controls-item">
            <a href="/ride/history">
                <span class="material-icons-round">
                watch_later
                </span><br>
                <span>History</span>
            </a>
        </div>
        <div class="bottom-controls-item">
            <a href="/ride/plans">
                <span class="material-icons-round">
                public
                </span><br>
                <span>Plans</span>
            </a>
        </div>
        <div class="bottom-controls-item">
            <a href="/ride/drivers">
                <span class="material-icons-round">
                directions_car
                </span><br>
                <span>Drivers</span>
            </a>
        </div>
        <div class="bottom-controls-item">
            <a href="/ride/offers">
                <span class="material-icons-round">
                local_offer
                </span><br>
                <span>Offers</span>
            </a>
        </div>
    </div>
    <script src="{{ $links['js'] }}"></script>
</body>
</html>