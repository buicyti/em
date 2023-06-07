<link rel="stylesheet" type="text/css" href="assets/css/multi-select.css">

<div class="col-md-6 list-machine">

    <div class="row mb-3">
        <div class="text">Line</div>
        <div class="col-md-3" id="loadline" style="width: 200px"></div>
    </div>
    <div class="row multii">
        <div class="showMachine"></div>
        <div class="listi">
            <i class="bi bi-chevron-double-right" id="selectall"></i>
            <i class="bi bi-chevron-double-left" id="deselectall"></i>
        </div>
        <div class="listbtn">
            <button class="btn btn-success mb-2">Cập nhật</button>
            <button class="btn btn-danger mb-2">Xóa</button>
        </div>
    </div>
</div>


<?php

$page_js[] = "js/line.js";
$page_js[] = "assets/js/jquery.multi-select.js";
$page_js[] = "js/sf-settings.js";
?>

<style>
    .list-machine{
        width: 100%;
        height: calc(100vh - 4rem);
        overflow-y: auto;
    }
    .showMachine {
        width: 400px;
        height: 500px;
    }

    .multii {
        position: relative;
    }

    .multii .listi {
        position: absolute;
        top: 10px;
        left: 215px;
        width: 40px;
        height: 40%;
        padding: auto;
    }
    .multii .listbtn {
        position: absolute;
        top: 10px;
        left: 470px;
        width: 100px;
        height: 70%;
        padding: auto;
    }
    .multii .listbtn button{
        width: 100px;
    }
</style>