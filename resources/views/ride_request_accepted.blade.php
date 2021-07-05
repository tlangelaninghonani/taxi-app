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
           <span class="material-icons-outlined items-menu-icon">
            more_vert
            </span>
        </div>
        <span class="material-icons-outlined" onclick="redirectBack()">
        arrow_back
        </span><br>
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
        <p>
            <div class="text-align-center">
                <span class="title">Charged R{{ $charges }}</span><br>
                <span>Balance (Prior) R{{ $rideData->ride_balance }}</span>
            </div>
        </p>
        <div class="curved-top">
            <div>
                @if($rideData->pick_up_requested == true)
                    @if($driveData->confirm_pickup == true)
                        @if($driveData->on_trip == true)
                            <script>
                                window.location.href = "/ride/dashboard";
                            </script>
                        @endif
                        <p>
                            <div class="text-align-center">
                                <span class="title">{{ $driveAuth->drive_first_name }} is on the way to pick you up</span>
                            </div>
                        </p> 
                    @else
                    <p>
                        <div class="text-align-center">
                            <span class="title">Waiting for {{ $driveAuth->drive_first_name }} to confirm pick-up</span>
                        </div>
                    </p>
                    @endif
                    
                @else
                <p>
                    <div class="text-align-center">
                        <span class="title">{{ $driveAuth->drive_first_name }} is waiting for your pick-up request</span>
                    </div>
                </p>
                <p>
                    <form action="/ride/{{ $driveAuth->id }}/request/pickup" method="POST">
                    @csrf
                    @method("POST")
                        <button>Request pick-up</button>
                    </form>
                </p>
                @endif
            </div>
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