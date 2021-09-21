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
        <div class="nav">
            <div class="display-flex-normal gap-10">
                <span class="">InterCityRides</span>
           </div>
           <div class="display-flex-normal gap-mid" onclick="redirectTo('/signin')">
                <span class="material-icons-round">
                account_circle
                </span>
                <span>Sign in</span>
           </div>
        </div>
        <div class="logo" id="logo">
            <div class="nav">
                <div class="display-flex-normal gap-10">
                    <span class="">InterCityRides</span>
            </div>
            </div>
            <div class="text-align-center">
                <img class="welcome-page-banner-1" src="https://blogapi.uber.com/wp-content/uploads/2020/06/uber-shield-blog_white.png" alt="">
                <div class="">
                    <span class="title">Choose your own driver with <strong>InterCityRides</strong></span><br>
                </div>
                <p>
                    <div class="text-align-center">
                        <strong class="title-small">App from DevOpsFactory</strong>
                    </div>
                </p>
            </div>
        </div>
        <div>
            <img class="welcome-page-banner-1" src="https://blogapi.uber.com/wp-content/uploads/2020/06/uber-shield-blog_white.png" alt="">
        </div>
        <div class="curved-top app-padding">
            <div class="text-align-center">
                <span class="title-large">Get where you like at your own pace</span>
            </div>
            <p>
                <div class="text-align-center">
                    <strong class="title-small">App from DevOpsFactory</strong>
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