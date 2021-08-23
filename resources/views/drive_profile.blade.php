<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="stylesheet" href="{{ $links['css'] }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
</head>
<body>
    <div class="container">
        <div class="menu display-none" id="menu">
            <div class="text-align-right">
                <span class="material-icons-round" onclick="closePopup('menu')">
                close
                </span>
            </div>
            <p>
                <div class="display-flex-normal gap-small" onclick="redirectTo('/drive/profile')">
                    @if($driveData->drive_profile_image == "")
                        <div class="position-relative">
                            <span class="material-icons-round empty-profile-small">
                            account_circle
                            </span><br>
                        </div>
                    @else
                        <div class="position-relative">
                            <img class="profile-image-small" src="{{ $driveData->drive_profile_image }}" alt=""><br>
                        </div>
                    @endif
                    <div>
                    <span>My account</span>
                        <div class="rating-stars-small-center">
                            @for($i = 1; $i <= 5; $i++)
                                @if($i <= floor($driveData->drive_ratings))
                                    <span class="material-icons-round" style="color: orange" >
                                    star
                                    </span>
                                @else
                                    <span class="material-icons-round" >
                                    star
                                    </span>
                                @endif
                            @endfor
                        </div>
                    </div>
                </div>
            </p>
            <p>
                <span>Send feedback</span>
            </p>
            <p>
                <div class="display-flex-normal gap-small" onclick="redirectTo('/signout')">
                    <span>Sign out</span>
                </div>
            </p>
        </div>
        <div class="nav">
            <div class="display-flex-normal gap-10">
                <span class="material-icons-round" onclick="redirectBack()">
                arrow_back
                </span>
                <span class="">My account</span>
           </div>
           <div class="display-flex-normal gap-mid">
                <span class="material-icons-round">
                notifications
                </span>
                <span class="material-icons-round " onclick="closePopup('menu')">
                more_vert
                </span>
           </div>
        </div>
        <p>
            <div class="display-center profile-style">
                <div class="text-align-center">
                    @if($driveData->drive_profile_image == "")
                        <div class="position-relative">
                            <span onclick="closePopup('profileedit')" class="material-icons-round empty-profile-large">
                            account_circle
                            </span><br>
                        </div>
                    @else
                        <div class="position-relative">
                            <img onclick="closePopup('profileedit')" class="profile-image-large" src="{{ $driveData->drive_profile_image }}" alt=""><br>
                        </div>
                    @endif
                    <span class="title">{{ $driveAuth->drive_first_name." ".$driveAuth->drive_last_name }}</span><br>
                    <div class="trunc-text">
                        <span>Drives <strong>{{ $driveData->drive_vehicle }} - </strong></span>
                        <strong>{{ $driveData->drive_vehicle_type }}</strong>
                    </div>
                    <div class="display-flex-center">
                        @if($driveAuth->drive_gender == "Male")
                            <span>Gender <strong>{{ $driveAuth->drive_gender }}</strong></span>
                        @elseif($driveAuth->drive_gender == "Female")
                            <span>Gender <strong>{{ $driveAuth->drive_gender }}</strong></span>
                        @else
                            <span>Gender <strong>{{ $driveAuth->drive_gender }}</strong></span>
                        @endif
                    </div>
                    <div class="rating-stars-small-center">
                        @for($i = 1; $i <= 5; $i++)
                            @if($i <= floor($driveData->drive_ratings))
                                <span class="material-icons-round" style="color: orange" >
                                star
                                </span>
                            @else
                                <span class="material-icons-round" >
                                star
                                </span>
                            @endif
                        @endfor
                    </div>
                </div>
            </div>
        </p>
        <form class="display-none" id="uploadform" action="/drive/profile/upload/image" method="POST" enctype="multipart/form-data">
            @csrf
            @method("POST")
            <input type="file" name="image" id="image" accept="image/png, image/jpg, image/jpeg, image/gif">
        </form>
        <div id="profileedit" class="profile-edit display-none">
            <div>
                <div class="text-align-right picture-edit-close">
                    <span class="material-icons-round" onclick="closePopup('profileedit')">
                    close
                    </span>
                </div>
                <p>
                    <div class="text-align-center">
                        @if($driveData->drive_profile_image == "")
                            <span class="material-icons-round empty-profile-large">
                            account_circle
                            </span><br>
                        @else
                            <img class="profile-image-large" src="{{ $driveData->drive_profile_image }}" alt=""><br>
                        @endif

                    </div>
                </p>
                <div class="display-flex-center gap">
                    <div class="display-flex-normal" onclick="uploadSubmit('image', 'uploadform')">
                        <span class="material-icons-round">
                        image
                        </span>
                        <span>Upload</span>
                    </div>
                    @if($driveData->drive_profile_image != "")
                        <div class="display-flex-normal" onclick="submitForm('uploadform')">
                            <span class="material-icons-round">
                            delete
                            </span>
                            <span>Remove</span>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        <p>
            <div class="display-flex-normal gap-small">
                <span class="material-icons-round icon-padding">
                swipe
                </span>
                <div class="city-container">
                    @foreach(json_decode($driveData->drive_cities, true) as $city)
                        <div class="city">
                            {{ $city }}
                        </div>
                    @endforeach
                </div>
            </div>
        </p>
        <p>
            <div class="display-flex-center-align gap-10">
                <span class="material-icons-round">
                travel_explore
                </span>
                <span onclick="closePopup('editcities')">Edit my cities</span>
            </div>
        </p>
        <div id="editcities" class="edit-cities">
            <div class="nav display-flex-space-between">
                <span>Edit cities</span>
                <span class="material-icons-round newplan" onclick="closePopup('editcities')">
                close
                </span>
            </div>
            <div class="curved-top padding-none">
                <div id="map"></div>
                <div class="app-padding">
                    <p>
                        <div class="text-align-center">
                            <span class="title">Choose a maximum of 5 cities you want to drive back-forth</span>
                        </div>
                    </p>
                    <div id="citycontainer" class="city-container">

                    </div>
                    <form id="citiesform" action="/drive/edit/cities" method="POST">
                        @csrf
                        @method("POST")
                        <p>
                            <div class="display-flex-normal gap-10">
                                <input id="ridefrom" type="text" placeholder="Type a city">
                                <input type="hidden" id="cities" name="cities">
                                <span onclick="addCity()" class="material-icons-round black-background">
                                add
                                </span>
                            </div>
                        </p>
                        <p>
                            <button type="button" onclick="jsonCitiesAndSubmit('citiesform')">Save</button>
                        </p>
                    </form>
                </div>
            </div>
        </div>
        <p>
            <div class="curved-top">
                <form class="app-padding" action="/drive/profile/update" method="POST">
                    @csrf
                    @method("POST")
                    <input type="text" name="firstname" value="{{ $driveAuth->drive_first_name }}" placeholder="Enter First name">
                    <p>
                        <input type="text" name="lastname" value="{{ $driveAuth->drive_last_name }}" placeholder="Enter Last name">
                    </p>
                    <p>
                        <input type="text" name="vehiclename" value="{{ $driveData->drive_vehicle }}" placeholder="Enter Vehicle name">
                    </p>
                    <p>
                        <input type="text" name="vehicletype" value="{{ $driveData->drive_vehicle_type }}" placeholder="Enter Vehicle type">
                    </p>
                    <p>
                        <button>Save</button>
                    </p>
                </form>
            </div>
        </p>
    </div>
    <div class="bottom-controls">
        <div class="bottom-controls-item">
            <a href="/drive/dashboard">
                <span class="material-icons-round">
                home
                </span><br>
                <span class="title-small">Home</span>
            </a>
        </div>
        <div class="bottom-controls-item">
            <a href="/drive/history">
                <span class="material-icons-round">
                watch_later
                </span><br>
                <span class="title-small">History</span>
            </a>
        </div>
        <div class="bottom-controls-item">
            <a href="/drive/reviews">
                <span class="material-icons-round">
                edit
                </span><br>
                <span class="title-small">Revie..</span>
            </a>
        </div>
        <div class="bottom-controls-item">
            <a href="/drive/riders">
                <span class="material-icons-round">
                travel_explore
                </span><br>
                <span class="title-small">Plans</span>
            </a>
        </div>
        <div class="bottom-controls-item">
            <a href="/drive/offers">
                <span class="material-icons-round">
                local_offer
                </span><br>
                <span class="title-small">Offers</span>
            </a>
        </div>
        <div class="bottom-controls-item">
            <a href="/drive/chats">
                <span class="material-icons-round">
                question_answer
                </span><br>
                <span class="title-small">Chats</span>
            </a>
        </div>
    </div>
    <script src="{{ $links['js'] }}"></script>
    <script>
        function initAutocompleteNow() {
            let from, to;
            var points = false;
            var directionsOptions = {
                polylineOptions: {
                    strokeColor: 'red',
                    strokeWeight: 2,
                }
            }
            let directionsRenderer = new google.maps.DirectionsRenderer(directionsOptions);

            const map = new google.maps.Map(document.getElementById("map"), {
            center: { lat: -33.8688, lng: 151.2195 },
            zoom: 13,
            mapId: "4cce301a9d6797df",
            disableDefaultUI: true,
            fullscreenControl: true
            });

            // Create the search box and link it to the UI element.
            const inputFrom = document.getElementById("ridefrom");
            const searchBoxFrom = new google.maps.places.SearchBox(inputFrom);
            
            map.addListener("bounds_changed", () => {
                searchBoxFrom.setBounds(map.getBounds());
            });

            let markers = [];

            searchBoxFrom.addListener("places_changed", () => {
            const places = searchBoxFrom.getPlaces();
        
            if (places.length == 0) {
                return;
            }
            // Clear out the old markers.
            markers.forEach((marker) => {
                marker.setMap(null);
            });
            markers = [];
            // For each place, get the icon, name and location.
            const bounds = new google.maps.LatLngBounds();
            places.forEach((place) => {
                if (!place.geometry || !place.geometry.location) {
                console.log("Returned place contains no geometry");
                return;
                }
                from = place.geometry.location;
                
                // Create a marker for each place.
                markers.push(
                    new google.maps.Marker({
                        map,
                        title: place.name,
                        position: place.geometry.location,
                        animation: google.maps.Animation.DROP,
                    })
                );
        
                if (place.geometry.viewport) {
                // Only geocodes have viewport.
                bounds.union(place.geometry.viewport);
                } else {
                bounds.extend(place.geometry.location);
                }
            });
            map.fitBounds(bounds);
            });
        }
    </script>
    <script
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCNarbofdMvrgaKRZ9e_LvJD2miCEOS6D0&callback=initAutocompleteNow&libraries=places&v=weekly"
    async
    ></script>
</body>
</html>