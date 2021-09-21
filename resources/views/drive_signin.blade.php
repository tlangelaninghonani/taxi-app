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
            <div class="display-flex-normal gap-10">
                <span class="material-icons-round" onclick="redirectBack()">
                arrow_back
                </span>
                <span class="">Signing in to drive?</span>
           </div>
        </div>
        <img class="welcome-page-banner-1" src="https://wolffolins.b-cdn.net/wolffolins%2F0f486af5-7c91-438c-a984-69ba0c16d85d_uber_cs_image_illustration_01.jpg?auto=compress,format" alt="">
        <div class="curved-top app-padding">
            <p>
                <div class="text-align-center">
                    <span class="title">Security is our priority with <strong>InterCityRides</strong></span>
                </div>
            </p>
            <p>
                <form action="/drive/signin" method="POST">
                    @csrf
                    @method("POST")
                    <div id="signin-phone">
                        <p>
                            <input type="tel" id="phone" name="phone" placeholder="Enter Phone" required>
                        </p>
                    </div>
                    <div id="signin-password">
                        <p>
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
                            <div class="display-flex-normal">
                                <div class="text-align-center button-icon" onclick="redirectTo('/drive/signup/personal/')">
                                    <span class="material-icons-round">
                                    person_add
                                    </span>
                                    <span>New</span>
                                </div>
                                <button>Sign in</button>
                            </div>
                        </p>
                    </div>
                </form>
            </p>
            <p>
                <div class="text-align-center">
                    <strong class="title-small">App from DevOpsFactory</strong>
                </div>
            </p>
            <!--<p>
                <div class="text-align-center">
                    <span>Don't have an account yet? <strong onclick="redirectTo('/drive/signup/personal')">Sign up</strong></span>
                </div>
            </p>-->
        </div>
    </div>
    <script src="{{ $links['js'] }}"></script>
    <script>
        setTimeout(() => {
            document.querySelector("#phone").value = "";
            document.querySelector("#password").value = "";
        }, 1000);
    </script>
</body>
</html>