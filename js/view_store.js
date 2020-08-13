
function GetXmlHttpObject() {
    var xmlHttp = null;
    try {
        // Firefox, Opera 8.0+, Safari
        xmlHttp = new XMLHttpRequest();
    } catch (e) {
// Internet Explorer
        try {
            xmlHttp = new ActiveXObject("Msxml2.XMLHTTP");
        } catch (e) {
            xmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
    }
    return xmlHttp;
}

function keyset(key, e) {

    if (e.keyCode == 13) {
        document.getElementById(key).focus();
    }
}

function got_focus(key) {
    document.getElementById(key).style.backgroundColor = "#000066";
}

function lost_focus(key) {
    document.getElementById(key).style.backgroundColor = "#000000";
}




function view_stores() {
  var url = "view_store.php";
  url = url + "?Command=" + "view";
  
  window.open(url, "_blank");
}









var directionsRenderer;
var directionsService;


var map;
function initMap() {
  
  map = new google.maps.Map(document.getElementById("map"), {
    center: { lat: 6.892785, lng: 79.980789 },
    zoom: 12,
  });
  

  
}

var marker = [];
function getStores() {
  xmlHttp = GetXmlHttpObject();
  if (xmlHttp == null) {
    alert("Browser does not support HTTP Request");
    return;
  }

  var url = "view_store_data.php";
  url = url + "?Command=" + "getStores";
  url = url + "&ls=" + "new";

  xmlHttp.onreadystatechange = got_stores;
  xmlHttp.open("GET", url, true);
  xmlHttp.send(null);
}

function got_stores() {
  var XMLAddress1;

  if (xmlHttp.readyState == 4 || xmlHttp.readyState == "complete") {
    var locations = JSON.parse(xmlHttp.response);
    
    var location;
   
    console.log(locations[1]);
    for (var i = 0; i < locations[0].length; i++) {
      location = {
        lat: parseFloat(locations[0][i].lat),
        lng: parseFloat(locations[0][i].lng),
      };
      marker.push(
        new google.maps.Marker({
          position: location,

          label: {
            text: locations[0][i].shop_name,
            color: "black",
            fontSize: "20px",
          },
          icon: "./img/store_icon.png",
          map: map,
        })
      );
    }

    var icon_rider = "";
    for (var i = 0; i < locations[1].length; i++) {
      location = {
        lat: parseFloat(locations[1][i].lat),
        lng: parseFloat(locations[1][i].lng),
      };

      if (locations[1][i].ON_DELIVERY == "1") {
        icon_rider = "./img/delivery_icon.png";
      }else{
        icon_rider = "./img/delivery_icon_offline.png";
      }

      marker.push(
        new google.maps.Marker({
          position: location,

          label: {
            text: locations[1][i].user_name,
            color: "black",
            fontSize: "17px",
          },
          icon: icon_rider,
          map: map,
        })
      );
    }


  }
}