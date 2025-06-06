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
                <div class="display-flex-normal gap-small" onclick="redirectTo('/drive/profile')">
                    @if($driveData->drive_profile_image == "")
                        <div class="position-relative">
                            <span class="material-icons-round empty-profile-small">
                            account_circle
                            </span><br>
                        </div>
                    @else
                        <div class="position-relative">
                            <img class="profile-image-small" src="{{ $driveData->drive_profile_image }}" alt=""><br>
                        </div>
                    @endif
                    <div>
                    <span>My account</span>
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
                    <span>Phone <strong>{{ $rideAuth->ride_phone }}</strong></span>
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
                <form id="ridertochat" action="/drive/{{ $rideAuth->id }}/chat" method="POST">
                    @csrf
                    @method("POST")
                </form>
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
                @if($requestInstant->pick_up_requested)
                    @if($requestInstant->pick_up_confirmed)
                        <div class="text-align-center">
                            <span class="title">Picked {{ $rideAuth->ride_first_name }}?</span>
                        </div>
                        <p>
                            <form action="/drive/{{ $requestInstant->id }}/request/trip/start" method="POST">
                                @csrf
                                @method("POST")
                                <button>Drive</button>
                            </form>
                        </p>
                    @else
                        <div class="text-align-center">
                            <span class="title">{{ $rideAuth->ride_first_name }} requested a pick-up</span>
                        </div>
                        <p>
                            <form action="/drive/{{ $requestInstant->id }}/request/pickup/confirm" method="POST">
                                @csrf
                                @method("POST")
                                <button>Confirm pick-up</button>
                            </form>
                        </p>
                    @endif
                    
                @else
                    <div class="text-align-center">
                        <span class="title">Waiting for {{ $rideAuth->ride_first_name }} to request pick-up...</span>
                    </div>
                @endif
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