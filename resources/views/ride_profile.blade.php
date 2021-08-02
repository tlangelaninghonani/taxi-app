<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="stylesheet" href="{{ $links['css'] }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
</head>
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
           <span class="material-icons-round" onclick="closePopup('menu')">
            more_vert
            </span>
        </div>
        <p>
            <span class="title">Profile</span>
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
            <div class="curved-top">
                <p>
                    <span class="title title-margin-left">Edit your details</span>
                </p>
                <form class="app-padding" action="/ride/profile/update" method="POST">
                    @csrf
                    @method("POST")
                    <span>First name</span><br>
                    <input type="text" name="firstname" value="{{ $rideAuth->ride_first_name }}" placeholder="Enter First name">
                    <p>
                        <span>Last name</span><br>
                        <input type="text" name="lastname" value="{{ $rideAuth->ride_last_name }}" placeholder="Enter Last name">
                    </p>
                    <p>
                        <button>Save</button>
                    </p>
                </form>
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