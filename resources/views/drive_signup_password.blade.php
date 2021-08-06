<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="stylesheet" href="{{ $links['css'] }}">
    <title>Drive sign up</title>
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
        </div>
        <p>
            <span class="title">Signing up to drive</span>
        </p>
        <p>
           <div class="text-align-center">
                <span class="material-icons-round shadow-round choose-ride-drive">
                local_taxi
                </span>
           </div>
        </p>
        <div class="curved-top app-padding">
            <p>
                <span class="title title-margin-left">Enter your password</span>
            </p>
            <p>
                <form action="/drive/signup" method="POST">
                    @csrf
                    @method("POST")
                    <p>
                        <span>Password</span><br>
                        <input type="password" id="password" onkeyup="verifyPasswords('signupubutton')" name="password" placeholder="Enter Password" required>
                    </p>
                    <p>
                        <span>Confirm password</span><br>
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