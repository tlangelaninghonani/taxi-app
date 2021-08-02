<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="stylesheet" href="{{ $links['css'] }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $rideAuth->ride_first_name }}'s review</title>
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
            <span class="title">{{ $rideAuth->ride_first_name }}'s review</span>
        </p>
        <p>
            <div class="display-center">
                <div class="text-align-center">
                    <img class="profile-image-large" src="{{ $rideData->ride_profile_image }}" alt=""><br>
                    <span class="title">{{ $rideAuth->ride_first_name." ".$rideAuth->ride_last_name }}</span><br>
                </div>
            </div>
        </p>
        <p>
            <div class="display-flex-center">
                <div>
                    <span>Rated you</span>   
                </div>
                <div class="rating-stars-small">
                    @for($i = 1; $i <= 5; $i++)
                        @if($i <= $driveReview["ratings"])
                            <span class="material-icons-round" style="color: orange" >
                            star
                            </span>
                        @else
                            <span class="material-icons-round" >
                            star
                            </span>
                        @endif
                    @endfor
                </div>
            </div>
        </p>
        <p>
            <div class="text-align-center">
                <span>{{ $driveReview["comment"] }}</span>
            </div>
        </p>
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
    </div>
    <script src="{{ $links['js'] }}"></script>
</body>
</html>