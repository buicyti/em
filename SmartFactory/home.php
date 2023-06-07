<link rel="stylesheet" href="css/smartfactory.css">
<div class="col-xs-auto select-tool">
    <div class="tool">
        <br />
        <b>Chọn Line</b>
        <div class="select-line" style="margin-left: -30px;"></div>
        
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



<div class="modal fade" id="modalLOB" tabindex="-1" aria-labelledby="modalLOBLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="fw-bold modal-title" id="modalLOBLabel">CẬP NHẬP LOB LINE</h5>
        <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" id="show_modal">
      <button type="button" class="btn btn-primary" id="modal_lob_chip" nameline="HS_SMD001">Lấy LOB Chip mouter</button>
      <button type="button" class="btn btn-primary" id="modal_lob_inline" nameline="HS_SMD001">Lấy LOB Inline</button>
      <canvas id="chartLOBChip"></canvas>
      </div>
    </div>
  </div>
</div>

<style>
    #chartLOBChip{
        max-width: 600px;
        max-height: 300px;
    }
</style>
<?php

$page_js[] = "assets/js/tree.min.js";
$page_js[] = "js/line.js";
$page_js[] = "assets/js/chart.min.js";
$page_js[] = "js/sf-home.js";
?>