@extends("layout")

@section("content")
<!-- Page Heading -->
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-2 text-gray-800">使用者清單</h1>
</div>
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <div class="form-row align-items-center">
        <div class="col-auto my-1">
            <button class="btn btn-success" data-toggle="modal" data-target="#addModal">新增使用者</button>
        </div>
    </div>
</div>
<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">使用者</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="DifficultDataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>序</th>
                        <th>名稱</th>
                        <th>帳號</th>
                        <th>建立時間</th>
                        <th>資料修改</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">建立使用者</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">使用者名稱:</label>
                        <input type="text" class="form-control" id="user_name" autocomplete="off" required>
                    </div>
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">使用者單位名稱:</label>
                        <input type="text" class="form-control" id="employer" autocomplete="off" required>
                    </div>
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">使用者分局名稱:</label>
                        <input type="text" class="form-control" id="burean" autocomplete="off" required>
                    </div>
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">使用者權限等級:</label>
                        <input type="text" class="form-control" id="permission_level" autocomplete="off" required>
                    </div>
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">帳號:</label>
                        <input type="text" class="form-control" id="account" autocomplete="off" required>
                    </div>
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">密碼:</label>
                        <input type="password" class="form-control" id="password" autocomplete="off" required>
                    </div>
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">確認密碼:</label>
                        <input type="password" class="form-control" id="password_confirmation" autocomplete="off"
                            required>
                    </div>
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">信箱:</label>
                        <input type="email" class="form-control" id="email" placeholder="選填" autocomplete="off"
                            required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">取消</button>
                <button type="button" class="btn btn-success" id="add_user">新增 </button>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="userdatachange" data-keyboard="false" tabindex="-1" aria-labelledby="userdatachangeLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="userdatachangeLabel">使用者資料</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-group">

                    </div>
                    <div class="form-group">

                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label class="col-form-label">使用者名稱：</label>
                            <input type="text" class="form-control" id="user_name_change">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label class="col-form-label">使用者單位名稱:</label>
                            <input type="text" class="form-control" id="employer_change" >
                        </div>
                        <div class="form-group col-md-4">
                            <label class="col-form-label">使用者分局名稱:</label>
                            <input type="text" class="form-control" id="burean_change">
                        </div>
                        <div class="form-group col-md-4">
                            <label class="col-form-label">使用者權限等級:</label>
                            <input type="text" class="form-control" id="permission_level_change">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label class="col-form-label">帳號:</label>
                            <input type="text" class="form-control" id="account_change" readonly="readonly"> 
                        </div>
                        <div class="form-group col-md-4">
                            <label class="col-form-label">密碼:</label>
                            <input type="text" class="form-control" id="password_change">
                        </div>
                        <div class="form-group col-md-4">
                            <label class="col-form-label">信箱:</label>
                            <input type="text" class="form-control" id="email_change">
                        </div>
                    </div>
                    <hr>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">關閉</button>
                <button type="button" class="btn btn-success" id="change_user_data">儲存</button>
            </div>
        </div>
    </div>
</div>
<script src="vendor/datatables/jquery.dataTables.min.js"></script>
<script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>
<link href="https://cdn.datatables.net/1.10.24/css/dataTables.bootstrap4.min.css" rel="stylesheet">
<script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>
<script src="js/auth/auth_user_list.js"></script>
<script src="js/auth/get_user_data.js"></script>
@endsection("content")