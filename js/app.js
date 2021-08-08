var googleIcons = document.createElement("link");
googleIcons.rel = "stylesheet";
googleIcons.href = "https://fonts.googleapis.com/icon?family=Material+Icons+Round";

document.getElementsByTagName("head")[0].appendChild(googleIcons);
var elementPrev = {};

/*var materialClass = document.querySelectorAll(".material-icons-round");
for (let i = 0; i < materialClass.length; i++) {
    materialClass[i].classList.add("material-icons-font");
}*/

function closePopup(id){
    let toClosePopup = document.querySelector("#"+id);
    if(toClosePopup.style.display == "" || toClosePopup.style.display == "none"){
        toClosePopup.style.display = "block";
    }else{
        toClosePopup.style.display = "none";
    }
}

function displayFilter(self, id){
    let toClosePopup = document.querySelector("#"+id);
    if(toClosePopup.style.display == "" || toClosePopup.style.display == "none"){
        toClosePopup.style.display = "block";
        self.innerHTML = "close";
    }else{
        toClosePopup.style.display = "none";
        self.innerHTML = "tune";
    }
}

function openClosePlan(iconId, id){
    let icon = document.querySelector("#"+iconId);
    let toClosePopup = document.querySelector("#"+id);
    if(toClosePopup.style.display == "" || toClosePopup.style.display == "none"){
        document.querySelector("#plans").style.display = "none";
        toClosePopup.style.display = "block";
        icon.innerHTML = "close";
    }else{
        toClosePopup.style.display = "none";
        document.querySelector("#plans").style.display = "block";
        icon.innerHTML = "add";
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

    comp.scrollIntoView();

    self.classList.add("border-bottom");

    elementPrev["tracked"] = self;

}

function verifyPasswords(buttonId){
    let button = document.querySelector("#"+buttonId);
    let password = document.querySelector("#password");
    let confirmPassword = document.querySelector("#confirm");
    if(password.value.length < 8){
        button.disabled = true;
        document.querySelector("#passwordmatcherr").style.display = "none";
        document.querySelector("#passwordlengtherr").style.display = "block";
    }else if(password.value !== confirmPassword.value){
        button.disabled = true;
        document.querySelector("#passwordlengtherr").style.display = "none";
        document.querySelector("#passwordmatcherr").style.display = "block";
    }else{
        document.querySelector("#passwordlengtherr").style.display = "none";
        document.querySelector("#passwordmatcherr").style.display = "none";
        button.disabled = false;
    }
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

function uploadSubmit(fileId, formId){
    let file = document.querySelector("#"+fileId);
    let form = document.querySelector("#"+formId);
    file.click();
    file.onchange = function(){
        form.submit();
    }
}

function sendMessageDrive(chatsId, profilePictureId, messageId, driveId){
    let message = document.querySelector("#"+messageId);
    let chats = document.querySelector("#"+chatsId);
    let driveChatContainer = document.createElement("div");
    let rideChat = document.createElement("div");
    let profilePicture = document.createElement("div");
    profilePicture.innerHTML = document.querySelector("#"+profilePictureId).innerHTML;

    if(message.value !== ""){
        if(document.querySelector("#nocomment")){
            document.querySelector("#nocomment").style.display = "none";
        }
        driveChatContainer.setAttribute("class", "display-flex chat-padding-drive");
        rideChat.setAttribute("class", "drive-chat");
        let messageSpan = document.createElement("span");
        messageSpan.innerHTML = message.value;
        driveChatContainer.appendChild(profilePicture);
        rideChat.appendChild(messageSpan);
        driveChatContainer.appendChild(rideChat);
        chats.appendChild(driveChatContainer);

        document.querySelector("#chat").value = message.value;
        formData = new FormData(document.querySelector("#chatform"));

        messageSpan.scrollIntoView();

        $.ajax({
        url : "/drive/"+driveId+"/chat/message",
        type : 'POST',
        cache: false,
        data : formData,
        processData: false, 
        contentType: false,  
        });

        message.value = "";
    }
   
}

function sendMessage(chatsId, profilePictureId, messageId, driveId){
    let message = document.querySelector("#"+messageId);
    let chats = document.querySelector("#"+chatsId);
    let rideChatContainer = document.createElement("div");
    let rideChat = document.createElement("div");
    let profilePicture = document.createElement("div");
    profilePicture.innerHTML = document.querySelector("#"+profilePictureId).innerHTML;

    if(message.value !== ""){
        if(document.querySelector("#nocomment")){
            document.querySelector("#nocomment").style.display = "none";
        }
        rideChatContainer.setAttribute("class", "display-flex-end chat-padding");
        rideChat.setAttribute("class", "ride-chat");
        let messageSpan = document.createElement("span");
        messageSpan.innerHTML = message.value;
        rideChat.appendChild(messageSpan);
        rideChatContainer.appendChild(rideChat);
        rideChatContainer.appendChild(profilePicture);
        chats.appendChild(rideChatContainer);

        document.querySelector("#chat").value = message.value;
        formData = new FormData(document.querySelector("#chatform"));

        messageSpan.scrollIntoView();

        $.ajax({
        url : "/ride/"+driveId+"/chat/message",
        type : 'POST',
        cache: false,
        data : formData,
        processData: false, 
        contentType: false,  
        });

        message.value = "";
    }
   
}

function submitForm(formId){
    let form = document.querySelector("#"+formId);
    form.submit();
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
    fullscreenControl: true
  });
  /*setInterval(function() {
    }, 60 * 1000);*/
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
              animation: google.maps.Animation.DROP,
          });
          },
        );
      } else {
          console.log("Browser doesn't support Geolocation");
      }
}

function initMapCurrentLocDrive() {
let map;
  map = new google.maps.Map(document.getElementById("map"), {
    center: { lat: -23.30246, lng: 30.71868},
    zoom: 12,
    mapId: "4cce301a9d6797df",
    disableDefaultUI: true,
    fullscreenControl: true
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
            animation: google.maps.Animation.DROP,
        });
        },
      );
    } else {
        console.log("Browser doesn't support Geolocation");
    }
}
























