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
                <span class="">Password</span>
            </div>
        </div>
        <div class="text-align-center">
            <img class="welcome-page-banner-1" src="https://i.pinimg.com/originals/97/2c/96/972c9683ddca85fb5c163d79fcb169ce.png" alt="">
            <span class="title">Signing up to ride with <strong>InterCityRides</strong></span>
        </div>
        <div class="curved-top app-padding">
            <p>
                <form action="/ride/signup" method="POST">
                    @csrf
                    @method("POST")
                    <p>
                        <input type="password" id="password" onkeyup="verifyPasswords('signupubutton')" name="password" placeholder="Enter Password" required>
                    </p>
                    <p>
                        <input type="password" id="confirm" onkeyup="verifyPasswords('signupubutton')" placeholder="Confirm password" required>
                    </p>
                    <p>
                        <div id="passwordlengtherr" class="text-align-center display-none">
                            <span>Password should be more than 8 characters</span>
                        </div>
                        <div id="passwordmatcherr" class="text-align-center display-none">
                            <span>Passwords does not match</span>
                        </div>
                    </p>
                    <p>
                        <button id="signupubutton">Sign up</button>
                    </p>
                </form>
            </p>
        </div>
    </div>
    <script src="{{ $links['js'] }}"></script>
</body>
</html>