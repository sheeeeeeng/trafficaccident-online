@extends("layout")

@section("content")
<div class="container">
    <div class='row'>
        <div class="col-md-12 text-center"> 
            <H1>網頁操作教學</H1>
            <br>
        </div>
    </div>
</div>
<div class="container">
    <div class='row'>
        <div class="col-md-12 text-center"> 
            <H1>交通大數據關聯平台網頁操作教學影片</H1>
            <br>
        </div>
        <div class="col-md-12 text-center">
          <video width="640" height="480" controls>
            <source src="Teachvideo/教育訓練影片交通大數據關聯平台verFin.mp4" type="video/mp4">
            <br>
          </video>
        </div>
        <div class="col-md-12 text-center"> 
            <H1>交通大數據關聯平台網頁實際操作影片</H1>
            <br>
        </div>
        <div class="col-md-12 text-center">
          <video width="640" height="480" controls>
            <source src="Teachvideo/trafficaccident網頁操作.mp4" type="video/mp4">
            <br>
          </video>
        </div>
    </div>
</div>

@endsection("content")
