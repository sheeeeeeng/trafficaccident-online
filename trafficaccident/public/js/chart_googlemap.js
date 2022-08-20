const url_location = '/api/ta/chart_map';
var a = -1;
var activeInfoWindow;
var locate_markers = null,
    circle_markers = null,
    lat = null,
    lng = null,
    myChart = null;

var mymap = L.map('map', {
    center: [22.756675,121.15024],
    zoom: 16
  });


L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
}).addTo(mymap);
L.control.scale({
    position: 'topleft',
    metric: 'True',
    imperial: 'False',
    maxWidth:100
  }).addTo(mymap);
var popup = L.popup();
function onMapClick(e) {
        lat=e.latlng.lat;
        lng=e.latlng.lng;
        document.getElementById('longitude').value = lat;
        document.getElementById('latitude').value = lng;
        popup
        .setLatLng(e.latlng)
        .setContent("你選擇的地點 " + lat+","+lng)
        .openOn(mymap);
        $('#filterModal').modal('show');
        if (locate_markers != null) {
            locate_markers.setMap(null);
            circle_markers.setMap(null);
        }

        locate_markers = L.Marker({
            position: e.latLng,
            map: mymap,
        });

        circle_markers = L.Circle({
            center: e.latLng,
            radius: 50,
            strokeOpacity: 0,
            fillColor: '#f00',
            fillOpacity: 0.35,
            map: mymap
        });

        locate_markers.addListener('click', function () {

            $('#filterModal').modal('show');

            if (locate_markers != null) {
                locate_markers.setMap(null);
                circle_markers.setMap(null);
            }

            locate_markers = L.maps.Marker({
                position: e.latLng,
                map: mymap,
            });
            circle_markers=L.circle(e.latLng, 500, {
                color: 'red',
                fillColor: '#f03',
                fillOpacity: 0.5
            }).addTo(mymap);

        });
}

mymap.on('click', onMapClick);

let token = localStorage.getItem('jwt');
function number_format(number, decimals, dec_point, thousands_sep) {

    // *     example: number_format(1234.56, 2, ',', ' ');
    // *     return: '1 234,56'
    number = (number + '').replace(',', '').replace(' ', '');
    var n = !isFinite(+number) ? 0 : +number,
        prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
        sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
        dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
        s = '',
        toFixedFix = function (n, prec) {
            var k = Math.pow(10, prec);
            return '' + Math.round(n * k) / k;
        };
    // Fix for IE parseFloat(0.55).toFixed(0) = 0;
    s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
    if (s[0].length > 3) {
        s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
    }
    if ((s[1] || '').length < prec) {
        s[1] = s[1] || '';
        s[1] += new Array(prec - s[1].length + 1).join('0');
    }
    return s.join(dec);
}

window.chartColors = {
    red: 'rgb(255, 99, 132)',
    orange: 'rgb(255, 159, 64)',
    yellow: 'rgb(255, 205, 86)',
    green: 'rgb(75, 192, 192)',
    blue: 'rgb(54, 162, 235)',
    purple: 'rgb(153, 102, 255)',
    grey: 'rgb(201, 203, 207)'
};

// 設定「重置」按鈕 on click 監聽器
var reset_btn = document.getElementById('reset-google-map');
reset_btn.addEventListener('click', function () {

    if (locate_markers != null) {
        locate_markers.setMap(null);
        circle_markers.setMap(null);
    }

});


var filter_btn = document.getElementById('show_chart');
filter_btn.addEventListener('click', function () {
    document.getElementById("loading-icon").classList.add("is-active");
    
    $('#filterModal').modal('toggle');

    var url = setfilter();

    // 設定 API 存取條件
    getData(url);


});

function setfilter() {
    // // 取得 datetimepicker 的值
    var date_start = document.getElementById('picker_date_start').value;
    var date_end = document.getElementById('picker_date_end').value;
    var time_start = document.getElementById('picker_time_start').value.replace(':', '-');
    var time_end = document.getElementById('picker_time_end').value.replace(':', '-');

    var cache = url_location + "?filter=";
    cache += 'lat:' + lat;
    cache += ',lng:' + lng;
    cache += ',date_start:' + date_start;
    cache += ',date_end:' + date_end;
    cache += ',time_start:' + time_start;
    cache += ',time_end:' + time_end;
    return cache
}

function getData(cache) {
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
            chart_json = response.data;
            var json_hour = chart_json.hour;
            var json_ta_total = chart_json.ta_total;
            var json_patrol_total = chart_json.patrol_total;
            var max = Math.max.apply(null, json_ta_total) + 2;


            if (myChart != null) {
                myChart.destroy();
            }

            draw_chart(json_hour, json_ta_total, json_patrol_total, max);

            $('#chartModal').modal('show');

            document.getElementById("loading-icon").classList.remove("is-active");

        });
}

function draw_chart(hour, ta_total, patrol_total, max) {

    // Area Chart Example
    var ctx = document.getElementById("myAreaChart");
    var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: hour,
            datasets: [{
                type: 'line',
                label: "事故案件數：",
                lineTension: 0.0,
                backgroundColor: "rgba(0,242,195, 0.05)",
                borderColor: window.chartColors.orange,
                pointRadius: 3,
                pointBackgroundColor: window.chartColors.orange,
                pointBorderColor: window.chartColors.orange,
                pointHoverRadius: 3,
                pointHoverBackgroundColor: window.chartColors.orange,
                pointHoverBorderColor: window.chartColors.orange,
                pointHitRadius: 10,
                pointBorderWidth: 2,
                data: ta_total,
                yAxisID: 'y-axis-1',
            }, {
                type: 'bar',
                label: '員警配置數：',
                backgroundColor: window.chartColors.blue,
                data: patrol_total,
                borderColor: window.chartColors.blue,
                borderWidth: 2,
                yAxisID: 'y-axis-2',
            }],
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                xAxes: [{
                    scaleLabel: {
                        display: true,
                        labelString: '時段'
                    },
                    gridLines: {
                        display: true,
                        drawBorder: true
                    }
                }],
                yAxes: [{
                    scaleLabel: {
                        display: true,
                        labelString: '案件數'
                    },
                    ticks: {
                        beginAtZero: true,
                        stepSize: 1,
                        max: max
                    },
                    gridLines: {
                        drawBorder: false,
                        borderDash: [2],
                        zeroLineBorderDash: [2]
                    },
                    position: 'left',
                    id: 'y-axis-1'
                }, {
                    scaleLabel: {
                        display: true,
                        labelString: '值勤人數'
                    },
                    ticks: {
                        beginAtZero: true,
                        stepSize: 1,
                        max: max
                    },
                    gridLines: {
                        display: true,
                        drawBorder: true,
                        borderDash: [2],
                        zeroLineBorderDash: [2]
                    },
                    position: 'right',
                    id: 'y-axis-2'
                }],
            },
            legend: {
                display: true
            },
            tooltips: {
                backgroundColor: "rgb(255,255,255)",
                bodyFontColor: "#858796",
                titleMarginBottom: 10,
                titleFontColor: '#6e707e',
                titleFontSize: 14,
                borderColor: '#dddfeb',
                borderWidth: 1,
                xPadding: 15,
                yPadding: 15,
                displayColors: false,
                intersect: false,
                mode: 'index',
                caretPadding: 10,
                callbacks: {
                    label: function (tooltipItem, chart) {
                        var datasetLabel = chart.datasets[tooltipItem.datasetIndex].label || '';
                        return datasetLabel + " " + number_format(tooltipItem.yLabel);
                    }
                }
            }
        }
    });
}