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
                <span>Profile</span>
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
                    <img class="profile-image-large" src="{{ $rideData->ride_profile_image }}" alt=""><br>
                    <span class="title">{{ $rideAuth->ride_first_name." ".$rideAuth->ride_last_name }}</span><br>
                </div>
            </div>
        </p>
        <div class="curved-top padding-none">
            <div id="map"></div>
            <input type="hidden" id="ridefrom" value="{{ $rideData->ride_from }}">
            <input type="hidden" id="rideto" value="{{ $rideData->ride_to }}">

            <form class="app-padding" action="/drive/{{ $rideAuth->id }}/request/accept" method="POST">
                @csrf
                @method("POST")
                <p>
                    <span class="title">Pick-up place</span><br>
                    <span>{{ $rideRequest["ride_from"] }}</span>
                </p>
                <p>
                    <span class="title">Destination</span><br>
                    <span>{{ $rideRequest["ride_to"] }}</span>
                </p>
                <div id="tripinfo" class="text-align-center ">
                    <p>
                        <span>Distance <strong id="tripdistance">{{ $rideRequest["ride_distance"] }}</strong></span><br>
                        <span>Estimated time <strong id="triptime">{{ $rideRequest["ride_time"] }}</strong></span><br>
                        <span class="title">Charges R<strong class="title" id="tripcharges">{{ $rideRequest["ride_charges"] }}</strong></span>
                    </p>
                </div>
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
                    document.querySelector("#tripinfo").style.display = "block";
                    document.querySelector("#tripdistance").innerHTML = directionsData.distance.text;
                    document.querySelector("#triptime").innerHTML = directionsData.duration.text;
                    document.querySelector("#tripcharges").innerHTML = parseFloat((directionsData.distance.value/1000) * 3.50).toFixed(2);
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