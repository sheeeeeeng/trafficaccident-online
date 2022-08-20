@extends("layout")

@section("content")
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 >交通事故及勤務分布</h1>
</div>
<hr>
    <h3 class="h3 mb-0 text-gray-800">
    <label for="inputEmail3">開始日期</label>
    
    <input type="text"  id="picker_start" placeholder="開始日期">


    <label for="inputPassword3" >結束日期</label>
    
    <input type="text"  id="picker_end" placeholder="結束日期">

    
    <font color="blue">藍</font>
    <input id="small" type="range" class="form-range" min="1" max="19" step="1" >
    <span id="demo1"></span>
 
    
    <font color="#E69500">黃</font>
    <input id="mid" type="range" class="form-range" min="20" max="45" step="1" >
   <span id="demo2"></span>
 

    <font color="red">紅</font>
    <input id="big" type="range" class="form-range" min="46" max="180" step="1" >
    <span id="demo3"></span>
    </h3>
<hr>
 
 
<div class="d-sm-flex align-items-center justify-content-between mb-4">

    <div class="form-row align-items-center">
        <div class="col-auto ">
            <button id="update-google-map" class="btn btn-outline-success">全選</button>
            <button id="reset-google-map" class="btn btn-outline-success">重置</button>
            <button id="A1-map" class="btn btn-secondary">A1 事故</button>
            <button id="A2-map" class="btn btn-secondary">A2 事故</button>
            <button id="A3-map" class="btn btn-secondary">A3 事故</button>
            <button id="police-map" class="btn btn-secondary">員警值勤地點</button>        
        </div>

       
        <div class="input-group flex-nowrap col-sm-2 my-1">
            <div class="input-group-prepend">
                <img class="input-group-text" src="/img/a1-pin-24.png" />
            </div>
            <input type="text" class="form-control" placeholder="A1 事故" disabled="true">
        </div>
        <div class="input-group flex-nowrap col-sm-2 my-1">
            <div class="input-group-prepend">
                <img class="input-group-text" src="/img/a2-pin-24.png" />
            </div>
            <input type="text" class="form-control" placeholder="A2 事故" disabled="true">
        </div>

        <div class="input-group flex-nowrap col-sm-2 my-1">
            <div class="input-group-prepend">
                <img class="input-group-text" src="http://maps.google.com/mapfiles/ms/icons/green-dot.png" />
            </div>
            <input type="text" class="form-control" placeholder="A3 事故" disabled="true">
        </div>

        
        <div class="input-group flex-nowrap col-sm-2 my-1">
            <div class="input-group-prepend">
                <img class="input-group-text" src="/img/police-24.png" />
            </div>
            <input type="text" class="form-control" placeholder="員警值勤地點" disabled="true">
        </div>
    </div>

</div>
<!-- Content Row -->



<!-- 日期選擇 -->
<script>
    $.datetimepicker.setLocale("zh-TW");
        $('#picker_start').datetimepicker({
            timepicker: false,
            datepicker: true,
            format: 'Y/m/d',
            value: '2021/01/01',
        })
        $('#picker_end').datetimepicker({
            timepicker: false,
            datepicker: true,
            format: 'Y/m/d',
            value: '2021/12/31'
        })
</script>










<link href="https://cdnjs.cloudflare.com/ajax/libs/leaflet.markercluster/1.4.1/MarkerCluster.css"></link> 
<link href="https://cdnjs.cloudflare.com/ajax/libs/leaflet.markercluster/1.4.1/MarkerCluster.Default.css"></link> 
<script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet.markercluster/1.4.1/leaflet.markercluster.js"></script>
<!-- 地圖相關 -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.6.0/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.6.0/dist/leaflet.js"></script>
<script src="https://api.tiles.mapbox.com/mapbox.js/plugins/leaflet-markercluster/v0.4.0/leaflet.markercluster.js"></script>
 <div id="map"></div>
<style>
#map {     height: 100% !important;
    padding-bottom: 50%;
    position: relative;
    width: 100%; }
.marker.cluster-small {
    background-color: blue;
    color:white;
    border-radius: 20px;
    width: 30px;
    height: 30px;
    margin-left: 5px;
    margin-top: 5px;
    text-align: center;
		}
    
.marker.cluster-medium {
    background-color: yellow;
    border-radius: 30px;
    width: 30px;
    height: 30px;
    margin-left: 5px;
    margin-top: 5px;
    text-align: center;
    }
.marker.cluster-large {
    background-color: red;
    border-radius: 50px;
    width: 30px;
    height: 30px;
    margin-left: 5px;
    margin-top: 5px;
    text-align: center;
    }
.marker.cluster-else {
    background-color: gray;
    border-radius: 50px;
    width: 30px;
    height: 30px;
    margin-left: 5px;
    margin-top: 5px;
    text-align: center;
    }
.po.cluster-small {
    background-color: blue;
    color:white;
    width:300px;
    height:300px;
    margin-left: 20px;
    margin-top: 20px;
    text-align: center;
    -webkit-clip-path:polygon(0% 38.31%, 50% 0%,100% 38.31%,80.86% 100%,19.14% 100%);
		}
	
.po.cluster-medium {
    background-color: yellow;
    width:300px;
    height:300px;
    margin-left: 20px;
    margin-top: 20px;
    text-align: center;
    -webkit-clip-path:polygon(0% 38.31%, 50% 0%,100% 38.31%,80.86% 100%,19.14% 100%);
    }

.po.cluster-large {
    background-color: red;
    width:300px;
    height:300px;
    margin-left: 20px;
    margin-top: 15%;
    text-align: center;
    font-size:20PX;
    -webkit-clip-path:polygon(0% 38.31%, 50% 0%,100% 38.31%,80.86% 100%,19.14% 100%);
    }
.po.cluster-else {
    background-color: gray;
    color:white;
    width:300px;
    height:300px;
    margin-left: 20px;
    margin-top: 20px;
    text-align: center;
    -webkit-clip-path:polygon(0% 38.31%, 50% 0%,100% 38.31%,80.86% 100%,19.14% 100%);
		}


    




	
/**zp */
</style>


<link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster@1.4.1/dist/MarkerCluster.css" /></link> 


<link href="https://cdnjs.cloudflare.com/ajax/libs/leaflet.markercluster/1.4.1/MarkerCluster.css"></link> 
<link href="https://cdnjs.cloudflare.com/ajax/libs/leaflet.markercluster/1.4.1/MarkerCluster.Default.css"></link> 
<script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet.markercluster/1.4.1/leaflet.markercluster.js"></script>


<script src="js/marker_googlemap.js"></script>

<!-- Content Row -->

@endsection("content")