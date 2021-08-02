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
                    <img class="profile-image-large" src="{{ $driveData->drive_profile_image }}" alt=""><br>
                    <span class="title">{{ $driveAuth->drive_first_name." ".$driveAuth->drive_last_name }}</span><br>
                    <span>Drives <strong>{{ $driveData->drive_vehicle }}</strong></span><br>
                    <strong>{{ $driveData->drive_vehicle_type }}</strong>
                    <div class="rating-stars-small-center">
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
            </div>
        </p>
        <p>
            <div class="curved-top">
                <form class="app-padding" action="/drive/profile/update" method="POST">
                    @csrf
                    @method("POST")
                    <p>
                        <span>First name</span><br>
                        <input type="text" name="firstname" value="{{ $driveAuth->drive_first_name }}" placeholder="Enter First name">
                    </p>
                    <p>
                        <span>Last name</span><br>
                        <input type="text" name="lastname" value="{{ $driveAuth->drive_last_name }}" placeholder="Enter Last name">
                    </p>
                    <p>
                        <span>Vehicle name </span><br>
                        <input type="text" name="vehiclename" value="{{ $driveData->drive_vehicle }}" placeholder="Enter Vehicle name">
                    </p>
                    <p>
                        <span>Vehicle type</span><br>
                        <input type="text" name="vehicletype" value="{{ $driveData->drive_vehicle_type }}" placeholder="Enter Vehicle type">
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
            <a href="">
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
            <a href="">
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