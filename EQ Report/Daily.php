<link rel="stylesheet" type="text/css" href="<?php echo $_DOMAIN; ?>assets/alertifyjs/css/alertify.css"> <!-- Giao diện -->
<link rel="stylesheet" type="text/css" href="<?php echo $_DOMAIN; ?>assets/DataTables/datatables.min.css">
<link rel="stylesheet" type="text/css" href="<?php echo $_DOMAIN; ?>assets/bootstrap/css/bootstrap-select.min.css">
<link rel="stylesheet" type="text/css" href="<?php echo $_DOMAIN; ?>assets/DataTables/Buttons-2.2.2/css/buttons.dataTables.min.css">
<link rel="stylesheet" type="text/css" href='<?php echo $_DOMAIN; ?>assets/css/daterangepicker.css'>

<div class="col-auto select-tool">
    <div class="tool">
        <br />
        <div class="d-flex justify-content-center"><button class="btn btn-info btn-lg text-uppercase fs-5 fw-bolder text-muted" data-bs-toggle="modal" data-bs-target="#exampleModal">Nhập báo cáo</button></div>
        <br />
        <b class="card-text">Line:</b>
        <div class="select-line mb-3" style="margin-left: -30px;"></div>

        <b class="card-text">Machine:</b>
        <select class="form-control mb-3" name="selectpicker" id="selectMachine" multiple></select>

        <b class="card-text">Ca:</b>
        <select class="form-control mb-3" name="selectpicker" id="selectShift" multiple></select>

        <b class="card-text">Nhóm:</b>
        <select class="form-control mb-3" name="selectpicker" id="selectGroup" multiple></select>

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
    <div class="row">
        <div class="table-responsive p-3">
            <table id="tabDailyReport" class="table table-striped table-bordered">
            </table>
        </div>
    </div>
    <div class="row mt-5">
        <h4 class="text-uppercase text-center fw-bolder">Thống kê loss time - tỉ lệ lỗi xuất hiện theo line</h4>
        <canvas id="lossTimeLine"></canvas>
    </div>
    
</div>




<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <!-- <h5 class="modal-title" id="exampleModalLabel">Nhập báo cáo</h5> -->
                <label class="btn btn-info" for="uploadExcel">
                    <i class="bi bi-file-earmark-excel"></i> Import Excel
                    <input type="file" id="uploadExcel" style="display:none">
                </label>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="container">
                    <div class="row mb-3">
                        <div class="col-md-auto"><i class="bi bi-1-square"></i>
                            <p class="text-start text-capitalize fs-6 fw-bold">Ngày:</p>
                            <p class="form-control" id="modal-day"></p>
                        </div>
                        <div class="col-md-auto">
                            <p class="text-start text-capitalize fs-6 fw-bold">Ca:</p>
                            <select class="form-select" id="modal-shift"></select>
                        </div>
                        <div class="col-md-auto">
                            <p class="text-start text-capitalize fs-6 fw-bold">Nhóm:</p>
                            <select class="form-select" id="modal-Group"></select>
                        </div>
                        <div class="col-md-auto">
                            <p class="text-start text-capitalize fs-6 fw-bold">Line:</p>
                            <select class="form-select" id="modal-line"></select>
                        </div>
                        <div class="col-md-auto">
                            <p class="text-start text-capitalize fs-6 fw-bold">Machine:</p>
                            <select class="form-select" id="modal-machine"></select>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="lblVande" class="form-label text-start text-capitalize fs-6 fw-bold">Vấn đề phát sinh</label>
                        <textarea class="form-control" id="lblVande" rows="2"></textarea>
                        <div class="form-text text-danger hidden">Vui lòng nhập vào trường này.</div>
                    </div>

                    <div class="mb-3">
                        <label for="lblNguyennhan" class="form-label text-start text-capitalize fs-6 fw-bold">Nguyên nhân</label>
                        <textarea class="form-control" id="lblNguyennhan" rows="2"></textarea>
                        <div class="form-text text-danger hidden">Vui lòng nhập vào trường này.</div>
                    </div>

                    <div class="mb-3">
                        <label for="lblKhacphuc" class="form-label text-start text-capitalize fs-6 fw-bold">Cách khắc phục</label>
                        <textarea class="form-control" id="lblKhacphuc" rows="3"></textarea>
                        <div class="form-text text-danger hidden">Vui lòng nhập vào trường này.</div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-auto">
                            <p class="text-start text-capitalize fs-6 fw-bold">Hình ảnh:</p>
                            <label class="border" for="uploadImage">
                                <img class="img-thumbnail" src="assets/images/card-image.svg" alt="Click để tải hình ảnh lên" style="width: 200px; height: 200px;"/>
                                <input type="file" id="uploadImage" style="display:none">
                            </label>
                        </div>
                        <div class="col-md-auto">
                            <p class="text-start text-capitalize fs-6 fw-bold">Losstime:</p>
                            <input class="form-control" type="number" id="modal-losstime" value="0" style="max-width: 100px;"/>
                        </div>
                        <div class="col-md-auto">
                            <p class="text-start text-capitalize fs-6 fw-bold">Tình trạng:</p>
                            <select class="form-select" id="modal-stt"></select>
                        </div>
                        <div class="col-6">
                            <label for="lblNote" class="form-label text-start text-capitalize fs-6 fw-bold">Note:</label>
                            <textarea class="form-control" id="lblNote" rows="3"></textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary">Gửi báo cáo</button>
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
$page_js[] = 'js/eq-report-daily.js';
?>