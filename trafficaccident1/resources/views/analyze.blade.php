@extends("layout")

@section("content")

<div class="container">
  <div class="row align-items-end">
    <div class="col-md-8">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">事故警示平台</h1>
        </div>
        <label for="exampleFormControlSelect1">請選擇事故想查詢的派出所：</label>
    </div>
  </div>
</div>

<div class="container">
  <div class="row">
    <div class="col-md-12">
        <form Name="myForm">
            <div class="form-group">
                <select class="form-control" id="policebureau" Name="PoliceBureau" OnChange="Buildkey(this.selectedIndex);">
                    <option>臺東縣警察局臺東分局</option>
                    <option>臺東縣警察局關山分局</option>
                    <option>臺東縣警察局成功分局</option>
                    <option>臺東縣警察局大武分局</option>
                    <option>臺東縣警察局全分局</option>
                </select>
                <br>
                <select class="form-control" id="policestation" Name="PoliceStation">
                    <option>Total</option>
                    <option>東清派出所</option>
                    <option>朗島派出所</option>
                    <option>公館派出所</option>
                    <option>溫泉派出所</option>
                    <option>東興派出所</option>
                    <option>利嘉派出所</option>
                    <option>寶桑派出所</option>
                    <option>初鹿派出所</option>
                    <option>建蘭派出所</option>
                    <option>蘭嶼分駐所</option>
                    <option>豐里派出所</option>
                    <option>富岡派出所</option>
                    <option>馬蘭派出所</option>
                    <option>南王派出所</option>
                    <option>知本派出所</option>
                    <option>卑南分駐所</option>
                    <option>永樂派出所</option>
                    <option>綠島分駐所</option>
                    <option>中興派出所</option>
                </select>
            </div>
        </form>
    </div>
  </div>
</div>


<div class="container">
  <div class="row align-items-end">
    <div class="col-md-8">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        </div>
        <label for="exampleFormControlSelect1">請選擇員警想查詢的派出所：</label>
    </div>
  </div>
</div>

<div class="container">
  <div class="row">
    <div class="col-md-12">
        <form Name="myForm4">
            <div class="form-group">
                <select class="form-control" id="policebureau2" Name="PoliceBureau2" OnChange="Buildkey2(this.selectedIndex);">
                    <option>臺東縣警察局臺東分局</option>
                    <option>臺東縣警察局關山分局</option>
                    <option>臺東縣警察局成功分局</option>
                    <option>臺東縣警察局大武分局</option>
                    <option>臺東縣警察局全分局</option>
                </select>
                <br>
                <select class="form-control" id="policestation2" Name="PoliceStation2">
                    <option>Total</option>
                    <option>東清</option>
                    <option>朗島</option>
                    <option>公館</option>
                    <option>溫泉</option>
                    <option>東興</option>
                    <option>利嘉</option>
                    <option>寶桑</option>
                    <option>初鹿</option>
                    <option>建蘭</option>
                    <option>蘭嶼</option>
                    <option>豐里</option>
                    <option>富岡</option>
                    <option>馬蘭</option>
                    <option>南王</option>
                    <option>知本</option>
                    <option>卑南</option>
                    <option>永樂</option>
                    <option>綠島</option>
                    <option>中興</option>
                </select>
            </div>
        </form>
    </div>
  </div>
</div>




<div class="container">
  <div class="row">
    <div class="col-md-12">
        <form Name="myForm2">
          <div class="form-group">
              <label for="exampleFormControlSelect1">事故查詢方式選擇：</label>
              <select class="form-control" id="FormInputSelect" onchange="myFunction(value)">
                <option value="#">請選擇查詢方式</option>
                <option value="1">依日期搜尋</option>
                <option value="2">依年/季/月</option>
              </select>
            </div>
        </form>
    </div>
  </div>
</div>

<div class="container">
  <div class="row align-items-end">
    <div class="col-md-8">
        <label for="exampleFormControlSelect1">請選擇事故想查詢的日期區間：</label>
    </div>
  </div>
</div>


