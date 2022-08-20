var ta_json, patrol_json;
var a = -1;
var activeInfoWindow;
var map;
var ta_markers = [], patrol_markers = [];




// API 全資料路徑，此為常數
const url_location = "/api/ta/ta_log";
const url_patrol = "/api/ta/ta_patrol";
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

var police = new L.Icon({
  iconUrl: 'img/police-32.png',
  shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png',
  iconSize: [25, 41],
  iconAnchor: [12, 41],
  popupAnchor: [1, -34],
  shadowSize: [41, 41]
  });
var A1 = new L.Icon({
iconUrl: 'img/a1-pin-32.png',
shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png',
iconSize: [25, 41],
iconAnchor: [12, 41],
popupAnchor: [1, -34],
shadowSize: [41, 41]
});
var A2 = new L.Icon({
  iconUrl: 'img/a2-pin-16.png',
  shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png',
  iconSize: [25, 41],
  iconAnchor: [12, 41],
  popupAnchor: [1, -34],
  shadowSize: [41, 41]
  });
var A3 = new L.Icon({
  iconUrl: 'http://maps.google.com/mapfiles/ms/icons/green-dot.png',
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

var po1 = new L.markerClusterGroup({
  iconCreateFunction: function (cluster) {
      const number = cluster.getChildCount();
      let icon = poIconLogic(number);

      return new L.divIcon({ html: number, className: icon.className
                              , iconSize: icon.point });
}});






//var markers = new L.MarkerClusterGroup().addTo(map);;
// 設定「篩選」按鈕 on click 監聽器
var update_btn = document.getElementById('update-google-map');
update_btn.addEventListener('click', function () {

    // 取得 datetimepicker 的值
    var strat = document.getElementById('picker_start').value;
    var end = document.getElementById('picker_end').value;

    // 設定 API 存取條件
    var api_log = url_location + "?filter=case_date:" + strat + "~" + end;
    var api_patrol = url_patrol + "?filter=set_date:" + strat + "~" + end

    // 取得資料
    getallData(api_log,api_patrol);

});


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


var update_btn = document.getElementById('A1-map');
update_btn.addEventListener('click', function () {

    // 取得 datetimepicker 的值
    var strat = document.getElementById('picker_start').value;
    var end = document.getElementById('picker_end').value;

    // 設定 API 存取條件
    var api_log = url_location + "?filter=case_date:" + strat + "~" + end;
    var api_patrol = url_patrol + "?filter=set_date:" + strat + "~" + end

    // 取得資料
    getA1Data(api_log);

});


var update_btn = document.getElementById('A2-map');
update_btn.addEventListener('click', function () {

    // 取得 datetimepicker 的值
    var strat = document.getElementById('picker_start').value;
    var end = document.getElementById('picker_end').value;

    // 設定 API 存取條件
    var api_log = url_location + "?filter=case_date:" + strat + "~" + end;
    var api_patrol = url_patrol + "?filter=set_date:" + strat + "~" + end;
  
    // 取得資料
    getA2Data(api_log);

});


var update_btn = document.getElementById('A3-map');
update_btn.addEventListener('click', function () {

    // 取得 datetimepicker 的值
    var strat = document.getElementById('picker_start').value;
    var end = document.getElementById('picker_end').value;

    // 設定 API 存取條件
    var api_log = url_location + "?filter=case_date:" + strat + "~" + end;
    var api_patrol = url_patrol + "?filter=set_date:" + strat + "~" + end;

    // 取得資料
    getA3Data(api_log);

});

var update_btn = document.getElementById('police-map');
update_btn.addEventListener('click', function () {
 
    // 取得 datetimepicker 的值
    var strat = document.getElementById('picker_start').value;
    var end = document.getElementById('picker_end').value;

    // 設定 API 存取條件
    var api_log = url_location + "?filter=case_date:" + strat + "~" + end;
    var api_patrol = url_patrol + "?filter=set_date:" + strat + "~" + end

    // 取得資料
    getPatrolData(api_patrol);

});

// 設定「重置」按鈕 on click 監聽器
var reset_btn = document.getElementById('reset-google-map');
reset_btn.addEventListener('click', function () {

  initMap();
  

});

function initMap() {

  markers.clearLayers();
  po1.clearLayers();

}

function IconLogic(number) {  // 數量
  let className = 'marker';
  let point;
  if (number > slider3.value){
    className += ' cluster-large';
    point = L.point(40, 40);

  }
  else if (number > slider2.value) {
    className += ' cluster-medium';
    point = L.point(35, 35);
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


function poIconLogic(number) {  // 數量
  let className = 'po';
  let point;
  if (number > slider3.value){
    className += ' cluster-large';
    point = L.point(45, 45);

  }
  else if (number > slider2.value) {
    className += ' cluster-medium';
    point = L.point(35, 35);
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




function getallData(cache,cache2) {
  markers.clearLayers();
  po1.clearLayers();
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
              var log = "案件編號：" + ta_json[e].serial_number + "<br>發生時間：" + ta_json[e].case_datetime + "<br>肇事主因：" + ta_json[e].case_cause;
              if(ta_json[e].accident_category == "A1"){
                markers.addLayer(L.marker([ta_json[e].latitude,ta_json[e].longitude], {icon: A1}).bindPopup(log));
              }
              else if(ta_json[e].accident_category == "A2"){
                markers.addLayer(L.marker([ta_json[e].latitude,ta_json[e].longitude], {icon: A2}).bindPopup(log));
              }
              else if(ta_json[e].accident_category == "A3"){
                markers.addLayer(L.marker([ta_json[e].latitude,ta_json[e].longitude], {icon: A3}).bindPopup(log));
              }
            }
           
          map.addLayer(markers);
      });

      axios({
        url: cache2,
        method: 'get',
        headers: {
            "Accept": "application/json",
            "Authorization": "Bearer " + token
        },
    })
        .then(function (response) {
            // 回傳資料放置於 json
            patrol_json = response.data.data;

          // 根據資料長度設定 Market
          for (var e = 0; e <  patrol_json.length; e++) {
            if ((patrol_json[e].latitude) !=null && (patrol_json[e].longitude)!=null) {
              patrol_json[e].latitude=parseFloat(patrol_json[e].latitude);
              patrol_json[e].longitude=parseFloat(patrol_json[e].longitude);
              if (isNaN(patrol_json[e].latitude)==true || isNaN(patrol_json[e].longitude)==true) {
                continue;
              }
              else{
                var log = "值勤單位：" + patrol_json[e].team_name + "<br>值勤員警：" + patrol_json[e].police_name + "<br>值勤內容：" + patrol_json[e].patrol_content + "<br>值勤日期：" + patrol_json[e].set_date;
                po1.addLayer(L.marker([patrol_json[e].latitude,patrol_json[e].longitude], {icon: police}).bindPopup(log));
              }
              
            }

        }
        map.addLayer(po1);
        });
  

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
            var log = "案件編號：" + ta_json[e].serial_number + "<br>發生時間：" + ta_json[e].case_datetime + "<br>肇事主因：" + ta_json[e].case_cause;
            if(ta_json[e].accident_category == "A1"){
              markers.addLayer(L.marker([ta_json[e].latitude,ta_json[e].longitude], {icon: A1}).bindPopup(log));
            }
          }
          map.addLayer(markers);
      });

}


