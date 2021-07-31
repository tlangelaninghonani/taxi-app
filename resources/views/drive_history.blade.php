<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="stylesheet" href="{{ $links['css'] }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>History</title>
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
        <span class="material-icons-round " onclick="closePopup('menu')">
        more_vert
        </span>
    </div>
    <p>
        <span class="title">History</span>
    </p>
    <div class="padding-bottom-layout">
        @if(sizeof(json_decode($driveData->drive_history_ride_id, true)) > 0)
            @foreach(json_decode($driveData->drive_history_ride_id, true) as $k => $v)
                <div style="display: none">
                    {{ $rideAuth = $rideAuth::find($k) }}
                    {{ $rideData = $rideData::where("ride_id", $k)->first() }}
                </div>
                <p>
                    <div class="display-flex">
                        <div>
                            <img class="profile-image" src="{{ $rideData->ride_profile_image }}" alt="">
                        </div>
                        <div class="trunc-text">
                            <span class="title">{{ $rideAuth->ride_first_name." ".$rideAuth->ride_last_name }}</span><br>
                            <span>From {{ $v["ride_from"] }}</span><br>
                            <span>To {{ $v["ride_to"] }}</span>
                        </div>
                    </div>
                </p>
            @endforeach
        @endif
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