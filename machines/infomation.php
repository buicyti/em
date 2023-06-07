<div class="col selected-items">
    <div class="row justify-content-between mt-3 mb-5">
        <div class="col-md-3">
            <select class="form-select" aria-label="Default select example" id="changeInfo">
                <option selected>Chọn thông tin cần xem</option>
                <option value="1">Printer</option>
                <option value="2">SPI</option>
                <option value="3">Chip mouter</option>
                <option value="4">M-AOI</option>
                <option value="5">Shield can</option>
                <option value="6">Reflow</option>
                <option value="7">S-AOI</option>
                <option value="8">Function test</option>
                <option value="9">Bonding (Underfill)</option>
                <option value="10">Multi mouter</option>
                <option value="11">Chamber (Underfill Reflow)</option>
                <option value="12">Router</option>
            </select>
        </div>
        <div class="col-md-auto">

        </div>
        <div class="col-md-4">
            Tải lên file Excel có định dạng giống với bảng dữ liệu hiển thị.
            <div class="input-group mt-1 mb-3">
                <input type="file" class="form-control" id="inputGroupFile02">
                <label class="input-group-text" for="inputGroupFile02">Upload</label>
            </div>
        </div>
    </div>
    <div class="row">
    <div class="table-responsive">
        <table id="tabInfo" class="table table-striped table-bordered"></table>
    </div>
    </div>
</div>


<?php
    $page_js[] = "assets/DataTables/datatables.min.js";

    $page_js[] = 'js/machines-infomation.js';
?>