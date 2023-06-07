<?php
require_once '../core/init.php';
require '../assets/phpexcel/vendor/autoload.php';
//Khai báo sử dụng các thư viện cần thiết


use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Color;

if (isset($_POST['data_select'])) { // dùng.......

    if ($_POST['data_select'] == 'dsnv') {
        $sql_load_data = "SELECT t1.id_employee, name_employee, nhom, ca_kip, checks FROM  acc_infomation t1, checklist_strap_card_id t2 WHERE t1.id_employee=t2.id_employee AND t1.trang_thai='Working'";
        if ($db->num_rows($sql_load_data)) {
            foreach ($db->fetch_assoc($sql_load_data, 0) as $data_load) {
                if ($data_load['checks'] == 0) {
                    $shoe = "N";
                    $wrist = "N";
                }
                if ($data_load['checks'] == 1) {
                    $shoe = "Y";
                    $wrist = "N";
                }
                if ($data_load['checks'] == 2) {
                    $shoe = "N";
                    $wrist = "Y";
                }
                if ($data_load['checks'] == 3) {
                    $shoe = "Y";
                    $wrist = "Y";
                }
                $data[] = array(
                    'id_employee' => $data_load['id_employee'], 'name_employee' => $data_load['name_employee'],
                    'nhom' => $data_load['nhom'], 'ca_kip' => $data_load['ca_kip'], 'shoe' => $shoe, 'wrist' => $wrist
                );
            }
            echo json_encode($data);
        }
    } elseif ($_POST['data_select'] == 'add_data_absent') { // thông tin nhân viên trên modal
        $du_lieu = array('danger', '');
        $du_lieu[0] = 'info';
        $d_absent = preg_split("/\r\n|\n|\r/", trim($_POST['data'], "\n"));

        $_day = date('d', strtotime($date_current));
        $_month = date('m', strtotime($date_current));
        $_year = date('Y', strtotime($date_current));

        foreach ($d_absent as $kay => $_absent) {
            $d_ab = preg_split("/\t/", $_absent);

            if ($d_ab[2] == "OK" || $d_ab[2] == "NG") {
                $du_lieu[1] .= $d_ab[0] . " ra máy đo đê! Đừng có mà lươn";
            } else {
                //tìm người đang làm việc và có trong danh sách kiểm tra
                $sql_get_employee_absent = "SELECT checks FROM acc_infomation t1, checklist_strap_card_id t2 WHERE t1.id_employee=t2.id_employee AND t1.trang_thai='Working' AND t2.checks != '0' AND t1.id_employee = '$d_ab[0]'";
                if ($db->num_rows($sql_get_employee_absent)) {
                    $checks = $db->fetch_assoc($sql_get_employee_absent, 1)['checks'];
                    if ($checks == 1 || $checks == 3) {
                        $sql_check_data = "SELECT * FROM checklist_strap_data WHERE id_employee='$d_ab[0]' AND nam_thang='$_year $_month' AND che_do='0'"; //kiểm tra dữ liệu có hay chưa
                        if ($db->num_rows($sql_check_data)) $sql_add_absent_data = "UPDATE `checklist_strap_data` SET du_lieu=JSON_SET(du_lieu, '$.d$_day','$d_ab[2]') WHERE id_employee='$d_ab[0]' AND nam_thang='$_year $_month' AND che_do='0'";
                        else $sql_add_absent_data = "INSERT INTO checklist_strap_data(id_employee, nam_thang, che_do, du_lieu) VALUES ('$d_ab[0]', '$_year $_month', '0', JSON_INSERT('{}','$.d$_day','$d_ab[2]'))";
                        $db->query($sql_add_absent_data);
                        $du_lieu[1] .= $d_ab[0] . $d_ab[1] . " thêm dữ liệu thành công";
                    }
                    if ($checks == 2 || $checks == 3) {
                        $sql_check_data = "SELECT * FROM checklist_strap_data WHERE id_employee='$d_ab[0]' AND nam_thang='$_year $_month' AND che_do='1'"; //kiểm tra dữ liệu có hay chưa
                        if ($db->num_rows($sql_check_data)) $sql_add_absent_data = "UPDATE `checklist_strap_data` SET du_lieu=JSON_SET(du_lieu, '$.d$_day','$d_ab[2]') WHERE id_employee='$d_ab[0]' AND nam_thang='$_year $_month' AND che_do='1'";
                        else $sql_add_absent_data = "INSERT INTO checklist_strap_data(id_employee, nam_thang, che_do, du_lieu) VALUES ('$d_ab[0]', '$_year $_month', '1', JSON_INSERT('{}','$.d$_day','$d_ab[2]'))";
                        $db->query($sql_add_absent_data);
                        $du_lieu[1] .= $d_ab[0] . $d_ab[1] . " thêm dữ liệu thành công";
                    }
                } else {
                    $du_lieu[1] .= $d_ab[0] . $d_ab[1] . " không có trong danh sách kiểm tra Dép hay Wrist Strap";
                }
            }
        }
        echo json_encode($du_lieu);
    } elseif ($_POST['data_select'] == 'list_absent') {
        $du_lieu = [];
        $_day = date('d', strtotime($date_current));
        $_month = date('m', strtotime($date_current));
        $_year = date('Y', strtotime($date_current));
        $sql_load_data = "SELECT t1.id_employee, name_employee, nhom, ca_kip, checks FROM acc_infomation t1, checklist_strap_card_id t2 WHERE t1.id_employee=t2.id_employee AND t1.trang_thai='Working' AND t2.checks!='0'";
        if ($db->num_rows($sql_load_data)) {
            foreach ($db->fetch_assoc($sql_load_data, 0) as $list_employee) {
                $emp_id = $list_employee['id_employee'];
                $_check = $list_employee['checks'];
                $list_ab = ["OK", "P", "UL", "US", "AUL"];


                if ($_check == 1 || $_check == 3) {
                    foreach ($list_ab as $k => $ab) {
                        $ab = '{"d' . $_day . '": "' . $ab . '"}';
                        $sql_check_data[$k] = "SELECT JSON_CONTAINS((SELECT du_lieu FROM checklist_strap_data WHERE id_employee='$emp_id' AND nam_thang='$_year $_month' AND che_do='0'), '$ab') AS Result";
                    }

                    if ($db->fetch_assoc($sql_check_data[0], 1)['Result'] != '1' && $db->fetch_assoc($sql_check_data[1], 1)['Result'] != '1' && $db->fetch_assoc($sql_check_data[2], 1)['Result'] != '1' &&  $db->fetch_assoc($sql_check_data[3], 1)['Result'] != '1' && $db->fetch_assoc($sql_check_data[4], 1)['Result'] != '1') {
                        $du_lieu[] = array('emp_id' => $emp_id, 'emp_name' => $list_employee['name_employee'], 'nhom' => $list_employee['nhom'], 'ca' => $list_employee['ca_kip'], 'che_do' => 'Dép');
                    }
                }
                if ($_check == 2 || $_check == 3) {
                    foreach ($list_ab as $k => $ab) {
                        $ab = '{"d' . $_day . '": "' . $ab . '"}';
                        $sql_check_data[$k] = "SELECT JSON_CONTAINS((SELECT du_lieu FROM checklist_strap_data WHERE id_employee='$emp_id' AND nam_thang='$_year $_month' AND che_do='1'), '$ab') AS Result";
                    }
                    if ($db->fetch_assoc($sql_check_data[0], 1)['Result'] != '1' && $db->fetch_assoc($sql_check_data[1], 1)['Result'] != '1' && $db->fetch_assoc($sql_check_data[2], 1)['Result'] != '1' && $db->fetch_assoc($sql_check_data[3], 1)['Result'] != '1' && $db->fetch_assoc($sql_check_data[4], 1)['Result'] != '1') {
                        $du_lieu[] = array('emp_id' => $emp_id, 'emp_name' => $list_employee['name_employee'], 'nhom' => $list_employee['nhom'], 'ca' => $list_employee['ca_kip'], 'che_do' => 'Strap');
                    }
                }
            }
        }
        echo json_encode($du_lieu);
    }
    
    $db->close();
}



