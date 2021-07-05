<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="stylesheet" href="{{ $links['css'] }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Drive</title>
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
                <span class="material-icons-outlined">
                apartment
                </span>
                <span class="app-name">InterCityRides</span>
           </div>
        </div>
        
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
        <span class="material-icons-outlined items-menu-icon" onclick="closePopup('menu')">
        more_vert
        </span>
        <p>
            <div class="display-center">
                <div class="text-align-center">
                    <img class="profile-image-large" src="{{ $driveData->drive_profile_image }}" alt=""><br>
                    <span class="title">{{ $driveAuth->drive_first_name." ".$driveAuth->drive_last_name }}</span><br>
                    <span>{{ $driveData->drive_vehicle }}</span><br>
                    <span>Rated {{ $driveData->drive_ratings }}</span>
                </div>
            </div>
        </p>
        @if($driveData->on_trip == false)
            @if(sizeof(json_decode($driveData->ride_requests, true)) > 0)
                <p>
                    <span class="title border-bottom" onclick="displayComp(this, 'requests')">Requests</span>
                    <span class="title f-right" onclick="displayComp(this, 'requestsaccepted')">Accepted</span>
                </p>
                <div id="requests" class="curved-top">
                    <div class="display-none">
                    {{ $requests_count = 0 }}
                    </div>
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
                        @foreach(json_decode($driveData->ride_requests, true) as $rideRequestID)
                            <div style="display: none">
                                {{ $rideAuth = $rideAuth::find($rideRequestID) }}
                                {{ $rideData = $rideData::where("ride_id", $rideRequestID)->first() }}
                            </div>
                            @if($driveData->ride_accepted == false)
                                <span class="display-none">{{ $requests_count++ }}</span>
                                <p>
                                    <a class="display-flex" href="/drive/{{ $rideAuth->id }}/request">
                                        <div>
                                            <div>
                                                <img class="profile-image" src="{{ $rideData->ride_profile_image }}" alt="">
                                            </div>
                                            <div class="trunc-text">
                                                <span class="title">{{ $rideAuth->ride_first_name." ".$rideAuth->ride_last_name }}</span><br>
                                                <span>From {{ $rideData->ride_from }}</span><br>
                                                <span>To {{ $rideData->ride_to }}</span>
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
                        @foreach(json_decode($driveData->ride_requests, true) as $rideRequestID)
                            <div style="display: none">
                                {{ $rideAuth = $rideAuth::find($rideRequestID) }}
                                {{ $rideData = $rideData::where("ride_id", $rideRequestID)->first() }}
                            </div>
                            @if($driveData->ride_accepted == true)
                                <span class="display-none">{{ $accepted_requests_count++ }}</span>
                                <p>
                                    <a class="display-flex" href="/drive/{{ $rideAuth->id }}/request/accepted">
                                        <div>
                                            <div>
                                                <img class="profile-image" src="{{ $rideData->ride_profile_image }}" alt="">
                                            </div>
                                            <div class="trunc-text">
                                                <span class="title">{{ $rideAuth->ride_first_name." ".$rideAuth->ride_last_name }}</span><br>
                                                <span>From {{ $rideData->ride_from }}</span><br>
                                                <span>To {{ $rideData->ride_to }}</span>
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
            @endif
        @else
            <div class="display-none">
                {{ $rideAuth = $rideAuth::find($driveData->on_trip_ride_id) }}
                {{ $rideData = $rideData::where("ride_id", $rideAuth->id)->first() }}
            </div>
            <div class="curved-top">
                <p>
                    <div class="text-align-center">
                        <span class="title">On trip with {{ $rideAuth->ride_first_name." ".$rideAuth->ride_last_name }}</span>
                    </div>
                </p>
                <p>
                    <form action="/drive/{{ $rideAuth->id }}/request/trip/end" method="POST">
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
            <a href="/drive/history">
                <span class="material-icons-outlined">
                history
                </span><br>
                <span>History</span>
            </a>
        </div>
        <div class="bottom-controls-item">
            <a href="">
                <span class="material-icons-outlined">
                public
                </span><br>
                <span>Plans</span>
            </a>
        </div>
        <div class="bottom-controls-item">
            <a href="/drive/riders">
                <span class="material-icons-outlined">
                directions_walk
                </span><br>
                <span>Riders</span>
            </a>
        </div>
        <div class="bottom-controls-item">
            <a href="">
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