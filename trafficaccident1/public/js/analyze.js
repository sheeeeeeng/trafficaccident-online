var ta_json, patrol_json;
var a = -1;
var activeInfoWindow;
var map;
var ta_markers = [], patrol_markers = [];
// API 全資料路徑，此為常數
const url_location = "/api/analyze2";//找事故
const url_patrol = "/api/analyze";//找員警
const url_test = "/api/test ";//test 
let token = localStorage.getItem('jwt');

var bureau = document.getElementById('policebureau').value;
var station = document.getElementById('policestation').value;




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

//測試


var markers = new L.MarkerClusterGroup().addTo(map);;
// 設定「篩選」按鈕 on click 監聽器

var chart_btn = document.getElementById('update-google-map');


chart_btn.addEventListener('click', function () {
  // 取得 所選警局資料
  var bureau = document.getElementById('policebureau').value;
  var station = document.getElementById('policestation').value;
  //員警所在派出所
  var pobureau = document.getElementById('policebureau2').value;
  var postation = document.getElementById('policestation2').value;
  // 取得 輸入的日期 
  var Inputselect=document.getElementById('FormInputSelect').value;//選擇搜尋方式
  if(Inputselect==1){//依日期搜尋
      var strat=document.getElementById('picker_start').value;
      var end=document.getElementById('picker_end').value;
      console.log(strat);
      console.log(end);
  }
  else if(Inputselect==2){//以年/季/月查詢
      var year=document.getElementById('searchyear').value;
      var mnd=document.getElementById('mnd').value;
      var newstr = mnd.replace(/yyyy/g, year);// /****/g 目的在於完全取代
      var dateObj = newstr.split('~'); 
      var strat=dateObj[0];
      var end=dateObj[1];
      if(end==year+'-02-29'){//確認2月是否有29號
          if(new Date(end).getDate()==new Date(year+'-03-01').getDate()){
              end=year+'-02-28'
          }
      }
      console.log(strat);
      console.log(end);
  }
  var postrat=document.getElementById('popicker_start').value;
  var poend=document.getElementById('popicker_end').value;
  if(postation=='Total'){
    if(pobureau=="臺東縣警察局臺東分局"){
      postation="臺東分局";
    }
    else if(pobureau=="臺東縣警察局關山分局"){
      postation="關山分局";
    }
    else if(pobureau=="臺東縣警察局成功分局"){
      postation="成功分局";
    }
    else if(pobureau=="臺東縣警察局大武分局"){
      postation="大武分局";
    }
  }
  getTAData(url_location,bureau,station,strat,end,postation,postrat,poend);
});



// 設定「重置」按鈕 on click 監聽器
var reset_btn = document.getElementById('reset-google-map');
reset_btn.addEventListener('click', function () {

  initMap();
  parent.document.location.reload();

});

function initMap() {

  L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
  attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
}).addTo(map);

}






function getTAData(cache,bureau,station,strat,end,postation,postrat,poend) {
  
  axios({
      url:cache,
      params: {           
          bur: bureau,
          sta: station,
          strat: strat,
          end: end,
          postation:postation,
          postrat:postrat,
          poend:poend,
      },
      method: 'get',
      headers: {
          "Accept": "application/json",//要求傳回json
          "Authorization": "Bearer " + token//jwt驗證相關
      },
  })
  .then(function (response) {
      // 回傳資料放置於 json
      
      ta_latitude = response.data.latitude;
      ta_longitude= response.data.longitude;
      ta_colar= response.data.colar;
      console.log(ta_latitude);
      if(ta_latitude[0]==0 && ta_longitude[0]==0){
        alert("此區間沒有事故資料");
      }
      else if(ta_latitude[0]==1 && ta_longitude[0]==1){
        alert("此區間沒有員警巡邏資料");
      }
      else{
        var warm="";
        map.panTo(L.latLng(ta_latitude[0],ta_longitude[0]));
        
        for (var e = 0; e < ta_latitude.length; e++) {
          var log = "群組：" + (e+1)+"經度:"+ta_latitude[e]+",緯度:"+ta_longitude[e];
          if(ta_colar[e]=='R'){
            var circle = L.circle([ta_latitude[e],ta_longitude[e]], {
              color: "red",
              fillColor: "#f03",
              fillOpacity: 0.5,
              radius: 250.0
            }).addTo(map).bindPopup(log); 
            warm=warm+" "+log+"\r";
          }
          else{
            var circle = L.circle([ta_latitude[e],ta_longitude[e]], {
              color: "green",
              fillColor: "green",
              fillOpacity: 0.5,
              radius: 250.0
            }).addTo(map).bindPopup(log); 
          }
                
        }
        warm=warm+"警力不足";
        alert("共分成: "+ta_latitude.length+"群");
        alert(warm);
          map.addLayer(circle);
        
      }
        
          // 根據資料長度設定 Market.
     
    //
    // pointer_list = []
    // pointer_list[0] = { 'x':x , 'y':y , 'group_index':-1, 'distance':-1 }
    //把座標放入pointer_list
  }//kmeans完成
  
  );
}