<div class="container">
  <div class="row">
        <div class="d-flex justify-content-start">

                <div class="col-sm-4">
                    <input type="text" class="form-control" id="picker_start" placeholder="開始日期" disabled=true>
                </div>
                ~
                <div class="col-sm-4">
                    <input type="text" class="form-control" id="picker_end" placeholder="結束日期" disabled=true>
                </div>

        </div> 
    </div>
</div> 

<div class="container">
  <div class="row">
    <div class="col-md-12">
        <label for="exampleFormControlSelect1">請選擇事故想查詢的年/季/月：</label>
    </div>
  </div>
</div>

<div class="container">
  <div class="row">
    <div class="col-md-4">
        <form>
          <div class="form-group">
            <input type="text" class="form-control" id="searchyear" placeholder="Ex：2019" disabled=true>
          </div>
        </form>
    </div>
    <div class="col-md-4">
        <form>
          <div class="form-group">
            <select class="form-control" id="selectmnd" onchange="selectway(value)" disabled=true>
                <option value="#">選擇查詢區間</option>
                <option value="0">以年份查詢</option>
                <option value="1">以季查詢</option>
                <option value="2">以月查詢</option>
            </select>
          </div>
        </form>
    </div>
    <div class="col-md-4">
        <form Name="monthandday">
          <div class="form-group">
            <select class="form-control" id="mnd" Name="mnd" disabled=true></select>
          </div>
        </form>
    </div>
  </div>
</div>


<div class="container">
<label for="exampleFormControlSelect1">請選擇員警想查詢的日期區間：</label>
  <div class="row">
        <div class="d-flex justify-content-start">      
            <input type="text" class="form-control" id="popicker_start" placeholder="開始日期" >
        </div> 
        ~
        <div class="col-sm-4">
                    <input type="text" class="form-control" id="popicker_end" placeholder="結束日期" >
         </div>
    </div>
</div> 

<div class="col-auto my-1">
                <button id="update-google-map" class="btn btn-outline-success">開始分析</button>
                <button id="reset-google-map" class="btn btn-outline-success">重置</button>
</div>
	


<script>
    $.datetimepicker.setLocale("zh-TW");
        $('#popicker_start').datetimepicker({
            timepicker: false,
            datepicker: true,
            format: 'Y/m/d',
            value: '2021/01/01',
        })
        $('#popicker_end').datetimepicker({
            timepicker: false,
            datepicker: true,
            format: 'Y/m/d',
            value: '2021/12/31'
        })
