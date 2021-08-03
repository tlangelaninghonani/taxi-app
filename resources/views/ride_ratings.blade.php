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
                    @if($driveData->drive_profile_image == "")
                        <span class="material-icons-round empty-profile-large">
                        account_circle
                        </span><br>
                    @else
                        <img class="profile-image-large" src="{{ $driveData->drive_profile_image }}" alt=""><br>
                    @endif
                    <span class="title">{{ $driveAuth->drive_first_name." ".$driveAuth->drive_last_name }}</span><br>
                    <div class="display-flex-center-align">
                        @if($driveAuth->drive_gender == "Male")
                            <span>Gender <strong> {{ $driveAuth->drive_gender }}</strong></span>
                        @elseif($driveAuth->drive_gender == "Female")
                            <span>Gender <strong> {{ $driveAuth->drive_gender }}</strong></span>
                        @else
                            <span>Gender <strong> Rather not say</strong></span>
                        @endif
                    </div>
                    <span>Drives <strong>{{ $driveData->drive_vehicle }}</strong></span><br>
                    <div class="rating-stars-small-center">
                        @for($i = 1; $i <= 5; $i++)
                            @if($i <= floor($driveData->drive_ratings))
                                <span class="material-icons-round" style="color: orange">
                                star
                                </span>
                            @else
                                <span class="material-icons-round">
                                star
                                </span>
                            @endif
                        @endfor
                    </div>
                </div>
            </div>
        </p>
        <p>
            <div class="curved-top">
                <form class="app-padding" action="/ride/{{ $driveData->id }}/rate" method="POST">
                    @csrf
                    @method("POST")
                    <p>
                        <div class="text-align-center">
                            <span class="title-large">How was your trip with {{ $driveAuth->drive_first_name." ".$driveAuth->drive_last_name }}?</span>
                        </div>
                    </p>
                    <p>
                        <div class="rating-stars">
                            <span id="star1" class="material-icons-round" style="color: orange" onclick="colorStar(this, 1)">
                            star
                            </span>
                            <span id="star2" class="material-icons-round" onclick="colorStar(this, 2)">
                            star
                            </span>
                            <span id="star3" class="material-icons-round" onclick="colorStar(this, 3)">
                            star
                            </span>
                            <span id="star4" class="material-icons-round" onclick="colorStar(this, 4)">
                            star
                            </span>
                            <span id="star5" class="material-icons-round" onclick="colorStar(this, 5)">
                            star
                            </span>
                        </div>
                    </p>
                        <input id="ratings" type="hidden" name="ratings" value="1">
                    <p>
                        <span>Comment</span><br>
                        <input type="text" name="comment" placeholder="We'd love your feedback">
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