//xuất Excel danh sách nhân viên
if (isset($_POST['phpOffice'])) {
    if ($_POST['phpOffice'] == 'export_DSNV') {
        /* $i = 2;
        $group_selected = $_POST['group_selected'];
        $part_selected = $_POST['part_selected'];
        $shift_selected = $_POST['shift_selected'];

        $spreadsheet = new Spreadsheet();
        //$spreadsheet->getSheetByName('TempHumi');
        $spreadsheet->getDefaultStyle()
            ->getFont()
            ->setName('Times New Roman')
            ->setSize(11);

        $sheet = $spreadsheet->getActiveSheet()->setTitle('DSNV'); //tạo font cho file Excel

        $sheet->setCellValue('A1', "DANH SÁCH NHÂN VIÊN");
        $sheet->mergeCells('A1:F1');
        $sheet->getStyle('A1')->getFont()->setSize(20);
        $sheet->getStyle('A1:F2')->getFont()->setBold(true);

        $sheet->getColumnDimension('A')->setWidth(5);
        $sheet->getColumnDimension('B')->setWidth(15);
        $sheet->getColumnDimension('C')->setWidth(30);
        $sheet->getColumnDimension('D')->setWidth(12);
        $sheet->getColumnDimension('E')->setWidth(12);
        $sheet->getColumnDimension('F')->setWidth(12);

        $sheet->getRowDimension(1)->setRowHeight(50);
        $sheet->getRowDimension(2)->setRowHeight(30);

        $sheet->setCellValue('A2', 'Thứ tự')
            ->setCellValue('B2', 'Mã nhân viên')
            ->setCellValue('C2', 'Tên nhân viên')
            ->setCellValue('D2', 'Nhóm')
            ->setCellValue('E2', 'Xưởng')
            ->setCellValue('F2', 'Ca');

        foreach ($part_selected as $part_l) {
            foreach ($group_selected as $group_l) {
                foreach ($shift_selected as $shift_l) {

                    $sql_load_data = "SELECT * FROM checklist_strap_employee WHERE part='$part_l' AND factory='$group_l' AND shift='$shift_l'";
                    if ($db->num_rows($sql_load_data)) {
                        foreach ($db->fetch_assoc($sql_load_data, 0) as $data_load) {
                            $i++;
                            $sheet->setCellValue('A' . $i, $i - 2);
                            $sheet->setCellValue('B' . $i, $data_load['id_employee']);
                            $sheet->setCellValue('C' . $i, $data_load['name_employee']);
                            $sheet->setCellValue('D' . $i, $data_load['part']);
                            $sheet->setCellValue('E' . $i, $data_load['factory']);
                            $sheet->setCellValue('F' . $i, $data_load['shift']);
                        }
                    }
                }
            }
        }
        //tạo đường kẻ
        $sheet->getStyle('A1:F' . $i)
            ->getBorders()
            ->getAllBorders()
            ->setBorderStyle(Border::BORDER_THIN)
            ->setColor(new Color('FF000000'));
        //căn chỉnh
        $sheet->getStyle('A1:F' . $i)->getAlignment()->setWrapText(true);
        $sheet->setAutoFilter('A2:F2');
        $sheet->getStyle('A1:F' . $i)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A1:F' . $i)->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);


        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->setIncludeCharts(true);
        $callStartTime = microtime(true);
        $filename = "Excel/DSnhanvien.xlsx";
        $writer->save($filename);
        echo $filename; */
    } elseif ($_POST['phpOffice'] == 'import_DSNV' && !empty($_FILES['file'])) {
        // xóa bảng cũ
        $db->query("DELETE FROM checklist_strap_card_id");


        $duoi = explode('.', $_FILES['file']['name']); // tách chuỗi khi gặp dấu .
        $duoi = $duoi[(count($duoi) - 1)]; //lấy ra đuôi file
        //kiểm tra định dạng file
        if ($duoi === 'xlsx' || $duoi === 'xlsm' || $duoi === 'xls') {
            // tiến hành upload
            if (move_uploaded_file($_FILES['file']['tmp_name'], 'Excel/tam.xlsx')) {
                // Nếu thành công
                $inputFileType = 'Xlsx';
                $inputFileName = 'Excel/tam.xlsx';
                $sheetname = 'Sheet1';

                $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($inputFileType);
                $reader->setLoadSheetsOnly($sheetname);
                $spreadsheet = $reader->load($inputFileName);
                $d = $spreadsheet->getSheet(0)->toArray();
                $sheetData = $spreadsheet->getActiveSheet()->toArray();

                unset($sheetData[0], $sheetData[1]); //xoas duwx lieeuj 2 dongf ddaauf
                foreach ($sheetData as $t) {
                    $t1 = 99;
                    if ($t[3] == 'Y' && $t[4] == 'Y') $t1 = 3;
                    elseif ($t[3] == 'Y' && $t[4] == 'N') $t1 = 1;
                    elseif ($t[3] == 'N' && $t[4] == 'Y') $t1 = 2;
                    elseif ($t[3] == 'N' && $t[4] == 'N') $t1 = 0;
                    $sql_add = "INSERT INTO checklist_strap_card_id(id_employee, card_id, checks) VALUES('$t[0]', '$t[2]', '$t1')";
                    $db->query($sql_add); //thêm vào cơ sở dữ liệu
                }

                //lấy dữ liệu file vừa upload
                $data = [];
                $sql_get_list_emp = "SELECT t1.id_employee, name_employee, nhom, ca_kip, checks FROM acc_infomation t1, checklist_strap_card_id t2 WHERE t1.id_employee=t2.id_employee AND t1.trang_thai='Working' AND t2.checks!='0'";
                if($db->num_rows($sql_get_list_emp)){
                    foreach($db->fetch_assoc($sql_get_list_emp, 0) as $data_load){
                        if ($data_load['checks'] == 0) {
                            $shoe = "N";
                            $wrist = "N";
                        }
                        if ($data_load['checks'] == 1) {
                            $shoe = "Y";
                            $wrist = "N";
                        }
                        if ($data_load['checks'] == 2) {
                            $shoe = "N";
                            $wrist = "Y";
                        }
                        if ($data_load['checks'] == 3) {
                            $shoe = "Y";
                            $wrist = "Y";
                        }
                        $data[] = array(
                            'id_employee' => $data_load['id_employee'], 'name_employee' => $data_load['name_employee'],
                            'nhom' => $data_load['nhom'], 'ca_kip' => $data_load['ca_kip'], 'shoe' => $shoe, 'wrist' => $wrist
                        );
                    }
                }
                $db->close();
                unlink('Excel/tam.xlsx');
                echo json_encode(array('alert' => ['success', 'Upload thành công'], 'data' => $data)); //in ra thông báo + tên file
            } else { // nếu không thành công
                echo json_encode(array('alert' => ['danger', 'Lỗi'])); // in ra thông báo
            }
        } else {
            echo json_encode(array('alert' => ['danger', 'Chỉ upload file Excel dạng xlsx, slsm, xls'])); // in ra thông báo
            die('Chỉ upload file Excel dạng xlsx, slsm, xls'); // in ra thông báo
        }
    } elseif ($_POST['phpOffice'] == 'import_absent' && !empty($_FILES['file'])) {
        $duoi = explode('.', $_FILES['file']['name']); // tách chuỗi khi gặp dấu .
        $duoi = $duoi[(count($duoi) - 1)]; //lấy ra đuôi file
        $du_lieu = [];
        //kiểm tra định dạng file
        if ($duoi === 'xlsx' || $duoi === 'xlsm' || $duoi === 'xls') {
            // tiến hành upload
            if (move_uploaded_file($_FILES['file']['tmp_name'], 'Excel/tam.xlsx')) {
                // Nếu thành công
                $inputFileType = 'Xlsx';
                $inputFileName = 'Excel/tam.xlsx';
                $sheetname = 'Sheet1';

                $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($inputFileType);
                $reader->setLoadSheetsOnly($sheetname);
                $spreadsheet = $reader->load($inputFileName);
                $d = $spreadsheet->getSheet(0)->toArray();
                $sheetData = $spreadsheet->getActiveSheet()->toArray();

                unset($sheetData[0], $sheetData[1]); //xoas duwx lieeuj 2 dongf ddaauf
                $du_lieu[0] = "success";
                $du_lieu[1] = "Lấy dữ liệu thành công<br/>";

                $_day = date('d', strtotime($date_current));
                $_month = date('m', strtotime($date_current));
                $_year = date('Y', strtotime($date_current));
                foreach ($sheetData as $t) {
                    if ($t[2] === "OK" || $t[2] === "NG") {
                        $du_lieu[1] .= $t[0] . " ra máy đo đê! Đừng có mà lươn";
                    } else {
                        //tìm người đang làm việc và có trong danh sách kiểm tra
                        $sql_get_employee_absent = "SELECT checks FROM acc_infomation t1, checklist_strap_card_id t2 WHERE t1.id_employee=t2.id_employee AND t1.trang_thai='Working' AND t2.checks != '0' AND t1.id_employee = '$t[0]'";
                        if ($db->num_rows($sql_get_employee_absent)) {
                            $checks = $db->fetch_assoc($sql_get_employee_absent, 1)['checks'];
                            if ($checks == 1 || $checks == 3) {
                                $sql_check_data = "SELECT * FROM checklist_strap_data WHERE id_employee='$t[0]' AND nam_thang='$_year $_month' AND che_do='0'"; //kiểm tra dữ liệu có hay chưa
                                if ($db->num_rows($sql_check_data)) $sql_add_absent_data = "UPDATE `checklist_strap_data` SET du_lieu=JSON_SET(du_lieu, '$.d$_day','$t[2]') WHERE id_employee='$t[0]' AND nam_thang='$_year $_month' AND che_do='0'";
                                else $sql_add_absent_data = "INSERT INTO checklist_strap_data(id_employee, nam_thang, che_do, du_lieu) VALUES ('$t[0]', '$_year $_month', '0', JSON_INSERT('{}','$.d$_day','$t[2]'))";
                                $db->query($sql_add_absent_data);
                                $du_lieu[1] .= $t[0] . $t[1] . " thêm dữ liệu thành công";
                            }
                            if ($checks == 2 || $checks == 3) {
                                $sql_check_data = "SELECT * FROM checklist_strap_data WHERE id_employee='$t[0]' AND nam_thang='$_year $_month' AND che_do='1'"; //kiểm tra dữ liệu có hay chưa
                                if ($db->num_rows($sql_check_data)) $sql_add_absent_data = "UPDATE `checklist_strap_data` SET du_lieu=JSON_SET(du_lieu, '$.d$_day','$t[2]') WHERE id_employee='$t[0]' AND nam_thang='$_year $_month' AND che_do='1'";
                                else $sql_add_absent_data = "INSERT INTO checklist_strap_data(id_employee, nam_thang, che_do, du_lieu) VALUES ('$t[0]', '$_year $_month', '1', JSON_INSERT('{}','$.d$_day','$t[2]'))";
                                $db->query($sql_add_absent_data);
                                $du_lieu[1] .= $t[0] . $t[1] . " thêm dữ liệu thành công";
                            }
                        } else {
                            $du_lieu[1] .= $t[0] . $t[1] . " không có trong danh sách kiểm tra Dép hay Wrist Strap";
                        }
                    }
                }
                $db->close();
                unlink('Excel/tam.xlsx');
            } else { // nếu không thành công
                $du_lieu[0] = "danger";
                $du_lieu[1] = "Lỗi dữ liệu";
            }
        } else {
            $du_lieu[0] = "danger";
            $du_lieu[1] = "Chỉ upload file Excel dạng xlsx, slsm, xls";
            die('Chỉ upload file Excel dạng xlsx, slsm, xls'); // in ra thông báo
        }
        echo json_encode($du_lieu);
    }
}
