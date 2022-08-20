const url_location = "/api/ta/ta_patrol";
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
            { data: 'set_date' },
            { data: 'work_time' },
            { data: 'communication' },
            { data: 'police_total' },
            { data: 'patrol_content' },
            { data: 'method' },
            { data: 'team_name' },
            { data: 'police_name' },
            { data: 'work_memo' },
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
                
                console.log(json);

                document.getElementById('set_date').value = json[0].set_date;
                document.getElementById('work_time').value = json[0].work_time;
                document.getElementById('communication').value = json[0].communication;
                document.getElementById('police_total').value = json[0].police_total;
                document.getElementById('patrol_content').value = json[0].patrol_content;
                document.getElementById('method').value = json[0].method;
                document.getElementById('latitude').value = json[0].latitude;
                document.getElementById('longitude').value = json[0].longitude;
                document.getElementById('team_name').value = json[0].team_name;
                document.getElementById('police_name').value = json[0].police_name;
                document.getElementById('work_memo').value = json[0].work_memo;
                document.getElementById('unit_uploader').value = json[0].unit_uploader;
                document.getElementById('center_uploader').value = json[0].center_uploader;
            });

    });

});

// 設定「篩選」按鈕 on click 監聽器
var update_btn = document.getElementById('update-data');
update_btn.addEventListener('click', function () {

    // 取得 datetimepicker 的值
    var strat = document.getElementById('picker_start').value;
    var end = document.getElementById('picker_end').value;

    // 設定 API 存取條件
    var url_set_date_cache = url_location + "?filter=set_date:" + strat + "~" + end;

    // 取得/更新資料
    myTable.ajax.url(url_set_date_cache).load();

});

// 設定「重置」按鈕 on click 監聽器
var reset_btn = document.getElementById('reset-data');
reset_btn.addEventListener('click', function () {

    // 取得/更新資料
    myTable.ajax.url(url_location).load();

});
