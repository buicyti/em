<?php
require_once '../core/init.php';
require '../assets/phpexcel/vendor/autoload.php';

if(isset($_POST['load_machine'])){
    if($_POST['load_machine'] == '1'){
        $sql_select_printer = "SELECT _data FROM machines_infomation WHERE _location LIKE '%Printer%'";
        if($db->num_rows($sql_select_printer)){
            $data_info = [];
            foreach($db->fetch_assoc($sql_select_printer, 0) as $fore){
                $data_info[] = json_decode($fore['_data'], true);
            }
            echo json_encode($data_info);
        }
    }
}

if (isset($_POST['phpOffice'])){
    if ($_POST['phpOffice'] == 'import-infomation' && !empty($_FILES['file'])){
        $duoi = explode('.', $_FILES['file']['name']); // tách chuỗi khi gặp dấu .
        $duoi = $duoi[(count($duoi) - 1)]; //lấy ra đuôi file
        //kiểm tra định dạng file
        if ($duoi === 'xlsx' || $duoi === 'xlsm' || $duoi === 'xls'){
            if (move_uploaded_file($_FILES['file']['tmp_name'], 'Excel/tam.xlsx')){
                // Nếu thành công
                $inputFileType = 'Xlsx';
                $inputFileName = 'Excel/tam.xlsx';
                $sheetname = 'Printer';

                $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($inputFileType);
                $reader->setLoadSheetsOnly($sheetname);
                $spreadsheet = $reader->load($inputFileName);
                //$d = $spreadsheet->getSheet(0)->toArray();
                $sheetData = $spreadsheet->getActiveSheet()->toArray();
                if($_POST['machine'] == '1'){
                    unset($sheetData[0], $sheetData[1], $sheetData[2]); //xoas duwx lieeuj 3 dongf ddaauf
                    $line = '0';
                    foreach($sheetData as $sh){
                        if($sh[0] != null) $line = $sh[0];
                        $_id_machine = preg_replace('/\s+|\-|\//', '', $sh[2].$sh[3].$sh[4]);
                        $_location = preg_replace('/\s+|\-|\//', '', $line . $sh[1]);
    
                        $sql_check_info = "SELECT id_machine FROM machines_infomation WHERE id_machine='$_id_machine'";
                        if($db->num_rows($sql_check_info)){
                            $sql_update_info = "UPDATE machines_infomation SET _location='$_location', _data=JSON_SET(_data, '$.Line', '$line', '$.Machine', '$sh[1]', '$.Asset', '$sh[2]', '$.Model', '$sh[3]', '$.Serial', '$sh[4]', '$.Version MMI', '$sh[5]', '$.Stencil Size', '$sh[6]', '$.Pass Lane', '$sh[7]', '$.Base Block Height', '$sh[8]', '$.SQZ Size', '$sh[9]', '$.Auto Solder', '$sh[10]', '$.Fix Lane', '$sh[11]', '$.Mfg Date', '$sh[12]', '$.Maker', '$sh[13]', '$.CPU', '$sh[14]', '$.RAM', '$sh[15]', '$.Hard Type', '$sh[16]', '$.Windows', '$sh[17]', '$.Service Pack', '$sh[18]', '$.IP', '$sh[19]', '$.MAC', '$sh[20]', '$.PCB Size', '$sh[21]', '$.Machine Size', '$sh[22]', '$.Power', '$sh[23]') WHERE id_machine='$_id_machine'";
                            $db->query($sql_update_info); //thêm vào cơ sở dữ liệu
                        }
                        else{
                            $sql_add_info = "INSERT INTO machines_infomation(id_machine, _location, _data) VALUES('$_id_machine', '$_location', JSON_INSERT('{}', '$.Line', '$line', '$.Machine', '$sh[1]', '$.Asset', '$sh[2]', '$.Model', '$sh[3]', '$.Serial', '$sh[4]', '$.Version MMI', '$sh[5]', '$.Stencil Size', '$sh[6]', '$.Pass Lane', '$sh[7]', '$.Base Block Height', '$sh[8]', '$.SQZ Size', '$sh[9]', '$.Auto Solder', '$sh[10]', '$.Fix Lane', '$sh[11]', '$.Mfg Date', '$sh[12]', '$.Maker', '$sh[13]', '$.CPU', '$sh[14]', '$.RAM', '$sh[15]', '$.Hard Type', '$sh[16]', '$.Windows', '$sh[17]', '$.Service Pack', '$sh[18]', '$.IP', '$sh[19]', '$.MAC', '$sh[20]', '$.PCB Size', '$sh[21]', '$.Machine Size', '$sh[22]', '$.Power', '$sh[23]'))";
                            $db->query($sql_add_info); //thêm vào cơ sở dữ liệu
                        }
                        
                    }
                }
                
                $db->close();
                unlink('Excel/tam.xlsx');
                echo json_encode($sheetData);
            }
        }
    }
}



?>