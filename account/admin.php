<!-- <link rel="stylesheet" type="text/css" href="<?php echo $_DOMAIN; ?>assets/alertifyjs/css/alertify.css"> --> <!-- Giao diện -->
<link rel="stylesheet" type="text/css" href="<?php echo $_DOMAIN; ?>assets/DataTables/datatables.min.css">
<!-- <link rel="stylesheet" type="text/css" href="<?php echo $_DOMAIN; ?>assets/bootstrap/css/bootstrap-select.min.css"> -->
<link rel="stylesheet" type="text/css" href="<?php echo $_DOMAIN; ?>assets/DataTables/Buttons-2.2.2/css/buttons.dataTables.min.css">
<!-- <link rel="stylesheet" type="text/css" href='<?php echo $_DOMAIN; ?>assets/css/daterangepicker.css'> -->

<div class="col selected-items">
    <div class="row mt-4">
    <h4 class="text-uppercase text-center fw-bolder">Danh sách tài khoản</h4>
        <div class="table-responsive p-3">
            <table id="tabAccountList" class="table table-striped table-bordered">
            </table>
        </div>
    </div>
    <div class="row">
        
    </div>
</div>



<div class="modal fade" tabindex="-1"  id="modalXacnhan">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-body">
        <p>Modal body text goes here.</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Save changes</button>
      </div>
    </div>
  </div>
</div>

<?php
if($data_user['part'] != 10) new Redirect($_DOMAIN);
$page_js[] = "assets/js/moment.min.js";
$page_js[] = "assets/js/tree.min.js";
$page_js[] = "assets/DataTables/datatables.min.js";
$page_js[] = 'assets/DataTables/jszip.min.js';
$page_js[] = 'assets/DataTables/Buttons-2.2.2/js/buttons.jqueryui.min.js'; //style cho nút ấn
//$page_js[] = 'assets/DataTables/Buttons-2.2.2/js/buttons.print.js';
$page_js[] = 'assets/DataTables/Buttons-2.2.2/js/buttons.html5.min.js';
$page_js[] = 'assets/DataTables/Buttons-2.2.2/js/dataTables.buttons.min.js';
$page_js[] = "assets/js/daterangepicker.js";
$page_js[] = "assets/bootstrap/js/bootstrap-select.min.js";
$page_js[] = "assets/js/chart.min.js";
$page_js[] = "js/line.js";
$page_js[] = 'js/acc-admin.js';
?>