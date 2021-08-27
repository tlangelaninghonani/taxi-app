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
        <div class="nav">
            <div class="display-flex-normal gap-10">
                <span class="">Where you going today?</span>
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
        <!--<p>
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
        </p>-->
        @if($rideData->ride_on_trip == false)
            @if($requestInstant)
            <div class="curved-top">
                <div id="map"></div>
                    <div class="app-padding">
                        <p>
                            <div class="text-align-center">
                                <div class="display-flex-justify-center">
                                    <span class="title">Pick-up</span><br>
                                </div>
                                <span>{{ $requestInstant->ride_from }}</span><br>
                                <div class="display-flex-justify-center">
                                    <span class="title">Drop</span><br>
                                </div>
                                <span>{{ $requestInstant->ride_to }}</span>
                            </div>
                        </p>
                        <div id="tripinfo" class="text-align-center ">
                            <p>
                                <span>Distance <strong id="tripdistance">{{ $requestInstant->ride_distance }}</strong></span><br>
                                <span>Estimated time <strong id="triptime">{{ $requestInstant->ride_duration }}</strong></span><br>
                                <span class="title">Charges R<strong class="title" id="tripcharges">{{ $requestInstant->ride_charges }}</strong></span>
                            </p>
                        </div>
                        <div class="display-none">
                            {{ $driveA = $driveAuth::find($requestInstant->drive_id) }}
                        </div>
                        @if($driveA)
                            <div class="display-none">
                                {{ $driveD = $driveData::where("drive_id", $driveA->id)->first() }}
                            </div>
                            <p>
                                <div class="display-flex-normal gap-10" onclick="redirectTo('')">
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
                                            <span>Drives - <strong>{{ $driveD->drive_vehicle }} - </strong></span>
                                            <strong>{{ $driveD->drive_vehicle_type }}</strong>
                                        </div>
                                        <div class="display-flex-normal gender">
                                            @if($driveA->drive_gender == "Male")
                                                <span>Gender - <strong>{{ $driveA->drive_gender }}</strong></span>
                                            @elseif($driveA->drive_gender == "Female")
                                                <span>Gender - <strong>{{ $driveA->drive_gender }}</strong></span>
                                            @else
                                                <span>Gender - <strong>{{ $driveA->drive_gender }}</strong></span>
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
                            <p>
                                <div class="display-flex-center-align">
                                    <span class="material-icons-round">
                                    local_taxi
                                    </span>
                                    <div>
                                        <span>Plate - {{ $driveD->drive_vehicle_plate }}</span><br>
                                        <span>Color - {{ $driveD->drive_vehicle_color }}</span>
                                    </div>
                                </div>
                            </p>
                            <p>
                                <div class="text-align-center">
                                    <span class="title">{{ $driveA->drive_first_name }} is on the way to pick you up</span>
                                </div>
                            </p>
                            <form id="nextdriverform" action="/ride/{{ $requestInstant->id }}/request/instant/next" method="POST">
                            @csrf
                            @method("POST")
                            </form>
                            <p>
                                <form action="/ride/{{ $requestInstant->id }}/request/instant/cancel" method="POST">
                                @csrf
                                @method("POST")
                                    <div class="display-flex-normal">
                                        <button>Cancel request</button>
                                        <div class="text-align-center button-icon" onclick="submitForm('nextdriverform')">
                                            <span class="material-icons-round">
                                            skip_next
                                            </span><br>
                                            <span>Next</span>
                                        </div>
                                    </div>
                                </form>
                            </p>
                        @else
                        <p>
                            <div class="text-align-center">
                                <span class="title">Waiting for drivers to accept your request</span>
                            </div>
                        </p>
                        <p>
                            <form action="/ride/{{ $requestInstant->id }}/request/instant/cancel" method="POST">
                            @csrf
                            @method("POST")
                            <button>Cancel request</button>
                        </p>
                        @endif
                    </div>
                </div>
            </div>
            <script>
            function drawLineInl(){
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
                    origin: {lat: parseFloat("{{ $requestInstant->ride_from_lat }}"), lng: parseFloat("{{ $requestInstant->ride_from_lng }}")},
                    destination: {lat: parseFloat("{{ $requestInstant->ride_to_lat }}"), lng: parseFloat("{{ $requestInstant->ride_to_lng }}")},
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
            src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCNarbofdMvrgaKRZ9e_LvJD2miCEOS6D0&callback=drawLineInl&libraries=places&v=weekly"
            async
            ></script>
            @else
                <div class="curved-top">
                    <div id="map"></div>
                    <div class="app-padding">
                        <form action="/ride/request/instant" method="POST">
                            @csrf
                            @method("POST")
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
                            <div id="choosecarcontainer" class="choose-car-container display-none">
                                <div class="nav display-flex-space-between">
                                    <span>Choose a ride</span>
                                    <span class="material-icons-round newplan" onclick="closePopup('choosecarcontainer')">
                                    close
                                    </span>
                                </div>
                                <img class="welcome-page-banner-1" src="https://cdn.dribbble.com/users/1138006/screenshots/12921013/arterndesign_uberlibrary_sfo_2x.png" alt="">
                                <div class="text-align-center">
                                    <p>
                                        <span class="title">Choose a <strong>sutaible</strong> ride for your trip</span>
                                    </p>
                                </div>    
                                <div class="box-shadow-abs">
                                    <div class="choose-car">
                                        <img src="https://www.uber-assets.com/image/upload/f_auto,q_auto:eco,c_fill,w_558,h_372/v1548646935/assets/64/93c255-87c8-4e2e-9429-cf709bf1b838/original/3.png" alt="">
                                        <div>
                                            <span class="title-mid">InterCityRides <strong>Go</strong></span><br>
                                            <span class="title-small">2 door</span>
                                        </div>
                                    </div>
                                    <div class="choose-car">
                                        <img src="https://www.uber-assets.com/image/upload/f_auto,q_auto:eco,c_fill,w_558,h_372/v1548646935/assets/64/93c255-87c8-4e2e-9429-cf709bf1b838/original/3.png" alt="">
                                        <div>
                                        <span class="title-mid">InterCityRides <strong>X</strong></span><br>
                                            <span class="title-small">4 door</span>
                                        </div>
                                    </div>
                                    <div class="choose-car">
                                        <img src="https://www.uber-assets.com/image/upload/f_auto,q_auto:eco,c_fill,w_558,h_372/v1548646918/assets/e9/2eeb8f-3764-4e26-8b17-5905a75e7e85/original/2.png" alt="">
                                        <div>
                                            <span class="title-mid">InterCityRides <strong>XL</strong></span><br>
                                            <span class="title-small">2 door (SUV)</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
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
                    </div>
                </div>
                <script
                src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCNarbofdMvrgaKRZ9e_LvJD2miCEOS6D0&callback=initAutocomplete&libraries=places&v=weekly"
                async
                ></script>
            @endif
        @else
            <div class="display-none">
                {{ $driveAuth = $driveAuth::find($trip->drive_id) }}
                {{ $driveData = $driveData::where("drive_id", $driveAuth->id)->first() }}
            </div>
            <div class="curved-top padding-none">
                <div id="map"></div>
                <div class="curved-top-padding">
                    <p>
                        <div class="text-align-center">
                            <span class="title">On trip wth {{ $driveAuth->drive_first_name." ".$driveAuth->drive_last_name }}...</span><br>
                        </div>
                        <div id="tripinfo" class="text-align-center ">
                            <p>
                                <div class="text-align-center">
                                    <div class="display-flex-justify-center">
                                        <span class="title">Pick-up</span><br>
                                    </div>
                                    <span>{{ $trip->ride_from }}</span><br>
                                    <div class="display-flex-justify-center">
                                        <span class="title">Drop</span><br>
                                    </div>
                                    <span>{{ $trip->ride_to }}</span>
                                </div>
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
                            <div class="display-flex-normal gap-10">
                                <button>End trip</button>
                            </div>
                        </form>
                    </p>
                </div>
            </div>
            <script>
            function drawLineInl(){
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
                    origin: {lat: parseFloat("{{ $trip->ride_from_lat }}"), lng: parseFloat("{{ $trip->ride_from_lng }}")},
                    destination: {lat: parseFloat("{{ $trip->ride_to_lat }}"), lng: parseFloat("{{ $trip->ride_to_lng }}")},
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
            src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCNarbofdMvrgaKRZ9e_LvJD2miCEOS6D0&callback=drawLineInl&libraries=places&v=weekly"
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