function getA2Data(cache) {
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
            var log = "案件編號：" + ta_json[e].serial_number + "<br>發生時間：" + ta_json[e].case_datetime + "<br>肇事主因：" + ta_json[e].case_cause;
          
            if(ta_json[e].accident_category == "A2"){
              markers.addLayer(L.marker([ta_json[e].latitude,ta_json[e].longitude], {icon: A2}).bindPopup(log));
            }
          }
          map.addLayer(markers);
          
      });

}
function getA3Data(cache) {
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
            var log = "案件編號：" + ta_json[e].serial_number + "<br>發生時間：" + ta_json[e].case_datetime + "<br>肇事主因：" + ta_json[e].case_cause;
            if(ta_json[e].accident_category == "A3"){
              markers.addLayer(L.marker([ta_json[e].latitude,ta_json[e].longitude], {icon: A3}).bindPopup(log));
            }
          }
          map.addLayer(markers);
      });

}

// 取得事故資料
function getTAData(cache) {
  markers.clearLayers();
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
              var log = "案件編號：" + ta_json[e].serial_number + "<br>發生時間：" + ta_json[e].case_datetime + "<br>肇事主因：" + ta_json[e].case_cause;
              if(ta_json[e].accident_category == "A1"){
                markers.addLayer(L.marker([ta_json[e].latitude,ta_json[e].longitude], {icon: A1}).bindPopup(log));
              }
              else if(ta_json[e].accident_category == "A2"){
                markers.addLayer(L.marker([ta_json[e].latitude,ta_json[e].longitude], {icon: A2}).bindPopup(log));
              }
              else if(ta_json[e].accident_category == "A3"){
                markers.addLayer(L.marker([ta_json[e].latitude,ta_json[e].longitude], {icon: A3}).bindPopup(log));
              }
            }
            map.addLayer(markers);

        });

}
function isFloat(n){
  var x = n;//测试的数字
    var y = String(x).indexOf(".") + 1;//获取小数点的位置
    
    var count = String(x).length - y;//获取小数点后的个数

    if(y > 0) {
        return x;
    } else {
      return false;
    }
}

function getPatrolData(cache) {
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
          patrol_json = response.data.data;
          
          // 根據資料長度設定 Market
          for (var e = 0; e <  patrol_json.length; e++) {
             
              if ((patrol_json[e].latitude) !=null && (patrol_json[e].longitude)!=null) {
                patrol_json[e].latitude=parseFloat(patrol_json[e].latitude);
                patrol_json[e].longitude=parseFloat(patrol_json[e].longitude);
                if (isNaN(patrol_json[e].latitude)==true || isNaN(patrol_json[e].longitude)==true) {
                  continue;
                }
                else{
                  var log = "值勤單位：" + patrol_json[e].team_name + "<br>值勤員警：" + patrol_json[e].police_name + "<br>值勤內容：" + patrol_json[e].patrol_content + "<br>值勤日期：" + patrol_json[e].set_date;
                  po1.addLayer(L.marker([patrol_json[e].latitude,patrol_json[e].longitude], {icon: police}).bindPopup(log));
                }
                
              }

          }
          map.addLayer(po1);
      });

}
