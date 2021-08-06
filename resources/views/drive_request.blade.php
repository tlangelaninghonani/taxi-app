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
           <div class="display-flex">
                <span class="material-icons-round">
                apartment
                </span>
                <span class="app-name">InterCityRides</span>
           </div>
           <span class="material-icons-round " onclick="closePopup('menu')">
            more_vert
            </span>
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
                </div>
            </div>
        </p>
        <p>
            <span class="title">Ride request</span>
        </p>
        <div class="curved-top padding-none">
            <div id="map"></div>
            <input type="hidden" id="ridefrom" value="{{ $rideData->ride_from }}">
            <input type="hidden" id="rideto" value="{{ $rideData->ride_to }}">
            <form id="ridertochat" action="/drive/{{ $rideAuth->id }}/chat" method="POST">
                @csrf
                @method("POST")
            </form>
            <form class="app-padding" action="/drive/{{ $request->id }}/request/accept" method="POST">
                @csrf
                @method("POST")
                <div class="text-align-center">
                <p>
                    <span class="title">Pick-up</span><br>
                    <span>{{ $request->ride_from }}</span><br>
                    <span class="title">Drop</span><br>
                    <span>{{ $request->ride_to }}</span>
                </p>
                </div>
                <div id="tripinfo" class="text-align-center ">
                    <p>
                        <span>Distance <strong id="tripdistance">{{ $request->ride_distance }}</strong></span><br>
                        <span>Estimated time <strong id="triptime">{{ $request->ride_duration }}</strong></span><br>
                        <span class="title">Charges <strong class="title" id="tripcharges">R{{ $request->ride_charges }}</strong></span>
                    </p>
                </div>
                <p>
                    <div class="display-flex-center">
                        <div class="display-flex-normal" onclick="submitForm('ridertochat')">
                            <span class="material-icons-round">
                            question_answer
                            </span>
                            <span>Chat with {{ $rideAuth->ride_first_name }}</span>
                        </div>
                    </div>
                </p>
                <p>
                    <button>Accept</button>
                </p>
            </form>
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