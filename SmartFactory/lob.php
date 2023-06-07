
<link rel="stylesheet" type="text/css" href='<?php echo $_DOMAIN; ?>assets/css/daterangepicker.css'>
<link rel="stylesheet" type="text/css" href="<?php echo $_DOMAIN; ?>assets/DataTables/datatables.min.css">
    
<div class="col-xs-auto select-tool">
      <div class="tool">
      <br/>
      <b>Line</b>
      <div class="select-line" style="margin-left: -30px;"></div>
      <b class="card-text">LOB:</b>
      <div class="input-group mb-3">
        <span class="input input-group-text bi bi-view-stacked"></span>
        <select class="input form-select" id="seLOB">
          <option value="1" selected>Tất cả</option>
          <option value="2">Chip</option>
          <option value="3">Inline</option>
        </select>
      </div>
      <b class="card-text">Sắp xếp:</b>
      <div class="input-group mb-3">
        <span class="input input-group-text bi bi-view-stacked"></span>
        <select class="input form-select" id="sxLOB">
          <option value="1" selected>Theo Line</option>
          <option value="2">Theo LOB</option>
        </select>
      </div>
      <b class="card-text">Kiểu:</b>
      <div class="input-group mb-3">
        <span class="input input-group-text bi bi-view-stacked"></span>
        <select class="input form-select" id="soLOB">
          <option value="1" selected>Tăng dần</option>
          <option value="2">Giảm dần</option>
        </select>
      </div>
      <b class="card-text">Thời gian:</b>
      <div id="reportrange">
        <div class="input-group">
          <p class="input input-group-text bi bi-hourglass-top"></p>
          <p class="input form-control"></p>
        </div>
        <div class="input-group">
          <p class="input input-group-text bi bi-hourglass-bottom"></p>
          <p class="input form-control"></p>
        </div>
      </div>
      </div>
      <button type="button" class="btn-bottom button-green" id="btn-Xac-nhan" style="border-radius: 0;">Xác nhận</button>
    </div>
    <div class="col selected-items">
        <canvas id="SumLOB" style="width: 100%; max-height: 500px" class="mt-3"></canvas>
        <div class="table-responsive mt-3 pt-3 px-2">
            <table id="example" class="table table-striped table-bordered" style="width: calc(100% - 1px);"></table>
        </div>
    </div>



    <?php
    $page_js[] = "assets/DataTables/datatables.min.js";
    //$page_js[] = 'assets/DataTables/dataTables.bootstrap5.min.js';
    $page_js[] = "assets/js/moment.min.js";
    $page_js[] = "assets/js/daterangepicker.js";
    $page_js[] = "assets/js/tree.min.js";
    $page_js[] = "assets/js/collect.min.js";
    $page_js[] = "js/line.js";
    $page_js[] = "assets/js/chart.min.js";
    $page_js[] = "js/sf-lob.js";
?>