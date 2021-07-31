<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="stylesheet" href="{{ $links['css'] }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riders</title>
</head>
<style>
     a{
        text-decoration: none;
        color: black;
    }
</style>
<body>
    <div class="container">
        <div class="nav">
           <div class="display-flex">
                <span class="material-icons-round">
                apartment
                </span>
                <span class="app-name">InterCityRides</span>
           </div>
           <div>
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
                <span>Profile</span>
            </p>
            <p>
                <a href="/signout">
                    <span> Sign out</span>
                </a>
            </p>
        </div>
        
        <p>
            <span class="title">See rider's plans</span>
        </p>
        <p>
            <input type="text" placeholder="Search riders">
        </p>
        <p>
            <div>
                @foreach($rideAuths as $rideAuth)
                    <div style="display: none">
                        {{ $rideData = $rideData::find($rideAuth->id) }}
                    </div>
                    @if(sizeof(json_decode($rideData->ride_plans, true)) > 0)
                        @if(sizeof(json_decode($rideData->ride_plans, true)) == 1)
                            @foreach(json_decode($rideData->ride_plans, true) as $ridePlan)
                                <p>
                                    <a class="display-flex" href="/drive/riders/{{ $rideAuth->id }}/plans">
                                        <div>
                                            <div>
                                                <img class="profile-image" src="{{ $rideData->ride_profile_image }}" alt="">
                                            </div>
                                            <div class="trunc-text">
                                                <span class="title">{{ $rideAuth->ride_first_name." ".$rideAuth->ride_last_name }}</span><br> 
                                                <span>From <strong>{{ $ridePlan["ride_from"] }}</strong></span><br>
                                                <span>To <strong>{{ $ridePlan["ride_to"] }}</strong></span><br>
                                                <span>Charges <strong>R{{ $ridePlan["ride_charges"] }}</strong></span>
                                            </div>
                                        </div>
                                    </a>
                                </p>
                            @endforeach
                        @else
                            <p>
                                <a class="display-flex" href="/drive/riders/{{ $rideAuth->id }}/plans">
                                    <div>
                                        <div>
                                            <img class="profile-image" src="{{ $rideData->ride_profile_image }}" alt="">
                                        </div>
                                        <div class="trunc-text">
                                            <span class="title">{{ $rideAuth->ride_first_name." ".$rideAuth->ride_last_name }}</span><br> 
                                            <span>Going multiple places</span><br>
                                            <span>{{ sizeof(json_decode($rideData->ride_plans, true)) }} trips planned</span>
                                        </div>
                                    </div>
                                </a>
                            </p>
                        @endif
                    @endif
                @endforeach
            </div>
        </p>
    </div>
    <div class="bottom-controls">
        <div class="bottom-controls-item">
            <a href="/drive/dashboard">
                <span class="material-icons-round">
                home
                </span><br>
                <span class="title-small">Home</span>
            </a>
        </div>
        <div class="bottom-controls-item">
            <a href="/drive/history">
                <span class="material-icons-round">
                watch_later
                </span><br>
                <span class="title-small">History</span>
            </a>
        </div>
        <div class="bottom-controls-item">
            <a href="">
                <span class="material-icons-round">
                travel_explore
                </span><br>
                <span class="title-small">Plans</span>
            </a>
        </div>
        <div class="bottom-controls-item">
            <a href="/drive/riders">
                <span class="material-icons-round">
                hail
                </span><br>
                <span class="title-small">Riders</span>
            </a>
        </div>
        <div class="bottom-controls-item">
            <a href="">
                <span class="material-icons-round">
                local_offer
                </span><br>
                <span class="title-small">Offers</span>
            </a>
        </div>
        <div class="bottom-controls-item">
            <a href="/drive/profile">
                <span class="material-icons-round">
                account_circle
                </span><br>
                <span class="title-small">Profile</span>
            </a>
        </div>
    </div>
    <script src="{{ $links['js'] }}"></script>
</body>
</html>