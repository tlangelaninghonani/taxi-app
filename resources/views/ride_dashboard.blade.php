<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="stylesheet" href="{{ $links['css'] }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ride</title>
</head>
<style>
    a{
        text-decoration: none;
        color: black;
    }
</style>
<body>
    <div class="container">
        <!--<p>
            <a href="/signout">
                <button>Sign out</button>
            </a>
        </p>-->
        <div class="menu display-none" id="menu">
            <div class="text-align-right">
                <span class="material-icons-outlined" onclick="closePopup('menu')">
                close
                </span>
            </div>
            <table>
                <td>
                    <span class="material-icons-outlined">
                    account_circle
                    </span>
                </td>
                <td>
                    <span>Profile</span>
                </td>
            </table>
            <a href="/signout">
                <table>
                    <td>
                        <span class="material-icons-outlined">
                        arrow_back
                        </span>
                    </td>
                    <td>
                    <span> Sign out</span>
                    </td>
                </table>
            </a>
        </div>
        <div class="nav">
           <div class="display-flex">
                <span class="material-icons-outlined">
                apartment
                </span>
                <span class="app-name">InterCityRides</span>
           </div>
           <span class="material-icons-outlined items-menu-icon" onclick="closePopup('menu')">
            more_vert
            </span>
        </div>
        <p>
            <div class="display-center border-bottom-curved">
                <div class="text-align-center">
                    <img class="profile-image-large" src="{{ $rideData->ride_profile_image }}" alt=""><br>
                    <span class="title">{{ $rideAuth->ride_first_name." ".$rideAuth->ride_last_name }}</span><br>
                    <span>Balance R{{ $rideData->ride_balance }}</span>
                </div>
            </div>
        </p>
        @if($rideData->on_trip == false)
            @if(sizeof(json_decode($rideData->drive_requests, true)) > 0)
                    <div>
                        <p>
                            <span class="title border-bottom" onclick="displayComp(this, 'requests')">Requests</span>
                            <span class="title f-right" onclick="displayComp(this, 'requestsaccepted')">Accepted</span>
                        </p>
                        <div id="requests" class="curved-top">
                            <p>
                                <div class="display-flex-justify-center">
                                    <div>
                                        <span class="material-icons-outlined">
                                        waving_hand
                                        </span>
                                    </div>
                                    <div>
                                        <span class="title">Requests</span>
                                    </div>
                                </div>
                            </p>
                            <p>
                                <div class="display-none">
                                {{ $requests_count = 0 }}
                                </div>
                                @foreach(json_decode($rideData->drive_requests, true) as $driveRequestID)
                                    <div style="display: none">
                                        {{ $driveAuth = $driveAuth::find($driveRequestID) }}
                                        {{ $driveData = $driveData::where("drive_id", $driveRequestID)->first() }}
                                    </div>
                                    @if($driveData->ride_accepted == false)
                                        <p>
                                            <span class="display-none">{{ $requests_count++ }}</span>
                                            <a class="display-flex" href="">
                                                <div>
                                                    <div>
                                                        <img class="profile-image" src="{{ $driveData->drive_profile_image }}" alt="">
                                                    </div>
                                                    <div class="trunc-text">
                                                        <span class="title">{{ $driveAuth->drive_first_name." ".$driveAuth->drive_last_name }}</span><br>
                                                        <span>{{ $driveData->drive_vehicle }}</span><br>
                                                        <span>Rated {{ $driveData->drive_ratings }}</span>
                                                    </div>
                                                </div>
                                            </a>
                                        </p>
                                    @endif
                                @endforeach
                            </p>
                            <p>
                                @if($requests_count == 0)
                                    <div class="text-align-center">
                                        <span>No requests</span>
                                    </div>
                                @endif
                            </p>
                        </div>
                        <div id="requestsaccepted" class="display-none curved-top">
                            <p>
                                <div class="display-flex-justify-center">
                                    <div>
                                        <span class="material-icons-outlined">
                                        done_all
                                        </span>
                                    </div>
                                    <div>
                                        <span class="title">Accepted</span>
                                    </div>
                                </div>
                            </p>
                            <p>
                                <div class="display-none">
                                {{ $accepted_requests_count = 0 }}
                                </div>
                                @foreach(json_decode($rideData->drive_requests, true) as $driveRequestID)
                                    <div style="display: none">
                                        {{ $driveAuth = $driveAuth::find($driveRequestID) }}
                                        {{ $driveData = $driveData::where("drive_id", $driveRequestID)->first() }}
                                        
                                    </div>
                                    @if($driveData->ride_accepted == true)
                                        <span class="display-none">{{ $accepted_requests_count++ }}</span>
                                        <p>
                                            <a class="display-flex" href="/ride/{{ $driveAuth->id }}/request/accepted">
                                                <div>
                                                    <div>
                                                        <img class="profile-image" src="{{ $driveData->drive_profile_image }}" alt="">
                                                    </div>
                                                    <div class="trunc-text">
                                                        <span class="title">{{ $driveAuth->drive_first_name." ".$driveAuth->drive_last_name }}</span><br>
                                                        <span>{{ $driveData->drive_vehicle }}</span><br>
                                                        <span>Rated {{ $driveData->drive_ratings }}</span>
                                                    </div>
                                                </div>
                                            </a>
                                        </p>
                                    @endif
                                @endforeach
                            </p>
                            <p>
                                @if($accepted_requests_count == 0)
                                    <div class="text-align-center">
                                        <span>No accepted requests</span>
                                    </div>
                                @endif
                            </p>
                        </div>
                    </div>
                @else
                <div class="text-align-center">
                    <span class="title-small">Hello {{ $rideAuth->ride_first_name }}</span><br>
                    <span class="title-small">Your balance looks good. </span>
                    <span class="title-small">Where are you going today?</span>
                </div>
                <p>
                    <a href="/ride/drivers">
                        <button>See drivers</button>
                    </a>
                </p>
                @endif
        @else
            <div class="display-none">
                {{ $driveAuth = $driveAuth::find($rideData->on_trip_drive_id) }}
                {{ $driveData = $driveData::where("drive_id", $driveAuth->id)->first() }}
            </div>
            <div class="curved-top">
                <p>
                    <div class="text-align-center">
                        <span class="title">On trip wth {{ $driveAuth->drive_first_name." ".$driveAuth->drive_last_name }}</span>
                    </div>
                </p>
                <p>
                    <form action="/ride/{{ $driveData::find($rideData->on_trip_drive_id)->id }}/request/trip/end" method="POST">
                        @csrf
                        @method("POST")
                        <button>End trip</button>
                    </form>
                </p>
            </div>
        @endif
    </div>
    <div class="bottom-controls">
        <div class="bottom-controls-item">
            <a href="">
                <span class="material-icons-outlined">
                home
                </span><br>
                <span>Home</span>
            </a>
        </div>
        <div class="bottom-controls-item">
            <a href="/ride/history">
                <span class="material-icons-outlined">
                history
                </span><br>
                <span>History</span>
            </a>
        </div>
        <div class="bottom-controls-item">
            <a href="/ride/plans">
                <span class="material-icons-outlined">
                public
                </span><br>
                <span>Plans</span>
            </a>
        </div>
        <div class="bottom-controls-item">
            <a href="/ride/drivers">
                <span class="material-icons-outlined">
                directions_car
                </span><br>
                <span>Drivers</span>
            </a>
        </div>
        <div class="bottom-controls-item">
            <a href="/ride/offers">
                <span class="material-icons-outlined">
                local_offer
                </span><br>
                <span>Offers</span>
            </a>
        </div>
    </div>
    <script src="{{ $links['js'] }}"></script>
</body>
</html>