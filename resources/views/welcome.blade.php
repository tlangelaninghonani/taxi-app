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
            <div class="text-align-center">
                <span class="material-icons-round app-icon">
                apartment
                </span><br>
                <span class="title">InterCityRides</span><br>
                <span class="cl-silver logo-marketing title-small">App from DevOpsFactory</span>
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
        <p>
            <div>
                <img class="welcome-page-banner-1" src="https://www.uber-assets.com/image/upload/q_auto:eco,c_fill,w_956,h_537/v1565734756/assets/fa/dc4e40-8aee-4a48-af4c-0475c1e01d26/original/singup_mobile.svg" alt="">
            </div>
        </p>
        <p>
            <div class="curved-top app-padding">
                 <p>
                    <div class="text-align-center">
                        <span class="title-large">Get where you like at your own pace</span>
                    </div>
                </p>
                <a href="/signin">
                    <button>Sign in</button>
                </a>
                <p>
                    <div class="text-align-center">
                        <span class="cl-silver title-small">App from DevOpsFactory</span>
                    </div>
                </p>
            </div>
        </p>
    </div>

    <script src="{{ $links['js'] }}"></script>
    <script>
        setTimeout(() => {
            document.querySelector("#logo").style.display = "none";
        }, 5000);
    </script>
</body>
</html>