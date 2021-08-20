<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="stylesheet" href="{{ $links['css'] }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
</head>
<body>
    <div class="container">
        <div class="logo" id="logo">
            <div class="nav">
                <div class="display-flex">
                        <span class="material-icons-round">
                        apartment
                        </span>
                        <span class="app-name">InterCityRides</span>
                </div>
            </div>
            <div class="text-align-center">
                <img class="welcome-page-banner-1" src="https://cdn.dribbble.com/users/1138006/screenshots/12920961/media/e9c536ccdb39ed2944bea2951299f559.png?compress=1&resize=400x300" alt="">
                <span class="title">Choose your own driver with <strong>InterCityRides</strong></span><br>
            </div>
        </div>
        <div class="nav">
           <div class="display-flex">
                <span class="material-icons-round">
                apartment
                </span>
                <span class="app-name">InterCityRides</span>
           </div>
        </div>
        <div>
            <img class="welcome-page-banner-1" src="https://cdn.dribbble.com/users/1138006/screenshots/12920961/media/e9c536ccdb39ed2944bea2951299f559.png?compress=1&resize=400x300" alt="">
        </div>
        <div class="curved-top app-padding">
            <div class="text-align-center">
                <span class="title-large">Get where you like at your own pace</span>
            </div>
            <p>
                <a href="/signin">
                    <button>Sign in</button>
                </a>
            </p>
            <p>
                <div class="text-align-center">
                    <strong class="cl-silver title-small">App from DevOpsFactory</strong>
                </div>
            </p>
        </div>
    </div>

    <script src="{{ $links['js'] }}"></script>
    <script>
        setTimeout(() => {
            document.querySelector("#logo").style.display = "none";
        }, 5000);
    </script>
</body>
</html>