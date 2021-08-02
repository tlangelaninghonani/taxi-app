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
            @if(sizeof(json_decode($rideData->ride_history, true)) > 0)
                @foreach(json_decode($rideData->ride_history, true) as $driveId => $rideHistory)
                    <div style="display: none">
                        {{ $driveA = $driveAuth::find($driveId) }}
                        {{ $driveD = $driveData::where("drive_id", $driveA->id)->first() }}
                    </div>
                    <p>
                        <div class="display-flex" onclick="redirectTo('/ride/{{ $driveA->id }}/request')">
                            <div>
                                <img class="profile-image" src="{{ $driveD->drive_profile_image }}" alt="">
                            </div>
                            <div class="trunc-text">
                                <span class="title">{{ $driveA->drive_first_name." ".$driveA->drive_last_name }}</span><br>
                                <span>Drives <strong>{{ $driveD->drive_vehicle }}</strong></span><br>
                                <span>Rated <strong>{{ $driveD->drive_ratings }}</strong></span>
                            </div>
                        </div>
                    </p>
                @endforeach
            @else
                <div class="text-align-center">
                    <span class="material-icons-round icon-large">
                    watch_later
                    </span><br>
                    <span>No history</span>
                </div>
            @endif
        </div>
        <div class="bottom-controls">
            <div class="bottom-controls-item">
                <a href="/ride/dashboard">
                    <span class="material-icons-round">
                    home
                    </span><br>
             
                </a>
            </div>
            <div class="bottom-controls-item">
                <a href="/ride/history">
                    <span class="material-icons-round">
                    watch_later
                    </span><br>
                  
                </a>
            </div>
            <div class="bottom-controls-item">
                <a href="/ride/plans">
                    <span class="material-icons-round">
                    travel_explore
                    </span><br>
               
                </a>
            </div>
            <div class="bottom-controls-item">
                <a href="/ride/drivers">
                    <span class="material-icons-round">
                    local_taxi
                    </span><br>
                  
                </a>
            </div>
            <div class="bottom-controls-item">
                <a href="/ride/offers">
                    <span class="material-icons-round">
                    local_offer
                    </span><br>
                
                </a>
            </div>
            <div class="bottom-controls-item">
                <a href="/ride/profile">
                    <span class="material-icons-round">
                    account_circle
                    </span><br>

                </a>
            </div>
        </div>
    </div>
    <script src="{{ $links['js'] }}"></script>
</body>
</html>