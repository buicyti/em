<link rel="stylesheet" type="text/css" href="assets/DataTables/datatables.min.css">
<style>
    .container-assets{
	background-color: #fff;
    width: calc(100% - 20px);
    height: 100vh;
	margin: 10px;
	margin-bottom: 20px;
	box-shadow: 5px 5px 5px rgb(139, 145, 146);
	border-radius: 10px;
    overflow: auto;
}
.status{
    display: none;
}
</style>

    <div class="col selected-items">
        <div class="d-grid gap-2 d-md-flex mt-2">
            <button class="btn btn-primary" type="button" id="import_excel"><i class="bi bi-arrow-through-heart"></i>  Import</button>
            <!--a class="btn btn-primary" target="popup" onclick="window.open('../html-link.htm','name','width=600,height=400')">Open page in new window</a-->
        </div>
        <div class="row mt-3 hidden" id="form_import">
            <form action="" method="POST" role="form">
                <input class="form-control" id="file" type="file" name="sortpic" required=""/>
                <button id="upload" class="btn btn-primary mt-2">Upload</button>
                <div class="status alert alert-success"></div>
            </form>
        </div>
        <div class="row mt-5">
            <div class="table-responsive" style="max-width: calc(100vw - var(--cui-sidebar-width));">
            <table id="example" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th scope="col">Line</th>
                    <th scope="col">No.</th>
                    <th scope="col">Factory</th>
                    <th scope="col">Asset Base</th>
                    <th scope="col">Asset No</th>
                    <th scope="col">Machine Asset</th>
                    <th scope="col">Machine</th>
                    <th scope="col">Model</th>
                    <th scope="col">Serial No.</th>
                    <th scope="col">Serial Base</th>
                    <th scope="col">Date Production</th>
                    <th scope="col">Power Supply</th>
                    <th scope="col">Size X*Y*Z</th>
                    <th scope="col">Maker</th>
                    <th scope="col">Country of Origin</th>
                    <th scope="col">Weights</th>
                    <th scope="col">Note</th>
                    <th scope="col">Last Update</th>
                </tr>
            </thead>
            <tbody id="tblAsset">
                
            </tbody>
            </table>
        </div>
    </div>
</div>

<?php
$page_js[] = "assets/DataTables/datatables.min.js";
$page_js[] = 'assets/DataTables/dataTables.bootstrap5.min.js';
$page_js[] = 'js/machines-assets.js';
?>