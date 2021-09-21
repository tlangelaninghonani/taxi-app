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
            <div class="display-flex-normal gap-10">
                <span class="material-icons-round" onclick="redirectBack()">
                arrow_back
                </span>
                <span class="">Sign in to?</span>
           </div>
        </div>
        <div class="choose-ride-drive-container">
            <div class="signin-container">
                <div class="text-align-center">
                    <div class="choose-ride-drive-item" onclick="redirectTo('/drive/signin')">
                        <span class="material-icons-round choose-ride-drive">
                        local_taxi
                        </span>
                    </div>
                </div>
                <div class="text-align-center">
                    <div class="choose-ride-drive-item" onclick="redirectTo('/ride/signin')">
                        <span class="material-icons-round choose-ride-drive">
                        hail
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ $links['js'] }}"></script>
</body>
</html>