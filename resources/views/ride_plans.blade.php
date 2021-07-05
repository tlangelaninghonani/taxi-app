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
                <span class="material-icons-outlined" onclick="closePopup('menu')">
                close
                </span>
            </div>
            <table>
                <td>
                    <span class="material-icons-outlined">
                    account_circle
                    </span>
                </td>
                <td>
                    <span>Profile</span>
                </td>
            </table>
            <a href="/signout">
                <table>
                    <td>
                        <span class="material-icons-outlined">
                        arrow_back
                        </span>
                    </td>
                    <td>
                    <span> Sign out</span>
                    </td>
                </table>
            </a>
        </div>
        <div class="nav">
           <div class="display-flex">
                <span class="material-icons-outlined">
                apartment
                </span>
                <span class="app-name">InterCityRides</span>
           </div>
           <span class="material-icons-outlined items-menu-icon" onclick="closePopup('menu')">
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
                            <span class="material-icons-outlined plan-icon">
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
            <p>
                <div class="text-align-right">
                    <span class="material-icons-outlined newplan" onclick="openClosePlan('newplan')">
                    close
                    </span>
                </div>
            </p>
            <p>
                <div>
                    <img class="welcome-page-banner-1" src="https://image.freepik.com/free-vector/man-holding-clock-time-management-concept_23-2148823171.jpg" alt="">
                </div>
            </p>
            <div class="curved-top">
                <form action="/ride/plans" method="POST">
                    @csrf
                    @method("POST")
                     <p>
                        <span class="title">Where are you going later?</span>
                    </p>
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
                    <span class="material-icons-outlined">
                    home
                    </span><br>
                    <span>Home</span>
                </a>
            </div>
            <div class="bottom-controls-item">
                <a href="/ride/history">
                    <span class="material-icons-outlined">
                    history
                    </span><br>
                    <span>History</span>
                </a>
            </div>
            <div class="bottom-controls-item">
                <a href="/ride/plans">
                    <span class="material-icons-outlined">
                    public
                    </span><br>
                    <span>Plans</span>
                </a>
            </div>
            <div class="bottom-controls-item">
                <a href="/ride/drivers">
                    <span class="material-icons-outlined">
                    directions_car
                    </span><br>
                    <span>Drivers</span>
                </a>
            </div>
            <div class="bottom-controls-item">
                <a href="/ride/offers">
                    <span class="material-icons-outlined">
                    local_offer
                    </span><br>
                    <span>Offers</span>
                </a>
            </div>
        </div>
    </div>
    <script src="{{ $links['js'] }}"></script>
</body>
</html>