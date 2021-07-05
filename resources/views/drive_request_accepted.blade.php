<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="stylesheet" href="{{ $links['css'] }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Request</title>
</head>
<body>
    <div class="container">
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
        <p>
            <div class="display-center">
                <div class="text-align-center">
                    <img class="profile-image-large" src="{{ $rideData->ride_profile_image }}" alt=""><br>
                    <span class="title">{{ $rideAuth->ride_first_name." ".$rideAuth->ride_last_name }}</span><br>
                    <span>From {{ $rideData->ride_from }}</span><br>
                    <span>To {{ $rideData->ride_to }}</span>
                </div>
            </div>
        </p>
        <p>
            <div class="text-align-center">
                <span class="title">Charged R{{ $charges }}</span>
            </div>
        </p>
        <div class="curved-top">
            
            @if($rideData->pick_up_requested == true)
                @if($driveData->confirm_pickup == true)
                    <p>
                        <div class="text-align-center">
                            <span class="title">Picked {{ $rideAuth->ride_first_name }}?</span>
                        </div>
                    </p>
                    <p>
                        <form action="/drive/{{ $rideAuth->id }}/request/trip/start" method="POST">
                            @csrf
                            @method("POST")
                            <input type="hidden" name="charges" value="{{ $charges }}">
                            <button>Drive</button>
                        </form>
                    </p>
                @else
                    <p>
                        <div class="text-align-center">
                            <span class="title">{{ $rideAuth->ride_first_name }} requested a pick-up</span>
                        </div>
                    </p>
                    <p>
                        <form action="/drive/{{ $rideAuth->id }}/request/pickup/confirm" method="POST">
                            @csrf
                            @method("POST")
                            <button>Confirm pick-up</button>
                        </form>
                    </p>
                @endif
                
            @else
                <p>
                    <div class="text-align-center">
                        <span class="title">Waiting for {{ $rideAuth->ride_first_name }} to request pick-up...</span>
                    </div>
                </p>
            @endif
            <p>
                <div class="text-align-center">
                    <span>This offer will expire within 24 hours</span>
                </div>
            </p>
        </div>
    </div>
    <script src="{{ $links['js'] }}"></script>
</body>
</html>