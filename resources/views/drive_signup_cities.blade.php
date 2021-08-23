<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="stylesheet" href="{{ $links['css'] }}">
    <title>Drive sign up</title>
</head>
<body>
    <div class="container">
        <div class="nav">
            <div class="display-flex-normal gap-10">
                <span class="material-icons-round" onclick="redirectBack()">
                arrow_back
                </span>
                <span class="">5 cities to drive at</span>
            </div>
        </div>
        <div class="curved-top">
            <div id="map"></div>
            <p>
                <div class="text-align-center app-padding">
                    <span class="title">Choose a maximum of 5 cities you want to drive back-forth</span>
                </div>
            </p>
            <p>
                <div id="citycontainer" class="city-container">

                </div>
            </p>
            <p>
                <form id="citiesform" action="/drive/signup/cities" method="POST">
                    @csrf
                    @method("POST")
                    <div class="display-flex-normal gap-10">
                        <input id="ridefrom" type="text" placeholder="Type a city">
                        <input type="hidden" id="cities" name="cities">
                        <span onclick="addCity()" class="material-icons-round black-background">
                        add
                        </span>
                    </div>
                    <p>
                        <button type="button" onclick="jsonCitiesAndSubmit('citiesform')">Next</button>
                    </p>
                </form>
            </p>
        </div>
    </div>
    <script src="{{ $links['js'] }}"></script>
    <script>
        function initAutocomplete() {
            let from, to;
            var points = false;
            var directionsOptions = {
                polylineOptions: {
                    strokeColor: 'red',
                    strokeWeight: 2,
                }
            }
            let directionsRenderer = new google.maps.DirectionsRenderer(directionsOptions);

            const map = new google.maps.Map(document.getElementById("map"), {
            center: { lat: -33.8688, lng: 151.2195 },
            zoom: 13,
            mapId: "4cce301a9d6797df",
            disableDefaultUI: true,
            fullscreenControl: true
            });

            // Create the search box and link it to the UI element.
            const inputFrom = document.getElementById("ridefrom");
            const searchBoxFrom = new google.maps.places.SearchBox(inputFrom);
            
            map.addListener("bounds_changed", () => {
                searchBoxFrom.setBounds(map.getBounds());
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
                        animation: google.maps.Animation.DROP,
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
            });
        }
    </script>
    <script
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCNarbofdMvrgaKRZ9e_LvJD2miCEOS6D0&callback=initAutocomplete&libraries=places&v=weekly"
    async
    ></script>
</body>
</html>