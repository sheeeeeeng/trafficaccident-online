var ta_json, patrol_json;
var a = -1;
var activeInfoWindow;
var map;
var ta_markers = [], patrol_markers = [];
// API 全資料路徑，此為常數
const url_location = "/api/ta/ta_log";
const url_patrol = "/api/ta/ta_patrol";
const url_rank = "/api/drinkMap";
let token = localStorage.getItem('jwt');
var map = L.map('map', {
  center: [22.756675,121.15024],
  zoom: 30
});
L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
  attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
}).addTo(map);

L.control.scale({
  position: 'topleft',
  metric: 'True',
  imperial: 'False',
  maxWidth:100
}).addTo(map);

var A1 = new L.Icon({
iconUrl: 'img/1.jpg',
shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png',
iconSize: [25, 41],
iconAnchor: [12, 41],
popupAnchor: [1, -34],
shadowSize: [41, 41]
});
var A2 = new L.Icon({
  iconUrl: 'img/2.jpg',
  shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png',
  iconSize: [25, 41],
  iconAnchor: [12, 41],
  popupAnchor: [1, -34],
  shadowSize: [41, 41]
  });
var A3 = new L.Icon({
  iconUrl: 'img/3.jpg',
  shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png',
  iconSize: [25, 41],
  iconAnchor: [12, 41],
  popupAnchor: [1, -34],
  shadowSize: [41, 41]
  });
var A4 = new L.Icon({
iconUrl: 'img/4.jpg',
shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png',
iconSize: [25, 41],
iconAnchor: [12, 41],
popupAnchor: [1, -34],
shadowSize: [41, 41]
});
var A5 = new L.Icon({
  iconUrl: 'img/5.jpg',
  shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png',
  iconSize: [25, 41],
  iconAnchor: [12, 41],
  popupAnchor: [1, -34],
  shadowSize: [41, 41]
  });
var A6 = new L.Icon({
  iconUrl: 'img/6.jpg',
  shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png',
  iconSize: [25, 41],
  iconAnchor: [12, 41],
  popupAnchor: [1, -34],
  shadowSize: [41, 41]
  });
var A7 = new L.Icon({
  iconUrl: 'img/7.jpg',
  shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png',
  iconSize: [25, 41],
  iconAnchor: [12, 41],
  popupAnchor: [1, -34],
  shadowSize: [41, 41]
});
var A8 = new L.Icon({
  iconUrl: 'img/8.jpg',
  shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png',
  iconSize: [25, 41],
  iconAnchor: [12, 41],
  popupAnchor: [1, -34],
  shadowSize: [41, 41]
});
var A9 = new L.Icon({
  iconUrl: 'img/9.jpg',
  shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png',
  iconSize: [25, 41],
  iconAnchor: [12, 41],
  popupAnchor: [1, -34],
  shadowSize: [41, 41]
});
var A10 = new L.Icon({
  iconUrl: 'img/10.jpg',
  shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png',
  iconSize: [25, 41],
  iconAnchor: [12, 41],
  popupAnchor: [1, -34],
  shadowSize: [41, 41]
});
var A11 = new L.Icon({
  iconUrl: 'img/11.jpg',
  shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png',
  iconSize: [25, 41],
  iconAnchor: [12, 41],
  popupAnchor: [1, -34],
  shadowSize: [41, 41]
});


var markers = new L.markerClusterGroup({
  iconCreateFunction: function (cluster) {
      const number = cluster.getChildCount();
      let icon = IconLogic(number);

      return new L.divIcon({ html: number, className: icon.className
                              , iconSize: icon.point });
}});

// 設定「篩選」按鈕 on click 監聽器
var update_btn = document.getElementById('update-google-map');

//群聚大小拉條
var slider = document.getElementById("small");
var output3 = document.getElementById("demo1");
output3.innerHTML = slider.value; // Display the default slider value
slider.oninput = function() {
  output3.innerHTML = this.value;
}

var slider2 = document.getElementById("mid");
var output2 = document.getElementById("demo2");
output2.innerHTML = slider2.value; // Display the default slider value
slider2.oninput = function() {
  output2.innerHTML = this.value;
}

var slider3 = document.getElementById("big");
var output = document.getElementById("demo3");
output.innerHTML = slider3.value; // Display the default slider value
slider3.oninput = function() {
  output.innerHTML = this.value;
}