</script>


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
    .cluster {
            border: 5px solid grey;
            border-radius: 35px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .cluster.cluster-green {
            background-color: green;
        }

        .cluster.cluster-yellow {
            background-color: yellow;
        }

        .cluster.cluster-red {
            background-color: red;
        }
</style>


<SCRIPT Language="JavaScript">
    key=new Array(3);
    key[0]=new Array(20);
    key[1]=new Array(18);
    key[2]=new Array(12);
    key[3]=new Array(14);
    key[4]=new Array(1);

    key[0][0]="Total";
    key[0][1]="朗島派出所";
    key[0][2]="公館派出所";
    key[0][3]="溫泉派出所";
    key[0][4]="東興派出所";
    key[0][5]="利嘉派出所";
    key[0][6]="寶桑派出所";
    key[0][7]="初鹿派出所";
    key[0][8]="建蘭派出所";
    key[0][9]="蘭嶼分駐所";
    key[0][10]="豐里派出所";
    key[0][11]="富岡派出所";
    key[0][12]="馬蘭派出所";
    key[0][13]="南王派出所";
    key[0][14]="知本派出所";
    key[0][15]="卑南分駐所";
    key[0][16]="永樂派出所";
    key[0][17]="綠島分駐所";
    key[0][18]="中興派出所";
    key[0][19]="東清派出所";

    key[1][0]="Total";
    key[1][1]="鸞山派出所";
    key[1][2]="關山派出所";
    key[1][3]="武陵派出所";
    key[1][4]="延平分駐所";
    key[1][5]="霧鹿派出所";
    key[1][6]="龍泉派出所";
    key[1][7]="崁頂派出所";
    key[1][8]="初來派出所";
    key[1][9]="海端分駐所";
    key[1][10]="利稻派出所";
    key[1][11]="向陽派出所";
    key[1][12]="錦安派出所";
    key[1][13]="池上分駐所";
    key[1][14]="瑞源派出所";
    key[1][15]="瑞豐派出所";
    key[1][16]="鹿野分駐所";
    key[1][17]="電光派出所";

    key[2][0]="Total";
    key[2][1]="三間派出所";
    key[2][2]="長濱分駐所";
    key[2][3]="竹湖派出所";
    key[2][4]="寧埔派出所";
    key[2][5]="忠孝派出所";
    key[2][6]="都歷派出所";
    key[2][7]="泰源派出所";
    key[2][8]="都蘭派出所";
    key[2][9]="東河分駐所";
    key[2][10]="新豐派出所";
    key[2][11]="樟原派出所";

    key[3][0]="Total";
    key[3][1]="達仁分駐所";
    key[3][2]="新化派出所";
    key[3][3]="森永派出所";
    key[3][4]="美和派出所";
    key[3][5]="金崙派出所";
    key[3][6]="金峰分駐所";
    key[3][7]="尚武派出所";
    key[3][8]="多良派出所";
    key[3][9]="正興派出所";
    key[3][10]="台坂派出所";
    key[3][11]="太麻里分駐所";
    key[3][12]="土坂派出所";
    key[3][13]="大武派出所";
    
    key[4][0]="Total";

    key2=new Array(3);
    key2[0]=new Array(1)
    key2[1]=new Array(4);
    key2[2]=new Array(12);

    key2[0][0]="全年度";

    key2[1][0]="Q1";
    key2[1][1]="Q2";
    key2[1][2]="Q3";
    key2[1][3]="Q4";

    key2[2][0]="一月";
    key2[2][1]="二月";
    key2[2][2]="三月";
    key2[2][3]="四月";
    key2[2][4]="五月";
    key2[2][5]="六月";
    key2[2][6]="七月";
    key2[2][7]="八月";
    key2[2][8]="九月";
    key2[2][9]="十月";
    key2[2][10]="十一月";
    key2[2][11]="十二月";

    key3=new Array(3);
    key3[0]=new Array(1)
    key3[1]=new Array(4);
    key3[2]=new Array(12);

    key3[0][0]="yyyy-01-01~yyyy-12-31";

    key3[1][0]="yyyy-01-01~yyyy-03-31";
    key3[1][1]="yyyy-04-01~yyyy-06-30";
    key3[1][2]="yyyy-07-01~yyyy-09-30";
    key3[1][3]="yyyy-10-01~yyyy-12-31";

    key3[2][0]="yyyy-01-01~yyyy-01-31";
    key3[2][1]="yyyy-02-01~yyyy-02-29";
    key3[2][2]="yyyy-03-01~yyyy-03-31";
    key3[2][3]="yyyy-04-01~yyyy-04-30";
    key3[2][4]="yyyy-05-01~yyyy-05-31";
    key3[2][5]="yyyy-06-01~yyyy-06-30";
    key3[2][6]="yyyy-07-01~yyyy-07-31";
    key3[2][7]="yyyy-08-01~yyyy-08-31";
    key3[2][8]="yyyy-09-01~yyyy-09-30";
    key3[2][9]="yyyy-10-01~yyyy-10-31";
    key3[2][10]="yyyy-11-01~yyyy-11-30";
    key3[2][11]="yyyy-12-01~yyyy-12-31";


    key4=new Array(3);
    key4[0]=new Array(20);
    key4[1]=new Array(18);
    key4[2]=new Array(12);
    key4[3]=new Array(14);
    key4[4]=new Array(1);
//員警查詢
    key4[0][0]="Total";
    key4[0][1]="朗島";
    key4[0][2]="公館";
    key4[0][3]="溫泉";
    key4[0][4]="東興";
    key4[0][5]="利嘉";
    key4[0][6]="寶桑";
    key4[0][7]="初鹿";
    key4[0][8]="建蘭";
    key4[0][9]="蘭嶼";
    key4[0][10]="豐里";
    key4[0][11]="富岡";
    key4[0][12]="馬蘭";
    key4[0][13]="南王";
    key4[0][14]="知本";
    key4[0][15]="卑南";
    key4[0][16]="永樂";
    key4[0][17]="綠島";
    key4[0][18]="中興";
    key4[0][19]="東清";

    key4[1][0]="Total";
    key4[1][1]="鸞山";
    key4[1][2]="關山";
    key4[1][3]="武陵";
    key4[1][4]="延平";
    key4[1][5]="霧鹿";
    key4[1][6]="龍泉";
    key4[1][7]="崁頂";
    key4[1][8]="初來";
    key4[1][9]="海端";
    key4[1][10]="利稻";
    key4[1][11]="向陽";
    key4[1][12]="錦安";
    key4[1][13]="池上";
    key4[1][14]="瑞源";
    key4[1][15]="瑞豐";
    key4[1][16]="鹿野";
    key4[1][17]="電光";

    key4[2][0]="Total";
    key4[2][1]="三間";
    key4[2][2]="長濱";
    key4[2][3]="竹湖";
    key4[2][4]="寧埔";
    key4[2][5]="忠孝";
    key4[2][6]="都歷";
    key4[2][7]="泰源";
    key4[2][8]="都蘭";
    key4[2][9]="東河";
    key4[2][10]="新豐";
    key4[2][11]="樟原";

    key4[3][0]="Total";
    key4[3][1]="達仁";
    key4[3][2]="新化";
    key4[3][3]="森永";
    key4[3][4]="美和";
    key4[3][5]="金崙";
    key4[3][6]="金峰";
    key4[3][7]="尚武";
    key4[3][8]="多良";
    key4[3][9]="正興";
    key4[3][10]="台坂";
    key4[3][11]="太麻里";
    key4[3][12]="土坂";
    key4[3][13]="大武";

    key4[4][0]="Total";
    
    function Buildkey(num)//二階層下拉式選單function事故
    {
        document.myForm.PoliceStation.selectedIndex=0;
            for(ctr=0;ctr<key[num].length;ctr++){
                document.myForm.PoliceStation.options[ctr]=new Option(key[num][ctr],key[num][ctr]);
    }
        document.myForm.PoliceStation.length=key[num].length;
    }  

    function selectway(value){
        
        for(ctr=0;ctr<key2[value].length;ctr++){
            document.monthandday.mnd.options[ctr]=new Option(key2[value][ctr],key3[value][ctr]);
        }
        document.monthandday.mnd.length=key2[value].length;
    }

    function Buildkey2(num)//二階層下拉式選單function員警
    {
        document.myForm4.PoliceStation2.selectedIndex=0;
            for(ctr=0;ctr<key4[num].length;ctr++){
                document.myForm4.PoliceStation2.options[ctr]=new Option(key4[num][ctr],key4[num][ctr]);
    }
        document.myForm4.PoliceStation2.length=key4[num].length;
    }  

    



    function myFunction(value){
        if(value==1){
            document.getElementById('picker_start').disabled=false;　// 變更欄位為可用
            document.getElementById('picker_end').disabled=false;　
            document.getElementById('searchyear').disabled=true;　
            document.getElementById('selectmnd').disabled=true;　// 變更欄位為禁用
            document.getElementById('mnd').disabled=true;
        }else if(value==2){
            document.getElementById('picker_start').disabled=true;　// 變更欄位為禁用
            document.getElementById('picker_end').disabled=true;
            document.getElementById('searchyear').disabled=false;　
            document.getElementById('selectmnd').disabled=false;　// 變更欄位為禁用
            document.getElementById('mnd').disabled=false;
        }
        else{
            document.getElementById('picker_start').disabled=true;　// 變更欄位為禁用
            document.getElementById('picker_end').disabled=true;
            document.getElementById('searchyear').disabled=true;　
            document.getElementById('selectmnd').disabled=true;　// 變更欄位為禁用
            document.getElementById('mnd').disabled=true;
        }
    }


</Script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/leaflet.markercluster/1.4.1/MarkerCluster.css"></link> 
<link href="https://cdnjs.cloudflare.com/ajax/libs/leaflet.markercluster/1.4.1/MarkerCluster.Default.css"></link> 
<script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet.markercluster/1.4.1/leaflet.markercluster.js"></script>

<script src="vendor/chart.js/Chart.min.js"></script>
<script src="js/analyze.js"></script>
@endsection("content")
