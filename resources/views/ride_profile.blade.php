<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="stylesheet" href="{{ $links['css'] }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
</head>
<body>
    <div class="container">
        <div class="menu display-none" id="menu">
            <div class="text-align-right ">
                <span class="material-icons-round" onclick="closePopup('menu')">
                close
                </span>
            </div>
            <p>
                <div class="display-flex-normal gap-small" onclick="redirectTo('/ride/profile')">
                    @if($rideData->ride_profile_image == "")
                        <div class="position-relative">
                            <span class="material-icons-round empty-profile-small">
                            account_circle
                            </span><br>
                        </div>
                    @else
                        <div class="position-relative">
                            <img class="profile-image-small" src="{{ $rideData->ride_profile_image }}" alt=""><br>
                        </div>
                    @endif
                    <span>My account</span>
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
                <span class="">My account</span>
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
        <p>
            <div class="display-center">
                <div class="text-align-center">
                    @if($rideData->ride_profile_image == "")
                        <div class="position-relative">
                            <span onclick="closePopup('profileedit')" class="material-icons-round empty-profile-large">
                            account_circle
                            </span><br>
                        </div>
                    @else
                        <div class="position-relative">
                            <img onclick="closePopup('profileedit')" class="profile-image-large" src="{{ $rideData->ride_profile_image }}" alt=""><br>
                        </div>
                    @endif
                    <span class="title">{{ $rideAuth->ride_first_name." ".$rideAuth->ride_last_name }}</span><br>
                    <div class="display-flex-center gender">
                        @if($rideAuth->ride_gender == "Male")
                            <span>Gender <strong>{{ $rideAuth->ride_gender }}</strong></span>
                        @elseif($rideAuth->ride_gender == "Female")
                            <span>Gender <strong>{{ $rideAuth->ride_gender }}</strong></span>
                        @else
                            <span>Gender <strong>{{ $rideAuth->ride_gender }}</strong></span>
                        @endif
                    </div>
                    <span>Phone <strong>{{ $rideAuth->ride_phone }}</strong></span>
                </div>
            </div>
        </p>
        <form class="display-none" id="uploadform" action="/ride/profile/upload/image" method="POST" enctype="multipart/form-data">
            @csrf
            @method("POST")
            <input type="file" name="image" id="image" accept="image/png, image/jpg, image/jpeg, image/gif">
        </form>
        <div id="profileedit" class="profile-edit display-none">
            <div>
                <div class="text-align-right picture-edit-close">
                    <span class="material-icons-round" onclick="closePopup('profileedit')">
                    close
                    </span>
                </div>
                <p>
                    <div class="text-align-center">
                        @if($rideData->ride_profile_image == "")
                            <span class="material-icons-round empty-profile-large">
                            account_circle
                            </span><br>
                        @else
                            <img class="profile-image-large" src="{{ $rideData->ride_profile_image }}" alt=""><br>
                        @endif

                    </div>
                </p>
                <div class="display-flex-center gap">
                    <div class="display-flex-normal" onclick="uploadSubmit('image', 'uploadform')">
                        <span class="material-icons-round">
                        image
                        </span>
                        <span>Upload</span>
                    </div>
                    @if($rideData->ride_profile_image != "")
                        <div class="display-flex-normal" onclick="submitForm('uploadform')">
                            <span class="material-icons-round">
                            delete
                            </span>
                            <span>Remove</span>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        <p>
            <div class="curved-top">
                <form class="app-padding" action="/ride/profile/update" method="POST">
                    @csrf
                    @method("POST")
                    <input type="text" name="firstname" value="{{ $rideAuth->ride_first_name }}" placeholder="Enter First name">
                    <p>
                        <input type="text" name="lastname" value="{{ $rideAuth->ride_last_name }}" placeholder="Enter Last name">
                    </p>
                    <p>
                        <input type="text" name="phone" value="{{ $rideAuth->ride_phone }}" placeholder="Enter Phone">
                    </p>
                    <p>
                        <button>Save</button>
                    </p>
                </form>
            </div>
        </p>
    </div>
    <div class="bottom-controls">
        <div class="bottom-controls-item">
            <a href="/ride/dashboard">
                <span class="material-icons-round">
                home
                </span><br>
                <span class="title-small">Home</span>
            </a>
        </div>
        <div class="bottom-controls-item">
            <a href="/ride/history">
                <span class="material-icons-round">
                watch_later
                </span><br>
                <span class="title-small">History</span>
            </a>
        </div>
        <div class="bottom-controls-item">
            <a href="/ride/plans">
                <span class="material-icons-round">
                travel_explore
                </span><br>
                <span class="title-small">Plans</span>
            </a>
        </div>
        <div class="bottom-controls-item">
            <a href="/ride/drivers">
                <span class="material-icons-round">
                local_taxi
                </span><br>
                <span class="title-small">Drivers</span>
            </a>
        </div>
        <div class="bottom-controls-item">
            <a href="/ride/offers">
                <span class="material-icons-round">
                local_offer
                </span><br>
                <span class="title-small">Offers</span>
            </a>
        </div>
        <div class="bottom-controls-item">
            <a href="/ride/chats">
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