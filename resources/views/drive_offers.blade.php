<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="stylesheet" href="{{ $links['css'] }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Offers</title>
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
            <span class="title">Offers from drivers for your plans</span>
        </p>
        <div class="offers">
            <div class="display-none">
                {{ $totalOffers = 0 }}
            </div>
            @foreach($rideAuth::all() as $auth)
                <div class="display-none">
                    {{ $rideD = $rideData::where("ride_id", $auth->id)->first() }}
                    {{ $totalOffers++ }}
                </div>
                @foreach(json_decode($rideD->ride_offers, true) as $driver_id => $rideOffers)
                    @if($driver_id == $driveAuth->id)
                        @foreach($rideOffers as $offer)
                            <p>
                                <div onclick="redirectTo('/drive/riders/{{ $auth->id }}/plans')" class="display-flex">
                                    <div>
                                        <img class="profile-image" src="{{ $rideD->ride_profile_image }}" alt="">
                                    </div>
                                    <div class="trunc-text">
                                        <span class="title">{{ $auth->ride_first_name." ".$auth->ride_last_name }}</span><br> 
                                        <span>From <strong>{{ json_decode($rideD->ride_plans, true)[$offer["plan"]]["ride_from"] }}</strong></span><br>
                                        <span>To <strong>{{ json_decode($rideD->ride_plans, true)[$offer["plan"]]["ride_to"] }}</strong></span><br>
                                    </div>
                                </div>
                            </p>
                        @endforeach
                    @endif
                @endforeach
            @endforeach
            @if($totalOffers == 0)
                <div class="text-align-center">
                    <span class="material-icons-round icon-large">
                    local_offer
                    </span><br>
                    <span>No offers</span>
                </div>
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
            <a href="/drive/reviews">
                <span class="material-icons-round">
                edit
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
            <a href="/drive/offers">
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