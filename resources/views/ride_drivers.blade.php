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
    <div id="securitytip" class="filter-gender-notice display-none">
        <p>
           <div class="text-align-center">
                <span class="material-icons-round font-size-big">
                privacy_tip
                </span>
           </div>
        </p>
        <p>
            <div class="text-align-center">
                <span>Security tip. It's more safer to choose a driver of the same gender than of the opposite</span>
            </div>
        </p>
        <p>
            <button onclick="closePopup('securitytip')">Got it</button>
        </p>
    </div>
    <div class="container">
        <div class="menu display-none" id="menu">
            <div class="text-align-right">
                <span class="material-icons-round" onclick="closePopup('menu')">
                close
                </span>
            </div>
            <p>
                <a href="/ride/profile">
                    <span>My account</span>
                </a>
            </p>
            <p>
                <a href="/signout">
                    <span> Sign out</span>
                </a>
            </p>
        </div>
        <div class="box-shadow">
            <div class="nav">
                <div class="display-flex-normal gap-10">
                    <span class="material-icons-round" onclick="redirectBack()">
                    arrow_back
                    </span>
                    <span class="">Drivers near you</span>
            </div>
            <span class="material-icons-round " onclick="closePopup('menu')">
                more_vert
                </span>
            </div>
            <div class="text-align-center">
                <p>
                    <span class="title">With <strong>InterCityRides</strong> you can choose a driver near you and send a request</span>
                </p>
            </div>
            @if($requests::where("ride_id", $rideAuth->id)->count() > 0)
            <p>
                <div class="drivers-requests">
                    <div onclick="displayComp(this, 'drivers')" class="display-flex-center-align">
                        <span class="material-icons-round">
                        local_taxi
                        </span>
                        <span>Drivers</span>
                    </div>
                    <div onclick="displayComp(this, 'requests')" class="display-flex-center-align">
                        <span class="material-icons-round">
                        waving_hand
                        </span>
                        <span>Requests</span>
                    </div>
                    <div onclick="displayComp(this, 'requestsaccepted')" class="display-flex-center-align">
                        <span class="material-icons-round">
                        check_circle
                        </span>
                        <span>Accepted</span>
                    </div>
                </div>
            </p>
            @endif
        </div>
        @if(sizeof($driveAuths) > 0)
            @if($requests::where("ride_id", $rideAuth->id)->count() > 0)
                <div class="">
                    
                    <div id="requests" class="app-padding display-none" style="padding-top: 0">
                        @foreach($requests::where("ride_accepted", false)->where("ride_id", $rideAuth->id)->get() as $request)   
                            <div class="display-none">
                                {{ $driveA = $driveAuth::find($request->drive_id) }}
                                {{ $driveD = $driveData::where("drive_id", $driveA->id)->first() }}
                            </div>
                            <p>
                                <div class="display-flex-normal gap-10" onclick="redirectTo('/ride/{{ $request->id }}/request/pending')">
                                    <div>
                                        @if($driveD->drive_profile_image == "")
                                        <span class="material-icons-round empty-profile-medium">
                                        account_circle
                                        </span><br>
                                        @else
                                        <img class="profile-image" src="{{ $driveD->drive_profile_image }}" alt="">
                                        @endif
                                    </div>
                                    <div class="trunc-text">
                                        <span class="title">{{ $driveA->drive_first_name." ".$driveA->drive_last_name }}</span><br>
                                        <div class="trunc-text">
                                            <span>Drives <strong>{{ $driveD->drive_vehicle }} - </strong></span>
                                            <strong>{{ $driveD->drive_vehicle_type }}</strong>
                                        </div>
                                        <div class="display-flex-normal gender">
                                            @if($driveA->drive_gender == "Male")
                                                <span>Gender <strong>{{ $driveA->drive_gender }}</strong></span>
                                            @elseif($driveA->drive_gender == "Female")
                                                <span>Gender <strong>{{ $driveA->drive_gender }}</strong></span>
                                            @else
                                                <span>Gender <strong>{{ $driveA->drive_gender }}</strong></span>
                                            @endif
                                        </div>
                                        <div class="rating-stars-small">
                                            @for($i = 1; $i <= 5; $i++)
                                                @if($i <= floor($driveD->drive_ratings))
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
                                </div>
                            </p>
                        @endforeach
                        <p>
                            @if($requests::where("ride_accepted", false)->where("ride_id", $rideAuth->id)->count() == 0)
                                <div class="text-align-center">
                                    <span>No requests</span>
                                </div>
                            @endif
                        </p>
                    </div>
                    <div id="requestsaccepted" class="display-none app-padding" style="padding-top: 0">
                    @foreach($requests::where("ride_accepted", true)->where("ride_id", $rideAuth->id)->get() as $request)   
                            <div class="display-none">
                                {{ $driveA = $driveAuth::find($request->drive_id) }}
                                {{ $driveD = $driveData::where("drive_id", $driveA->id)->first() }}
                            </div>
                            <p>
                                <div class="display-flex-normal gap-10" onclick="redirectTo('/ride/{{ $request->id }}/request/accepted')">
                                    <div>
                                        @if($driveD->drive_profile_image == "")
                                        <span class="material-icons-round empty-profile-medium">
                                        account_circle
                                        </span><br>
                                        @else
                                        <img class="profile-image" src="{{ $driveD->drive_profile_image }}" alt="">
                                        @endif
                                    </div>
                                    <div class="trunc-text">
                                        <span class="title">{{ $driveA->drive_first_name." ".$driveA->drive_last_name }}</span><br>
                                        <div class="trunc-text">
                                            <span>Drives <strong>{{ $driveD->drive_vehicle }} - </strong></span>
                                            <strong>{{ $driveD->drive_vehicle_type }}</strong>
                                        </div>
                                        <div class="display-flex-normal gender">
                                            @if($driveA->drive_gender == "Male")
                                                <span>Gender <strong>{{ $driveA->drive_gender }}</strong></span>
                                            @elseif($driveA->drive_gender == "Female")
                                                <span>Gender <strong>{{ $driveA->drive_gender }}</strong></span>
                                            @else
                                                <span>Gender <strong>{{ $driveA->drive_gender }}</strong></span>
                                            @endif
                                        </div>
                                        <div class="rating-stars-small">
                                            @for($i = 1; $i <= 5; $i++)
                                                @if($i <= floor($driveD->drive_ratings))
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
                                </div>
                            </p>
                        @endforeach
                        <p>
                            @if($requests::where("ride_accepted", true)->where("ride_id", $rideAuth->id)->count() == 0)
                                <div class="text-align-center">
                                    <span>No accepted requests </span>
                                </div>
                            @endif
                        </p>
                    </div>
                </div>
            @endif
        <div id="drivers" class="popout-drivers ">
            <p>
                <input type="text" onkeydown="search('driverscontainer', 'drivers', this.value)" placeholder="Search drivers">
                <div class="display-flex-center-align gap-small">
                    <span class="material-icons-round">
                    tune
                    </span>
                    <span class="title-small">Type Male/Female/Other to filter by gender</span>
                </div>
            </p>
            <p>
                <div id="driverscontainer" class="padding-bottom-layout">
                    @foreach($driveAuths as $driveAuth)
                        <div id="{{ $driveAuth->drive_first_name.$driveAuth->drive_last_name.$driveAuth->id.$driveAuth->drive_gender }}" class="drivers">
                            <div style="display: none">
                                {{ $driveAuth->drive_first_name = ucwords($driveAuth->drive_first_name) }}
                                {{ $driveAuth->drive_last_name = ucwords($driveAuth->drive_last_name) }}

                                {{ $driveData = $driveData::find($driveAuth->id) }}
                                {{ $driveData->drive_vehicle = ucwords($driveData->drive_vehicle) }}
                            </div>
                            <p>
                                <div class="display-flex-normal gap-10">
                                    <div>
                                        @if($driveData->drive_profile_image == "")
                                        <span class="material-icons-round empty-profile-medium">
                                        account_circle
                                        </span><br>
                                        @else
                                        <img class="profile-image" src="{{ $driveData->drive_profile_image }}" alt="">
                                        @endif
                                    </div>
                                    <div class="trunc-text">
                                        @if($driveData->on_trip == true)
                                            <div class="status-driving">
                                                <span class="title">{{ $driveAuth->drive_first_name." ".$driveAuth->drive_last_name }}</span><br> 
                                                <div id="{{ $driveAuth->drive_gender.$driveAuth->id }}" class="display-flex-normal gender">
                                                    @if($driveAuth->drive_gender == "Male")
                                                        <span>Gender <strong>{{ $driveAuth->drive_gender }}</strong></span>
                                                    @elseif($driveAuth->drive_gender == "Female")
                                                        <span>Gender <strong>{{ $driveAuth->drive_gender }}</strong></span>
                                                    @else
                                                        <span>Gender <strong>{{ $driveAuth->drive_gender }}</strong></span>
                                                    @endif
                                                </div>
                                                <span>Drives <strong>{{ $driveData->drive_vehicle }}</strong></span><br>
                                                <div class="rating-stars-small">
                                                    @for($i = 1; $i <= 5; $i++)
                                                        @if($i <= floor($driveData->drive_ratings))
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
                                                    <div id="{{ $driveAuth->drive_gender.$driveAuth->id }}" class="display-flex-normal gender">
                                                        @if($driveAuth->drive_gender == "Male")
                                                            <span>Gender <strong>{{ $driveAuth->drive_gender }}</strong></span>
                                                        @elseif($driveAuth->drive_gender == "Female")
                                                            <span>Gender <strong>{{ $driveAuth->drive_gender }}</strong></span>
                                                        @else
                                                            <span>Gender <strong>{{ $driveAuth->drive_gender }}</strong></span>
                                                        @endif
                                                    </div>
                                                    <div class="rating-stars-small">
                                                        @for($i = 1; $i <= 5; $i++)
                                                            @if($i <= floor($driveData->drive_ratings))
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
        @else
        <div class="text-align-center">
            <span class="material-icons-round icon-large">
            local_taxi
            </span><br>
            <span>No drivers</span>
        </div>
        @endif
    </div>
    <div class="bottom-controls">
        <div class="bottom-controls-item">
            <a href="/ride/dashboard">
                <span class="material-icons-round">
                home
                </span><br>
                <span class="title-small">Home</span>
            </a>
        </div>
        <div class="bottom-controls-item">
            <a href="/ride/history">
                <span class="material-icons-round">
                watch_later
                </span><br>
                <span class="title-small">History</span>
            </a>
        </div>
        <div class="bottom-controls-item">
            <a href="/ride/plans">
                <span class="material-icons-round">
                travel_explore
                </span><br>
                <span class="title-small">Plans</span>
            </a>
        </div>
        <div class="bottom-controls-item">
            <a href="/ride/drivers">
                <span class="material-icons-round">
                local_taxi
                </span><br>
                <span class="title-small">Drivers</span>
            </a>
        </div>
        <div class="bottom-controls-item">
            <a href="/ride/offers">
                <span class="material-icons-round">
                local_offer
                </span><br>
                <span class="title-small">Offers</span>
            </a>
        </div>
        <div class="bottom-controls-item">
            <a href="/ride/chats">
                <span class="material-icons-round">
                question_answer
                </span><br>
                <span class="title-small">Chats</span>
            </a>
        </div>
    </div>
    <script src="{{ $links['js'] }}"></script>
    <script>
        setTimeout(() => {
            document.querySelector("#securitytip").style.display = "block";
        }, 1000000);
    </script>
</body>
</html>