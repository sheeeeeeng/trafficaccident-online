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
            { data: 'user_name' },
            { data: 'account' },
            { data: 'created_at' },
            { // 一個欄位為「資料修改」的按鈕，並連接 Modal
                "targets": -1,
                "data": null,
                "defaultContent": "<button class='btn btn-success' data-toggle='modal' data-target='#userdatachange'>資料修改</button>"
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
        $("#case_rank tr").remove();
        // 使用 axios 取得 API 資料
        axios({
            url: "/api/getdata",
            params: {           
                id: data.id,
            },
            method: 'get',
            headers: {
                "Accept": "application/json",
                "Authorization": "Bearer " + token
            },
        })
        .then(function (response) {
            // 回傳資料放置於 json
            json = response.data.data;
            document.getElementById('user_name_change').value = json[0].user_name;
            document.getElementById('employer_change').value = json[0].employer;
            document.getElementById('burean_change').value = json[0].burean;
            document.getElementById('permission_level_change').value = json[0].permission_level;
            document.getElementById('account_change').value = json[0].account;
            document.getElementById('password_change').value = json[0].password;
            document.getElementById('email_change').value = json[0].email;
        });
    

    });

});