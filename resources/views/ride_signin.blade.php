<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="stylesheet" href="{{ $links['css'] }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ride sign in</title>
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
           <div class="text-align-center">
                <span class="material-icons-round shadow-round choose-ride-drive">
                hail
                </span>
           </div>
        </p>
        <p>
            <div class="text-align-center">
                <span class="title">You could plan a ride for later and get offers from drivers</span>
            </div>
        </p>
        <div class="curved-top app-padding">
            <p>
                <span class="title title-margin-left">Enter your details</span>
            </p>
            <p>
                <form action="/ride/signin" method="POST">
                    @csrf
                    @method("POST")
                    <p>
                        <span>Phone</span><br>
                        <input type="tel" id="phone" name="phone" placeholder="Enter Phone" required>
                    </p>
                    <p>
                        <span>Password</span><br>
                        <input type="password" id="password" name="password" placeholder="Enter password" required>
                    </p>
                    <p>
                        <div class="text-align-center">
                            @if(Session::has("error"))
                                <span>Account does not exists</span>
                                {{ Session::forget("error") }}
                            @endif
                        </div>
                    </p>
                    <p>
                        <button>Sign in</button>
                    </p>
                </form>
            </p>
            <p>
                <div class="text-align-center">
                    <span>Don't have an account yet? <strong onclick="redirectTo('/ride/signup/personal')">Sign up</strong></span>
                </div>
            </p>
        </div>
    </div>
    <script src="{{ $links['js'] }}"></script>
</body>
</html>