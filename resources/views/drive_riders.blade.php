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
        <p>
            <span class="">Riders plans</span>
        </p>
        <p>
            @if($plans::all()->count() > 0)
                <p>
                    <input type="text" id="search" onkeydown="search('riderscontainer', 'riders', this.value)" placeholder="Search riders">
                    <div class="display-flex-center-align gap-small">
                        <span class="material-icons-round">
                        tune
                        </span>
                        <span class="title-small">Type Male/Female/Other to filter by gender</span>
                    </div>
                </p>
                <div id="riderscontainer">
                    @foreach($plans::all() as $plan)
                        <div style="display: none">
                            {{ $rideA = $rideAuth::find($plan->ride_id) }}
                            {{ $rideD = $rideData::find($rideA->id) }}
                        </div>
                        <div id="{{ $rideA->ride_first_name.$rideA->ride_last_name.$rideA->id.$rideA->ride_gender }}" class="riders">
                            <p>
                                <div class="display-flex-normal gap-10" onclick="redirectTo('/drive/{{ $plan->id }}/riders/plans')">
                                    <div>
                                        @if($rideD->ride_profile_image == "")
                                        <span class="material-icons-round empty-profile-medium">
                                        account_circle
                                        </span><br>
                                        @else
                                        <img class="profile-image" src="{{ $rideD->ride_profile_image }}" alt="">
                                        @endif
                                    </div>
                                    <div class="trunc-text">
                                        <span class="title">{{ $rideA->ride_first_name." ".$rideA->ride_last_name }}</span><br> 
                                        <div class="display-flex-normal gender">
                                            @if($rideA->ride_gender == "Male")
                                                <span>Gender <strong>{{ $rideA->ride_gender }}</strong></span>
                                            @elseif($rideA->ride_gender == "Female")
                                                <span>Gender <strong>{{ $rideA->ride_gender }}</strong></span>
                                            @else
                                                <span>Gender <strong>{{ $rideA->ride_gender }}</strong></span>
                                            @endif
                                        </div>
                                        <span>Pick-up <strong>{{ $plan->ride_from }}</strong></span><br>
                                        <span>Drop <strong>{{ $plan->ride_to }}</strong></span><br>
                                    </div> 
                                </div>  
                            </p>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-align-center">
                    <span class="material-icons-round icon-large">
                    hail
                    </span><br>
                    <span>No rider's plans</span>
                </div>
            @endif
        </p>
    </div>
    <div class="bottom-controls">
        <div class="bottom-controls-item">
            <a href="/drive/dashboard">
                <span class="material-icons-round">
                home
                </span><br>
                <span class="title-small">Home</span>
            </a>
        </div>
        <div class="bottom-controls-item">
            <a href="/drive/history">
                <span class="material-icons-round">
                watch_later
                </span><br>
                <span class="title-small">History</span>
            </a>
        </div>
        <div class="bottom-controls-item">
            <a href="/drive/reviews">
                <span class="material-icons-round">
                edit
                </span><br>
                <span class="title-small">Reviews</span>
            </a>
        </div>
        <div class="bottom-controls-item">
            <a href="/drive/riders">
                <span class="material-icons-round">
                hail
                </span><br>
                <span class="title-small">Riders</span>
            </a>
        </div>
        <div class="bottom-controls-item">
            <a href="/drive/offers">
                <span class="material-icons-round">
                local_offer
                </span><br>
                <span class="title-small">Offers</span>
            </a>
        </div>
        <div class="bottom-controls-item">
            <a href="/drive/chats">
                <span class="material-icons-round">
                question_answer
                </span><br>
                <span class="title-small">Chats</span>
            </a>
        </div>
    </div>
    <script src="{{ $links['js'] }}"></script>
</body>
</html>