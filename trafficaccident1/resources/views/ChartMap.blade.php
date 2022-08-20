@extends("layout")

@section("content")
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">事故媒合分析</h1>
    <div class="col-auto my-1">
        <button id="reset-google-map" class="btn btn-danger">重置</button>
    </div>
</div>

<!-- Content Row -->
<div class="row">
    <div id="map"></div>
</div>

<div class="loader loader-default" data-text="搜尋中..." id="loading-icon"></div>
<!-- Modal -->
<div class="modal fade" id="filterModal" tabindex="-1" aria-labelledby="filterModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="filterModalLabel">篩選器</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-row align-items-center">
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
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label class="col-form-label">開始日期:</label>
                            <input type="text" class="form-control" id="picker_date_start" placeholder="開始時間">
                        </div>
                        <div class="form-group col-md-4">
                            <label class="col-form-label">結束日期:</label>
                            <input type="text" class="form-control" id="picker_date_end" placeholder="結束時間">
                        </div>
                        <div class="form-group col-md-2">
                            <label class="col-form-label">開始時間:</label>
                            <input type="text" class="form-control" id="picker_time_start" placeholder="開始時間">
                        </div>
                        <div class="form-group col-md-2">
                            <label class="col-form-label">結束時間:</label>
                            <input type="text" class="form-control" id="picker_time_end" placeholder="結束時間">
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">取消</button>
                <button type="button" class="btn btn-success" id="show_chart">顯示圖表</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade bd-example-modal-lg" id="chartModal" tabindex="-1" aria-labelledby="chartModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="chartModalLabel">路口事故媒合分析</h5>
            </div>
            <div class="modal-body">
                <div class="chart-area">
                    <canvas id="myAreaChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $.datetimepicker.setLocale("zh-TW");
        $('#picker_date_start').datetimepicker({
            timepicker: false,
            datepicker: true,
            format: 'Y-m-d',
            value: '2021-01-01',
        })
        $('#picker_date_end').datetimepicker({
            timepicker: false,
            datepicker: true,
            format: 'Y-m-d',
            value: '2021-12-31'
        })
        $('#picker_time_start').datetimepicker({
            timepicker: true,
            datepicker: false,
            format: 'H:i',
            value: '00:00',
        })
        $('#picker_time_end').datetimepicker({
            timepicker: true,
            datepicker: false,
            format: 'H:i',
            value: '23:59'
        })
</script>
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.6.0/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.6.0/dist/leaflet.js"></script>
 <div id="map"></div>
<style>
#map {     height: 100% !important;
    padding-bottom: 50%;
    position: relative;
    width: 100%; }


</style>
<link href="https://cdnjs.cloudflare.com/ajax/libs/leaflet.markercluster/1.4.1/MarkerCluster.css"></link> 
<link href="https://cdnjs.cloudflare.com/ajax/libs/leaflet.markercluster/1.4.1/MarkerCluster.Default.css"></link> 
<script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet.markercluster/1.4.1/leaflet.markercluster.js"></script>

<script src="js/chart_googlemap.js"></script>
<!-- Page level plugins -->
<script src="vendor/chart.js/Chart.min.js"></script>
<!-- Page level custom scripts -->
{{-- <script src="js/draw_chart.js"></script> --}}
<!-- Content Row -->

@endsection("content")