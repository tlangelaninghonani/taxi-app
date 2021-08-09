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
            <div class="text-align-right">
                <span class="material-icons-round" onclick="closePopup('menu')">
                close
                </span>
            </div>
            <p>
                <a href="/drive/profile">
                    <span>My account</span>
                </a>
            </p>
            <p>
                <a href="/signout">
                    <span> Sign out</span>
                </a>
            </p>
        </div>
        <div class="nav">
           <div class="display-flex">
                <span class="material-icons-round">
                apartment
                </span>
                <span class="app-name">InterCityRides</span>
           </div>
           <span class="material-icons-round" onclick="closePopup('menu')">
            more_vert
            </span>
        </div>
        <p>
            <span class="title">My account</span>
        </p>
        <span onclick="redirectBack()" class="material-icons-round arrow-back">
        arrow_back
        </span>
        <p>
            <div class="display-center">
                <div class="text-align-center">
                    @if($driveData->drive_profile_image == "")
                        <div class="position-relative">
                            <span class="material-icons-round empty-profile-large">
                            account_circle
                            </span><br>
                            <span onclick="closePopup('profileedit')" class="material-icons-round change-profile-image">
                            edit
                            </span>
                        </div>
                    @else
                        <div class="position-relative">
                            <img class="profile-image-large" src="{{ $driveData->drive_profile_image }}" alt=""><br>
                            <span onclick="closePopup('profileedit')" class="material-icons-round change-profile-image">
                            edit
                            </span>
                        </div>
                    @endif
                    <span class="title">{{ $driveAuth->drive_first_name." ".$driveAuth->drive_last_name }}</span><br>
                    <div class="trunc-text">
                        <span>Drives <strong>{{ $driveData->drive_vehicle }} - </strong></span>
                        <strong>{{ $driveData->drive_vehicle_type }}</strong>
                    </div>
                    <div class="display-flex-center">
                        @if($driveAuth->drive_gender == "Male")
                            <span>Gender <strong>{{ $driveAuth->drive_gender }}</strong></span>
                        @elseif($driveAuth->drive_gender == "Female")
                            <span>Gender <strong>{{ $driveAuth->drive_gender }}</strong></span>
                        @else
                            <span>Gender <strong>{{ $driveAuth->drive_gender }}</strong></span>
                        @endif
                    </div>
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
        <form class="display-none" id="uploadform" action="/drive/profile/upload/image" method="POST" enctype="multipart/form-data">
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
                        @if($driveData->drive_profile_image == "")
                            <span class="material-icons-round empty-profile-large">
                            account_circle
                            </span><br>
                        @else
                            <img class="profile-image-large" src="{{ $driveData->drive_profile_image }}" alt=""><br>
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
                    @if($driveData->drive_profile_image != "")
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
                <p>
                    <span class="title title-margin-left">Edit your details</span>
                </p>
                <form class="app-padding" action="/drive/profile/update" method="POST">
                    @csrf
                    @method("POST")
                    <span>First name</span><br>
                    <input type="text" name="firstname" value="{{ $driveAuth->drive_first_name }}" placeholder="Enter First name">
                    <p>
                        <span>Last name</span><br>
                        <input type="text" name="lastname" value="{{ $driveAuth->drive_last_name }}" placeholder="Enter Last name">
                    </p>
                    <p>
                        <span>Vehicle name </span><br>
                        <input type="text" name="vehiclename" value="{{ $driveData->drive_vehicle }}" placeholder="Enter Vehicle name">
                    </p>
                    <p>
                        <span>Vehicle type</span><br>
                        <input type="text" name="vehicletype" value="{{ $driveData->drive_vehicle_type }}" placeholder="Enter Vehicle type">
                    </p>
                    <p>
                        <button>Save</button>
                    </p>
                </form>
            </div>
        </p>
    </div>
    <script src="{{ $links['js'] }}"></script>
</body>
</html>