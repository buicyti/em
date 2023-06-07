<?php
	require '../assets/phpexcel/vendor/autoload.php';


    if (isset($_POST) && !empty($_FILES['file_up'])) {

    $inputFileType = 'Xlsx';
    $inputFileName = $_FILES["file_up"]["tmp_name"];
    move_uploaded_file($inputFileName,'Excel/aaaaa.xlsx');
    //echo $inputFileName;
    $inputFileName = 'Excel/aaaaa.xlsx';
    $sheetname = 'Sheet1';
    //Create a new Reader of the type defined in $inputFileType
    $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($inputFileType);
    ///  Advise the Reader of which WorkSheets we want to load 
    $reader->setLoadSheetsOnly($sheetname);
    //  Load $inputFileName to a Spreadsheet Object 
    $spreadsheet = $reader->load($inputFileName);

    $d=$spreadsheet->getSheet(0)->toArray();

    $sheetData = $spreadsheet->getActiveSheet()->toArray();

    $i=1;
    $OT = array();
    unset($sheetData[0]);

    foreach ($sheetData as $t) {
        // process element here;
        $OT[] = array('id'=>$t[1], 'name' => $t[2], 'OT150' => $t[9], 'OT200' => $t[10], 'OT200T7' => $t[16], 'OT270' => $t[12], 'OT300' => $t[13], 'OT390' => $t[14]);
        $i++;
    }

    echo json_encode($OT);
    unlink('Excel/aaaaa.xlsx');
}
?>