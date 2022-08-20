const url_location = '/api/CaseCause';
let token = localStorage.getItem('jwt');//驗證jwt的token
var ta_json,myPieChart;//myPieChart用來記錄圖形
var chart_btn = document.getElementById('Case_Cause_btn');
var csv_btn = document.getElementById('Case_Cause_csv');

chart_btn.addEventListener('click', function () {
    // 取得 所選警局資料
    var bureau = document.getElementById('policebureau').value;
    var station = document.getElementById('policestation').value;
    // 取得 輸入的日期 
    var Inputselect=document.getElementById('FormInputSelect').value;//選擇搜尋方式
    if(Inputselect==1){//依日期搜尋
        var strat=document.getElementById('picker_start').value;
        var end=document.getElementById('picker_end').value;
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
    //開始繪圖
    getTAData(url_location,bureau,station,strat,end);
});

csv_btn.addEventListener('click', function () {
    // 取得 所選警局資料
    var bureau = document.getElementById('policebureau').value;
    var station = document.getElementById('policestation').value;
    // 取得 輸入的日期 
    var Inputselect=document.getElementById('FormInputSelect').value;//選擇搜尋方式
    if(Inputselect==1){//依日期搜尋
        var strat=document.getElementById('picker_start').value;
        var end=document.getElementById('picker_end').value;
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
    getTAData2(url_location,bureau,station,strat,end);
});
function getTAData(cache,bureau,station,strat,end) {//要資料，畫圓餅圖
    // 使用 axios 取得 API 資料
    axios({
        url: cache,
        //一次傳送多個params給controller
        params: {           
            bur: bureau,
            sta: station,
            strat: strat,
            end: end
        },
        method: 'get',
        headers: {
            "Accept": "application/json",//要求傳回json
            "Authorization": "Bearer " + token//jwt驗證相關
        },
    })
    .then(function (response) {
        // 回傳資料放置於 json
        ta_json = response.data;
        Draw_pie(ta_json['causecount'],bureau,station,strat,end);
    });
}
function getTAData2(cache,bureau,station,strat,end) {//要資料，匯出csv報表
    // 使用 axios 取得 API 資料
    axios({
       url: cache,
       //一次傳送多個params給controller
       params: {           
           bur: bureau,
           sta: station,
           strat: strat,
           end: end
       },
       method: 'get',
       headers: {
           "Accept": "application/json",//要求傳回json
           "Authorization": "Bearer " + token//jwt驗證相關
       },
   })
   .then(function (response) {
       // 回傳資料放置於 json
       ta_json = response.data;
       exportToCsv(bureau.toString()+station.toString()+" "+strat.toString()+"~"+end.toString()+"肇因統計"+'.csv', [
           [' ','未依規定讓車','變換車道或方向不當','左轉彎未依規定','右轉彎未依規定','未保持行車安全距離','起步未注意其他車(人)安全','酒醉(後)駕駛失控','未注意車前狀態','違反特定標誌(線)禁制','其他引起事故之違規或不當行','其他'],	
         ['事件數量',ta_json['causecount'][0].toString(),ta_json['causecount'][1].toString(),ta_json['causecount'][2].toString(),ta_json['causecount'][3].toString(),ta_json['causecount'][4].toString(),ta_json['causecount'][5].toString(),ta_json['causecount'][6].toString(),ta_json['causecount'][7].toString(),ta_json['causecount'][8].toString(),ta_json['causecount'][9].toString(),ta_json['causecount'][10].toString()],
       
       ])
   });   
}
function exportToCsv(filename, rows) {//產生並下載csv
    var processRow = function (row) {
        var finalVal = '';
        for (var j = 0; j < row.length; j++) {
            var innerValue = row[j] === null ? '' : row[j].toString();
            if (row[j] instanceof Date) {
                innerValue = row[j].toLocaleString();
            };
            var result = innerValue.replace(/"/g, '""');
            if (result.search(/("|,|\n)/g) >= 0)
                result = '"' + result + '"';
            if (j > 0)
                finalVal += ',';
            finalVal += result;
        }
        return finalVal + '\n';
    };

    var csvFile = '';
    for (var i = 0; i < rows.length; i++) {
        csvFile += processRow(rows[i]);
    }

    var blob = new Blob(["\uFEFF" + csvFile], { type: 'text/csv;charset=gb2312;' });
    if (navigator.msSaveBlob) { // IE 10+
        navigator.msSaveBlob(blob, filename);
    } else {
        var link = document.createElement("a");
        if (link.download !== undefined) { // feature detection
            // Browsers that support HTML5 download attribute
            var url = URL.createObjectURL(blob);
            link.setAttribute("href", url);
            link.setAttribute("download", filename);
            link.style.visibility = 'hidden';
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        }
    }
}
function Draw_pie(causecount,bureau,station,strat,end){
    var count=causecount[0]+causecount[1]+causecount[2]+causecount[3]+causecount[4]+causecount[5]+causecount[6]+causecount[7]+causecount[8]+causecount[9]+causecount[10];
    var ctx = document.getElementById("CauseCountPieChart");
    if(myPieChart){
        myPieChart.destroy();
    }
    myPieChart = new Chart(ctx, {
    type: 'pie',
    data: {
        labels: ["未依規定讓車 "+Math.round(causecount[0]/count*100).toString()+"%", "變換車道或方向不當 "+Math.round(causecount[1]/count*100).toString()+"%","左轉彎未依規定 "+Math.round(causecount[2]/count*100).toString()+"%","右轉彎未依規定 "+Math.round(causecount[3]/count*100).toString()+"%","未保持行車安全距離 "+Math.round(causecount[4]/count*100).toString()+"%", "起步未注意其他車(人)安全 "+Math.round(causecount[5]/count*100).toString()+"%","酒醉(後)駕駛失控 "+Math.round(causecount[6]/count*100).toString()+"%" ,"未注意車前狀態 "+Math.round(causecount[7]/count*100).toString()+"%" ,"違反特定標誌(線)禁制 "+Math.round(causecount[8]/count*100).toString()+"%" ,"其他引起事故之違規或不當行為 "+Math.round(causecount[9]/count*100).toString()+"%" ,"其他 "+Math.round(causecount[10]/count*100).toString()+"%"],
        datasets: [{
        data: [causecount[0],
        causecount[1], 
        causecount[2], 
        causecount[3], 
        causecount[4], 
        causecount[5], 
        causecount[6], 
        causecount[7], 
        causecount[8], 
        causecount[9], 
        causecount[10], ],
        backgroundColor: ['#4e73df', '#1cc88a', '#36b9cc','#A03C78','#ED8E7C','#CDF3A2','#B5EAEA','#EDF6E5','#FFBCBC','#F38BA0','#FFD369'],
        hoverBackgroundColor: ['#2e59d9', '#17a673', '#2c9faf'],
        hoverBorderColor: "rgba(234, 236, 244, 1)",
        }],
    },
    options: {
        responsive: true,
        legend: {
            position: 'top',
            labels: {
                fontSize: 35,
            }
        },
        title: {
            fontSize: 50,
            display: true,
            text: bureau.toString()+station.toString()+" "+strat.toString()+"~"+end.toString()+"肇因統計",
        },
      },
    });
}
