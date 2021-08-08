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
                <a href="/drive/profile">
                    <span>My account</span>
                </a>
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
            <span class="title">{{ $rideAuth->ride_first_name }}'s review</span>
        </p>
        <span onclick="redirectBack()" class="material-icons-round arrow-back">
        arrow_back
        </span>
        <p>
            <div class="display-center">
                <div class="text-align-center">
                    @if($rideData->ride_profile_image == "")
                        <span class="material-icons-round empty-profile-large">
                        account_circle
                        </span><br>
                    @else
                        <img class="profile-image-large" src="{{ $rideData->ride_profile_image }}" alt=""><br>
                    @endif
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
                        @if($i <= $review->ratings)
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
                <div class="display-flex-justify-center">
                    <span class="material-icons-round">
                    local_taxi
                    </span>
                    <span class="title">Pick-up</span><br>
                </div>
                <span>{{ $review->ride_from }}</span><br>
                <div class="display-flex-justify-center">
                    <span class="material-icons-round">
                    my_location
                    </span>
                    <span class="title">Drop</span><br>
                </div>
                <span>{{ $review->ride_to }}</span>
            </div>
        </p>
        <p>
            <div class="text-align-center">
                <span>{{ $review->comment }}</span>
            </div>
        </p>
    </div>
    <script src="{{ $links['js'] }}"></script>
</body>
</html>