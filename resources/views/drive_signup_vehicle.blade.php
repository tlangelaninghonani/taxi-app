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
                <span class="">Vehicle details</span>
           </div>
        </div>
        <div class="text-align-center">
            <img class="welcome-page-banner-1" src="https://www.uber-assets.com/image/upload/f_auto,q_auto:eco,c_fill,w_956,h_537/v1571217564/assets/1d/9c8c86-fe11-48ba-be15-832d3b0200aa/original/Vehicle-requirements.png" alt="">
            <span class="title">Signing up to drive with <strong>InterCityRides</strong></span><br>
        </div>
        <div class="curved-top app-padding">
            <p>
                <form action="/drive/signup/vehicle" method="POST">
                    @csrf
                    @method("POST")
                    <p>
                        <input type="text" id="vehiclename" name="vehiclename" placeholder="Enter Vehicle name" required>
                    </p>
                    <p>
                        <select name="vehicletype" id="vehicletype">
                            <option value="hatchback">Hatchback</option>
                            <option value="sedan">Sedan</option>
                            <option value="executive">Executive</option>
                            <option value="pickup">Pick-up</option>
                            <option value="bus">Bus</option>
                        </select>
                    </p>
                    <p>
                        <input type="text" id="vehicleplate" name="vehicleplate" placeholder="Enter Vehicle plate" required>
                    </p>
                    <p>
                        <input type="text" id="vehiclecolor" name="vehiclecolor" placeholder="Enter Vehicle color" required>
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