
<link rel="stylesheet" type="text/css" href='<?php echo $_DOMAIN; ?>assets/css/daterangepicker.css'>
<link rel="stylesheet" type="text/css" href="<?php echo $_DOMAIN; ?>assets/DataTables/datatables.min.css">

<div class="col-md-9 selected-items">
    <div class="table-responsive mt-3">
        <table id="example" class="table table-striped table-bordered">
            <thead>
                <tr style="width: 100%">
                    <th scope="col-1" class="text-center align-middle" style="width: 50px;">STT</th>
                    <th scope="col-2" class="text-center align-middle">Line</th>
                    <th scope="col-md-auto" class="text-center align-middle">Trạng thái</th>
                    <th scope="col-2" class="text-center align-middle" style="width: 100px;">Điều khiển</th>
                    <th scope="col-2" class="text-center align-middle" style="width: 20%;">HẸN GIỜ BẬT</th>
                    <th scope="col-2" class="text-center align-middle" style="width: 20%;">HẸN GIỜ TẮT</th>
                </tr>
            </thead>
            
        </table>

    </div>

<?php
$page_js[] = "assets/DataTables/datatables.min.js";
//$page_js[] = 'assets/DataTables/dataTables.bootstrap5.min.js';
$page_js[] = "assets/js/moment.min.js";
$page_js[] = "assets/js/daterangepicker.js";

$page_js[] = 'js/monitors-dat.js';
?>
