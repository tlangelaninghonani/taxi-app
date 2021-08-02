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
           <span class="material-icons-round ">
            more_vert
            </span>
        </div>
        <p>
            <div class="display-center">
                <div class="text-align-center">
                    <img class="profile-image-large" src="{{ $driveData->drive_profile_image }}" alt=""><br>
                    <span class="title">{{ $driveAuth->drive_first_name." ".$driveAuth->drive_last_name }}</span><br>
                    <div class="display-flex-center-align">
                        @if($driveAuth->drive_gender == "Male")
                            <span>Gender <strong>{{ $driveAuth->drive_gender }}</strong></span>
                        @elseif($driveAuth->drive_gender == "Female")
                            <span>Gender <strong>{{ $driveAuth->drive_gender }}</strong></span>
                        @else
                            <span>Gender <strong>{{ $driveAuth->drive_gender }}</strong></span>
                        @endif
                    </div>
                    <span>Drives <strong>{{ $driveData->drive_vehicle }} - </strong></span>
                    <strong>{{ $driveData->drive_vehicle_type }}</strong>
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
        <p>
            <div class="text-align-center">
                <span class="title">Where are you going?</span>
            </div>
        </p>
        <div class="curved-top">
            <div id="map"></div>
            <form class="app-padding" action="/ride/{{ $driveAuth->id }}/request" method="POST">
                @csrf
                @method("POST")
                <input type="hidden" value="{{  $driveAuth->id }}" name="rideid" id="rideid">
                <p>
                    <span class="title">Pick-up place</span><br>
                    <input type="text" name="ridefrom" id="ridefrom" placeholder="Pick-up place" required>
                </p>
                <p>
                    <span class="title">Destination</span><br>
                    <input type="text" name="rideto" id="rideto" placeholder="Your destination"  required>
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
                    <input type="hidden" id="ridetime" name="ridetime">

                    <button id="requestbutton" class="display-none">Request</button>
                </p>
            </form>
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
                    document.querySelector("#requestbutton").style.display = "block";
                    document.querySelector("#tripdistance").innerHTML = directionsData.distance.text;
                    document.querySelector("#triptime").innerHTML = directionsData.duration.text;
                    document.querySelector("#tripcharges").innerHTML = parseFloat((directionsData.distance.value/1000) * 3.50).toFixed(2);
                    
                    document.querySelector("#ridecharges").value = parseFloat((directionsData.distance.value/1000) * 3.50).toFixed(2);
                    document.querySelector("#ridefromcoords").value = JSON.stringify(origin);
                    document.querySelector("#ridetocoords").value = JSON.stringify(destination);
                    document.querySelector("#ridedistance").value = directionsData.distance.text;
                    document.querySelector("#ridetime").value = directionsData.duration.text;
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