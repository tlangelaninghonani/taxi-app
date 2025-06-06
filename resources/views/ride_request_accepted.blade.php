<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="stylesheet" href="{{ $links['css'] }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Request</title>
</head>
<body>
    <div class="container">
        <div class="nav">
           <div class="display-flex-normal gap-10">
                <span class="material-icons-round" onclick="redirectBack()">
                arrow_back
                </span>
                <span class="">{{ $driveAuth->drive_first_name }} accepted your request</span>
           </div>
           <div class="display-flex-normal gap-mid">
                <span class="material-icons-round">
                notifications
                </span>
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
                <div class="display-flex-normal gap-small" onclick="redirectTo('/ride/profile')">
                    @if($rideData->ride_profile_image == "")
                        <div class="position-relative">
                            <span class="material-icons-round empty-profile-small">
                            account_circle
                            </span><br>
                        </div>
                    @else
                        <div class="position-relative">
                            <img class="profile-image-small" src="{{ $rideData->ride_profile_image }}" alt=""><br>
                        </div>
                    @endif
                    <span>My account</span>
                </div>
            </p>
            <p>
                <span>Send feedback</span>
            </p>
            <p>
                <div class="display-flex-normal gap-small" onclick="redirectTo('/signout')">
                    <span>Sign out</span>
                </div>
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
        <div class="curved-top">
            <div id="map"></div>
            <div class="app-padding">
                <p>
                    <div class="text-align-center">
                        <div class="display-flex-justify-center">
                            <span class="title">Pick-up</span><br>
                        </div>
                        <span>{{ $request->ride_from }}</span><br>
                        <div class="display-flex-justify-center">
                            <span class="title">Drop</span><br>
                        </div>
                        <span>{{ $request->ride_to }}</span>
                    </div>
                </p>
                <p>
                    <div class="display-flex-center-align">
                        <span class="material-icons-round">
                        local_taxi
                        </span>
                        <div>
                            <span>Plate - {{ $driveData->drive_vehicle_plate }}</span><br>
                            <span>Color - {{ $driveData->drive_vehicle_color }}</span>
                        </div>
                    </div>
                </p>
                <div id="tripinfo" class="text-align-center ">
                    <p>
                        <span>Distance <strong id="tripdistance">{{ $request->ride_distance }}</strong></span><br>
                        <span>Estimated time <strong id="triptime">{{ $request->ride_duration }}</strong></span><br>
                        <span class="title">Charges R<strong class="title" id="tripcharges">{{ $request->ride_charges }}</strong></span>
                    </p>
                </div>
                <form id="drivertochat" action="/ride/{{ $driveAuth->id }}/chat" method="POST">
                    @csrf
                    @method("POST")
                </form>
                <p>
                    <div class="display-flex-center">
                        <div class="display-flex-normal" onclick="submitForm('drivertochat')">
                            <span class="material-icons-round">
                            question_answer
                            </span>
                            <span>Chat with {{ $driveAuth->drive_first_name }}</span>
                        </div>
                    </div>
                </p>
                <div>
                    @if($request->pick_up_requested )
                        @if($request->pick_up_confirmed)
                            @if($rideData->ride_on_trip)
                                <script>
                                    window.location.href = "/ride/dashboard";
                                </script>
                            @endif
                            <div class="text-align-center">
                                <span class="title">{{ $driveAuth->drive_first_name }} is on the way to pick you up...</span>
                            </div>
                        @else
                            <div class="text-align-center">
                                <span class="title">Waiting for {{ $driveAuth->drive_first_name }} to confirm pick-up...</span>
                            </div>
                        @endif
                    @else
                    <div class="text-align-center">
                        <span class="title">{{ $driveAuth->drive_first_name }} is waiting for your pick-up request...</span>
                    </div>
                    <p>
                        <form action="/ride/{{ $request->id }}/request/pickup" method="POST">
                        @csrf
                        @method("POST")
                            <button>Request pick-up</button>
                        </form>
                    </p>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <script src="{{ $links['js'] }}"></script>
    <script>
    function drawLine(){
        const map = new google.maps.Map(document.getElementById("map"), {
        center: { lat: -33.8688, lng: 151.2195 },
        zoom: 12,
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
            origin: {lat: parseFloat("{{ $request->ride_from_lat }}"), lng: parseFloat("{{ $request->ride_from_lng }}")},
            destination: {lat: parseFloat("{{ $request->ride_to_lat }}"), lng: parseFloat("{{ $request->ride_to_lng }}")},
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
            }
        });
    }
    </script>
    <script
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCNarbofdMvrgaKRZ9e_LvJD2miCEOS6D0&callback=drawLine&libraries=places&v=weekly"
    async
    ></script>
</body>
</html>