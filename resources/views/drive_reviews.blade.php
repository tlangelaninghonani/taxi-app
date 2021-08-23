<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="stylesheet" href="{{ $links['css'] }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reviews</title>
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
                <div class="display-flex-normal gap-small" onclick="redirectTo('/drive/profile')">
                    @if($driveData->drive_profile_image == "")
                        <div class="position-relative">
                            <span class="material-icons-round empty-profile-small">
                            account_circle
                            </span><br>
                        </div>
                    @else
                        <div class="position-relative">
                            <img class="profile-image-small" src="{{ $driveData->drive_profile_image }}" alt=""><br>
                        </div>
                    @endif
                    <div>
                    <span>My account</span>
                        <div class="rating-stars-small-center">
                            @for($i = 1; $i <= 5; $i++)
                                @if($i <= floor($driveData->drive_ratings))
                                    <span class="material-icons-round" style="color: orange" >
                                    star
                                    </span>
                                @else
                                    <span class="material-icons-round" >
                                    star
                                    </span>
                                @endif
                            @endfor
                        </div>
                    </div>
                </div>
            </p>
            <p>
                <span>Send feedback</span>
            </p>
            <p>
                <div class="display-flex-normal gap-small" onclick="redirectTo('/signout')">
                    <span>Sign out</span>
                </div>
            </p>
        </div>
        <div class="nav">
            <div class="display-flex-normal gap-10">
                <span class="material-icons-round" onclick="redirectBack()">
                arrow_back
                </span>
                <span class="">Offers to riders' plans</span>
           </div>
           <div class="display-flex-normal gap-mid">
                <span class="material-icons-round">
                notifications
                </span>
                <span class="material-icons-round " onclick="closePopup('menu')">
                more_vert
                </span>
           </div>
        </div>
        <div class="padding-bottom-layout">
            @if($reviews::where("drive_id", $driveAuth->id)->count() > 0)
                @foreach($reviews::where("drive_id", $driveAuth->id)->get() as $review)
                    <div style="display: none">
                        {{ $rideA = $rideAuth::find($review->ride_id) }}
                        {{ $rideD = $rideData::where("ride_id", $rideA->id)->first() }}
                    </div>
                    <p>
                        <div class="display-flex-normal gap-10" onclick="redirectTo('/drive/review/{{ $review->id }}/view')">
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
                                <div class="display-flex">
                                    <div>
                                     <span>Rated you</span>   
                                    </div>
                                    <div class="rating-stars-small">
                                        @for($i = 1; $i <= 5; $i++)
                                            @if($i <= $review->ratings)
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
                                <span>Pick-up <strong>{{ $review->ride_from }}</strong></span><br>
                                <span>Drop <strong>{{ $review->ride_to }}</strong></span><br>
                            </div>
                        </div>
                    </p>
                @endforeach
            @else
                <div class="text-align-center">
                    <span class="material-icons-round icon-large">
                    edit
                    </span><br>
                    <span>No reviews</span>
                </div>
            @endif
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
                    <span class="title-small">Revie..</span>
                </a>
            </div>
            <div class="bottom-controls-item">
                <a href="/drive/riders">
                    <span class="material-icons-round">
                    travel_explore
                    </span><br>
                    <span class="title-small">Plans</span>
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