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
function redirectTo(path){
    window.location.href = path;
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

function nextPlan(hide, show, originLat, originLng, destLat, destLng, mapId){
    document.querySelector("#"+hide).style.display = "none";
    document.querySelector("#"+show).style.display = "block";

    drawLine(originLat, originLng, destLat, destLng, mapId);
}

function search(containerId, itemsClass, keyword){
    if(keyword !== ""){
        let container = document.querySelector("#"+containerId);
        let items = document.querySelectorAll("."+itemsClass);

        for (let i = 0; i < items.length; i++) {
            const item = items[i];
            if(item.id.toLowerCase().includes(keyword.toLowerCase())){
                container.prepend(item);
            }
        }
    }
}

function nextPlanEnd(hide, show){
    document.querySelector("#"+hide).style.display = "none";
    document.querySelector("#"+show).style.display = "block";
}

function colorStar(span, starId){
    for (let i = 1; i < 6; i++) {
        const star = document.querySelector("#star"+i);
        if(i <= starId){
            star.setAttribute("style", "color: orange;");
        }else{
            star.setAttribute("style", "color: black;");
        }
        document.querySelector("#ratings").value = starId;
    }
    
}

function initMapCurrentLoc() {
let map;
  map = new google.maps.Map(document.getElementById("map"), {
    center: { lat: -23.30246, lng: 30.71868},
    zoom: 12,
    mapId: "4cce301a9d6797df",
    disableDefaultUI: true,
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
























