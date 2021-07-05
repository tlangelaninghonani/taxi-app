<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="stylesheet" href="{{ $links['css'] }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ratings</title>
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
            <div class="curved-top">
                <form action="/ride/{{ $driveData->id }}/rate" method="POST">
                    @csrf
                    @method("POST")
                    <p>
                        <div class="text-align-center">
                            <span class="title-large">How was your trip with {{ $driveAuth->drive_first_name." ".$driveAuth->drive_last_name }}?</span>
                        </div>
                    </p>
                    <p>
                        <span>Rate your trip</span><br>
                        <input type="number" step="0.1" name="ratings">
                    </p>
                    <p>
                        <span>Comment</span><br>
                        <input type="text" placeholder="We'd love to see your feedback">
                    </p>
                    <p>
                        <button>Rate</button>
                    </p>
                </form>
            </div>
        </p>
    </div>
    <script src="{{ $links['js'] }}"></script>
</body>
</html>