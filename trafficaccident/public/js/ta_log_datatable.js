const url_location = "/api/ta/ta_log";
var myTable;

$(document).ready(function () {

    let token = localStorage.getItem('jwt');
    myTable = $('#DifficultDataTable').DataTable({
        "destroy": true,
        "ajax": { // AJAX 取得資料
            "url": url_location,
            "type": "get",
            "headers": {
                "Accept": "application/json",
                "Authorization": "Bearer " + token
            },
            "dataSrc": 'data',
            "error": function (xhr) {
                if (xhr.status == 500 && xhr.statusText == "Internal Server Error") {
                    swal("取得資料失敗", "請聯絡管理員", "error");
                }
            }
        },
        "columns": [ // 要顯示的資料表欄位
            { data: 'id' },
            { data: 'serial_number' },
            { data: 'case_datetime' },
            { data: 'case_township' },
            { data: 'accident_category' },
            { data: 'case_cause' },
            { // 一個欄位為「詳細內容」的按鈕，並連接 Modal
                "targets": -1,
                "data": null,
                "defaultContent": "<button class='btn btn-success' data-toggle='modal' data-target='#staticBackdrop'>詳細內容</button>"
            }
        ],
        "processing": true,
        "deferRender": true,
        "language": {
            "sProcessing": "處理中...",
            "sLengthMenu": "顯示 _MENU_ 項結果",
            "sZeroRecords": "沒有匹配結果",
            "sInfo": "顯示第 _START_ 至 _END_ 項結果，共 _TOTAL_ 項",
            "sInfoEmpty": "顯示第 0 至 0 項結果，共 0 項",
            "sInfoFiltered": "(從 _MAX_ 項結果過濾)",
            "sInfoPostFix": "",
            "sSearch": "搜索:",
            "sUrl": "",
            "oPaginate": {
                "sFirst": "首頁",
                "sPrevious": "上頁",
                "sNext": "下頁",
                "sLast": "尾頁"
            },
        }
    });

    $('#DifficultDataTable tbody').on('click', 'button', function () {
        var data = myTable.row($(this).parents('tr')).data();
        console.log(data);
        $("#case_rank tr").remove();

        // 使用 axios 取得 API 資料
        axios({
            url: url_location + "/" + data.id,
            method: 'get',
            headers: {
                "Accept": "application/json",
                "Authorization": "Bearer " + token
            },
        })
            .then(function (response) {
                // 回傳資料放置於 json
                json = response.data.data;

                document.getElementById('serial_number').value = json[0].serial_number;
                document.getElementById('case_datetime').value = json[0].case_datetime;
                document.getElementById('accident_category').value = json[0].accident_category;
                document.getElementById('case_jurisdiction').value = json[0].case_jurisdiction;
                document.getElementById('case_handle_team').value = json[0].case_handle_team;
                document.getElementById('case_county').value = json[0].case_county;
                document.getElementById('case_township').value = json[0].case_township;
                document.getElementById('case_village').value = json[0].case_village;
                document.getElementById('case_neighborhood').value = json[0].case_neighborhood;
                document.getElementById('case_road').value = json[0].case_road;
                document.getElementById('case_section').value = json[0].case_section;
                document.getElementById('case_lane').value = json[0].case_lane;
                document.getElementById('case_number').value = json[0].case_number;
                document.getElementById('case_intersection_road').value = json[0].case_intersection_road;
                document.getElementById('case_intersection_lane').value = json[0].case_intersection_lane;
                document.getElementById('case_other').value = json[0].case_other;
                document.getElementById('case_highway_category').value = json[0].case_highway_category;
                document.getElementById('case_highway_name').value = json[0].case_highway_name;
                document.getElementById('case_highway_kilometers').value = json[0].case_highway_kilometers;
                document.getElementById('case_highway_meter').value = json[0].case_highway_meter;
                document.getElementById('case_24h_death').value = json[0].case_24h_death;
                document.getElementById('case_30d_death').value = json[0].case_30d_death;
                document.getElementById('case_injuries').value = json[0].case_injuries;
                document.getElementById('case_accident_type_parent').value = json[0].case_accident_type_parent;
                document.getElementById('case_accident_type_child').value = json[0].case_accident_type_child;
                document.getElementById('case_cause').value = json[0].case_cause;
                document.getElementById('latitude').value = json[0].latitude;
                document.getElementById('longitude').value = json[0].longitude;

                var table = document.getElementById("case_rank");

                for (var i = 0; i < json[0].case_rank_data.length; i++) {

                    var row = table.insertRow(i);

                    row.insertCell(0).innerHTML = json[0].case_rank_data[i].case_rank;
                    row.insertCell(1).innerHTML = json[0].case_rank_data[i].case_rank_age;
                    row.insertCell(2).innerHTML = json[0].case_rank_data[i].case_car_type;
                    row.insertCell(3).innerHTML = json[0].case_rank_data[i].case_is_drunk;

                }

            });

    });

});


// 設定「篩選」按鈕 on click 監聽器
var update_btn = document.getElementById('update-google-map');
update_btn.addEventListener('click', function () {

    // 取得 datetimepicker 的值
    var strat = document.getElementById('picker_start').value;
    var end = document.getElementById('picker_end').value;

    // 設定 API 存取條件
    var url = url_location + "?filter=case_date:" + strat + "~" + end;

    // 取得資料
    myTable.ajax.url(url).load();

});

// 設定「重置」按鈕 on click 監聽器
var reset_btn = document.getElementById('reset-google-map');
reset_btn.addEventListener('click', function () {

    // 取得資料
    myTable.ajax.url(url_location).load();
});