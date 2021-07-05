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
            <span class="title">History</span>
        </p>
        <div class="padding-bottom-layout">
            @if(sizeof(json_decode($rideData->ride_history_drive_id, true)) > 0)
                @foreach(json_decode($rideData->ride_history_drive_id, true) as $driveRequestID)
                    <div style="display: none">
                        {{ $driveAuth = $driveAuth::find($driveRequestID) }}
                        {{ $driveData = $driveData::where("drive_id", $driveRequestID)->first() }}
                    </div>
                    <p>
                        <a class="display-flex" href="/ride/{{ $driveAuth->id }}/request">
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
                @endforeach
            @endif
        </div>
        <div class="bottom-controls">
            <div class="bottom-controls-item">
                <a href="/ride/dashboard">
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
    </div>
    <script src="{{ $links['js'] }}"></script>
</body>
</html>