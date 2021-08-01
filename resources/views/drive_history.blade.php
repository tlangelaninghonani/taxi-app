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
        <p>
            <span class="title">History</span>
        </p>
        <div class="padding-bottom-layout">
            @if(sizeof(json_decode($driveData->drive_history, true)) > 0)
                @foreach(json_decode($driveData->drive_history, true) as $rideId => $driveHistory)
                    <div style="display: none">
                        {{ $rideA = $rideAuth::find($rideId) }}
                        {{ $rideD = $rideData::where("ride_id", $rideA->id)->first() }}
                    </div>
                    <p>
                        <div class="display-flex">
                            <div>
                                <img class="profile-image" src="{{ $rideD->ride_profile_image }}" alt="">
                            </div>
                            <div class="trunc-text">
                                <span class="title">{{ $rideA->ride_first_name." ".$rideA->ride_last_name }}</span><br>
                                <span>From <strong>{{ $driveHistory["drive_from"] }}</strong></span><br>
                                <span>To <strong>{{ $driveHistory["drive_to"] }}</strong></span>
                            </div>
                        </div>
                    </p>
                @endforeach
            @endif
        </div>
    </div>
    <div class="bottom-controls">
        <div class="bottom-controls-item">
            <a href="/drive/dashboard">
                <span class="material-icons-round">
                home
                </span><br>
          
            </a>
        </div>
        <div class="bottom-controls-item">
            <a href="/drive/history">
                <span class="material-icons-round">
                watch_later
                </span><br>
             
            </a>
        </div>
        <div class="bottom-controls-item">
            <a href="/drive/plans">
                <span class="material-icons-round">
                travel_explore
                </span><br>
  
            </a>
        </div>
        <div class="bottom-controls-item">
            <a href="/drive/riders">
                <span class="material-icons-round">
                hail
                </span><br>
         
            </a>
        </div>
        <div class="bottom-controls-item">
            <a href="/drive/offer">
                <span class="material-icons-round">
                local_offer
                </span><br>
          
            </a>
        </div>
        <div class="bottom-controls-item">
            <a href="/drive/profile">
                <span class="material-icons-round">
                account_circle
                </span><br>
             
            </a>
        </div>
    </div>
    <script src="{{ $links['js'] }}"></script>
</body>
</html>