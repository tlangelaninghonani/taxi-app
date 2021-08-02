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
                <span class="material-icons-round">
                apartment
                </span>
                <span class="app-name">InterCityRides</span>
           </div>
           <span class="material-icons-round ">
            more_vert
            </span>
        </div>

        <p>
            <div class="display-center">
                <div class="text-align-center">
                    <img class="profile-image-large" src="{{ $driveData->drive_profile_image }}" alt=""><br>
                    <span class="title">{{ $driveAuth->drive_first_name." ".$driveAuth->drive_last_name }}</span><br>
                    <div class="trunc-text">
                        <span>Drives <strong>{{ $driveData->drive_vehicle }} - </strong></span>
                        <strong>{{ $driveData->drive_vehicle_type }}</strong>
                    </div>
                    <div class="rating-stars-small-center">
                        @for($i = 1; $i <= 5; $i++)
                            @if($i <= floor($driveData->drive_ratings))
                                <span id="star1" class="material-icons-round" style="color: orange" onclick="colorStar(this, 1)">
                                star
                                </span>
                            @else
                                <span id="star1" class="material-icons-round" onclick="colorStar(this, 1)">
                                star
                                </span>
                            @endif
                        @endfor
                    </div>
                </div>
            </div>
        </p>
        <div id="tripinfo" class="text-align-center ">
            <p>
                <span>Distance <strong id="tripdistance">{{ $rideRequest["ride_distance"] }}</strong></span><br>
                <span>Estimated time <strong id="triptime">{{ $rideRequest["ride_time"] }}</strong></span><br>
                <span class="title">Charges R<strong class="title" id="tripcharges">{{ $rideRequest["ride_charges"] }}</strong></span>
            </p>
        </div>
        <div class="curved-top app-padding">
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
        </div>
    </div>
    <script src="{{ $links['js'] }}"></script>
</body>
</html>