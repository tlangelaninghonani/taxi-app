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
        <div class="curved-top">
            <form action="/ride/{{ $driveAuth->id }}/request" method="POST">
                @csrf
                @method("POST")
                <input type="hidden" value="{{  $driveAuth->id }}" name="rideid" id="rideid">
                <p>
                    <div class="text-align-center">
                        <span class="title">Where are you going?</span>
                    </div>
                </p>
                <p>
                    <span>From</span><br>
                    <input type="text" name="ridefrom" id="ridefrom" placeholder="Pick-up place" required>
                </p>
                <p>
                    <span>To</span><br>
                    <input type="text" name="rideto" id="rideto" placeholder="Your destination"  required>
                </p>
                <p>
                    <button>Request</button>
                </p>
            </form>
        </div>
    </div>
    <script src="{{ $links['js'] }}"></script>
</body>
</html>