<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="stylesheet" href="{{ $links['css'] }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riders</title>
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
           <div>
                <span class="material-icons-round " onclick="closePopup('menu')">
                more_vert
                </span>
           </div>
        </div>
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
        
        <p>
            <span class="title">See rider's plans</span>
        </p>
        <p>
            <input type="text" id="search" class="display-none" onkeydown="search('riderscontainer', 'riders', this.value)" placeholder="Search riders">
        </p>
        <p>
            <div id="riderscontainer">
                <div class="display-none">
                {{ $ridersPlans = 0 }}
                </div>
                @foreach($rideAuths as $rideAuth)
                    <div id="{{ $rideAuth->ride_first_name.$rideAuth->ride_last_name.$rideAuth->id.$rideAuth->ride_gender }}" class="riders">
                        <div style="display: none">
                            {{ $rideData = $rideData::find($rideAuth->id) }}
                        </div>
                        @if(sizeof(json_decode($rideData->ride_plans, true)) > 0)
                        <script>
                            if(document.querySelector("#search").style.display == "" || document.querySelector("#search").style.display == "none"){
                                document.querySelector("#search").style.display = "block";
                            }
                        </script>
                         <div class="display-none">
                            {{ $ridersPlans++ }}
                        </div>
                            @if(sizeof(json_decode($rideData->ride_plans, true)) == 1)
                                @foreach(json_decode($rideData->ride_plans, true) as $ridePlan)
                                    <p>
                                        <div class="display-flex-normal gap-10" onclick="redirectTo('/drive/riders/{{ $rideAuth->id }}/plans')">
                                            <div>
                                                @if($rideData->ride_profile_image == "")
                                                <span class="material-icons-round empty-profile-medium">
                                                account_circle
                                                </span><br>
                                                @else
                                                <img class="profile-image" src="{{ $rideData->ride_profile_image }}" alt="">
                                                @endif
                                            </div>
                                            <div class="trunc-text">
                                                <span class="title">{{ $rideAuth->ride_first_name." ".$rideAuth->ride_last_name }}</span><br> 
                                                <div class="display-flex-normal gender">
                                                    @if($rideAuth->ride_gender == "Male")
                                                        <span>Gender <strong>{{ $rideAuth->ride_gender }}</strong></span>
                                                    @elseif($rideAuth->ride_gender == "Female")
                                                        <span>Gender <strong>{{ $rideAuth->ride_gender }}</strong></span>
                                                    @else
                                                        <span>Gender <strong>{{ $rideAuth->ride_gender }}</strong></span>
                                                    @endif
                                                </div>
                                                <span>Pick-up <strong>{{ $ridePlan["ride_from"] }}</strong></span><br>
                                                <span>Drop <strong>{{ $ridePlan["ride_to"] }}</strong></span><br>
                                            </div> 
                                        </div>  
                                    </p>
                                @endforeach
                            @else
                                <p>
                                    <div class="display-flex" onclick="redirectTo('/drive/riders/{{ $rideAuth->id }}/plans')">
                                        <div>
                                            <img class="profile-image" src="{{ $rideData->ride_profile_image }}" alt="">
                                        </div>
                                        <div class="trunc-text">
                                            <span class="title">{{ $rideAuth->ride_first_name." ".$rideAuth->ride_last_name }}</span><br> 
                                            <span>Going multiple places</span><br>
                                            <span>{{ sizeof(json_decode($rideData->ride_plans, true)) }} trips planned</span>
                                        </div>
                                    </div>
                                </p>
                            @endif
                        @endif
                    </div>
                @endforeach
                @if($ridersPlans == 0)
                    <div class="text-align-center">
                        <span class="material-icons-round icon-large">
                        hail
                        </span><br>
                        <span>No rider's plans</span>
                    </div
                @endif
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