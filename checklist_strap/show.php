<link rel="stylesheet" type="text/css" href="assets/DataTables/datatables.min.css">
<link rel="stylesheet" type="text/css" href="assets/DataTables/Buttons-2.2.2/css/buttons.dataTables.min.css">

<div class="col selected-items">
    <div class="container-fluid mt-2">
        <div class="row">
            <b class="col-xs-3 col-md-1">Danh mục kiểm tra:</b>
            <div class="col-xs-3 col-md-2">
                <div class="input-group mb-3">
                    <span class="input-group-text bi bi-view-stacked"></span>
                    <select class="form-select" id="checklist-select">
                        <option value="0" selected>Dép chống tĩnh điện</option>
                        <option value="1">Vòng tay chống tĩnh điện</option>
                    </select>
                </div>
            </div>
            <b class="col-xs-2 col-md-1">Thời gian</b>
            <div class="col-xs-3 col-md-2">
                <div class="input-group mb-3"><span class="input-group-text" style="width: 70px">Tháng</span><input class="form-control" name="select-month" type="number" <?php echo 'value="' . date('m', strtotime($date_current)) . '"' ?> min="1" max="12"></div>
                <div class="input-group mb-3"><span class="input-group-text" style="width: 70px">Năm</span><input class="form-control" name="select-year" type="number" <?php echo 'value="' . date('Y', strtotime($date_current)) . '"' ?> min="2000" max="2100"></div>

            </div>
            <div class="col-xs-4 col-md-3">
                <div>
                    <label>Hiện cột Nhóm
                        <input type="checkbox" id="showGroup">
                    </label>
                </div>
                <div>
                    <label>Hiện cột Ca/Kíp
                        <input type="checkbox" id="showShift">
                    </label>
                </div>
            </div>
        </div>
    </div>
    <div class="table-responsive">
        <table id="example" class="table table-striped table-bordered">
        </table>
    </div>
</div>





<?php
$page_js[] = "assets/DataTables/datatables.min.js";
//$page_js[] = 'assets/DataTables/dataTables.bootstrap5.min.js';
$page_js[] = 'assets/DataTables/jszip.min.js';
$page_js[] = 'assets/DataTables/Buttons-2.2.2/js/buttons.jqueryui.min.js'; //style cho nút ấn
$page_js[] = 'assets/DataTables/Buttons-2.2.2/js/buttons.print.js';
$page_js[] = 'assets/DataTables/Buttons-2.2.2/js/buttons.html5.min.js';
//$page_js[] = "assets/jquery/jquery.form.min.js";
$page_js[] = "assets/js/tree.min.js";
$page_js[] = 'js/checklist-view.js';
