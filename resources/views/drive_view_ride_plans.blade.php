<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="stylesheet" href="{{ $links['css'] }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View ride plans</title>
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
        <div>
            <div class="display-none">
                {{ $counter = 0 }}
                {{ $ridePlansIndex = 0 }}
            </div>
            @foreach(json_decode($rideData->ride_plans, true) as $ridePlans) 
                <div class="display-none">
                    {{ $counter++ }}
                </div>
                @if($counter < 2)     
                    <div class="curved-top" id="plan-{{ $counter }}">
                        <div id="map{{ $counter }}" class="map"></div>
                        <div class="app-padding">
                            <span class="title">Pick-up place</span><br>
                            <span>{{ $ridePlans["ride_from"] }}</span><br>
                            <span class="title">Destination</span><br>
                            <span>{{ $ridePlans["ride_to"] }}</span><br>
                            <span class="title">Date</span><br>
                            <span>{{ $ridePlans["ride_date"] }}</span><br>
                            <span class="title">Time</span><br>
                            <span>{{ $ridePlans["ride_time"] }}</span>
                            <span>{{ $ridePlans["ride_meridiem"] }}</span>
                            <div id="tripinfo{{ $counter }}" class="text-align-center display-none">
                                <p>
                                    <span>Distance <strong id="tripdistance{{ $counter }}"></strong></span><br>
                                    <span>Estimated time <strong id="triptime{{ $counter }}"></strong></span><br>
                                    <span class="title">Charges R<strong class="title" id="tripcharges{{ $counter }}"></strong></span>
                                </p>
                            </div>
                            <p>
                                <form action="/drive/{{ $rideAuth->id }}/{{ $counter }}/offer" method="POST">
                                    @csrf
                                    @method("POST")
                                    <input type="hidden" name="ridefrom" value="{{ $ridePlans['ride_from'] }}">
                                    <input type="hidden" name="rideto" value="{{ $ridePlans['ride_to'] }}">
                                    <input type="hidden" name="ridedatetime" value="{{ $ridePlans['ride_date'] }} {{ $ridePlans['ride_time'] }} {{ $ridePlans['ride_meridiem'] }}">
                                    <div class="display-none">
                                        {{ $isOffered = false }}
                                    </div>
                                    @if(array_key_exists($driveAuth->id, json_decode($rideData->ride_offers, true)))
                                        @foreach(json_decode($rideData->ride_offers, true)[$driveAuth->id] as $k => $v)
                                            @if($k == $ridePlansIndex)
                                                <div class="display-none">
                                                    {{ $isOffered = true }}
                                                </div>
                                                <input type="hidden" name="action" value="cancel">
                                                <div class="text-align-center">
                                                    <p>
                                                        <span class="title">You offered {{ $rideAuth->ride_first_name }} a ride for this plan</span>
                                                    </p>
                                                    <p>
                                                        <button>Cancel</button>
                                                    </p>
                                                </div>
                                                @break
                                            @endif
                                        @endforeach
                                    @endif
                                    @if($isOffered == false)
                                    <input type="hidden" name="action" value="offer">    
                                        <button>Offer</button>
                                    @endif
                                </form>
                            </p>
                            @if(sizeof(json_decode($rideData->ride_plans, true)) != 1)
                                <div class="display-none">
                                    {{ $originLat = $ridePlansData[$counter + 1]["originLat"] }}
                                    {{ $originLng = $ridePlansData[$counter + 1]["originLng"] }}
                                    {{ $destLat = $ridePlansData[$counter + 1]["destLat"] }}
                                    {{ $destLng = $ridePlansData[$counter + 1]["destLng"] }}
                                </div>
                                <span class="material-icons-round next-plan" onclick="nextPlan('plan-{{ $counter }}', 'plan-{{ $counter + 1 }}', '{{ $originLat }}', '{{ $originLng  }}', '{{ $destLat }}', '{{ $destLng }}', 'map{{ $counter + 1 }}')">
                                arrow_forward
                                </span>
                            @endif
                        </div>
                    </div>
                @else
                    @if($counter < sizeof(json_decode($rideData->ride_plans, true))) 
                        <div class="curved-top display-none" id="plan-{{ $counter }}">
                            <div id="map{{ $counter }}" class="map"></div>
                            <div class="app-padding">
                                <span class="title">Pick-up place</span><br>
                                <span>{{ $ridePlans["ride_from"] }}</span><br>
                                <span class="title">Destination</span><br>
                                <span>{{ $ridePlans["ride_to"] }}</span><br>
                                <span class="title">Date</span><br>
                                <span>{{ $ridePlans["ride_date"] }}</span><br>
                                <span class="title">Time</span><br>
                                <span>{{ $ridePlans["ride_time"] }}</span>
                                <span>{{ $ridePlans["ride_meridiem"] }}</span>
                                <div id="tripinfo{{ $counter }}" class="text-align-center display-none">
                                    <p>
                                        <span>Distance <strong id="tripdistance{{ $counter }}"></strong></span><br>
                                        <span>Estimated time <strong id="triptime{{ $counter }}"></strong></span><br>
                                        <span class="title">Charges R<strong class="title" id="tripcharges{{ $counter }}"></strong></span>
                                    </p>
                                </div>
                                <p>
                                    <form action="/drive/{{ $rideAuth->id }}/{{ $counter }}/offer" method="POST">
                                        @csrf
                                        @method("POST")
                                        <input type="hidden" name="ridefrom" value="{{ $ridePlans['ride_from'] }}">
                                        <input type="hidden" name="rideto" value="{{ $ridePlans['ride_to'] }}">
                                        <input type="hidden" name="ridedatetime" value="{{ $ridePlans['ride_date'] }} {{ $ridePlans['ride_time'] }} {{ $ridePlans['ride_meridiem'] }}">
                                        <div class="display-none">
                                            {{ $isOffered = false }}
                                        </div>
                                        @if(array_key_exists($driveAuth->id, json_decode($rideData->ride_offers, true)))
                                            @foreach(json_decode($rideData->ride_offers, true)[$driveAuth->id] as $k => $v)
                                                @if($k == $ridePlansIndex)
                                                    <div class="display-none">
                                                        {{ $isOffered = true }}
                                                    </div>
                                                    <input type="hidden" name="action" value="cancel">
                                                    <div class="text-align-center">
                                                        <p>
                                                            <span class="title">You offered {{ $rideAuth->ride_first_name }} a ride for this plan</span>
                                                        </p>
                                                        <p>
                                                            <button>Cancel</button>
                                                        </p>
                                                    </div>
                                                    @break
                                                @endif
                                            @endforeach
                                        @endif
                                        @if($isOffered == false)
                                        <input type="hidden" name="action" value="offer">    
                                            <button>Offer</button>
                                        @endif
                                    </form>
                                </p>
                            </div>
                            <div class="display-none">
                                {{ $originLatNext = $ridePlansData[$counter + 1]["originLat"] }}
                                {{ $originLngNext = $ridePlansData[$counter + 1]["originLng"] }}
                                {{ $destLatNext = $ridePlansData[$counter + 1]["destLat"] }}
                                {{ $destLngNext = $ridePlansData[$counter + 1]["destLng"] }}
                            </div>
                            <div class="display-none">
                                {{ $originLatPrev = $ridePlansData[$counter - 1]["originLat"] }}
                                {{ $originLngPrev = $ridePlansData[$counter - 1]["originLng"] }}
                                {{ $destLatPrev = $ridePlansData[$counter - 1]["destLat"] }}
                                {{ $destLngPrev = $ridePlansData[$counter - 1]["destLng"] }}
                            </div>
                            <span class="material-icons-round next-plan-back" onclick="nextPlanEnd('plan-{{ $counter }}', 'plan-{{ $counter - 1 }}', '{{ $originLatPrev }}', '{{ $originLngPrev }}', '{{ $destLatPrev }}', '{{ $destLngPrev }}', 'map{{ $counter - 1 }}')">
                            arrow_back
                            </span>
                            <span class="material-icons-round next-plan" onclick="nextPlan('plan-{{ $counter }}', 'plan-{{ $counter + 1 }}', '{{ $originLatNext }}', '{{ $originLngNext  }}', '{{ $destLatNext }}', '{{ $destLngNext }}', 'map{{ $counter + 1 }}')">
                            arrow_forward
                            </span>
                        </div>
                    @else
                        <div class="curved-top display-none" id="plan-{{ $counter }}">
                            <div id="map{{ $counter }}" class="map"></div>
                            <div class="app-padding">
                                <span class="title">Pick-up place</span><br>
                                <span>{{ $ridePlans["ride_from"] }}</span><br>
                                <span class="title">Destination</span><br>
                                <span>{{ $ridePlans["ride_to"] }}</span><br>
                                <span class="title">Date</span><br>
                                <span>{{ $ridePlans["ride_date"] }}</span><br>
                                <span class="title">Time</span><br>
                                <span>{{ $ridePlans["ride_time"] }}</span>
                                <span>{{ $ridePlans["ride_meridiem"] }}</span>
                                <div id="tripinfo{{ $counter }}" class="text-align-center display-none">
                                    <p>
                                        <span>Distance <strong id="tripdistance{{ $counter }}"></strong></span><br>
                                        <span>Estimated time <strong id="triptime{{ $counter }}"></strong></span><br>
                                        <span class="title">Charges R<strong class="title" id="tripcharges{{ $counter }}"></strong></span>
                                    </p>
                                </div>
                                <p>
                                    <form action="/drive/{{ $rideAuth->id }}/{{ $counter }}/offer" method="POST">
                                        @csrf
                                        @method("POST")
                                        <input type="hidden" name="ridefrom" value="{{ $ridePlans['ride_from'] }}">
                                        <input type="hidden" name="rideto" value="{{ $ridePlans['ride_to'] }}">
                                        <input type="hidden" name="ridedatetime" value="{{ $ridePlans['ride_date'] }} {{ $ridePlans['ride_time'] }} {{ $ridePlans['ride_meridiem'] }}">
                                        <div class="display-none">
                                            {{ $isOffered = false }}
                                        </div>
                                        @if(array_key_exists($driveAuth->id, json_decode($rideData->ride_offers, true)))
                                            @foreach(json_decode($rideData->ride_offers, true)[$driveAuth->id] as $k => $v)
                                                @if($k == $ridePlansIndex)
                                                    <div class="display-none">
                                                        {{ $isOffered = true }}
                                                    </div>
                                                    <input type="hidden" name="action" value="cancel">
                                                    <div class="text-align-center">
                                                        <p>
                                                            <span class="title">You offered {{ $rideAuth->ride_first_name }} a ride for this plan</span>
                                                        </p>
                                                        <p>
                                                            <button>Cancel</button>
                                                        </p>
                                                    </div>
                                                    @break
                                                @endif
                                            @endforeach
                                        @endif
                                        @if($isOffered == false)
                                        <input type="hidden" name="action" value="offer">    
                                            <button>Offer</button>
                                        @endif
                                    </form>
                                </p>
                            </div>
                            <div class="display-none">
                                {{ $originLatPrev = $ridePlansData[$counter - 1]["originLat"] }}
                                {{ $originLngPrev = $ridePlansData[$counter - 1]["originLng"] }}
                                {{ $destLatPrev = $ridePlansData[$counter - 1]["destLat"] }}
                                {{ $destLngPrev = $ridePlansData[$counter - 1]["destLng"] }}
                            </div>
                            <span class="material-icons-round next-plan-back" onclick="nextPlanEnd('plan-{{ $counter }}', 'plan-{{ $counter - 1 }}', '{{ $originLatPrev }}', '{{ $originLngPrev }}', '{{ $destLatPrev }}', '{{ $destLngPrev }}', 'map{{ $counter - 1 }}')">
                            arrow_back
                            </span>
                        </div>
                    @endif
                @endif
                <div class="display-none">
                    {{ $ridePlansIndex++ }}
                </div>
            @endforeach
        </div>
    </div>
    <script src="{{ $links['js'] }}"></script>
    <script>
    function drawLine(originLat, originLng, destLat, destLng, mapId){

        if(! originLat && ! originLng){
            var originLat = parseFloat("{{ $ridePlansData[1]['originLat'] }}");
            var originLng = parseFloat("{{ $ridePlansData[1]['originLng'] }}");

            var destLat = parseFloat("{{ $ridePlansData[1]['destLat']  }}");
            var destLng = parseFloat("{{ $ridePlansData[1]['destLng']  }}");

            var mapId = "map1";
        }else{
            var originLat = parseFloat(originLat);
            var originLng = parseFloat(originLng);

            var destLat = parseFloat(destLat);
            var destLng = parseFloat(destLng);
        }

        tripInfoId = mapId.substr(3, 1);

        
        const map = new google.maps.Map(document.getElementById(mapId), {
        center: { lat: -33.8688, lng: 151.2195 },
        zoom: 2,
        mapId: "4cce301a9d6797df",
        disableDefaultUI: true,
        });


        let directionsService = new google.maps.DirectionsService();
        directionsRenderer = new google.maps.DirectionsRenderer();
        directionsRenderer.setMap(map); // Existing map object displays directions
        // Create route from existing points used for markers
        const route = {
            origin: { lat: originLat, lng: originLng },
            destination: { lat: destLat, lng: destLng },
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
                    
                    document.querySelector("#tripinfo"+tripInfoId).style.display = "block";
                    document.querySelector("#tripdistance"+tripInfoId).innerHTML = directionsData.distance.text;
                    document.querySelector("#triptime"+tripInfoId).innerHTML = directionsData.duration.text;
                    document.querySelector("#tripcharges"+tripInfoId).innerHTML = parseFloat((directionsData.distance.value/1000) * 3.50).toFixed(2);
                
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