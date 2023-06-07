<div class="col-12 selected-items">
    <div class="row background bg-light">
        <div class="col-9">
            <canvas id="THxuong"></canvas>
        </div>
        <div class="col-3" style="width: 20%">
            <canvas id="Txuong"></canvas>
            <canvas id="Hxuong"></canvas>
        </div>

    </div>
    <!----nhiệt độ xưởng--------->
    <div class="row background bg-light">
        <div class="col-3" style="width: 20%">
            <canvas id="TtuLKDT"></canvas>
            <canvas id="HtuLKDT"></canvas>
        </div>
        <div class="col-9">
            <canvas id="THtuLKDT"></canvas>
        </div>
    </div>
    <!----độ ẩm tủ LKĐT--------->
    <div class="row background bg-light">
        <div class="col-9">
            <canvas id="THreflow"></canvas>
        </div>
        <div class="col-3" style="width: 20%">
            <canvas id="Treflow"></canvas>
            <canvas id="Hreflow"></canvas>
        </div>
    </div>
    <!--------reflow---------->
    <div class="row background bg-light">
        <div class="col-3" style="width: 20%">
            <canvas id="VCprinter1"></canvas>
        </div>
        <div class="col-9">
            <canvas id="VCprinter"></canvas>
        </div>
    </div>
</div>


<style>
    @font-face {
  font-family: 'Dancing Script';
  src: url(assets/font/Dancing_Script/DancingScript-VariableFont_wght.ttf);
}

    .clock,
    h1,
    h2,
    #tetornot,
    #featured,
    #fixed-bot {
        font-family: 'Dancing Script', cursive;
        font-weight: 700;
        text-align: center;
    }

    
    h2{
        font-size: 5vw;
    }
    .clock {
        margin: 1.5em .5em 0;
    }


    .clock .clock-item {
        width: 20%;
        padding-bottom: 20%;
        border-radius: 30%;
        overflow: hidden;
        background: #FFDD7E;
        position: relative;
    }


    .clock .num {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 72%;
        font-size:calc(5vw);
        display:flex;
        align-items:center;
        justify-content:center
    }

    .clock .text {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        height: 28%;
        background: #FFCA38;
        text-transform: uppercase;
        font-weight: 400;
        font-size:calc(2.2vw);
        display:flex;
        align-items:center;
        justify-content:center
    }
</style>


<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">

            <div class="modal-body" style="background-color: #FFFCF2">
                    <h1>
                        <div id="tetornot" class="">Sắp Tết rồi!!! Chỉ còn...</div>
                    </h1>
                    <div class="container-fluid">
                        <div class="row clock">

                            <div class="col-md-2 ms-auto clock-item">
                                <div id="days" class="num">50</div>
                                <div id="days-text" class="text">Ngày</div>
                            </div>
                            <div class="col-md-2 ms-auto clock-item">
                                <div id="hours" class="num">7</div>
                                <div id="hours-text" class="text">Giờ</div>
                            </div>
                            <div class="col-md-2 ms-auto clock-item">

                                <div id="mins" class="num">23</div>
                                <div id="mins-text" class="text">Phút</div>
                            </div>
                            <div class="col-md-2 ms-auto clock-item">

                                <div id="secs" class="num">57</div>
                                <div id="secs-text" class="text">Giây</div>
                            </div>

                        </div>

                        <div class="row mt-5">
                            <h2>Quý Mão 2023</h2>
      <img class="alignnone size-full wp-image-50" src="assets/images/tet-nguyen-dan.png" alt="Tết Nguyên Đán 2023" width="100%" height="100%"></div>
                    </div>
                    
            </div>

        </div>
    </div>
</div>

<?php
$page_js[] = "assets/js/chart.min.js";
$page_js[] = "assets/js/chartjs-plugin-datalabels@2.js";
$page_js[] = "js/home.js";
?>