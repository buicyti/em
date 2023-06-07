
<link rel="stylesheet" type="text/css" href="assets/DataTables/datatables.min.css">
<div class="col selected-items">
    <div class="row">
        <div class="col-md-4 mt-5">
            <div class="card">
                <div class="card-header text-uppercase fw-bold">
                    Mapping
                </div>
                <div class="card-body">
                    <!-- <h5 class="card-title">Special title treatment</h5>
                    <p class="card-text">With supporting text below as a natural lead-in to additional content.</p> -->
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="fliIDCard" placeholder="Nhập mã thẻ">
                        <label for="fliIDCard">Mã thẻ</label>
                        <div id="idCardHelp" class="form-text" style="display: none;">Thông báo hiện ở đây.</div>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="fliEmployeeID" placeholder="Mã nhân viên">
                        <label for="fliEmployeeID">Mã nhân viên</label>
                        <div id="idEmployeeHelp" class="form-text" style="display: none;">Thông báo hiện ở đây.</div>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="fliEmployeeName" placeholder="Tên nhân viên">
                        <label for="fliEmployeeName">Tên nhân viên</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="fliGr" placeholder="Nhóm">
                        <label for="fliGr">Nhóm</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="fliCa" placeholder="Ca / Kíp">
                        <label for="fliCa">Ca / Kíp</label>
                    </div>
                    <button class="btn btn-primary" id="btnMap">Cập nhật dữ liệu</button>
                    <div id="btnHelp" class="form-text" style="display: none;">Thông báo hiện ở đây.</div>
                </div>
            </div>
        </div>
        <div class="col-md-8 mt-5">
            <table id="tabMap" class="table table-striped table-bordered" width="99%"></table>
        </div>
    </div>
</div>



<?php
$page_js[] = "assets/DataTables/datatables.min.js";
//$page_js[] = 'assets/DataTables/dataTables.bootstrap5.min.js';
$page_js[] = 'assets/DataTables/Buttons-2.2.2/js/dataTables.buttons.min.js';
$page_js[] = 'js/checklist-mapping.js';
?>