@extends("layout")

@section("content")
<link href='https://cdn.jsdelivr.net/npm/fullcalendar@5.5.1/main.css' rel='stylesheet' />
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.5.1/main.js'></script>
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-2 text-gray-800">勤務登錄/查詢</h1>
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
            <button class="btn btn-primary" id="update-data">篩選案件</button>
            <button class="btn btn-danger" id="reset-data">重置表格</button>
        </div>
    </div>
</div>
<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">員警勤務點清單</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="DifficultDataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>序</th>
                        <th>日期</th>
                        <th>時段</th>
                        <th>代號</th>
                        <th>警力</th>
                        <th>任務目標</th>
                        <th>方式</th>
                        <th>單位</th>
                        <th>帶班</th>
                        <th>備考</th>
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
                <h5 class="modal-title" id="exampleModalLabel">上傳勤務報表</h5>
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
                <h5 class="modal-title" id="staticBackdropLabel">勤務內容</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-row">
                        <div class="form-group col-md-3">
                            <label class="col-form-label">執勤日期:</label>
                            <input type="text" class="form-control" id="set_date" readonly="readonly">
                        </div>
                        <div class="form-group col-md-3">
                            <label class="col-form-label">執勤時段:</label>
                            <input type="text" class="form-control" id="work_time" readonly="readonly">
                        </div>
                        <div class="form-group col-md-3">
                            <label class="col-form-label">代號:</label>
                            <input type="text" class="form-control" id="communication" readonly="readonly">
                        </div>
                        <div class="form-group col-md-3">
                            <label class="col-form-label">警力:</label>
                            <input type="text" class="form-control" id="police_total" readonly="readonly">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-3">
                            <label class="col-form-label">執勤方式:</label>
                            <input type="text" class="form-control" id="method" readonly="readonly">
                        </div>
                        <div class="form-group col-md-3">
                            <label class="col-form-label">單位:</label>
                            <input type="text" class="form-control" id="team_name" readonly="readonly">
                        </div>
                        <div class="form-group col-md-3">
                            <label class="col-form-label">帶班:</label>
                            <input type="text" class="form-control" id="police_name" readonly="readonly">
                        </div>
                        <div class="form-group col-md-3">
                            <label class="col-form-label">備考:</label>
                            <input type="text" class="form-control" id="work_memo" readonly="readonly">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label class="col-form-label">勤務內容:</label>
                            <input type="text" class="form-control" id="patrol_content" readonly="readonly">
                        </div>
                        <div class="form-group col-md-4">
                            <label class="col-form-label">經度:</label>
                            <input type="text" class="form-control" id="longitude" readonly="readonly">
                        </div>
                        <div class="form-group col-md-4">
                            <label class="col-form-label">緯度:</label>
                            <input type="text" class="form-control" id="latitude" readonly="readonly">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label class="col-form-label">勤務單位上傳人:</label>
                            <input type="text" class="form-control" id="unit_uploader" readonly="readonly">
                        </div>
                        <div class="form-group col-md-6">
                            <label class="col-form-label">勤務中心上傳人:</label>
                            <input type="text" class="form-control" id="center_uploader" readonly="readonly">
                        </div>
                    </div>
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
<script src="js/patrol_list_datatable.js"></script>
<script src="js/upload_patrol_log.js"></script>
@endsection("content")
