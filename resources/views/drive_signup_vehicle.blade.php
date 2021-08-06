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
                <span class="title title-margin-left">Vehicle details</span>
            </p>
            <p>
                <form action="/drive/signup/vehicle" method="POST">
                    @csrf
                    @method("POST")
                    <p>
                        <span>Vehicle name</span><br>
                        <input type="text" id="vehiclename" name="vehiclename" placeholder="Enter Vehicle name" required>
                    </p>
                    <p>
                        <span>Vehicle type</span><br>
                        <select name="vehicletype" id="vehicletype">
                            <option value="hatchback">Hatchback</option>
                            <option value="sedan">Sedan</option>
                            <option value="executive">Executive</option>
                            <option value="pickup">Pick-up</option>
                            <option value="bus">Bus</option>
                        </select>
                    </p>
                    <p>
                        <span>Vehicle plate</span><br>
                        <input type="text" id="vehicleplate" name="vehicleplate" placeholder="Enter Vehicle plate" required>
                    </p>
                    <p>
                        <span>Vehicle color</span><br>
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