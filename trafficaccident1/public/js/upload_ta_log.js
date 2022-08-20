// 上傳報表的按鈕
var upload_btn = document.getElementById('upload_csv');
upload_btn.addEventListener('click', function () {

    // 顯示 Loading 畫面，用意：不給使用者操作畫面
    document.getElementById("loading-icon").classList.add("is-active");

    // 取得 Input 選的檔案內容
    var file = document.forms['upload_form']['csv_file'].files[0];

    if (file === undefined) {
        // 關閉 Loading 畫面
        document.getElementById("loading-icon").classList.remove("is-active");
        // 重置上傳報表 Modal 的欄位
        document.getElementById("file_label").value = "請選擇檔案";
        // 關閉 Modal
        $('#uploadModal').modal('toggle');
        // 顯示回應視窗
        swal("上傳失敗", "請選擇要上傳的檔案", "error");

        return false;
    }

    // 檢查是否選到非 Excel 的文件，有則透由 AJAX 發送，無則取消動作
    if (file.name.indexOf(".xls") > 0 || file.name.indexOf(".xlsx") > 0) {

        var method = $('input[name=inlineRadioOptions]:checked').val();

        // 將檔案放入表格內
        let formData = new FormData();
        formData.append('method', method); //required
        formData.append('csv', file); //required

        let token = localStorage.getItem('jwt');

        axios({
            method: 'POST',
            url: url_location,
            headers: {
                "Accept": "application/json",
                "Authorization": "Bearer " + token
            },
            data: formData,
            mimeType: 'multipart/form-data'
        }).then(function (response) {
            console.log(response.data['handltram']);
            if (response.data['status'] == "Success") {

                // 若狀態為「Success」即成功則
                // 關閉 Loading 畫面
                document.getElementById("loading-icon").classList.remove("is-active");
                // 重置上傳報表 Modal 的欄位
                document.getElementById("file_label").value = "請選擇檔案";
                // 關閉 Modal
                $('#uploadModal').modal('toggle');

                var log = "新增案件資料數：" + response.data['case_add_volume'] + "，順位資料數：" + response.data['rank_add_volume'] + "\n略過案件資料數：" + response.data['case_pass_volume'] + "\n上傳權限不足案件資料數：" + response.data['case_pass_volume_noPL'] + "\n覆蓋案件資料數：" + response.data['case_replace_volume'] + "，順位資料數：" + response.data['rank_replace_volume'];
                // 顯示回應視窗
                swal("上傳成功", log, "success");

            } else {

                // 例外處理
                // 關閉 Loading 畫面
                document.getElementById("loading-icon").classList.remove("is-active");
                // 重置上傳報表 Modal 的欄位
                document.getElementById("file_label").value = "請選擇檔案";
                // 關閉 Modal
                $('#uploadModal').modal('toggle');
                // 顯示回應視窗
                swal("上傳失敗", "請聯絡管理員", "error");

            }
        }).catch(function (response) {

            // 關閉 Loading 畫面
            document.getElementById("loading-icon").classList.remove("is-active");
            // 重置上傳報表 Modal 的欄位
            document.getElementById("file_label").value = "請選擇檔案";
            // 關閉 Modal
            $('#uploadModal').modal('toggle');
            // 顯示回應視窗
            swal("連線失敗", "請聯絡管理員", "error");

        })
    } else {

        // 關閉 Loading 畫面
        document.getElementById("loading-icon").classList.remove("is-active");
        // 重置上傳報表 Modal 的欄位
        document.getElementById("file_label").value = "請選擇檔案";
        // 關閉 Modal
        $('#uploadModal').modal('toggle');
        // 顯示回應視窗
        swal("上傳失敗", "請勿上傳非 .xls 或 .xlsx 之檔案", "error");

        return false;

    }

});
