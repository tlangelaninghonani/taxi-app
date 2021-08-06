<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="stylesheet" href="{{ $links['css'] }}">
    <title>Chat with {{ $driveAuth->drive_first_name }}</title>
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
           <span class="material-icons-round " onclick="closePopup('menu')">
            more_vert
            </span>
        </div>
        <div class="menu display-none" id="menu">
            <div class="text-align-right">
                <span class="material-icons-round" onclick="closePopup('menu')">
                close
                </span>
            </div>
            <p>
                <a href="/ride/profile">
                    <span>My account</span>
                </a>
            </p>
            <p>
                <a href="/signout">
                    <span> Sign out</span>
                </a>
            </p>
        </div>
        <p>
            <span class="title">Chat with {{ $driveAuth->drive_first_name }}</span>
        </p>
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
        <div id="rideprofileimage" class="ride-profile-image display-none">
            @if($rideAuth->ride_profile_image == "")
            <span class="material-icons-round empty-profile-small">
            account_circle
            </span><br>
            @else
            <img class="profile-image-small" src="{{ $rideAuth->ride_profile_image }}" alt="">
            @endif
        </div>
        <p>
            <div id="chats">
                @if($chats::where("drive_id", $driveAuth->id)->where("ride_id", $rideAuth->id)->count() > 0)
                    @foreach($chats::where("drive_id", $driveAuth->id)->where("ride_id", $rideAuth->id)->get() as $chat)   
                        @if($chat->from == "drive")
                            <div class="display-flex chat-padding-drive">
                                <div>
                                    @if($driveData->drive_profile_image == "")
                                    <span class="material-icons-round empty-profile-small">
                                    account_circle
                                    </span><br>
                                    @else
                                    <img class="profile-image-small" src="{{ $driveData->drive_profile_image }}" alt="">
                                    @endif
                                </div>
                                <div class="drive-chat">
                                    <span>
                                    {{ $chat->chat }}
                                    </span>
                                </div>
                            </div>
                        @else
                        
                            <div class="display-flex-end chat-padding">
                                <div class="ride-chat">
                                    <span>
                                    {{ $chat->chat }}
                                    </span>
                                </div>
                                <div class="ride-profile-image">
                                    @if($rideAuth->ride_profile_image == "")
                                    <span class="material-icons-round empty-profile-small">
                                    account_circle
                                    </span><br>
                                    @else
                                    <img class="profile-image" src="{{ $rideAuth->ride_profile_image }}" alt="">
                                    @endif
                                </div>
                            </div>
                        @endif
                    @endforeach
                @else
                    <div id="nocomment" class="text-align-center">
                        <span class="material-icons-round icon-large">
                        question_answer
                        </span><br>
                        <span>No chats</span>
                    </div>
                @endif
            </div>
        </p>
        <form id="chatform" class="display-none" action="/ride/{{ $driveAuth->id }}/chat/message" method="POST">
            @csrf
            @method("POST")
            <input type="text" id="chat" name="chat">
        </form>
        <div class="type-message">
            <textarea name="" id="message" cols="30" rows="1" placeholder="Type a message"></textarea>
            <span class="material-icons-round send-message" onclick="sendMessage('chats', 'rideprofileimage', 'message', '{{ $driveAuth->id }}')">
            send
            </span>
        </div>
    </div>
    <script src="{{ $links['js'] }}"></script>
</body>
</html>