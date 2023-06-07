    <div class="col-6 selected-items">
        <!-------Nhập---------->
        <div class="row mt-3">

            <div class="col-6">
                <ul class="list-group list-group-flush card mb-2">
                    <li class="list-group-item">
                        <b>Tháng/Năm:</b>
                        <div class="input-group">
                            <input type="number" value="5" min="1" max="12" class="form-control me-2" id="thang-cong" style="max-width: 30%" />
                            <input type="number" value="2022" min="1990" max="2050" class="form-control" id="nam-cong" style="max-width: 70%" />
                        </div>
                    </li>
                </ul>
                <ul class="list-group list-group-flush card">
                    <li class="list-group-item tl">
                        <p>Bậc lương</p>
                        <div class="input-group mb-1">
                            <select class="form-select me-2" id="bac-luong1"></select>
                            <select class="form-select" id="bac-luong2"></select>
                        </div>
                        <div class="input-group mb-1">
                            <p class="me-3">Chức vụ</p>
                            <select class="form-select" id="chuc-vu"></select>
                        </div>
                        <div class="input-group">
                            <p class="me-3">MBO</p>
                            <select class="form-select" id="mbo"></select>
                        </div>
                    </li>
                    <li class="list-group-item tl">
                        <p>Họ tên</p>
                        <input type="text" class="form-control mb-2" id="name-user">
                        <div class="input-group">
                            <select class="form-select me-1" id="name-id"></select>
                            <button class="btn btn-outline-secondary" type="button" id="btn-search"><i class="bi bi-search"></i></button>
                        </div>
                    </li>
                    <li class="list-group-item tl">
                        <p>Nhập File:</p>
                        <form method="POST" enctype="multipart/form-data">
                            <input type="file" class="form-control" name="file_up" multiple="false" value="" id="file_up" accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet">
                            <input type="button" class="btn btn-secondary" value="Get" id="submit1" />
                        </form>
                    </li>
                    <li class="list-group-item tl" id="thang-nam" style="display: none;">
                    </li>
                </ul>
            </div>
            <div class="col-6">
                <ul class="list-group list-group-flush card" id="list-phu-cap">
                    <li class="list-group-item" id="pc_cc">Bonus chuyên cần<span>200000</span></li>
                    <li class="list-group-item" id="pc_ds">PC Đời sống<span>500000</span></li>
                    <li class="list-group-item" id="pc_kn">PC Kỹ năng<span>200000</span></li>
                    <li class="list-group-item" id="pc_nl">PC Năng lực (chưa ct tính)<span>0</span></li>
                    <li class="list-group-item" id="nguoi-phu-thuoc">Số người phụ thuộc<span>0</span></li>
                    <li class="list-group-item" id="pc_cdn">Chế độ nữ (1.5h)<span>0</span></li>
                </ul>
                <br />
                <div class="d-grid gap-2 d-md-flex justify-content-md-end md-3">
                    <button class="btn btn-primary" type="button" id="tingting">Ting Ting!!!!!!!!!!!!</button>
                </div>
            </div>
        </div>
    </div>
    <div class="col-6 selected-items">
        <h4 class="text-center align-middle text-uppercase fw-bold mt-3">PHIẾU LƯƠNG</h4>
        <div id="nhap-cong">
            <!-------Xem---------->
            <div class="row border-top">
                <div class="col-4 border-end border-start text-align">Ngày công tính lương hành chính</div>
                <span class="col-2 nums border-end" id="cong_hc">0</span>
                <div class="col-6 border-end">
                    <div class="row">
                        <div class="col-8 border-end border-bottom">Nghỉ không lương</div>
                        <span class="col-4 nums border-bottom" id="cong_nglk">0</span>
                    </div>
                    <div class="row">
                        <div class="col-8 border-end">Đi muộn, về sớm (giờ)</div>
                        <span class="col-4 nums" id="cong_dmvs">0</span>
                    </div>
                </div>
            </div>

            <div class="row border-top">
                <div class="col-4 border-end border-start text-align">Ca ngày</div>
                <span class="col-2 nums border-end" id="cong_cangay"> 0</span>
                <div class="col-6 border-end">
                    <div class="row">
                        <div class="col-8 border-end border-bottom">OT trước lễ (0) ngày</div>
                        <span class="col-4 nums border-bottom" id="cong_ottrle">0</span>
                    </div>
                    <div class="row">
                        <div class="col-8 border-end">OT sau lễ (0) ngày</div>
                        <span class="col-4 nums" id="cong_otsaule">0</span>
                    </div>
                </div>
            </div>

            <div class="row border-top">
                <div class="col-4 border-end border-start text-align">Ca đêm</div>
                <span class="col-2 nums border-end" id="cong_cadem"> 0</span>
                <div class="col-6 border-end">
                    <div class="row">
                        <div class="col-8 border-end border-bottom">OT 130%</div>
                        <span class="col-4 nums border-bottom">0</span>
                    </div>
                    <div class="row">
                        <div class="col-8 border-end">OT 150%</div>
                        <span class="col-4 nums" id="cong_ot150">0</span>
                    </div>
                </div>
            </div>

            <div class="row border-top">
                <div class="col-4 border-end border-start">Nghỉ bù (ngày)</div>
                <span class="col-2 nums border-end"> 0</span>
                <div class="col-4 border-end">OT 200%</div>
                <span class="col-2 nums border-end" id="cong_ot200"> 0</span>
            </div>

            <div class="row border-top">
                <div class="col-4 border-end border-start">Nghỉ bù (đêm)</div>
                <span class="col-2 nums border-end"> 0</span>
                <div class="col-4 border-end">OT 200% T7</div>
                <span class="col-2 nums border-end" id="cong_ot200t7"> 0</span>
            </div>

            <div class="row border-top">
                <div class="col-4 border-end border-start">Nghỉ phép</div>
                <span class="col-2 nums border-end" id="cong_nghip"> 0</span>
                <div class="col-4 border-end">OT 270%</div>
                <span class="col-2 nums border-end" id="cong_ot270"> 0</span>
            </div>

            <div class="row border-top border-bottom border-start">
                <div class="col-4 border-end text-align">Nghỉ 70%</div>
                <span class="col-2 nums border-end" id="cong_nghi70"> 0</span>
                <div class="col-6 border-end">
                    <div class="row">
                        <div class="col-8 border-end border-bottom">OT 300%</div>
                        <span class="col-4 nums border-bottom" id="cong_ot300">0</span>
                    </div>
                    <div class="row">
                        <div class="col-8 border-end">OT 390%</div>
                        <span class="col-4 nums" id="cong_ot390">0</span>
                    </div>
                </div>
            </div>
        </div>
        <br />

        <div class="row border-top">
            <div class="col-6 border-end border-start" style="text-align: center;height: 50px;display: flex;flex-direction: column;justify-content: center;"><b>DANH SÁCH THU NHẬP</b></div>
            <div class="col-6 border-end" style="text-align: center;height: 50px;display: flex;flex-direction: column;justify-content: center;"><b>DANH SÁCH KHẤU TRỪ</b></div>
        </div>

        <div class="row border-top">
            <div class="col-6 border-end border-start">
                <div class="row">
                    <div class="col-8 border-end border-bottom">Lương cơ bản</div>
                    <div class="col-4 nums border-bottom" id="luong-co-ban" data-toggle="tooltip_c" data-bs-html="true" data-bs-placement="right" title="">0</div>
                </div>
                <div class="row">
                    <div class="col-8 border-end">Lương 70%</div>
                    <div class="col-4 nums" id="luong-70">0</div>
                </div>
            </div>
            <div class="col-4 border-end text-align">BHXH (8%)</div>
            <div class="col-2 nums border-end" id="tru-bhxh"> 0</div>
        </div>

        <div class="row border-top">
            <div class="col-4 border-end border-start">Bonus chuyên cần</div>
            <div class="col-2 nums border-end" id="luong-chuyen-can"> 0</div>
            <div class="col-4 border-end">BHYT (1.5%)</div>
            <div class="col-2 nums border-end" id="tru-bhyt"> 0</div>
        </div>

        <div class="row border-top">
            <div class="col-4 border-end border-start">PC Đời sống</div>
            <div class="col-2 nums border-end" id="luong-doi-song"> 0</div>
            <div class="col-4 border-end">BHTN (1%)</div>
            <div class="col-2 nums border-end" id="tru-bhtn"> 0</div>
        </div>

        <div class="row border-top">
            <div class="col-4 border-end border-start">PC Kỹ năng</div>
            <div class="col-2 nums border-end" id="luong-ky-nang"> 0</div>
            <div class="col-4 border-end">Đoàn phí</div>
            <div class="col-2 nums border-end" id="tru-doan-phi"> 0</div>
        </div>

        <div class="row border-top">
            <div class="col-4 border-end border-start">PC Năng lực</div>
            <div class="col-2 nums border-end" id="luong-nang-luc"> 0</div>
            <div class="col-4 border-end">Truy thu thẻ BHYT</div>
            <div class="col-2 nums border-end"> 0</div>
        </div>

        <div class="row border-top">
            <div class="col-4 border-end border-start">PC Trách nhiệm</div>
            <div class="col-2 nums border-end" id="luong-trach-nhiem"> 0</div>
            <div class="col-4 border-end">Điều chỉnh bảo hiểm</div>
            <div class="col-2 nums border-end"> 0</div>
        </div>

        <div class="row border-top">
            <div class="col-4 border-end border-start">PC Ca đêm</div>
            <div class="col-2 nums border-end" id="luong-pc-ca-dem"> 0</div>
            <div class="col-4 border-end">Thuế TNCN</div>
            <div class="col-2 nums border-end" id="tru-thue-tncn"> 0</div>
        </div>

        <div class="row border-top">
            <div class="col-4 border-end border-start">Thông ca</div>
            <div class="col-2 nums border-end" id="luong-thong-ca"> 0</div>
            <div class="col-4 border-end">Trừ tiền ăn</div>
            <div class="col-2 nums border-end"> 0</div>
        </div>

        <div class="row border-top">
            <div class="col-6 border-end border-start">
                <div class="row">
                    <div class="col-8 border-end border-bottom">Chế độ LĐ nữ</div>
                    <div class="col-4 nums border-bottom" id="che-do-nu">0</div>
                </div>
                <div class="row">
                    <div class="col-8 border-end">Trợ cấp gửi trẻ</div>
                    <div class="col-4 nums">0</div>
                </div>
            </div>
            <div class="col-4 border-end text-align">Trừ tiền ăn 2 lần/bữa</div>
            <div class="col-2 nums border-end"> 0</div>
        </div>

        <div class="row border-top">
            <div class="col-4 border-end border-start">Thưởng MBO tháng</div>
            <div class="col-2 nums border-end" id="thuong-mbo"> 0</div>
            <div class="col-4 border-end">Trừ thẻ từ</div>
            <div class="col-2 nums border-end"> 0</div>
        </div>

        <div class="row border-top">
            <div class="col-4 border-end border-start">Xếp loại MBO</div>
            <div class="col-2 nums border-end" id="xep-loai-mbo"> 0</div>
            <div class="col-4 border-end">Nghỉ Y tế trên 1h</div>
            <div class="col-2 nums border-end"> 0</div>
        </div>

        <div class="row border-top">
            <div class="col-4 border-end border-start">Bonus thứ 7</div>
            <div class="col-2 nums border-end" id="bonus-t7"> 0</div>
            <div class="col-4 border-end">Trừ đồng phục</div>
            <div class="col-2 nums border-end"> 0</div>
        </div>

        <div class="row border-top">
            <div class="col-4 border-end border-start">Hỗ trợ OY M,P,I</div>
            <div class="col-2 nums border-end"> 0</div>
            <div class="col-4 border-end">Trừ HĐLĐ</div>
            <div class="col-2 nums border-end"> 0</div>
        </div>

        <div class="row border-top">
            <div class="col-4 border-end border-start">TT tiền phép (nghỉ việc)</div>
            <div class="col-2 nums border-end"> 0</div>
            <div class="col-4 border-end">Trừ khác</div>
            <div class="col-2 nums border-end"> 0</div>
        </div>

        <div class="row border-top">
            <div class="col-4 border-end border-start">Tổng OT (bao gồm 45p ca đêm)</div>
            <div class="col-2 nums border-end" id="tong-ot" data-toggle="tooltip_c" data-bs-html="true" data-bs-placement="right"> 0</div>
            <div class="col-4 border-end">Phép tồn</div>
            <div class="col-2 nums border-end"> 0</div>
        </div>

        <div class="row border-top border-bottom mb-3">
            <div class="col-6 border-end border-start">
                <div class="row">
                    <div class="col-8 border-end border-bottom">Thưởng khuyến khích</div>
                    <div class="col-4 nums border-bottom">0</div>
                </div>
                <div class="row">
                    <div class="col-8 border-end border-bottom">Cộng khác</div>
                    <div class="col-4 nums border-bottom">0</div>
                </div>border
                <div class="row">
                    <div class="col-8 border-end border-bottom">Bù, trừ lương</div>
                    <div class="col-4 nums border-bottom">0</div>
                </div>
                <div class="row">
                    <div class="col-8 border-end border-bottom">Tổng thu nhập</div>
                    <div class="col-4 nums border-bottom" id="tong-thu-nhap">0</div>
                </div>
                <div class="row" style="height: 50px; font-weight: bold">
                    <div class="col-8 border-end text-align">Thu nhập thực lĩnh</div>
                    <div class="col-4 nums" id="thu-nhap-thuc-linh">0</div>
                </div>
            </div>
            <div class="col-4 border-end text-align">Tổng khấu trừ</div>
            <div class="col-2 border-end nums" id="tong-khau-tru"> 0</div>

        </div>


    </div>

    <!-- <div class="row" id="ex"></div> -->




    <style>
        .text-align {
            background: transparent;
            color: #000;
            display: flex;
            flex-direction: column;
            justify-content: center;
            text-align: left;
        }

        .nums {
            text-align: right;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .tl p {
            font-weight: bold;
        }

        #cong li span,
        .card span {
            float: right;
        }

        .tll {
            position: relative;
            height: 50px;
        }

        .tll span {
            position: absolute;
            left: 5px;
            top: 5px;
            z-index: 10000;
        }

        .tll input {
            padding-left: 40px;
        }
    </style>
    <?php
    $page_js[] = 'js/timeaheets-tinh-luong.js';
    ?>