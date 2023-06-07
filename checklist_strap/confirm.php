
<link rel="stylesheet" type="text/css" href="assets/DataTables/datatables.min.css">
<style>
    tfoot input {
        width: 100%;
        padding: 3px;
        box-sizing: border-box;
    }
</style>


                    
                        <div class="col-6 selected-items">
                            <br />
                            <!-- <button type="button" id="ex-to-Excel-list-emp" class="btn btn-primary bi bi-cloud-arrow-down-fill" data-toggle="tooltip" title="Tải xuống" data-bs-placement="top"></button> -->
                            <button type="button" id="upload-dsnv" class="btn btn-primary bi bi-cloud-arrow-up-fill" data-toggle="tooltip" title="Tải lên" data-bs-placement="right" data-bs-toggle="collapse" data-bs-target="#colUpload" aria-expanded="false" aria-controls="colUpload"></button>
                            
                            <div class="collapse mt-3 mb-3" id="colUpload">

                                <div class="card card-body">
                                    <p><b class="text-danger fw-bold">Lưu ý:</b> 
                                        <ul>
                                            <li>Khi lựa chọn Upload sẽ bị xóa tất cả các trường được chọn giống nhau</li>
                                            <li>Không sử dụng công thức trong dữ liệu </li>
                                        </ul>
                                    </p>
                                    <p><a href="<?php echo $_DOMAIN.'assets/phpexcel/mau/checklist.xlsx'?>">Tải file mẫu</a></p>
                                    <div class="input-group mb-3">
                                        <input type="file" id="file" class="form-control" name="file">
                                        <button type="button" id="Upload-DSNV" class="btn btn-primary">Upload</button>
                                    </div>
                                    <div class="status"></div>
                                </div>
                            </div>
                            <h4 class="text-center align-middle text-uppercase fw-bold">Danh sách nhân viên</h4>
                            <div class="table-responsive">
                                <table id="danhsach" class="table table-striped table-bordered" width="99%">
                                <!-- <thead>
                                    <tr>
                                        <th>STT</th>
                                        <th>Mã Nhân viên</th>
                                        <th style="width: 200px">Tên Nhân viên</th>
                                        <th>Nhóm</th>
                                        <th>Ca/Kíp</th>
                                        <th>Dép</th>
                                        <th>Wrist</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>STT</th>
                                        <th>Mã Nhân viên</th>
                                        <th>Tên Nhân viên</th>
                                        <th>Nhóm</th>
                                        <th>Ca/Kíp</th>
                                        <th>Dép</th>
                                        <th>Wrist</th>
                                    </tr>
                                </tfoot> -->
                                </table>

                            </div>
                        </div>
                        <div class="col-6 selected-items">
                            <br/><div class="card">
                        <h5 class="card-header text-uppercase fw-bold">Dữ liệu nhân viên nghỉ trong ngày</h5>
                        <div class="card-body">
                            <h5 class="card-title">Nhập dữ liệu từ Excel</h5>
                            <div class="input-group mb-3">
                                <input type="file" id="file1" class="form-control" name="file">
                            </div>
                            <p><a href="<?php echo $_DOMAIN.'assets/phpexcel/mau/absent.xlsx'?>">Tải file mẫu</a></p>
                            
                            <div class="mb-3">
                                <label for="floatingTextarea2">Hoặc trực tiếp dán dữ liệu vào đây</label>
                                <textarea class="form-control" placeholder="Dữ liệu lấy trực tiếp trong file Excel (bỏ qua các Header)" id="floatingTextarea2" style="height: 100px"></textarea>
                            </div>
                            <button id="btnabsent" class="btn btn-primary">Tải lên</button>
                            
                            <div class="status1"></div>
                        </div>
                        </div>
                            <div class="table-responsive mt-5">
                                <h4 class="text-uppercase fw-bold">Chưa đo hôm nay</h4>
                                <table id="tababsent" class="table table-striped table-bordered">
                                    
                                </table>

                            </div>
                        </div>
                    


        





    <div class="modal fade" id="modalNhanvien" tabindex="-1" aria-labelledby="exampleModalLiveLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="fw-bold modal-title" id="exampleModalLiveLabel">THÔNG TIN NHÂN VIÊN</h5>
              <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <button type="button" class="btn btn-primary">Thêm</button>
              <button type="button" class="btn btn-info">Sửa</button>
              <button type="button" class="btn btn-danger" disabled>Xóa</button>

              <div class="container-fluid mt-4">
                <div class="row">
                    <div class="col-4">Mã nhân viên</div>
                    <div class="col-8"></div>
                </div>
                <hr/>
                <div class="row">
                    <div class="col-4">Tên nhân viên</div>
                    <div class="col-8"></div>
                </div>
                <hr/>
                <div class="row">
                    <div class="col-4">Nhóm</div>
                    <div class="col-8"></div>
                </div>
                <hr/>
                <div class="row">
                    <div class="col-4">Ca / Kíp</div>
                    <div class="col-8"></div>
                </div>
                <hr/>
                <div class="form-check">
                <input class="form-check-input" type="checkbox" value=" " id="shoeCheck">
                <label class="form-check-label" for="shoeCheck">
                    Kiểm tra dép
                </label>
                </div>
                <hr/>
                <div class="form-check">
                <input class="form-check-input" type="checkbox" value=" " id="wristCheck">
                <label class="form-check-label" for="wristCheck">
                    Kiểm tra Wrist Strap
                </label>
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-success" id="modal_del">Xác nhận</button>
            </div>
          </div>
        </div>
      </div>





<?php
$page_js[] = "assets/DataTables/datatables.min.js";
//$page_js[] = 'assets/DataTables/dataTables.bootstrap5.min.js';
$page_js[] = 'assets/DataTables/Buttons-2.2.2/js/dataTables.buttons.min.js';

$page_js[] = "assets/js/tree.min.js";
$page_js[] = 'js/checklist-confirm.js';


