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
        <span class="material-icons-round" onclick="redirectBack()">
        arrow_back
        </span><br>
        <p>
            <div class="display-center">
                <div class="text-align-center">
                    <img class="profile-image-large" src="{{ $rideData->ride_profile_image }}" alt=""><br>
                    <span class="title">{{ $rideAuth->ride_first_name." ".$rideAuth->ride_last_name }}</span><br>
                </div>
            </div>
        </p>
        <div class="curved-top">
            <form action="/drive/{{ $rideAuth->id }}/offer/accept" method="POST">
                @csrf
                @method("POST")
                <p>
                    <div class="display-flex-justify-center">
                        <div>
                            <span class="material-icons-round">
                            local_offer
                            </span>
                        </div>
                        <div>
                            <span class="title">Offer</span>
                        </div>
                    </div>
                </p>
                <p>
                    <span class="title">Pick-up place</span><br>
                    <span>{{ $drive_offer_ride_from }}</span>
                </p>
                <p>
                    <span class="title">Destination</span><br>
                    <span>{{ $drive_offer_ride_to }}</span>
                </p>
                <p>
                    <span class="title">Date and Time</span><br>
                    <span>{{ $drive_offer_ride_date_time }}</span>
                </p>
                <p>
                    <span class="title">How much you charging for this trip?</span><br>
                    <span>(In rand)</span><br>
                    <input type="number" placeholder="Enter amount you charging for this trip" name="charge">
                </p> 
                <p>
                    <input type="hidden" name="ridefrom" value="{{ $drive_offer_ride_from }}">
                    <input type="hidden" name="rideto" value="{{ $drive_offer_ride_to }}">
                    <input type="hidden" name="ridedatetime" value="{{ $drive_offer_ride_date_time }}">
                    <input type="hidden" name="planid" value="{{ $plan_id }}">
                    <button>Offer</button>
                </p>
            </form>
        </div>
    </div>
    <script src="{{ $links['js'] }}"></script>
</body>
</html>