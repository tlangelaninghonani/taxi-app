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
                <span class="">Request to {{ $driveAuth->drive_first_name }}</span>
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
        <div class="curved-top">
            <div id="map"></div>
            @if($rideData->ride_promo > 0)
            <p>
                <div class="display-flex-center">  
                    <span class="material-icons-round">
                    card_giftcard
                    </span>
                    <span>R{{ $rideData->ride_promo }} off applied</span>
                </div>
            </p>
            @endif
            @if(sizeof(json_decode($driveData->drive_cities, true)) > 0)
                <p>
                    <div class="display-flex-normal gap-small">
                        <span class="material-icons-round icon-padding">
                        swipe
                        </span>
                        <div class="city-container">
                            @foreach(json_decode($driveData->drive_cities, true) as $city)
                                <div class="city">
                                    {{ $city }}
                                </div>
                            @endforeach
                        </div>
                    </div>
                </p>
                <form class="app-padding" action="/ride/{{ $driveAuth->id }}/request" method="POST">
                @csrf
                @method("POST")
                <input type="hidden" value="{{  $driveAuth->id }}" name="rideid" id="rideid">

                    <div class="display-flex-normal">
                    </div>
                    <input type="text" name="ridefrom" id="ridefrom" placeholder="Pick-up" required>
             
                <p>
                    <div class="display-flex-normal">
                    </div>
                    <input type="text" name="rideto" id="rideto" placeholder="Your destination"  required>
                </p>
                <div id="tripinfo" class="text-align-center display-none">
                    <p>
                        <span>Distance <strong id="tripdistance"></strong></span><br>
                        <span>Estimated time <strong id="triptime"></strong></span><br>
                        <span class="title">Charges <strong>R</strong><strong class="title" id="tripcharges"></strong></span>
                    </p>
                </div>
                <p>
                    <input type="hidden" id="ridecharges" name="ridecharges">
                    <input type="hidden" id="ridefromcoords" name="ridefromcoords">
                    <input type="hidden" id="ridetocoords" name="ridetocoords">
                    <input type="hidden" id="ridedistance" name="ridedistance">
                    <input type="hidden" id="rideduration" name="rideduration">

                    <button id="mapbutton" class="display-none">Request</button>
                </p>
            </form>
            @else
                <form class="app-padding" action="/ride/{{ $driveAuth->id }}/request" method="POST">
                    @csrf
                    @method("POST")
                    <input type="hidden" value="{{  $driveAuth->id }}" name="rideid" id="rideid">
                    <p>
                        <div class="display-flex-normal">
                        </div>
                        <input type="text" name="ridefrom" id="ridefrom" placeholder="Pick-up" required>
                    </p>
                    <p>
                        <div class="display-flex-normal">
                        </div>
                        <input type="text" name="rideto" id="rideto" placeholder="Your destination"  required>
                    </p>
                    <div id="tripinfo" class="text-align-center display-none">
                        <p>
                            <span>Distance <strong id="tripdistance"></strong></span><br>
                            <span>Estimated time <strong id="triptime"></strong></span><br>
                            <span class="title">Charges <strong>R</strong><strong class="title" id="tripcharges"></strong></span>
                        </p>
                    </div>
                    <p>
                        <input type="hidden" id="ridecharges" name="ridecharges">
                        <input type="hidden" id="ridefromcoords" name="ridefromcoords">
                        <input type="hidden" id="ridetocoords" name="ridetocoords">
                        <input type="hidden" id="ridedistance" name="ridedistance">
                        <input type="hidden" id="rideduration" name="rideduration">

                        <button id="mapbutton" class="display-none">Request</button>
                    </p>
                </form>
            @endif
            
        </div>
    </div>
    <script src="{{ $links['js'] }}"></script>
    <script>
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
                    document.querySelector("#mapbutton").style.display = "block";
                    document.querySelector("#tripdistance").innerHTML = directionsData.distance.text;
                    document.querySelector("#triptime").innerHTML = directionsData.duration.text;
                    document.querySelector("#tripcharges").innerHTML = parseFloat((directionsData.distance.value/1000) * parseInt("{{ $links['internalAdmin']->minimum_price }}") - parseInt("{{ $rideData->ride_promo }}")).toFixed(2);
                    
                    if(document.querySelector("#ridecharges")){
                        document.querySelector("#ridecharges").value = parseFloat((directionsData.distance.value/1000) * parseInt("{{ $links['internalAdmin']->minimum_price }}") - parseInt("{{ $rideData->ride_promo }}")).toFixed(2);
                        document.querySelector("#ridefromcoords").value = JSON.stringify(origin);
                        document.querySelector("#ridetocoords").value = JSON.stringify(destination);
                        document.querySelector("#ridedistance").value = directionsData.distance.text;
                        document.querySelector("#rideduration").value = directionsData.duration.text;
                    }
                
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