//圖例群聚
function IconLogic(number) {  // 數量
  let className = 'marker';
  let point;
  if (number > slider3.value){
    className += ' cluster-large';
    point = L.point(35, 35);

  }
  else if (number > slider2.value) {
    className += ' cluster-medium';
    point = L.point(30, 30);
  }
  else if  (number >= slider.value){
    className += ' cluster-small';
    point = L.point(25, 25);
  }
  else{
    className += ' cluster-else';
    point = L.point(25, 25);
  }
  return {
      className: className,
      point: point
  }
}


var update_btn = document.getElementById('update-google-map');
update_btn.addEventListener('click', function () {

    // 取得 datetimepicker 的值
    var strat = document.getElementById('picker_start').value;
    var end = document.getElementById('picker_end').value;

    // 設定 API 存取條件
    var api_log = url_rank + "?filter=case_date:" + strat + "~" + end;
    var api_patrol = url_patrol + "?filter=set_date:" + strat + "~" + end

    // 取得資料
    getA1Data(api_log);

});

// 設定「重置」按鈕 on click 監聽器
var reset_btn = document.getElementById('reset-google-map');
reset_btn.addEventListener('click', function () {

  initMap();
  

});

function initMap() {

  markers.clearLayers();

}

function getA1Data(cache) {
  //markers.clearLayers();
  // 若有 Market 則先跑重置 Market

  // 使用 axios 取得 API 資料
  axios({
      url: cache,
      method: 'get',
      headers: {
          "Accept": "application/json",
          "Authorization": "Bearer " + token
      },
  })
      .then(function (response) {
          // 回傳資料放置於 json
          ta_json = response.data.data;
          // 根據資料長度設定 Market
          for (var e = 0; e < ta_json.length; e++) {
            var log = "案件編號：" + ta_json[e].serial_number + "<br>發生地點：" +  ta_json[e].latitude+","+ta_json[e].longitude;
            if(ta_json[e].case_is_drunk == "經觀察未飲酒"){
              markers.addLayer(L.marker([ta_json[e].latitude,ta_json[e].longitude], {icon: A1}).bindPopup(log));
            }
            else if(ta_json[e].case_is_drunk == "經檢測無酒精反應"){
              markers.addLayer(L.marker([ta_json[e].latitude,ta_json[e].longitude], {icon: A2}).bindPopup(log));
            }
            else if(ta_json[e].case_is_drunk == "經呼吸檢測未超過0.15mg/L或血液檢測未超過0.03%"){
              markers.addLayer(L.marker([ta_json[e].latitude,ta_json[e].longitude], {icon: A3}).bindPopup(log));
            }
            else if(ta_json[e].case_is_drunk == "經呼吸檢測0.16mg/L~0.25mg/L或血液檢測未超過0.031%~0.05%"){
              markers.addLayer(L.marker([ta_json[e].latitude,ta_json[e].longitude], {icon: A4}).bindPopup(log));
            }
            else if(ta_json[e].case_is_drunk == "經呼吸檢測0.26mg/L~0.4mg/L或血液檢測未超過0.051%~0.08%"){
              markers.addLayer(L.marker([ta_json[e].latitude,ta_json[e].longitude], {icon: A5}).bindPopup(log));
            }
            else if(ta_json[e].case_is_drunk == "經呼吸檢測0.41mg/L~0.55mg/L或血液檢測未超過0.081%~0.11%"){
              markers.addLayer(L.marker([ta_json[e].latitude,ta_json[e].longitude], {icon: A6}).bindPopup(log));
            }
            else if(ta_json[e].case_is_drunk == "經呼吸檢測0.56mg/L~0.8mg/L或血液檢測未超過0.111%~0.16%"){
              markers.addLayer(L.marker([ta_json[e].latitude,ta_json[e].longitude], {icon: A7}).bindPopup(log));
            }
            else if(ta_json[e].case_is_drunk == "經呼吸檢測超過0.8mg/L或血液檢測超過0.16%"){
              markers.addLayer(L.marker([ta_json[e].latitude,ta_json[e].longitude], {icon: A8}).bindPopup(log));
            }
            else if(ta_json[e].case_is_drunk == "無法檢測"){
              markers.addLayer(L.marker([ta_json[e].latitude,ta_json[e].longitude], {icon: A9}).bindPopup(log));
            }
            else if(ta_json[e].case_is_drunk == "非駕駛人，未檢測"){
              markers.addLayer(L.marker([ta_json[e].latitude,ta_json[e].longitude], {icon: A10}).bindPopup(log));
            }
            else if(ta_json[e].case_is_drunk == "不明"){
              markers.addLayer(L.marker([ta_json[e].latitude,ta_json[e].longitude], {icon: A11}).bindPopup(log));
            }
          }
          map.addLayer(markers);
      });

}



