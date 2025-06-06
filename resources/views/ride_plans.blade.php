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
                <span class="material-icons-round" onclick="redirectBack()">
                arrow_back
                </span>
                <span class="">Ride plans for later</span>
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
        <p>
            <div class="make-new-plan" onclick="closePopup('newplan')">
                <span class="material-icons-round new-plan-icon" id="closenewplan">
                add
                </span>
                <span>New plan</span>
            </div>
        </p>
        <div id="plans">
            @if($plans::where("ride_id", $rideAuth->id)->count() > 0)
                @foreach($plans::where("ride_id", $rideAuth->id)->get() as $plan)
                    <p>
                        <div class="display-flex" onclick="redirectTo('/ride/{{ $plan->id }}/plans/view')">
                            <div>
                                <span class="material-icons-round plan-icon">
                                schedule
                                </span>
                            </div>
                            <div class="trunc-text">
                                <span class="title">{{ $plan->ride_date }} {{ $plan->ride_time }} {{ $plan->ride_meridiem }}</span><br> 
                                <span>Pick-up <strong>{{ $plan->ride_from }}</strong></span><br>
                                <span>Drop <strong>{{ $plan->ride_to }}</strong></span><br>

                                <span>Charges <strong>R{{ $plan->ride_charges }}</strong></span>
                            </div>
                        </div>
                    </p>
                @endforeach
            @else
                <div class="text-align-center">
                    <span class="material-icons-round icon-large">
                    travel_explore
                    </span><br>
                    <span>No plans</span>
                </div>
            @endif
        </div>
        <div id="newplan" class="new-plan display-none">
            <div class="curved-top">
                <div class="nav display-flex-space-between">
                    <span>New plan</span>
                    <span class="material-icons-round newplan" onclick="closePopup('newplan')">
                    close
                    </span>
                </div>
                <div id="map"></div>
                <form class="app-padding" action="/ride/plans" method="POST">
                    @csrf
                    @method("POST")
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
                    <p>
                        <input type="text" name="ridefrom" id="ridefrom" placeholder="Pick-up" required>
                    </p>
                    <p>
                        <input type="text" name="rideto" id="rideto" placeholder="Your destination"  required>
                    </p>
                    <p>
                        <input type="date" name="ridedate" required>
                    </p>
                    <p>
                        <input type="text" placeholder="12:00" name="ridetime" required>
                    </p>
                    <p>
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

                        <button id="mapbutton" class="display-none">Save</button>
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
            <div class="bottom-controls-item focused">
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
                    document.querySelector("#tripcharges").innerHTML = parseFloat((directionsData.distance.value/1000) * parseInt("{{ $admin->minimum_price }}") - parseInt("{{ $rideData->ride_promo }}")).toFixed(2);
                    
                    if(document.querySelector("#ridecharges")){
                        document.querySelector("#ridecharges").value = parseFloat((directionsData.distance.value/1000) * parseInt("{{ $admin->minimum_price }}") - parseInt("{{ $rideData->ride_promo }}")).toFixed(2);
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