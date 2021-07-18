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
           <span class="material-icons-round items-menu-icon" onclick="closePopup('menu')">
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
        <p>
            <div class="display-center">
                <div class="text-align-center">
                    <img class="profile-image-large" src="{{ $rideData->ride_profile_image }}" alt=""><br>
                    <span class="title">{{ $rideAuth->ride_first_name." ".$rideAuth->ride_last_name }}</span><br>
                    <span>From <strong>{{ $rideRequest["ride_from"] }}</strong></span><br>
                    <span>To <strong>{{ $rideRequest["ride_to"] }}</strong></span>
                </div>
            </div>
        </p>
        <div id="tripinfo" class="text-align-center ">
            <p>
                <span>Distance <strong id="tripdistance">{{ $rideRequest["ride_distance"] }}</strong></span><br>
                <span>Estimated time <strong id="triptime">{{ $rideRequest["ride_time"] }}</strong></span><br>
                <span class="title">Charges R<strong class="title" id="tripcharges">{{ $rideRequest["ride_charges"] }}</strong></span>
            </p>
        </div>
        <div class="curved-top">
            
            @if($rideData->pick_up_requested == true)
                @if($driveData->confirm_pickup == true)
                    <p>
                        <div class="text-align-center">
                            <span class="title">Picked {{ $rideAuth->ride_first_name }}?</span>
                        </div>
                    </p>
                    <p>
                        <form action="/drive/{{ $rideAuth->id }}/request/trip/start" method="POST">
                            @csrf
                            @method("POST")
                            <input type="hidden" name="charges" value="{{ $charges }}">
                            <button>Drive</button>
                        </form>
                    </p>
                @else
                    <p>
                        <div class="text-align-center">
                            <span class="title">{{ $rideAuth->ride_first_name }} requested a pick-up</span>
                        </div>
                    </p>
                    <p>
                        <form action="/drive/{{ $rideAuth->id }}/request/pickup/confirm" method="POST">
                            @csrf
                            @method("POST")
                            <button>Confirm pick-up</button>
                        </form>
                    </p>
                @endif
                
            @else
                <p>
                    <div class="text-align-center">
                        <span class="title">Waiting for {{ $rideAuth->ride_first_name }} to request pick-up...</span>
                    </div>
                </p>
            @endif
            <p>
                <div class="text-align-center">
                    <span>This offer will expire within 24 hours</span>
                </div>
            </p>
        </div>
    </div>
    <script src="{{ $links['js'] }}"></script>
</body>
</html>