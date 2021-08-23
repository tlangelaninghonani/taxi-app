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
        <div class="box-shadow app-padding-bottom">
            <div class="nav">
                <div class="display-flex-normal gap-10">
                    <span class="material-icons-round" onclick="redirectBack()">
                    arrow_back
                    </span>
                    <span class="">Offers to riders' plans</span>
                </div>
                <div class="display-flex-normal gap-mid">
                    <span class="material-icons-round">
                    notifications
                    </span>
                    <span class="material-icons-round " onclick="closePopup('menu')">
                    more_vert
                    </span>
                </div>
            </div>
            <div class="text-align-center app-padding">
                <span class="title">Riders may send direct request to you</span>
            </div>
                
                <p>
                    <div class="drivers-requests">
                        <div onclick="showHideElementThree('plans', 'directrequestsaccepted', 'directrequests',)" class="display-flex-center-align">
                            <span>Direct</span>
                        </div>
                        <div onclick="showHideElementThree('plans', 'directrequests', 'directrequestsaccepted')" class="display-flex-center-align">
                            <span>Accepted</span>
                        </div>
                        <div onclick="showHideElementThree('directrequests', 'directrequestsaccepted', 'plans')" class="display-flex-center-align">
                            <span>Plans</span>
                        </div>
                    </div>
                </p>
    
        </div>
        <div class="menu display-none" id="menu">
            <div class="text-align-right">
                <span class="material-icons-round" onclick="closePopup('menu')">
                close
                </span>
            </div>
            <p>
                <div class="display-flex-normal gap-small" onclick="redirectTo('/drive/profile')">
                    @if($driveData->drive_profile_image == "")
                        <div class="position-relative">
                            <span class="material-icons-round empty-profile-small">
                            account_circle
                            </span><br>
                        </div>
                    @else
                        <div class="position-relative">
                            <img class="profile-image-small" src="{{ $driveData->drive_profile_image }}" alt=""><br>
                        </div>
                    @endif
                    <div>
                    <span>My account</span>
                        <div class="rating-stars-small-center">
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
                </div>
            </p>
            <p>
                <span>Send feedback</span>
            </p>
            <p>
                <div class="display-flex-normal" onclick="redirectTo('/signout')">
                    <span>Sign out</span>
                </div>
            </p>
        </div>
        <p>
            <div id="plans" class="display-none">
                @if($plans::all()->count() > 0)
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
                        travel_explore
                        </span><br>
                        <span>No rider's plans</span>
                    </div>
                @endif
            </div>
            <div id="directrequests" class="app-padding" style="padding-top: 0">
                <div class="display-none">
                    {{ $driveCity = false }}
                </div>
                    @foreach($requests::where("drive_id", $driveAuth->id)->where("ride_accepted", false)->get() as $request)  
                        <div class="display-none">
                            {{ $rideA = $rideAuth::find($request->ride_id) }}
                            {{ $rideD = $rideData::where("ride_id", $rideA->id)->first() }}
                        </div>
                        <p>
                            <div id="requestInstant{{ $request->id }}" class="display-flex-normal gap-10" onclick="redirectTo('/drive/{{ $request->id }}/request')">
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
                                    <span>Pick-up <strong>{{ $request->ride_from }}</strong></span><br>
                                    <span>Drop <strong>{{ $request->ride_to }}</strong></span>
                                </div>
                            </div>
                        </p>
                    @endforeach
                    @if(sizeof($requests::where("drive_id", $driveAuth->id)->where("ride_accepted", false)->get()) == 0)
                        <p>
                            <div class="text-align-center">
                                <span class="material-icons-round icon-large">
                                waving_hand
                                </span><br>
                                <span>No direct requests</span>
                            </div>
                        </p>
                    @endif
                <!--<script>
                    var xmlhttp = new XMLHttpRequest();
                    setInterval(() => {
                        xmlhttp.onreadystatechange = function() { 
                            if (this.readyState == 4 && this.status == 200) {
                                let requestsObj = JSON.parse(this.responseText).requests;
                                let requestsObj = JSON.parse(this.responseText).requests;
                                console.log(requestsObj);
                                for (let i = 1; i <= requestsObj.length; i++) {
                                    if(! document.querySelector("#request"+requestsObj[i-1].id) && requestsObj[i-1].ride_accepted == false){
                                        let pTag = document.createElement("p");
                                        let requestDiv = document.createElement("div");

                                        requestDiv.setAttribute("class", "display-flex-normal gap-10");
                                        requestDiv.setAttribute("onclick", "redirectTo('/drive/"+requestObj[i-1].id+"/request')");
                                        requestDiv.setAttribute("id", "request"+requestObj[i-1].id);

                                        let emptyProfile = document.createElement("span");
                                        emptyProfile.setAttribute("class", "material-icons-round empty-profile-medium");

                                        let profileImg = document.createElement("img");
                                        profileImg.setAttribute("class", "profile-image");
                                        profileImg.setAttribute("src", );
                                    }
                                }
                            }
                        };
                        xmlhttp.open("GET", "/drive/getrequests", true);
                        xmlhttp.send();
                    }, 5000);  
                </script>-->
            </div>
            <div id="directrequestsaccepted" class="app-padding display-none" style="padding-top: 0">
                <div class="display-none">
                    {{ $driveCity = false }}
                </div>
                    @foreach($requests::where("drive_id", $driveAuth->id)->where("ride_accepted", true)->get() as $request)  
                        <div class="display-none">
                            {{ $rideA = $rideAuth::find($request->ride_id) }}
                            {{ $rideD = $rideData::where("ride_id", $rideA->id)->first() }}
                        </div>
                        <p>
                            <div id="requestInstant{{ $request->id }}" class="display-flex-normal gap-10" onclick="redirectTo('/drive/{{ $request->id }}/request/accepted')">
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
                                    <span>Pick-up <strong>{{ $request->ride_from }}</strong></span><br>
                                    <span>Drop <strong>{{ $request->ride_to }}</strong></span>
                                </div>
                            </div>
                        </p>
                    @endforeach
                    @if(sizeof($requests::where("drive_id", $driveAuth->id)->where("ride_accepted", true)->get()) == 0)
                        <p>
                            <div class="text-align-center">
                                <span class="material-icons-round icon-large">
                                task_alt
                                </span><br>
                                <span>No accepted direct requests</span>
                            </div>
                        </p>
                    @endif
                <!--<script>
                    var xmlhttp = new XMLHttpRequest();
                    setInterval(() => {
                        xmlhttp.onreadystatechange = function() { 
                            if (this.readyState == 4 && this.status == 200) {
                                let requestsObj = JSON.parse(this.responseText).requests;
                                let requestsObj = JSON.parse(this.responseText).requests;
                                console.log(requestsObj);
                                for (let i = 1; i <= requestsObj.length; i++) {
                                    if(! document.querySelector("#request"+requestsObj[i-1].id) && requestsObj[i-1].ride_accepted == false){
                                        let pTag = document.createElement("p");
                                        let requestDiv = document.createElement("div");

                                        requestDiv.setAttribute("class", "display-flex-normal gap-10");
                                        requestDiv.setAttribute("onclick", "redirectTo('/drive/"+requestObj[i-1].id+"/request')");
                                        requestDiv.setAttribute("id", "request"+requestObj[i-1].id);

                                        let emptyProfile = document.createElement("span");
                                        emptyProfile.setAttribute("class", "material-icons-round empty-profile-medium");

                                        let profileImg = document.createElement("img");
                                        profileImg.setAttribute("class", "profile-image");
                                        profileImg.setAttribute("src", );
                                    }
                                }
                            }
                        };
                        xmlhttp.open("GET", "/drive/getrequests", true);
                        xmlhttp.send();
                    }, 5000);  
                </script>-->
            </div>
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
                <span class="title-small">Revie..</span>
            </a>
        </div>
        <div class="bottom-controls-item">
            <a href="/drive/riders">
                <span class="material-icons-round">
                travel_explore
                </span><br>
                <span class="title-small">Plans</span>
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