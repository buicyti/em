
<link rel="stylesheet" type="text/css" href="<?php echo $_DOMAIN; ?>assets/alertifyjs/css/alertify.css">   <!-- Giao diện canhr baso--> 

    
<div class="col-xs-auto select-tool">
      <div class="tool">
      <br/>
      <div class="form-check">
  					<input class="form-check-input" type="radio" name="display_type" id="display_type1" value="line_type" checked>
  						<b class="form-check-label" for="flexRadioDefault1">Hiện theo Line</b>
  					<select class="input form-select" id="list-line">
  						<!---------Hiện line ở đây---------->
  					</select>
				</div>
				<div class="form-check">
  					<input class="form-check-input" type="radio" name="display_type" id="display_type2" value="machine_type">
  						<b class="form-check-label" for="flexRadioDefault2">Hiện theo máy</b>
  					<select class="input form-select" id="list-machine">
  						<!---------Hiện machine ở đây---------->
  					</select>	
				</div>
      <!--br/><br/-->
      <b class="card-text">Kích thước:</b>
      <div class="input-group mb-3"><span class="input input-group-text bi bi-arrow-left-right"></span><input class="input form-control" name="kt-ngang" type="number" value="3" min="1" max="6"></div>
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
          <br/>
          <div class="row table-responsive" id="PC-SMD">
                          <table id="example" class="table table-striped table-bordered">
                            <thead class="table-light">
                                <tr>
                                    <th class="diagonalCross2"><span style="vertical-align: bottom;">Line</span></th>
                                    <th>DAT</th>
                                    <th>Printer 1</th>
                                    <th>Printer 2</th>
                                    <th>SPI</th>
                                    <th>M-AOI</th>
                                    <th>NG M-AOI</th>
                                    <th>Shield can</th>
                                    <th>Reflow</th>
                                    <th>S-AOI</th>
                                    <th>NG S-AOI</th>
                                    <th>Function Main</th>
                                    <th>Function 1</th>
                                    <th>Function 2</th>
                                    <th>Function 3</th>
                                    <th>Function 4</th>
                                    <th>Function 5</th>
                                    <th>Function 6</th>
                                    <th>Function DL</th>
                                    <th>Bonding</th>
                                    <th>Multi Mouter</th>
                                    <th>Chamber</th>
                                    <th>Router</th>
                                    <th>Laptop</th>
                                </tr>
                            </thead>
                            <tbody>
                              <tr>
                                
                              </tr>
                            </tbody>
                          </table>

            <!-------Data được đổ vào đây-------->
            
          </div>
          <div id="alertify"> <!-----Cảnh báo được đổ vào đây-------></div>
        </div>


<?php
$page_js[] = "js/monitors-pc-infomations.js";
?>

<style>
  .diagonalCross2 {
  background: linear-gradient(to top right, #fff calc(50% - 1px), #E0E0E0 , #fff calc(50% + 1px) );
  
}
</style>