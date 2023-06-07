
<link rel="stylesheet" type="text/css" href='<?php echo $_DOMAIN; ?>assets/css/daterangepicker.css'>
<link rel="stylesheet" type="text/css" href="<?php echo $_DOMAIN; ?>assets/alertifyjs/css/alertify.css">   <!-- Giao diện -->
    
<div class="col-xs-auto select-tool">
      <div class="tool">
      <br/>
      <b>Chọn Line</b>
      <div class="select-line" style="margin-left: -30px;"></div>
      <!--br/><br/-->
      <b class="card-text">Kích thước:</b>
      <div class="input-group mb-3"><span class="input input-group-text bi bi-arrow-left-right"></span><input class="input form-control" name="kt-ngang" type="number" value="3" min="1" max="6"></div>
      
      <b class="card-text">Sắp xếp:</b>
      <div class="input-group mb-3">
        <span class="input input-group-text bi bi-view-stacked"></span>
        <select class="input form-select" id="sapxep">
          <option value="1" selected>Theo Line</option>
          <option value="2">Theo Kiểu</option>
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
      <br />
      <div class="row row-cols-3" id="THSMD">

        <!-------Data được đổ vào đây-------->

      </div>
    </div>





<style type="text/css">
  .float{
    font-weight: bold ;
    /*float: right;*/
    padding-left: 0.5em;
  }
  .green{
    color: green;
  }
  .red{
    color: red;
  }
  .gray{
    color: gray;
  }
  canvas {
    width: 400px;
    height: 400px;  }
</style>


  

<?php
$page_js[] = "assets/js/moment.min.js";
$page_js[] = "assets/js/daterangepicker.js";
$page_js[] = "assets/js/tree.min.js";
$page_js[] = "assets/js/chart.min.js";
$page_js[] = "assets/alertifyjs/alertify.js";
$page_js[] = "js/line.js";
$page_js[] = "js/monitors-TH-xuong.js";

?>


  