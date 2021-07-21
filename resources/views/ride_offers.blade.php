<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="stylesheet" href="{{ $links['css'] }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
        <!--<p>
            <a href="/signout">
                <button>Sign out</button>
            </a>
        </p>-->
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
           <span class="material-icons-round items-menu-icon" onclick="closePopup('menu')">
            more_vert
            </span>
        </div>
        <p>
            <span class="title">Offers</span>
        </p>
        <div class="offers">
            @foreach(json_decode($rideData->drive_offers, true) as $offers)
                @foreach($offers as $k => $v)
                    <div class="display-none">
                        {{ $driveA = $driveAuth::find($k) }}
                        {{ $driveD = $driveData::where("drive_id", $driveA->id)->first() }}
                    </div>
                    <div class="display-flex">
                        <div>
                            <img class="profile-image" src="{{ $driveD->drive_profile_image }}" alt="">
                        </div>
                        <div class="trunc-text">
                            <a href="/ride/{{ $driveA->id }}/request">
                                <div>
                                    <span class="title">{{ $driveA->drive_first_name." ".$driveA->drive_last_name }}</span><br> 
                                    <span>{{ $driveD->drive_vehicle }}</span><br>
                                    <span>Rated {{ $driveD->drive_ratings }}</span><br>
                                </div>
                            </a>
                        </div>
                    </div>
                @endforeach
            @endforeach
        </div>
        
    </div>
    <div class="bottom-controls">
        <div class="bottom-controls-item">
            <a href="/ride/dashboard">
                <span class="material-icons-round">
                home
                </span><br>
                <span>Home</span>
            </a>
        </div>
        <div class="bottom-controls-item">
            <a href="/ride/history">
                <span class="material-icons-round">
                watch_later
                </span><br>
                <span>History</span>
            </a>
        </div>
        <div class="bottom-controls-item">
            <a href="/ride/plans">
                <span class="material-icons-round">
                public
                </span><br>
                <span>Plans</span>
            </a>
        </div>
        <div class="bottom-controls-item">
            <a href="/ride/drivers">
                <span class="material-icons-round">
                directions_car
                </span><br>
                <span>Drivers</span>
            </a>
        </div>
        <div class="bottom-controls-item">
            <a href="/ride/offers">
                <span class="material-icons-round">
                local_offer
                </span><br>
                <span>Offers</span>
            </a>
        </div>
        <div class="bottom-controls-item">
            <a href="/ride/profile">
                <span class="material-icons-round">
                account_circle
                </span><br>
                <span>Profile</span>
            </a>
        </div>
    </div>
    <script src="{{ $links['js'] }}"></script>
</body>
</html>