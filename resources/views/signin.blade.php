<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="stylesheet" href="{{ $links['css'] }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign in</title>
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
        <div class="choose-ride-drive-container">
            <div>
                <p>
                    <a class="choose-ride-drive-a" href="/drive/signin">
                        <div class="choose-ride-drive-item">
                            <span class="material-icons-round choose-ride-drive">
                            local_taxi
                            </span>
                        </div>
                        <div class="choose-ride-drive-div">
                            <span>Drive</span>
                        </div>
                    </a>
                </p>
                <p>
                    <a class="choose-ride-drive-a" href="/ride/signin">
                        <div class="choose-ride-drive-item">
                            <span class="material-icons-round choose-ride-drive">
                            hail
                            </span>
                        </div>
                        <div class="choose-ride-drive-div">
                            <span>Ride</span>
                        </div>
                    </a>
                </p>
            </div>
        </div>
        <div class="text-align-center">
            <span class="cl-silver logo-marketing title-small">App from DevOpsFactory</span>
        </div>
    </div>
    <script src="{{ $links['js'] }}"></script>
</body>
</html>