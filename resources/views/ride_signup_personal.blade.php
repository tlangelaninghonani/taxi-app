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
        <div class="curved-top app-padding">
            <p>
                <span class="title title-margin-left">Personal details</span>
            </p>
            <p>
                <form action="/ride/signup/personal" method="POST">
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
                        <span>Gender</span><br>
                        <select name="gender" id="gender">
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                            <option value="other">Other</option>
                        </select>
                    </p>
                    <p>
                        <span>Phone</span><br>
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