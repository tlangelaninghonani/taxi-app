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
        <span class="material-icons-round" onclick="redirectBack()">
        arrow_back
        </span><br>
        <p>
            <img class="welcome-page-banner-1" src="https://image.freepik.com/free-vector/online-ordering-taxi-car-rent-sharing-using-service-mobile-application_333239-96.jpg" alt="">
        </p>
        <div class="curved-top">
            <p>
                <div class="text-align-center">
                    <span class="title-large">Signing to ride</span>
                </div>
            </p>
            <p>
                <form action="/ride/signin" method="POST">
                    @csrf
                    @method("POST")
                    <p>
                        <span>First name</span><br>
                        <input type="text" id="firstname" name="firstname" placeholder="Enter First name" required>
                    </p>
                    <p>
                        <span>Last name</span><br>
                        <input type="text" id="lastname" name="lastname" placeholder="Enter Last name" required>
                    </p>
                    <p>
                        <span>Password</span><br>
                        <input type="password" id="password" name="password" placeholder="Enter password" required>
                    </p>
                    <p>
                        <button>Sign in</button>
                    </p>
                </form>
            </p>
        </div>
    </div>
    <script src="{{ $links['js'] }}"></script>
</body>
</html>