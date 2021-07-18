var googleIcons = document.createElement("link");
googleIcons.rel = "stylesheet";
googleIcons.href = "https://fonts.googleapis.com/icon?family=Material+Icons+Round";

document.getElementsByTagName("head")[0].appendChild(googleIcons);
var elementPrev = {};






function closePopup(id){
    let toClosePopup = document.querySelector("#"+id);
    if(toClosePopup.style.display == "" || toClosePopup.style.display == "none"){
        toClosePopup.style.display = "block";
    }else{
        toClosePopup.style.display = "none";
    }
}

function openClosePlan(id){
    let toClosePopup = document.querySelector("#"+id);
    if(toClosePopup.style.display == "" || toClosePopup.style.display == "none"){
        document.querySelector("#plans").style.display = "none";
        toClosePopup.style.display = "block";
    }else{
        toClosePopup.style.display = "none";
        document.querySelector("#plans").style.display = "block";
    }
}

function redirectBack(){
    window.history.back();
}

function displayComp(self, id){
    if(elementPrev["tracked"]){
        elementPrev["tracked"].classList.remove("border-bottom");
    }
    
    document.querySelector("#requests").style.display = "none";
    document.querySelector("#requestsaccepted").style.display = "none";

    let comp = document.querySelector("#"+id);
    comp.style.display = "block";

    self.classList.add("border-bottom");

    elementPrev["tracked"] = self;

}

function nextPlan(hide, show){
    document.querySelector("#"+hide).style.display = "none";
    document.querySelector("#"+show).style.display = "block";
}

function nextPlanEnd(hide, show){
    document.querySelector("#"+hide).style.display = "none";
    document.querySelector("#"+show).style.display = "block";
}

function initMapCurrentLoc() {
let map;
  map = new google.maps.Map(document.getElementById("map"), {
    center: { lat: -23.30246, lng: 30.71868},
    zoom: 9,
    mapId: "4cce301a9d6797df"
  });
    if (navigator.geolocation) {
      navigator.geolocation.getCurrentPosition(
        (position) => {
          const pos = {
            lat: position.coords.latitude,
            lng: position.coords.longitude,
          };
          const myLocation = new google.maps.Marker({
            position: {lat: position.coords.latitude, lng: position.coords.longitude},
            map: map,
            title: "Me",
        });
        },
      );
    } else {
        console.log("Browser doesn't support Geolocation");
    }
}
























