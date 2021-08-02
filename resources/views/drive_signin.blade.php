<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="stylesheet" href="{{ $links['css'] }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Drive sign in</title>
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
                local_taxi
                </span>
           </div>
        </p>
        <div class="curved-top app-padding">
            <p>
                <form action="/drive/signin" method="POST">
                    @csrf
                    @method("POST")
                    <p>
                        <span>First name</span><br>
                        <input type="text" id="firstname" placeholder="Enter First name" name="firstname" required>
                    </p>
                    <p>
                        <span>Last name</span><br>
                        <input type="text" id="lastname" placeholder="Enter Last name" name="lastname" required>
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
        </div>
    </div>
    <script src="{{ $links['js'] }}"></script>
</body>
</html>