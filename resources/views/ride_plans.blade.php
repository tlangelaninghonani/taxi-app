<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="stylesheet" href="{{ $links['css'] }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Plans</title>
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
        <p>
            <div class="display-flex-space-between">
                <span class="title">Plans</span>
                <span  onclick="openClosePlan('newplan')" class="material-icons-round new-plan-icon">
                add
                </span>
            </div>
        </p>
        <div id="plans">
            @foreach(json_decode($rideData->ride_plans, true) as $ridePlans)
                <p>
                    <div class="display-flex">
                        <div>
                            <span class="material-icons-round plan-icon">
                            schedule
                            </span>
                        </div>
                        <div>
                            <span class="title">{{ $ridePlans["ride_date"] }} {{ $ridePlans["ride_time"] }} {{ $ridePlans["ride_meridiem"] }}</span><br>
                            <span>From <strong>{{ $ridePlans["ride_from"] }}</strong></span><br>
                            <span>To <strong>{{ $ridePlans["ride_to"] }}</strong></span>
                        </div>
                    </div>
                </p>
            @endforeach
            @if(sizeof(json_decode($rideData->ride_plans, true)) == 0)
                <div class="text-align-center">
                    <span class="material-icons-round icon-large">
                    travel_explore
                    </span><br>
                    <span>No plans</span>
                </div>
            @endif
        </div>
        <div id="newplan" class="display-none">
            <div class="curved-top">
                <!--<div class="text-align-right">
                    <span class="material-icons-round newplan" onclick="openClosePlan('newplan')">
                    close
                    </span>
                </div>-->
                <div id="map"></div>
                <form class="app-padding" action="/ride/plans" method="POST">
                    @csrf
                    @method("POST")
                    <p>
                        <span class="title">Pick-up place</span><br>
                        <input type="text" name="ridefrom" id="ridefrom" placeholder="Pick-up place" required>
                    </p>
                    <p>
                        <span class="title">Destination</span><br>
                        <input type="text" name="rideto" id="rideto" placeholder="Your destination"  required>
                    </p>
                    <p>
                        <span class="title">Date</span><br>
                        <input type="date" name="ridedate" required>
                    </p>
                    <p>
                        <span class="title">Time</span><br>
                        <input type="text" placeholder="12:00" name="ridetime" required>
                    </p>
                    <p>
                        <span class="title">Meridiem</span><br>
                        <select name="ridemeridiem" id="ridemeridiem">
                            <option value="PM">PM</option>
                            <option value="AM">AM</option>
                        </select>
                    </p>
                    <div id="tripinfo" class="text-align-center display-none">
                        <p>
                            <span>Distance <strong id="tripdistance"></strong></span><br>
                            <span>Estimated time <strong id="triptime"></strong></span><br>
                            <span class="title">Charges R<strong class="title" id="tripcharges"></strong></span>
                        </p>
                    </div>
                    <p>
                        <input type="hidden" id="ridecharges" name="ridecharges">
                        <input type="hidden" id="ridefromcoords" name="ridefromcoords">
                        <input type="hidden" id="ridetocoords" name="ridetocoords">
                        <input type="hidden" id="ridedistance" name="ridedistance">
                        <input type="hidden" id="rideduration" name="rideduration">

                        <button id="save" class="display-none">Save</button>
                    </p>
                </form>
            </div>
        </div>
        <div class="bottom-controls">
            <div class="bottom-controls-item">
                <a href="/ride/dashboard">
                    <span class="material-icons-round">
                    home
                    </span><br>
                 
                </a>
            </div>
            <div class="bottom-controls-item">
                <a href="/ride/history">
                    <span class="material-icons-round">
                    watch_later
                    </span><br>
                   
                </a>
            </div>
            <div class="bottom-controls-item">
                <a href="/ride/plans">
                    <span class="material-icons-round">
                    travel_explore
                    </span><br>
           
                </a>
            </div>
            <div class="bottom-controls-item">
                <a href="/ride/drivers">
                    <span class="material-icons-round">
                    local_taxi
                    </span><br>
               
                </a>
            </div>
            <div class="bottom-controls-item">
                <a href="/ride/offers">
                    <span class="material-icons-round">
                    local_offer
                    </span><br>
              
                </a>
            </div>
            <div class="bottom-controls-item">
                <a href="/ride/profile">
                    <span class="material-icons-round">
                    account_circle
                    </span><br>
                 
                </a>
            </div>
        </div>
    </div>
    <script src="{{ $links['js'] }}"></script>
    <script>
        function initAutocomplete() {
            let from, to;
            var points = false;
            let directionsRenderer = new google.maps.DirectionsRenderer();

            const map = new google.maps.Map(document.getElementById("map"), {
            center: { lat: -33.8688, lng: 151.2195 },
            zoom: 13,
            mapId: "4cce301a9d6797df",
            disableDefaultUI: true,
            });

            // Create the search box and link it to the UI element.
            const inputFrom = document.getElementById("ridefrom");
            const searchBoxFrom = new google.maps.places.SearchBox(inputFrom);
            
            const inputTo = document.getElementById("rideto");
            const searchBoxTo = new google.maps.places.SearchBox(inputTo);

            map.addListener("bounds_changed", () => {
                searchBoxFrom.setBounds(map.getBounds());
            });

            map.addListener("bounds_changed", () => {
                searchBoxTo.setBounds(map.getBounds());
            });

            let markers = [];

            searchBoxFrom.addListener("places_changed", () => {
            const places = searchBoxFrom.getPlaces();
        
            if (places.length == 0) {
                return;
            }
            // Clear out the old markers.
            markers.forEach((marker) => {
                marker.setMap(null);
            });
            markers = [];
            // For each place, get the icon, name and location.
            const bounds = new google.maps.LatLngBounds();
            places.forEach((place) => {
                if (!place.geometry || !place.geometry.location) {
                console.log("Returned place contains no geometry");
                return;
                }
                from = place.geometry.location;
                
                // Create a marker for each place.
                markers.push(
                new google.maps.Marker({
                    map,
                    title: place.name,
                    position: place.geometry.location,
                })
                );
        
                if (place.geometry.viewport) {
                // Only geocodes have viewport.
                bounds.union(place.geometry.viewport);
                } else {
                bounds.extend(place.geometry.location);
                }
            });
            map.fitBounds(bounds);
            if(points){
                drawLine(from, to, map, directionsRenderer);
            }
            });

            searchBoxTo.addListener("places_changed", () => {
                const places = searchBoxTo.getPlaces();
            
                if (places.length == 0) {
                return;
                }
                // Clear out the old markers.
                markers.forEach((marker) => {
                marker.setMap(null);
                });
                markers = [];
                // For each place, get the icon, name and location.
                const bounds = new google.maps.LatLngBounds();
                places.forEach((place) => {
                if (!place.geometry || !place.geometry.location) {
                    console.log("Returned place contains no geometry");
                    return;
                }
                to = place.geometry.location;
                /*const icon = {
                    url: place.icon,
                    size: new google.maps.Size(71, 71),
                    origin: new google.maps.Point(0, 0),
                    anchor: new google.maps.Point(17, 34),
                    scaledSize: new google.maps.Size(25, 25),
                };*/
                // Create a marker for each place.
                markers.push(
                    new google.maps.Marker({
                    map,
                    title: place.name,
                    position: place.geometry.location,
                    })
                );
            
                if (place.geometry.viewport) {
                    // Only geocodes have viewport.
                    bounds.union(place.geometry.viewport);
                } else {
                    bounds.extend(place.geometry.location);
                }
                });
                map.fitBounds(bounds);
                points = true;
                drawLine(from, to, map, directionsRenderer);
            });
        }
        
        function drawLine(origin, destination, map, directionsRenderer){
            let directionsService = new google.maps.DirectionsService();
            directionsRenderer.setMap(map); // Existing map object displays directions
            // Create route from existing points used for markers
            const route = {
                origin: origin,
                destination: destination,
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
                    document.querySelector("#save").style.display = "block";
                    document.querySelector("#tripdistance").innerHTML = directionsData.distance.text;
                    document.querySelector("#triptime").innerHTML = directionsData.duration.text;
                    document.querySelector("#tripcharges").innerHTML = parseFloat((directionsData.distance.value/1000) * 3.50).toFixed(2);
                    
                    document.querySelector("#ridecharges").value = parseFloat((directionsData.distance.value/1000) * 3.50).toFixed(2);
                    document.querySelector("#ridefromcoords").value = JSON.stringify(origin);
                    document.querySelector("#ridetocoords").value = JSON.stringify(destination);
                    document.querySelector("#ridedistance").value = directionsData.distance.text;
                    document.querySelector("#rideduration").value = directionsData.duration.text;
                  }
                }
            });
        }
    </script>
    <script
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCNarbofdMvrgaKRZ9e_LvJD2miCEOS6D0&callback=initAutocomplete&libraries=places&v=weekly"
    async
    ></script>
</body>
</html>