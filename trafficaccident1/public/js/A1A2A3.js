const url_location = '/api/A1A2A3';
let token = localStorage.getItem('jwt');//驗證jwt的token
var ta_json,mylinechart;
var chart_btn = document.getElementById('A1A2A3_btn');
var csv_btn = document.getElementById('A1A2A3_csv');

chart_btn.addEventListener('click', function () {//繪製圖表
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
    }
    console.log(strat);
    console.log(end);
    //開始繪圖
    getTAData(url_location,bureau,station,strat,end);
});

csv_btn.addEventListener('click', function () {//製作報表
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
    }
    getTAData2(url_location,bureau,station,strat,end);
});

function getTAData(cache,bureau,station,strat,end) {
    // 使用 axios 取得 API 資料
    axios({
        url: cache,
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
        Draw(ta_json['A1count'],ta_json['A2count'],ta_json['A3count'],bureau,station,strat,end);
    });
}
function getTAData2(cache,bureau,station,strat,end) {//要資料，匯出csv報表
    // 使用 axios 取得 API 資料
    axios({
        url: cache,
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
       exportToCsv(bureau.toString()+station.toString()+" "+strat.toString()+"~"+end.toString()+"A1A2A3案件數"+'.csv', [
           [' ','一月','二月','三月','四月','五月','六月','七月','八月','九月','十月','十一月','十二月'],	
         ['A1事件數量',ta_json['A1count'][0].toString(),ta_json['A1count'][1].toString(),ta_json['A1count'][2].toString(),ta_json['A1count'][3].toString(),ta_json['A1count'][4].toString(),ta_json['A1count'][5].toString(),ta_json['A1count'][6].toString(),ta_json['A1count'][7].toString(),ta_json['A1count'][8].toString(),ta_json['A1count'][9].toString(),ta_json['A1count'][10].toString(),ta_json['A1count'][11].toString()],
         ['A2事件數量',ta_json['A2count'][0].toString(),ta_json['A2count'][1].toString(),ta_json['A2count'][2].toString(),ta_json['A2count'][3].toString(),ta_json['A2count'][4].toString(),ta_json['A2count'][5].toString(),ta_json['A2count'][6].toString(),ta_json['A2count'][7].toString(),ta_json['A2count'][8].toString(),ta_json['A2count'][9].toString(),ta_json['A2count'][10].toString(),ta_json['A2count'][11].toString()],
         ['A3事件數量',ta_json['A3count'][0].toString(),ta_json['A3count'][1].toString(),ta_json['A3count'][2].toString(),ta_json['A3count'][3].toString(),ta_json['A3count'][4].toString(),ta_json['A3count'][5].toString(),ta_json['A3count'][6].toString(),ta_json['A3count'][7].toString(),ta_json['A3count'][8].toString(),ta_json['A3count'][9].toString(),ta_json['A3count'][10].toString(),ta_json['A3count'][11].toString()],
       
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
function Draw(a1,a2,a3,bureau,station,strat,end) {
    var ctx = document.getElementById("A1A2A3Chart");
    if(mylinechart){
        mylinechart.destroy();
    }
    mylinechart = new Chart(ctx, {
        type: 'line',
        labels: ["一月","二月","三月","四月","五月","六月","七月","八月","九月","十月","十一月","十二月",],
        data: {
            labels: ["一月","二月","三月","四月","五月","六月","七月","八月","九月","十月","十一月","十二月",],
            datasets: [
            {
                label:"A1案件數",
                data: [a1[0],a1[1],a1[2],a1[3],a1[4],a1[5],a1[6],a1[7],a1[8],a1[9],a1[10],a1[11]],
                fill: false,
                borderColor: '#98DDCA',
                tension:0.01
            },{
                label:"A2案件數",
                data: [a2[0],a2[1],a2[2],a2[3],a2[4],a2[5],a2[6],a2[7],a2[8],a2[9],a2[10],a2[11]],
                fill: false,
                borderColor: '#FFD3B4',
                tension:0.01
            },{
                label:"A3案件數",
                data: [a3[0],a3[1],a3[2],a3[3],a3[4],a3[5],a3[6],a3[7],a3[8],a3[9],a3[10],a3[11]],
                fill: false,
                borderColor: '#FFAAA7',
                tension:0.01
            }
            ],
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
                text: bureau.toString()+station.toString()+" "+strat.toString()+"~"+end.toString()+"A1A2A3案件數",
            },
        }
    });
}


