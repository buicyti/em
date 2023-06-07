
<link rel="stylesheet" type="text/css" href="<?php echo $_DOMAIN; ?>assets/alertifyjs/css/alertify.css">   <!-- Giao diện -->
   

<div class="col-xs-auto select-tool">
      <div class="tool">
      <br/>
      <b>Chọn Line</b>
      <div class="select-line" style="margin-left: -30px;"></div>
      <!--br/><br/-->
      <b class="card-text">Kích thước:</b>
      <div class="input-group mb-3"><span class="input input-group-text bi bi-arrow-left-right"></span><input class="input form-control" name="kt-ngang" type="number" value="4" min="1" max="6"></div>
      <div class="input-group mb-3"><span class="input input-group-text bi bi-arrow-down-up"></span><input class="input form-control" name="kt-doc" type="number" value="10" min="1" max="20"></div>
      <b class="card-text">Tải lại:</b>
      <div class="input-group mb-3"><span class="input input-group-text bi bi-clock"></span><input class="input form-control" name="time_st_reload" type="number" value="10" min="1" max="60"><span class="input-group-text">phút</span></div>
      <b class="card-text">Sắp xếp:</b>
      <div class="input-group mb-3">
        <span class="input input-group-text bi bi-view-stacked"></span>
        <select class="input form-select" id="sapxep">
          <option value="1" selected>Theo Line</option>
          <option value="2">Theo Kiểu</option>
        </select>
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

<?php
$page_js[] = "assets/js/tree.min.js";
$page_js[] = "assets/alertifyjs/alertify.js";
$page_js[] = "js/line.js";
$page_js[] = "js/monitors-chip.js";

?>