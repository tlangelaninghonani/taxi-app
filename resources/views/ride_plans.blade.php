<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="stylesheet" href="{{ $links['css'] }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Plans</title>
</head>
<style>
    a{
        text-decoration: none;
        color: black;
    }
</style>
<body>
    <div class="container">
        <div class="menu display-none" id="menu">
            <div class="text-align-right">
                <span class="material-icons-round" onclick="closePopup('menu')">
                close
                </span>
            </div>
            <p>
                <span>Profile</span>
            </p>
            <p>
                <a href="/signout">
                    <span> Sign out</span>
                </a>
            </p>
        </div>
        <div class="nav">
           <div class="display-flex">
                <span class="material-icons-round">
                apartment
                </span>
                <span class="app-name">InterCityRides</span>
           </div>
           <span class="material-icons-round items-menu-icon" onclick="closePopup('menu')">
            more_vert
            </span>
        </div>
        <p>
            <span class="title">Plans</span>
        </p>
        <div id="plans">
            @foreach(json_decode($rideData->ride_plans, true) as $k => $v)
                <p>
                    <div class="display-flex">
                        <div>
                            <span class="material-icons-round plan-icon">
                            schedule
                            </span>
                        </div>
                        <div>
                            <span class="title">{{ $v["riding_later_date"] }} {{ $v["riding_later_time"] }} {{ $v["riding_later_meridiem"] }}</span><br>
                            <span>From {{ $v["riding_later_from"] }}</span><br>
                            <span>To {{ $v["riding_later_to"] }}</span>
                        </div>
                    </div>
                </p>
            @endforeach
            @if(sizeof(json_decode($rideData->ride_plans, true)) == 0)
                <div class="text-align-center">
                    <span>No plans</span>
                </div>
            @endif
            <p>
                <button onclick="openClosePlan('newplan')">New plan</button>
            </p>
        </div>
        <div id="newplan" class="display-none">
            <div class="curved-top">
                <div class="text-align-right">
                    <span class="material-icons-round newplan" onclick="openClosePlan('newplan')">
                    close
                    </span>
                </div>
                <p>
                    <span class="title">Where are you going later?</span>
                </p>
                <p>
                    <div>
                        <img class="welcome-page-banner-1" src="https://image.freepik.com/free-vector/man-holding-clock-time-management-concept_23-2148823171.jpg" alt="">
                    </div>
                </p>
                <form action="/ride/plans" method="POST">
                    @csrf
                    @method("POST")
                    <p>
                        <span>From</span><br>
                        <input type="text" name="ridinglaterfrom" id="ridinglaterfrom" placeholder="Pick-up place" required>
                    </p>
                    <p>
                        <span>To</span><br>
                        <input type="text" name="ridinglaterto" id="ridinglaterto" placeholder="Your destination"  required>
                    </p>
                    <p>
                        <span>Date</span><br>
                        <input type="date" name="ridinglaterdate" required>
                    </p>
                    <p>
                        <span>Time</span><br>
                        <input type="text" placeholder="12:00" name="ridinglatertime" required>
                    </p>
                    <p>
                        <span>Meridiem</span><br>
                        <select name="ridinglatermeridiem" id="meridiem" >
                            <option value="PM">PM</option>
                            <option value="AM">AM</option>
                        </select>
                    </p>
                    <p>
                        <button>Save</button>
                    </p>
                </form>
            </div>
        </div>
        <div class="bottom-controls">
            <div class="bottom-controls-item">
                <a href="/ride/dashboard">
                    <span class="material-icons-round">
                    home
                    </span><br>
                    <span>Home</span>
                </a>
            </div>
            <div class="bottom-controls-item">
                <a href="/ride/history">
                    <span class="material-icons-round">
                    watch_later
                    </span><br>
                    <span>History</span>
                </a>
            </div>
            <div class="bottom-controls-item">
                <a href="/ride/plans">
                    <span class="material-icons-round">
                    public
                    </span><br>
                    <span>Plans</span>
                </a>
            </div>
            <div class="bottom-controls-item">
                <a href="/ride/drivers">
                    <span class="material-icons-round">
                    directions_car
                    </span><br>
                    <span>Drivers</span>
                </a>
            </div>
            <div class="bottom-controls-item">
                <a href="/ride/offers">
                    <span class="material-icons-round">
                    local_offer
                    </span><br>
                    <span>Offers</span>
                </a>
            </div>
            <div class="bottom-controls-item">
                <a href="/ride/profile">
                    <span class="material-icons-round">
                    account_circle
                    </span><br>
                    <span>Profile</span>
                </a>
            </div>
        </div>
    </div>
    <script src="{{ $links['js'] }}"></script>
</body>
</html>