<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="stylesheet" href="{{ $links['css'] }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Plan</title>
</head>
<style>
    a{
        text-decoration: none;
        color: black;
    }
</style>
<body>
    <div class="container">
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
           <span class="material-icons-round" onclick="closePopup('menu')">
            more_vert
            </span>
        </div>

        <div class="curved-top" id="plans">
            <div id="map"></div>
            <div class="app-padding">
                <p>
                    <div class="text-align-center">
                        <div>
                            <span class="title">Pick-up</span><br>
                            <span>{{ $plan->ride_from }}</span><br>
                            <span class="title">Drop</span><br>
                            <span>{{ $plan->ride_to }}</span><br>
                            <span class="title">Date & Time</span><br>
                            <span>{{ $plan->ride_date }} {{ $plan->ride_time }} {{ $plan->meridiem }}</span><br>
                        </div>
                    </div>
                </p>
                <div id="tripinfo" class="text-align-center">
                    <p>
                        <span>Distance <strong id="tripdistance"></strong>{{ $plan->ride_distance }}</span><br>
                        <span>Estimated time <strong id="triptime">{{ $plan->ride_duration }}</strong></span><br>
                        <span class="title">Charges <strong class="title" id="tripcharges">R{{ $plan->ride_charges }}</strong></span>
                    </p>
                </div>
                <p>
                    <form action="/ride/{{ $plan->id }}/plans/cancel" method="POST">
                        @csrf
                        @method("POST")
                        <button>Cancel plan</button>
                    </form>
                </p>
            </div>
        </div>
    </div>
    <script src="{{ $links['js'] }}"></script>
    <script>
    function drawLine(){
        const map = new google.maps.Map(document.getElementById("map"), {
        center: { lat: -33.8688, lng: 151.2195 },
        zoom: 2,
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
            origin: {lat: parseFloat("{{ $plan->ride_from_lat }}"), lng: parseFloat("{{ $plan->ride_from_lng }}")},
            destination: {lat: parseFloat("{{ $plan->ride_to_lat }}"), lng: parseFloat("{{ $plan->ride_to_lng }}")},
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