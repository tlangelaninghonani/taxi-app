<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="stylesheet" href="{{ $links['css'] }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>History</title>
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
        <div class="padding-bottom-layout">
            @if(sizeof($history::where("drive_id", $driveAuth->id)->get()) > 0)
                @foreach($history::where("drive_id", $driveAuth->id)->get() as $driveHistory)
                    <div style="display: none">
                        {{ $rideA = $rideAuth::find($driveHistory->ride_id) }}
                        {{ $rideD = $rideData::where("ride_id", $rideA->id)->first() }}
                    </div>
                    <p>
                        <div class="display-flex">
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
                                <span>Picked-up <strong>{{ $driveHistory->ride_from }}</strong></span><br>
                                <span>Dropped <strong>{{ $driveHistory->ride_to }}</strong></span>
                            </div>
                        </div>
                    </p>
                @endforeach
            @else
                <div class="text-align-center">
                    <span class="material-icons-round icon-large">
                    watch_later
                    </span><br>
                    <span>No history</span>
                </div>
            @endif
        </div>
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