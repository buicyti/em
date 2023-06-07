<link rel="stylesheet" type="text/css" href="assets/DataTables/datatables.min.css">
<link rel="stylesheet" type="text/css" href="assets/DataTables/Buttons-2.2.2/css/buttons.dataTables.min.css">
<!-- <div class="col-xs-auto select-tool">
  <div class="tool">

    <br />
    <br />

    <b>Xưởng</b>
    <div class="select-group" style="margin-left: -30px;"></div>
    <b>Nhóm</b>
    <div class="select-part" style="margin-left: -30px;"></div>
    <b>Ca - Kíp</b>
    <div class="select-shift" style="margin-left: -30px;"></div>

  </div>
  <button type="button" class="btn-bottom button-green" id="btn-Xac-nhan" style="border-radius: 0;">Xác nhận</button>
</div> -->
<div class="col selected-items">
  <br />
  <button type="button" id="ex-to-Excel-list-emp" class="btn btn-primary bi bi-cloud-arrow-down-fill" data-toggle="tooltip" title="Tải xuống" data-bs-placement="top"></button>
  <button type="button" id="upload-dsnv" class="btn btn-primary bi bi-cloud-arrow-up-fill" data-toggle="tooltip" title="Tải lên" data-bs-placement="right" data-bs-toggle="collapse" data-bs-target="#colUpload" aria-expanded="false" aria-controls="colUpload"></button>

  <div class="collapse mt-3 mb-3" id="colUpload">

    <div class="card card-body">
      <p><span class="text-danger fw-bold">Lưu ý:</span> Khi lựa chọn Upload sẽ bị xóa tất cả các trường được chọn giống nhau</p>
      <div class="input-group mb-3">
        <input type="file" id="file" class="form-control" name="file">
        <button type="button" id="Upload-DSNV" class="btn btn-primary">Upload</button>
      </div>
      <div class="status alert alert-success"></div>
    </div>
  </div>
  <div class="table-responsive mt-3">
    
    <table id="example" class="table table-striped table-bordered"><thead></thead><tfoot><tr></tr></tfoot></table>

  </div>
</div>


<div class="modal fade" id="modalThongtin" tabindex="-1" aria-labelledby="exampleModalLiveLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="fw-bold modal-title" id="exampleModalLiveLabel">THÔNG TIN NHÂN VIÊN</h5>
        <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" id="show_modal">
        <!-----------Hiện data-------->
      </div>
      <div class="modal-footer">
        <!-- <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Close</button> -->
        <button type="button" class="btn btn-primary" id="modal_add" disabled>Thêm</button>
        <button type="button" class="btn btn-success" id="modal_edit" disabled>Sửa</button>
        <button type="button" class="btn btn-danger" id="modal_del" disabled>Xóa</button>
      </div>
    </div>
  </div>
</div>
<!-- The Modal -->
<div id="myModal" class="modal_avatar">
  <span class="close">&times;</span>
  <img class="modal-avatar-content" id="avatar">
  <div id="caption"></div>
</div>

<!-- <style>

table.dataTable thead th,
table.dataTable tbody td {
   width: 100px;
   max-width: 100px;
   min-width: 100px;
} 

table.dataTable thead th:nth-child(1),
table.dataTable tbody td:nth-child(1) {
   min-width: 40px;
} 

table.dataTable thead th:nth-child(3),
table.dataTable tbody td:nth-child(3) {
   width: 200px;
   max-width: 200px;
   min-width: 200px;
} 

table.dataTable thead th:nth-child(24),
table.dataTable tbody td:nth-child(24) {
   min-width: 400px;
}

table.dataTable thead th:nth-child(25),
table.dataTable tbody td:nth-child(25) {
   min-width: 300px;
}
table.dataTable thead th:nth-child(28),
table.dataTable tbody td:nth-child(28) {
   width: 400px;
   max-width: 400px;
   min-width: 300px;
}
</style> -->

<?php
$page_js[] = "assets/DataTables/datatables.min.js";
//$page_js[] = 'assets/DataTables/Buttons-2.2.2/js/buttons.bootstrap5.min.js';
$page_js[] = 'assets/DataTables/jszip.min.js';
$page_js[] = 'assets/DataTables/Buttons-2.2.2/js/buttons.jqueryui.min.js';//style cho nút ấn
$page_js[] = 'assets/DataTables/Buttons-2.2.2/js/buttons.print.js';
$page_js[] = 'assets/DataTables/Buttons-2.2.2/js/buttons.html5.min.js';
//$page_js[] = "assets/jquery/jquery.form.min.js";
$page_js[] = "assets/js/tree.min.js";
$page_js[] = 'js/acc-infomation.js';

?>