<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="stylesheet" href="{{ $links['css'] }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View ride plans</title>
</head>
<body>
    <div class="container">
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
         <span class="material-icons-outlined" onclick="redirectBack()">
        arrow_back
        </span><br>
        <p>
            <div class="display-center">
                <div class="text-align-center">
                    <img class="profile-image-large" src="{{ $rideData->ride_profile_image }}" alt=""><br>
                    <span class="title">{{ $rideAuth->ride_first_name." ".$rideAuth->ride_last_name }}</span><br>
                </div>
            </div>
        </p>
        <p>
            <div class="display-flex-scroll">
                @foreach(json_decode($rideData->ride_plans, true) as $k => $v) 
                    @if($k < 2)      
                        <div class="curved-top position-relative" id="plan-{{ $k }}">
                            <p>
                                <div class="display-flex-justify-center">
                                    <div>
                                        <span class="material-icons-outlined">
                                        schedule
                                        </span>
                                    </div>
                                    <div>
                                        <span class="title">Plans</span>
                                    </div>
                                </div>
                            </p>
                            <span class="title">Pick-up place</span><br>
                            <span>{{ $v["riding_later_from"] }}</span><br>
                            <span class="title">Destination</span><br>
                            <span>{{ $v["riding_later_to"] }}</span><br>
                            <span class="title">Date and Time</span><br>
                            <span>{{ $v["riding_later_date"] }}</span>
                            <span>{{ $v["riding_later_time"] }}</span>
                            <span>{{ $v["riding_later_meridiem"] }}</span>
                            <p>
                                <form action="/drive/{{ $rideAuth->id }}/offer" method="POST">
                                    @csrf
                                    @method("POST")
                                    <input type="hidden" name="ridefrom" value="{{ $v['riding_later_from'] }}">
                                    <input type="hidden" name="rideto" value="{{ $v['riding_later_to'] }}">
                                    <input type="hidden" name="ridedatetime" value="{{ $v['riding_later_date'] }} {{ $v['riding_later_time'] }} {{ $v['riding_later_meridiem'] }}">
                                    <input type="hidden" name="planid" value="{{ $k }}">
                                    @foreach(json_decode($driveData->ride_offers, true) as $rideofferid)
                                        @if($rideofferid == $k)
                                        <input type="hidden" name="action" value="cancel">
                                            <div class="text-align-center">
                                                <p>
                                                    <button>Cancel</button>
                                                </p>
                                            </div>
                                            @break
                                        @else
                                            <button>Offer</button>
                                        @endif
                                    @endforeach
                                    @if(sizeof(json_decode($driveData->ride_offers, true)) == 0)
                                        <input type="hidden" name="action" value="new">    
                                        <button>Offer</button>
                                    @endif
                                </form>
                            </p>
                            @if(sizeof(json_decode($rideData->ride_plans, true)) != 1)
                                <span class="material-icons-outlined next-plan" onclick="nextPlan('plan-{{ $k }}', 'plan-{{ $k + 1 }}')">
                                arrow_forward
                                </span>
                            @endif
                        </div>
                    @else
                        @if($k < sizeof(json_decode($rideData->ride_plans, true)))
                            <div class="curved-top position-relative display-none" id="plan-{{ $k }}">
                                <p>
                                    <div class="display-flex-justify-center">
                                        <div>
                                            <span class="material-icons-outlined">
                                            schedule
                                            </span>
                                        </div>
                                        <div>
                                            <span class="title">Plans</span>
                                        </div>
                                    </div>
                                </p>
                                <span class="title">Pick-up place</span><br>
                                <span>{{ $v["riding_later_from"] }}</span><br>
                                <span class="title">Destination</span><br>
                                <span>{{ $v["riding_later_to"] }}</span><br>
                                <span class="title">Date and Time</span><br>
                                <span>{{ $v["riding_later_date"] }}</span>
                                <span>{{ $v["riding_later_time"] }}</span>
                                <span>{{ $v["riding_later_meridiem"] }}</span>
                                <p>
                                    <form action="/drive/{{ $rideAuth->id }}/offer" method="POST">
                                        @csrf
                                        @method("POST")
                                        <input type="hidden" name="ridefrom" value="{{ $v['riding_later_from'] }}">
                                        <input type="hidden" name="rideto" value="{{ $v['riding_later_to'] }}">
                                        <input type="hidden" name="ridedatetime" value="{{ $v['riding_later_date'] }} {{ $v['riding_later_time'] }} {{ $v['riding_later_meridiem'] }}">
                                        <input type="hidden" name="planid" value="{{ $k }}">
                                        @foreach(json_decode($driveData->ride_offers, true) as $rideofferid)
                                            @if($rideofferid == $k)
                                            <input type="hidden" name="action" value="cancel">
                                                <div class="text-align-center">
                                                    <p>
                                                        <button>Cancel</button>
                                                    </p>
                                                </div>
                                                @break
                                            @else
                                                <button>Offer</button>
                                            @endif
                                        @endforeach
                                        @if(sizeof(json_decode($driveData->ride_offers, true)) == 0)
                                            <input type="hidden" name="action" value="new">    
                                            <button>Offer</button>
                                        @endif
                                    </form>
                                </p>
                                <span class="material-icons-outlined next-plan-back" onclick="nextPlanEnd('plan-{{ $k }}', 'plan-{{ $k - 1 }}')">
                                arrow_back
                                </span>
                                <span class="material-icons-outlined next-plan" onclick="nextPlan('plan-{{ $k }}', 'plan-{{ $k + 1 }}')">
                                arrow_forward
                                </span>
                            </div>
                        @else
                            <div class="curved-top position-relative display-none" id="plan-{{ $k }}">
                                <p>
                                    <div class="display-flex-justify-center">
                                        <div>
                                            <span class="material-icons-outlined">
                                            schedule
                                            </span>
                                        </div>
                                        <div>
                                            <span class="title">Plans</span>
                                        </div>
                                    </div>
                                </p>    
                                <span class="title">Pick-up place</span><br>
                                <span>{{ $v["riding_later_from"] }}</span><br>
                                <span class="title">Destination</span><br>
                                <span>{{ $v["riding_later_to"] }}</span><br>
                                <span class="title">Date and Time</span><br>
                                <span>{{ $v["riding_later_date"] }}</span>
                                <span>{{ $v["riding_later_time"] }}</span>
                                <span>{{ $v["riding_later_meridiem"] }}</span>
                                <p>
                                    <form action="/drive/{{ $rideAuth->id }}/offer" method="POST">
                                        @csrf
                                        @method("POST")
                                        <input type="hidden" name="ridefrom" value="{{ $v['riding_later_from'] }}">
                                        <input type="hidden" name="rideto" value="{{ $v['riding_later_to'] }}">
                                        <input type="hidden" name="ridedatetime" value="{{ $v['riding_later_date'] }} {{ $v['riding_later_time'] }} {{ $v['riding_later_meridiem'] }}">
                                        <input type="hidden" name="planid" value="{{ $k }}">
                                        @foreach(json_decode($driveData->ride_offers, true) as $rideofferid)
                                            @if($rideofferid == $k)
                                            <input type="hidden" name="action" value="cancel">
                                                <div class="text-align-center">
                                                    <p>
                                                        <button>Cancel</button>
                                                    </p>
                                                </div>
                                                @break
                                            @else
                                                <button>Offer</button>
                                            @endif
                                        @endforeach
                                        @if(sizeof(json_decode($driveData->ride_offers, true)) == 0)
                                            <input type="hidden" name="action" value="new">    
                                            <button>Offer</button>
                                        @endif
                                    </form>
                                </p>
                                <span class="material-icons-outlined next-plan-back" onclick="nextPlanEnd('plan-{{ $k }}', 'plan-{{ $k - 1 }}')">
                                arrow_back
                                </span>
                            </div>
                        @endif
                    @endif
                @endforeach
            </div>
        </p>
    </div>
    <script src="{{ $links['js'] }}"></script>
</body>
</html>