<?php
    require_once '../core/init.php';
	require '../assets/phpexcel/vendor/autoload.php';

    if (isset($_POST) && !empty($_FILES['file'])) {
        $duoi = explode('.', $_FILES['file']['name']); // tách chuỗi khi gặp dấu .
        $duoi = $duoi[(count($duoi) - 1)]; //lấy ra đuôi file
        // Kiểm tra xem có phải file ảnh không
        if ($duoi === 'xlsx' || $duoi === 'xlsm' || $duoi === 'xls') {
            // tiến hành upload
            if (move_uploaded_file($_FILES['file']['tmp_name'], 'Excel/tam.xlsx')) {
                // Nếu thành công
                $inputFileType = 'Xlsx';
                $inputFileName = 'Excel/tam.xlsx';
                $sheetname = 'All Line';
                
                $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($inputFileType);
                $reader->setLoadSheetsOnly($sheetname);
                $spreadsheet = $reader->load($inputFileName);
                $d=$spreadsheet->getSheet(0)->toArray();
                $sheetData = $spreadsheet->getActiveSheet()->toArray();
                $i=1;
                //$OT = array();
                unset($sheetData[0]);

                // xóa bảng
                $db->query('DELETE FROM machines_assets');
                foreach ($sheetData as $t) {
                    $sql_add = "INSERT INTO machines_assets(line_id, stt, factory, asset_base, asset_no, machine_asset, machine, model, serial_no, serial_base,
                        datee, power_supply, size_xyz, maker, country_of_origin, weights, note) VALUES('$t[0]','$t[1]','$t[2]','$t[3]','$t[4]','$t[5]','$t[6]','$t[7]',
                        '$t[8]','$t[9]','$t[10]','$t[11]','$t[12]','$t[13]','$t[14]','$t[15]','$t[16]')";
                    $db->query($sql_add); //thêm vào cơ sở dữ liệu
                    $i++;
                }
                $db -> close();
                //echo json_encode($OT);
                unlink('Excel/tam.xlsx');

                echo 'Upload thành công file: ' . $_FILES['file']['name']; //in ra thông báo + tên file
            } else { // nếu không thành công
                echo 'Có lỗi!'; // in ra thông báo
            }
        } else {
            die('Chỉ upload file Excel dạng xlsx, slsm, xls'); // in ra thông báo
        }
    }


    if (isset($_POST['load'])){
        $sql_load_asset = "SELECT * FROM machines_assets";
        if($db -> num_rows($sql_load_asset)){
            foreach($db -> fetch_assoc($sql_load_asset, 0) as $data_assets){
                echo 
                    '<tr> 
                        <td>'. $data_assets["line_id"].'</td>
                        <td>'. $data_assets["stt"].'</td>
                        <td>'. $data_assets["factory"].'</td>
                        <td>'. $data_assets["asset_base"].'</td>
                        <td>'. $data_assets["asset_no"].'</td>
                        <td>'. $data_assets["machine_asset"].'</td>
                        <td>'. $data_assets["machine"].'</td>
                        <td>'. $data_assets["model"].'</td>
                        <td>'. $data_assets["serial_no"].'</td>
                        <td>'. $data_assets["serial_base"].'</td>
                        <td>'. $data_assets["datee"].'</td>
                        <td>'. $data_assets["power_supply"].'</td>
                        <td>'. $data_assets["size_xyz"].'</td>
                        <td>'. $data_assets["maker"].'</td>
                        <td>'. $data_assets["country_of_origin"].'</td>
                        <td>'. $data_assets["weights"].'</td>
                        <td>'. $data_assets["note"].'</td>
                        <td>'. $data_assets["last_update"].'</td>
                    </tr>';
            }
        }
    }
?>
