<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="stylesheet" href="{{ $links['css'] }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chats</title>
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
                <div class="display-flex-normal gap-small" onclick="redirectTo('/ride/profile')">
                    @if($rideData->ride_profile_image == "")
                        <div class="position-relative">
                            <span class="material-icons-round empty-profile-small">
                            account_circle
                            </span><br>
                        </div>
                    @else
                        <div class="position-relative">
                            <img class="profile-image-small" src="{{ $rideData->ride_profile_image }}" alt=""><br>
                        </div>
                    @endif
                    <span>My account</span>
                </div>
            </p>
            <p>
                <span>Send feedback</span>
            </p>
            <p>
                <div class="display-flex-normal gap-small" onclick="redirectTo('/signout')">
                    <span>Sign out</span>
                </div>
            </p>
        </div>
        <div class="nav">
            <div class="display-flex-normal gap-10">
                <span class="material-icons-round" onclick="redirectBack()">
                arrow_back
                </span>
                <span class="">Chat with drivers</span>
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
        @if($history::where("ride_id", $rideAuth->id)->exists() || $requests::where("ride_id", $rideAuth->id)->exists() || $hasInstantRequest)
        <p>
            <div class="app-padding">
                <input type="text" onkeydown="search('driverscontainer', 'drivers', this.value)" placeholder="Search drivers to chat with">
                <div class="text-align-center">
                    <span class="title-small">Type Male/Female/Other to filter by gender</span>
                </div>
            </div>
        </p>
        <p>
            <div id="driverscontainer" class="padding-bottom-layout">
                @foreach($driveAuth::all() as $driveToChat)
                    @if($history::where("ride_id", $rideAuth->id)->where("drive_id", $driveToChat->id)->exists() || $requests::where("ride_id", $rideAuth->id)->where("drive_id", $driveToChat->id)->exists() || $hasInstantRequest)
                        <div style="display: none">
                            {{ $driveA = $driveAuth::find($driveToChat->id) }}
                            {{ $driveD = $driveData::where("drive_id", $driveA->id)->first() }}
                        </div>
                        @if($hasInstantRequest)
                            @if($hasInstantRequest->drive_id == $driveA->id)
                                <div id="{{ $driveA->drive_first_name.$driveA->drive_last_name.$driveA->id.$driveA->drive_gender }}" class="drivers">
                                    <p>
                                        <div class="display-flex-normal gap-10">
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
                                                <form id="drivertochat{{ $driveA->id }}" action="/ride/{{ $driveA->id }}/chat" method="POST">
                                                    @csrf
                                                    @method("POST")
                                                </form>
                                                <div onclick="submitForm('drivertochat{{ $driveA->id }}')">
                                                    <span class="title">{{ $driveA->drive_first_name." ".$driveA->drive_last_name }}</span><br> 
                                                    <div class="trunc-text">
                                                    <span>Drives - <strong>{{ $driveD->drive_vehicle }} - </strong></span>
                                                    <strong>{{ $driveD->drive_vehicle_type }}</strong>
                                                    </div>
                                                    <div id="{{ $driveA->drive_gender.$driveA->id }}" class="display-flex-normal gender">
                                                        @if($driveA->drive_gender == "Male")
                                                            <span>Gender - <strong>{{ $driveA->drive_gender }}</strong></span>
                                                        @elseif($driveA->drive_gender == "Female")
                                                            <span>Gender - <strong>{{ $driveA->drive_gender }}</strong></span>
                                                        @else
                                                            <span>Gender - <strong>{{ $driveA->drive_gender }}</strong></span>
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
                                        </div>
                                    </p>
                                </div>
                            @endif
                        @elseif($history::where("ride_id", $rideAuth->id)->where("drive_id", $driveToChat->id)->exists() || $requests::where("ride_id", $rideAuth->id)->where("drive_id", $driveToChat->id)->exists())
                        <div id="{{ $driveA->drive_first_name.$driveA->drive_last_name.$driveA->id.$driveA->drive_gender }}" class="drivers">
                                <p>
                                    <div class="display-flex-normal gap-10">
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
                                            <form id="drivertochat{{ $driveA->id }}" action="/ride/{{ $driveA->id }}/chat" method="POST">
                                                @csrf
                                                @method("POST")
                                            </form>
                                            <div onclick="submitForm('drivertochat{{ $driveA->id }}')">
                                                <span class="title">{{ $driveA->drive_first_name." ".$driveA->drive_last_name }}</span><br> 
                                                <div class="trunc-text">
                                                <span>Drives - <strong>{{ $driveD->drive_vehicle }} - </strong></span>
                                                <strong>{{ $driveD->drive_vehicle_type }}</strong>
                                                </div>
                                                <div id="{{ $driveA->drive_gender.$driveA->id }}" class="display-flex-normal gender">
                                                    @if($driveA->drive_gender == "Male")
                                                        <span>Gender - <strong>{{ $driveA->drive_gender }}</strong></span>
                                                    @elseif($driveA->drive_gender == "Female")
                                                        <span>Gender - <strong>{{ $driveA->drive_gender }}</strong></span>
                                                    @else
                                                        <span>Gender - <strong>{{ $driveA->drive_gender }}</strong></span>
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
                                    </div>
                                </p>
                            </div>
                        @endif
                    @endif
                @endforeach
            </div>
        </p>
        @else
        <div class="text-align-center">
            <span class="material-icons-round icon-large">
            question_answer
            </span><br>
            <span>No drivers to chat with</span>
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
        <div class="bottom-controls-item focused">
            <a href="/ride/chats">
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