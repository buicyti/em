<link rel="stylesheet" type="text/css" href="<?php echo $_DOMAIN; ?>assets/alertifyjs/css/alertify.css"> <!-- Giao diện -->
<link rel="stylesheet" type="text/css" href="<?php echo $_DOMAIN; ?>assets/DataTables/datatables.min.css">

<div class="col-xs-auto select-tool">
  <div class="tool">
    <br />
    <b>Chọn Line</b>
    <div class="select-line" style="margin-left: -30px;"></div>
    <!--br/><br/-->
    <b class="card-text">Kích thước:</b>
    <div class="input-group mb-3"><span class="input input-group-text bi bi-arrow-left-right"></span><input class="input form-control" name="kt-ngang" type="number" value="4" min="1" max="6"></div>
    <div class="input-group mb-3"><span class="input input-group-text bi bi-arrow-down-up"></span><input class="input form-control" name="kt-doc" type="number" value="10" min="1" max="20"></div>
    <b class="card-text">Tải lại:</b>
    <div class="input-group mb-3"><span class="input input-group-text bi bi-clock"></span><input class="input form-control" name="time_st_reload" type="number" value="10" min="1" max="60"><span class="input-group-text">phút</span></div>

    <div class="form-check">
      <input class="input form-check-input" type="checkbox" value="" id="flexCheckChecked" checked>
      <label class="form-check-label" for="flexCheckChecked">
        Cảnh báo lỗi
      </label>
    </div>
  </div>
  <button type="button" class="btn-bottom button-green" id="btn-Xac-nhan" style="border-radius: 0;">Xác nhận</button>
</div>
<div class="col selected-items">

    <div class="table-responsive mt-3 pt-3">
      <table id="example" class="table table-striped table-bordered" style="width: calc(100% - 5px);">
        <thead>
          <tr class="text-center align-middle">
            <th scope="col" rowspan="2">STT</th>
            <th scope="col" rowspan="2">Line</th>
            <th scope="col" rowspan="2">Machine</th>
            <th scope="col" rowspan="2"><div style="width: 150px;">Model</div></th>
            <th scope="col" rowspan="2">Vacuum block</th>
            <th scope="col" colspan="6">Machine Status</th>
            <th scope="col" colspan="9">Product State</th>
          </tr>
          <tr>
            <th scope="col">CYCLE_TIME_MEAN</th>
            <th scope="col">CYCLE_TIME</th>
            <th scope="col">PCB_TEMP</th>
            <th scope="col">MASK_TEMP</th>
            <th scope="col">HUMIDITY</th>
            <th scope="col">MASK_VACUUM_SPEED</th>
            <th scope="col">VACUUM_FORCE_MAX</th>
            <th scope="col">PRINT_FORCE_MIN</th>
            <th scope="col">PRINT_FORCE_MAX</th>
            <th scope="col">MASK_PCB_X_DISTANCE</th>
            <th scope="col">MASK_PCB_Y_DISTANCE</th>
            <th scope="col">MASK_PCB_SHRINKAGE_RATIO</th>
            <th scope="col">MASK_PCB_X_DISTANCE_AVG</th>
            <th scope="col">MASK_PCB_Y_DISTANCE_AVG</th>
            <th scope="col">MASK_PCB_SHRINKAGE_RATIO_AVG</th>
          </tr>
        </thead>

      </table>
    

  </div>
</div>





<style type="text/css">
  .green {
    color: green;
  }

  .red {
    color: red;
  }

  .gray {
    color: gray;
  }
</style>






<?php
$page_js[] = "assets/DataTables/datatables.min.js";
//$page_js[] = "assets/DataTables/RowGroup-1.1.4/js/rowGroup.bootstrap5.min.js";
$page_js[] = "assets/DataTables/dataTables.rowsGroup.js";
$page_js[] = "assets/js/tree.min.js";
$page_js[] = "assets/alertifyjs/alertify.js";
$page_js[] = "js/line.js";
$page_js[] = "js/monitors-printer.js";
?>