<!-- <link rel="stylesheet" type="text/css" href="<?php echo $_DOMAIN; ?>assets/alertifyjs/css/alertify.css"> --> <!-- Giao diện -->
<link rel="stylesheet" type="text/css" href="<?php echo $_DOMAIN; ?>assets/DataTables/datatables.min.css">
<!-- <link rel="stylesheet" type="text/css" href="<?php echo $_DOMAIN; ?>assets/bootstrap/css/bootstrap-select.min.css"> -->
<link rel="stylesheet" type="text/css" href="<?php echo $_DOMAIN; ?>assets/DataTables/Buttons-2.2.2/css/buttons.dataTables.min.css">
<!-- <link rel="stylesheet" type="text/css" href='<?php echo $_DOMAIN; ?>assets/css/daterangepicker.css'> -->

<div class="col selected-items">
    <div class="row mt-2">
        <div class="col-auto">
            <button type="button" id="upload-dsnv" class="btn btn-primary bi bi-cloud-arrow-up-fill" data-toggle="tooltip" title="Tải lên" data-bs-placement="right" data-bs-toggle="collapse" data-bs-target="#colUpload" aria-expanded="false" aria-controls="colUpload"> Tải lên tập tin</button>
            <div class="collapse mt-3 mb-3" id="colUpload">
                <div class="card card-body">
                    <p><b class="text-danger fw-bold">Lưu ý:</b>
                    <ul>
                        <li>Mỗi lần upload tối đa 20 file. Mỗi file có dung lượng không vượt quá 100MB</li>
                        <li>Vui lòng không upload các file có chứa mã độc</li>
                    </ul>
                    </p>
                    <div class="input-group mb-3">
                        <input type="file" id="fileUpload" name="fileUpload[]" class="form-control" multiple>
                        <button type="button" id="uploadFile" class="btn btn-primary">Upload</button>
                    </div>
                    <div class="form-group hidden box-progress-bar">
                        <div class="progress">
                            <div class="progress-bar" role="progressbar"></div>
                        </div>
                    </div>
                    <div class="status mt-2"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-4">
        <table id="tabFile" class="table table-striped table-bordered"></table>
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
$page_js[] = "js/file.js";
?>

<div class="modal fade" id="modalFileShow" tabindex="-1" aria-labelledby="exampleModalLiveLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLiveLabel">Download</h5>
                <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="container">
                    <div class="row">
                        <div class="col-6">
                            <ul class="list-group text-left">
                                <li class="list-group-item">
                                    <i style="font-size:18px;" class="bi bi-file"></i><b> File Name: </b><span></span>
                                </li>
                                <li class="list-group-item">
                                    <i style="font-size:18px;" class="bi bi-funnel-fill"></i><b> File Extension: </b><span></span>
                                </li>
                                <li class="list-group-item">
                                    <i style="font-size:18px;" class="bi bi-diagram-2"></i><b> File Size: </b><span></span>
                                </li>
                                <br>
                                <a rel="nofollow" class="btn btn-primary bi bi-cloud-arrow-down-fill" style="max-width: 120px">Tải xuống</a>
                            </ul>
                        </div>
                        <div class="col-6">
                            <ul class="list-group col-right text-left">
                                <li class="list-group-item">
                                    <span><i class="fa fa-link"></i><b>Download Link</b></span>
                                    <input style="margin-bottom:0px;" class="form-control" type="text" value="" readonly="">
                                </li>
                                <li class="list-group-item">
                                    <span><i class="fa fa-code"></i><b>HTML Include (For Websites)</b></span>
                                    <input style="margin-bottom:0px;" class="form-control" type="text" value="" readonly="">
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>