@extends("layout")

@section("content")
<!-- Page Heading -->
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-2 text-gray-800">事故登錄/查詢</h1>
    <a href="#" class="d-none d-sm-inline-block btn btn-primary shadow-sm" data-toggle="modal"
        data-target="#uploadModal"><i class="fas fa-upload fa-sm text-white-50"></i> 上傳報表</a>
</div>
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <div class="form-row align-items-center">
        <div class="col-sm-3 my-1">
            <input type="text" class="form-control" id="picker_start" placeholder="開始日期">
        </div>
        ~
        <div class="col-sm-3 my-1">
            <input type="text" class="form-control" id="picker_end" placeholder="結束日期">
        </div>
        <div class="col-auto my-1">
            <button class="btn btn-primary" id="update-google-map">篩選案件</button>
            <button class="btn btn-danger" id="reset-google-map">重置表格</button>
        </div>
    </div>
</div>
<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">事故紀錄清單</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="DifficultDataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>序</th>
                        <th>案件編號</th>
                        <th>案件日期時間</th>
                        <th>事故區域</th>
                        <th>事故類型</th>
                        <th>肇事主因</th>
                        <th>詳細內容</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="uploadModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">上傳事故報表</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form name="upload_form">
                    <label class="col-form-label">請上傳 Excel 記錄檔:</label>
                    <div class="input-group">
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" name="csv_file">
                            <label class="custom-file-label" for="customFile" id="file_label">請選擇檔案</label>
                        </div>
                    </div>
                    <label class="col-form-label">如遇到重複內容:</label>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio1"
                            value="pass" checked="checked">
                        <label class="form-check-label" for="inlineRadio1">略過</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio2"
                            value="replace">
                        <label class="form-check-label" for="inlineRadio2">覆蓋</label>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">取消</button>
                <button type="button" class="btn btn-success" id="upload_csv">上傳</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="staticBackdrop" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">案件內容</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-row">
                        <div class="form-group col-md-5">
                            <label class="col-form-label">案件編號:</label>
                            <input type="text" class="form-control" id="serial_number" readonly="readonly">
                        </div>
                        <div class="form-group col-md-5">
                            <label class="col-form-label">案件日期時間:</label>
                            <input type="text" class="form-control" id="case_datetime" readonly="readonly">
                        </div>
                        <div class="form-group col-md-2">
                            <label class="col-form-label">事故類型:</label>
                            <input type="text" class="form-control" id="accident_category" readonly="readonly">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label class="col-form-label">管轄單位:</label>
                            <input type="text" class="form-control" id="case_jurisdiction" readonly="readonly">
                        </div>
                        <div class="form-group col-md-6">
                            <label class="col-form-label">處理單位:</label>
                            <input type="text" class="form-control" id="case_handle_team" readonly="readonly">
                        </div>
                    </div>
                    <hr>
                    <div class="form-row">
                        <div class="form-group col-md-3">
                            <label class="col-form-label">縣市:</label>
                            <input type="text" class="form-control" id="case_county" readonly="readonly">
                        </div>
                        <div class="form-group col-md-3">
                            <label class="col-form-label">市區鄉鎮:</label>
                            <input type="text" class="form-control" id="case_township" readonly="readonly">
                        </div>
                        <div class="form-group col-md-3">
                            <label class="col-form-label">村里:</label>
                            <input type="text" class="form-control" id="case_village" readonly="readonly">
                        </div>
                        <div class="form-group col-md-3">
                            <label class="col-form-label">鄰:</label>
                            <input type="text" class="form-control" id="case_neighborhood" readonly="readonly">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-3">
                            <label class="col-form-label">路:</label>
                            <input type="text" class="form-control" id="case_road" readonly="readonly">
                        </div>
                        <div class="form-group col-md-3">
                            <label class="col-form-label">段:</label>
                            <input type="text" class="form-control" id="case_section" readonly="readonly">
                        </div>
                        <div class="form-group col-md-3">
                            <label class="col-form-label">巷:</label>
                            <input type="text" class="form-control" id="case_lane" readonly="readonly">
                        </div>
                        <div class="form-group col-md-3">
                            <label class="col-form-label">號:</label>
                            <input type="text" class="form-control" id="case_number" readonly="readonly">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-3">
                            <label class="col-form-label">交叉路段:</label>
                            <input type="text" class="form-control" id="case_intersection_road" readonly="readonly">
                        </div>
                        <div class="form-group col-md-3">
                            <label class="col-form-label">交叉巷口:</label>
                            <input type="text" class="form-control" id="case_intersection_lane" readonly="readonly">
                        </div>
                        <div class="form-group col-md-6">
                            <label class="col-form-label">其他:</label>
                            <input type="text" class="form-control" id="case_other" readonly="readonly">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-3">
                            <label class="col-form-label">公路類別:</label>
                            <input type="text" class="form-control" id="case_highway_category" readonly="readonly">
                        </div>
                        <div class="form-group col-md-3">
                            <label class="col-form-label">公路名稱:</label>
                            <input type="text" class="form-control" id="case_highway_name" readonly="readonly">
                        </div>
                        <div class="form-group col-md-3">
                            <label class="col-form-label">公里數:</label>
                            <input type="text" class="form-control" id="case_highway_kilometers" readonly="readonly">
                        </div>
                        <div class="form-group col-md-3">
                            <label class="col-form-label">公尺數:</label>
                            <input type="text" class="form-control" id="case_highway_meter" readonly="readonly">
                        </div>
                    </div>
                    <hr>
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label class="col-form-label">24小時內死亡:</label>
                            <input type="text" class="form-control" id="case_24h_death" readonly="readonly">
                        </div>
                        <div class="form-group col-md-4">
                            <label class="col-form-label">2-30日內死亡:</label>
                            <input type="text" class="form-control" id="case_30d_death" readonly="readonly">
                        </div>
                        <div class="form-group col-md-4">
                            <label class="col-form-label">受傷人數:</label>
                            <input type="text" class="form-control" id="case_injuries" readonly="readonly">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label class="col-form-label">事故類型-父類別:</label>
                            <input type="text" class="form-control" id="case_accident_type_parent" readonly="readonly">
                        </div>
                        <div class="form-group col-md-4">
                            <label class="col-form-label">事故類型-子類別:</label>
                            <input type="text" class="form-control" id="case_accident_type_child" readonly="readonly">
                        </div>
                        <div class="form-group col-md-4">
                            <label class="col-form-label">肇因研判:</label>
                            <input type="text" class="form-control" id="case_cause" readonly="readonly">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label class="col-form-label">經度:</label>
                            <input type="text" class="form-control" id="longitude" readonly="readonly">
                        </div>
                        <div class="form-group col-md-6">
                            <label class="col-form-label">緯度:</label>
                            <input type="text" class="form-control" id="latitude" readonly="readonly">
                        </div>
                    </div>
                    <hr>
                    <label class="col-form-label">案件當事人順位:</label>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th scope="col">順位</th>
                                <th scope="col">當事人年齡</th>
                                <th scope="col">當事者區分類別</th>
                                <th scope="col">酒精反應</th>
                            </tr>
                        </thead>
                        <tbody id="case_rank">
                        </tbody>
                    </table>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">關閉</button>
            </div>
        </div>
    </div>
</div>
<div class="loader loader-default" data-text="上傳中..." id="loading-icon"></div>
<script>
    $('input[type="file"]').change(function(e){
        var fileName = e.target.files[0].name;
        $('.custom-file-label').html(fileName);
    });
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
<script src="vendor/datatables/jquery.dataTables.min.js"></script>
<script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>
<link href="https://cdn.datatables.net/1.10.24/css/dataTables.bootstrap4.min.css" rel="stylesheet">
<script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>
<link rel="stylesheet" href="css/css-loader.css">
<script src="js/ta_log_datatable.js"></script>
<script src="js/upload_ta_log.js"></script>
@endsection("content")