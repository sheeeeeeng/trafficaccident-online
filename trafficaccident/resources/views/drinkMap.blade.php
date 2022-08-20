@extends("layout")

@section("content")

<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">飲酒事故分布</h1>
</div>
<hr>
    <h3 class="h3 mb-0 text-gray-800">
    <label for="inputEmail3">開始日期</label>
    
    <input type="text"  id="picker_start" placeholder="開始日期">


    <label for="inputPassword3" >結束日期</label>
    
    <input type="text"  id="picker_end" placeholder="結束日期">

    
    <font color="blue">藍</font>
    <input id="small" type="range" class="form-range" min="1" max="4" step="1" >
    <span id="demo1"></span>
 
    
    <font color="#E69500">黃</font>
    <input id="mid" type="range" class="form-range" min="5" max="19" step="1" >
   <span id="demo2"></span>
 

    <font color="red">紅</font>
    <input id="big" type="range" class="form-range" min="20" max="100" step="1" >
    <span id="demo3"></span>
    </h3>
<hr>
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <div class="form-row align-items-center">
		
		<div class="col-auto my-1">
					<button id="update-google-map" class="btn btn-outline-success">顯示圖例</button>
					<button id="reset-google-map" class="btn btn-outline-success">重置</button>
		</div>
		<div class="input-group flex-nowrap col-sm-2 my-1">
            <div class="input-group-prepend">
                <img class="input-group-text" src="img/1-24.jpg" />
            </div>
            <input type="text" class="form-control" placeholder="經觀察未飲酒" disabled="true">
        </div>
        <div class="input-group flex-nowrap col-sm-2 my-1">
            <div class="input-group-prepend">
                <img class="input-group-text" src="img/2-24.jpg" />
            </div>
            <input type="text" class="form-control" placeholder="經檢測無酒精反應" disabled="true">
        </div>
		<div class="input-group flex-nowrap col-sm-2 my-1">
            <div class="input-group-prepend">
                <img class="input-group-text" src="img/3-24.jpg" />
            </div>
            <input type="text" class="form-control" placeholder="經呼吸檢測未超過0.15mg/L或血液檢測未超過0.03%" disabled="true">
        </div>
		<div class="input-group flex-nowrap col-sm-2 my-1">
            <div class="input-group-prepend">
                <img class="input-group-text" src="img/4-24.jpg" />
            </div>
            <input type="text" class="form-control" placeholder="經呼吸檢測0.16mg/L~0.25mg/L或血液檢測未超過0.031%~0.05%" disabled="true">
        </div>
		<div class="input-group flex-nowrap col-sm-2 my-1">
            <div class="input-group-prepend">
                <img class="input-group-text" src="img/5-24.jpg" />
            </div>
            <input type="text" class="form-control" placeholder="經呼吸檢測0.26mg/L~0.4mg/L或血液檢測未超過0.051%~0.08%" disabled="true">
        </div>
		<div class="input-group flex-nowrap col-sm-2 my-1">
            <div class="input-group-prepend">
                <img class="input-group-text" src="img/6-24.jpg" />
            </div>
            <input type="text" class="form-control" placeholder="經呼吸檢測0.41mg/L~0.55mg/L或血液檢測未超過0.081%~0.11%" disabled="true">
        </div>
		<div class="input-group flex-nowrap col-sm-2 my-1">
            <div class="input-group-prepend">
                <img class="input-group-text" src="img/7-24.jpg" />
            </div>
            <input type="text" class="form-control" placeholder="經呼吸檢測0.56mg/L~0.8mg/L或血液檢測未超過0.111%~0.16%" disabled="true">
        </div>
		<div class="input-group flex-nowrap col-sm-2 my-1">
            <div class="input-group-prepend">
                <img class="input-group-text" src="img/8-24.jpg" />
            </div>
            <input type="text" class="form-control" placeholder="經呼吸檢測超過0.8mg/L或血液檢測超過0.16%" disabled="true">
        </div>
		<div class="input-group flex-nowrap col-sm-2 my-1">
            <div class="input-group-prepend">
                <img class="input-group-text" src="img/9-24.jpg" />
            </div>
            <input type="text" class="form-control" placeholder="無法檢測" disabled="true">
        </div>
		<div class="input-group flex-nowrap col-sm-2 my-1">
            <div class="input-group-prepend">
                <img class="input-group-text" src="img/10-24.jpg" />
            </div>
            <input type="text" class="form-control" placeholder="非駕駛人，未檢測" disabled="true">
        </div>
		<div class="input-group flex-nowrap col-sm-2 my-1">
            <div class="input-group-prepend">
                <img class="input-group-text" src="img/11-24.jpg" />
            </div>
            <input type="text" class="form-control" placeholder="不明" disabled="true">
        </div>

	</div>
	
</div>




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


<link rel="stylesheet" href="https://unpkg.com/leaflet@1.6.0/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.6.0/dist/leaflet.js"></script>
 <div id="map"></div>
 <style>
#map {     height: 100% !important;
    padding-bottom: 50%;
    position: relative;
    width: 100%; }
.marker.cluster-small {
    background-color: blue;
    color:white;
    width: 30px;
    height: 30px;
    margin-left: 5px;
    margin-top: 5px;
    text-align: center;
		}
	.marker.cluster-small div {
        background-color: blue;
        color:white;
        width: 30px;
		height: 30px;
		margin-left: 5px;
		margin-top: 5px;
		text-align: center;
		}

	.marker.cluster-medium {
		background-color: yellow;

        width: 30px;
		height: 30px;
		margin-left: 5px;
		margin-top: 5px;
		text-align: center;
		}
	.marker.cluster-medium div {
		background-color: yellow;

        width: 30px;
		height: 30px;
		margin-left: 5px;
		margin-top: 5px;
		text-align: center;
		}

	.marker.cluster-large {
		background-color: red;

        width: 30px;
		height: 30px;
		margin-left: 5px;
		margin-top: 5px;
		text-align: center;
		}
	.marker.cluster-large div {
		background-color: red;

        width: 30px;
		height: 30px;
		margin-left: 5px;
		margin-top: 5px;
		text-align: center;
		}
        .marker.cluster-else {
    background-color: gray;
    color:white;
    width: 30px;
    height: 30px;
    margin-left: 5px;
    margin-top: 5px;
    text-align: center;
		}
	.marker.cluster-else div {
        background-color: gray;
        color:white;
        width: 30px;
		height: 30px;
		margin-left: 5px;
		margin-top: 5px;
		text-align: center;
		}
	.marker.cluster {
		background-clip: padding-box;
		border-radius: 20px;
        width: 30px;
		height: 30px;
		margin-left: 5px;
		margin-top: 5px;
		text-align: center;
		}
	.marker.cluster div {
		width: 30px;
		height: 30px;
		margin-left: 5px;
		margin-top: 5px;

		text-align: center;
		border-radius: 15px;
		font: 12px "Helvetica Neue", Arial, Helvetica, sans-serif;
		}
	.marker-cluster span {
		line-height: 30px;
		}
</style>

<link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster@1.4.1/dist/MarkerCluster.css" /></link> 


<link href="https://cdnjs.cloudflare.com/ajax/libs/leaflet.markercluster/1.4.1/MarkerCluster.css"></link> 
<link href="https://cdnjs.cloudflare.com/ajax/libs/leaflet.markercluster/1.4.1/MarkerCluster.Default.css"></link> 
<script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet.markercluster/1.4.1/leaflet.markercluster.js"></script>
<script src="js/drinkMap.js"></script>
@endsection("content")