<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="stylesheet" href="{{ $links['css'] }}">
    <title>Ride sign up</title>
</head>
<body>
    <div class="container">
        <div class="nav">
            <div class="display-flex-normal gap-10">
                <span class="material-icons-round" onclick="redirectBack()">
                arrow_back
                </span>
                <span class="">Personal details</span>
           </div>
        </div>
        <div class="text-align-center">
            <img class="welcome-page-banner-1" src="https://blogapi.uber.com/wp-content/uploads/2020/06/uber-shield-blog_white.png" alt="">
            <span class="title">Signing up to ride with <strong>InterCityRides</strong></span>
        </div>
        <div class="curved-top app-padding">
            <p>
                <form action="/ride/signup/personal" method="POST">
                    @csrf
                    @method("POST")
                    <p>
                        <input type="text" id="firstname" name="firstname" placeholder="Enter First name" required>
                    </p>
                    <p>
                        <input type="text" id="lastname" name="lastname" placeholder="Enter Last name" required>
                    </p>
                    <p>
                        <select name="gender" id="gender">
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                            <option value="other">Other</option>
                        </select>
                    </p>
                    <p>
                        <input type="text" id="phone" name="phone" placeholder="Enter Phone" required>
                    </p>
                    <p>
                        <div class="text-align-center">
                            @if(Session::has("error"))
                                <span>Account already exists</span>
                                {{ Session::forget("error") }}
                            @endif
                        </div>
                    </p>
                    <p>
                        <button>Next</button>
                    </p>
                </form>
            </p>
        </div>
    </div>
    <script src="{{ $links['js'] }}"></script>
</body>
</html>