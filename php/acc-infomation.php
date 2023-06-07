<?php

require_once '../core/init.php';
require '../assets/phpexcel/vendor/autoload.php';
//Khai báo sử dụng các thư viện cần thiết


use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Color;


//xuất Excel danh sách nhân viên
if (isset($_POST['phpOffice'])) {
  if ($_POST['phpOffice'] == 'export_DSNV') {
    $i = 2;
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
    echo $filename;
  } elseif ($_POST['phpOffice'] == 'import_DSNV' && !empty($_FILES['file'])) {
    $sql_check_permission = "SELECT * FROM accounts WHERE user_name='$user'";
    if ($db->num_rows($sql_check_permission)) {
      $data_per = $db->fetch_assoc($sql_check_permission, 1);
      if ($data_per['part'] != 10) {
        echo 'Bạn không đủ quyền để cập nhật!';
      } else {
        

        // xóa bảng
        
              $db->query("DELETE FROM acc_infomation");
            

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
            $i = 2;
            unset($sheetData[0]);


            foreach ($sheetData as $t) {
              $sql_add = "INSERT INTO acc_infomation VALUES($i-1,'$t[0]','$t[1]','$t[2]','$t[3]','$t[4]','$t[5]','$t[6]','$t[7]','$t[8]','$t[9]','$t[10]','$t[11]','$t[12]','$t[13]','$t[14]','$t[15]','$t[16]','$t[17]','$t[18]','$t[19]','$t[20]','$t[21]','$t[22]','$t[23]','$t[24]','$t[25]','$t[26]','$t[27]','$t[28]','$t[29]')";
              $db->query($sql_add); //thêm vào cơ sở dữ liệu
              $i++;
            }
            $db->close();
            unlink('Excel/tam.xlsx');

            echo 'Upload thành công file: ' . $_FILES['file']['name']; //in ra thông báo + tên file
          } else { // nếu không thành công
            echo 'Có lỗi!'; // in ra thông báo
          }
        } else {
          die('Chỉ upload file Excel dạng xlsx, slsm, xls'); // in ra thông báo
        }
      }
    }
  }
}




//load thông tin nhân viên

if (isset($_POST['data_select'])) {

  if ($_POST['data_select'] == 'dsnv') {
    $sql_load_data = "SELECT * FROM acc_infomation";
    if ($db->num_rows($sql_load_data)) {
      echo json_encode($db->fetch_assoc($sql_load_data, 0));
    }
  }
}
