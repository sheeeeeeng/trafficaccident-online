const url_location = '/api/Time';
let token = localStorage.getItem('jwt');//驗證jwt的token
var ta_json,myBarChart;//myBarChart用來記錄圖形
var chart_btn = document.getElementById('Case_Time_btn');
var csv_btn = document.getElementById('Case_Time_csv');

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

function getTAData(cache,bureau,station,strat,end) {
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
        Draw_bar(ta_json['timearray'],bureau,station,strat,end);
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
       exportToCsv(bureau.toString()+station.toString()+" "+strat.toString()+"~"+end.toString()+"所有事故統計表"+'.csv', [
           [' ',"00:00:00~01:59:59","02:00:00~03:59:59","04:00:00~05:59:59","06:00:00~07:59:59","08:00:00~09:59:59","10:00:00~11:59:59","12:00:00~13:59:59","14:00:00~15:59:59","16:00:00~17:59:59","18:00:00~19:59:59","20:00:00~21:59:59","22:00:00~23:59:59"],	
         ['事件數量',ta_json['timearray'][0].toString(),ta_json['timearray'][1].toString(),ta_json['timearray'][2].toString(),ta_json['timearray'][3].toString(),ta_json['timearray'][4].toString(),ta_json['timearray'][5].toString(),ta_json['timearray'][6].toString(),ta_json['timearray'][7].toString(),ta_json['timearray'][8].toString(),ta_json['timearray'][9].toString(),ta_json['timearray'][10].toString(),ta_json['timearray'][11].toString()],
       
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
function Draw_bar(timearray,bureau,station,strat,end){
    //Chart.plugins.register(ChartDataLabels);
    var ctx = document.getElementById("CauseTimeBarChart");
    if(myBarChart){
        myBarChart.destroy();
    }
    myBarChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ["00:00:00~01:59:59","02:00:00~03:59:59","04:00:00~05:59:59","06:00:00~07:59:59","08:00:00~09:59:59","10:00:00~11:59:59","12:00:00~13:59:59","14:00:00~15:59:59","16:00:00~17:59:59","18:00:00~19:59:59","20:00:00~21:59:59","22:00:00~23:59:59"],
            datasets: [{
                data: [timearray[0],
                timearray[1], 
                timearray[2], 
                timearray[3], 
                timearray[4], 
                timearray[5], 
                timearray[6], 
                timearray[7], 
                timearray[8], 
                timearray[9], 
                timearray[10],
                timearray[11], 
                ],
            backgroundColor: ['#3EDBF0', '#1cc88a', '#ECDBBA','#36b9cc','#F2A154','#CDF3A2','#B5EAEA','#BEAEE2','#FFBCBC','#F38BA0','#FFD369'],
            hoverBackgroundColor: ['#2e59d9', '#17a673', '#2c9faf'],
            hoverBorderColor: "rgba(234, 236, 244, 1)",
            }],
        },
        options: {
            responsive: true,
            legend: {
                display: false,
                labels: {
                    fontSize: 35,
                }
            },
            title: {
                fontSize: 50,
                display: true,
                text: bureau.toString()+station.toString()+" "+strat.toString()+"~"+end.toString()+"所有事故統計表",
            },
        },
    });
}
