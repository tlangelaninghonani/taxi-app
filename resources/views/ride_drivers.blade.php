<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="stylesheet" href="{{ $links['css'] }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Drivers</title>
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
            <span class="title">Drivers near you</span>
        </p>
        <p>
            <input type="text" onkeydown="search('driverscontainer', 'drivers', this.value)" placeholder="Search drivers">
        </p>
        <p>
            <div id="driverscontainer" class="padding-bottom-layout">
                @foreach($driveAuths as $driveAuth)
                    <div id="{{ $driveAuth->drive_first_name.$driveAuth->drive_last_name.$driveAuth->id }}" class="drivers">
                        <div style="display: none">
                            {{ $driveAuth->drive_first_name = ucwords($driveAuth->drive_first_name) }}
                            {{ $driveAuth->drive_last_name = ucwords($driveAuth->drive_last_name) }}

                            {{ $driveData = $driveData::find($driveAuth->id) }}
                            {{ $driveData->drive_vehicle = ucwords($driveData->drive_vehicle) }}
                        </div>
                        <p>
                            <div class="display-flex">
                                <div>
                                    <img class="profile-image" src="{{ $driveData->drive_profile_image }}" alt="">
                                </div>
                                <div class="trunc-text">
                                    @if($driveData->on_trip == true)
                                        <div class="status-driving">
                                            <span class="title">{{ $driveAuth->drive_first_name." ".$driveAuth->drive_last_name }}</span><br> 
                                            <span>Drives <strong>{{ $driveData->drive_vehicle }}</strong></span><br>
                                            <span>Rated <strong>{{ $driveData->drive_ratings }}</strong></span><br>
                                            <span>Completing a trip</span>
                                        </div>
                                    @else
                                        <a href="/ride/{{ $driveAuth->id }}/request">
                                            <div>
                                                <span class="title">{{ $driveAuth->drive_first_name." ".$driveAuth->drive_last_name }}</span><br> 
                                                <div class="trunc-text">
                                                <span>Drives <strong>{{ $driveData->drive_vehicle }} - </strong></span>
                                                <strong>{{ $driveData->drive_vehicle_type }}</strong>
                                                </div>
                                                <div class="rating-stars-small">
                                                    @for($i = 1; $i <= 5; $i++)
                                                        @if($i <= floor($driveData->drive_ratings))
                                                            <span id="star1" class="material-icons-round" style="color: orange" onclick="colorStar(this, 1)">
                                                            star
                                                            </span>
                                                        @else
                                                            <span id="star1" class="material-icons-round" onclick="colorStar(this, 1)">
                                                            star
                                                            </span>
                                                        @endif
                                                    @endfor
                                                </div>     
                                            </div>
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </p>
                    </div>
                @endforeach
            </div>
        </p>
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
    <script src="{{ $links['js'] }}"></script>
</body>
</html>