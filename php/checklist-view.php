<?php

require_once '../core/init.php';

if (isset($_POST['checklist_selected'])) {
    $checklist_selected = $_POST['checklist_selected'];
    $month_selected = $_POST['month_selected'];
    $year_selected = $_POST['year_selected'];
    $month_selected = ($month_selected < 10 ? '0' . $month_selected * 1 : $month_selected);
    $sqli = "";
    $data = [];
    if ($checklist_selected == "0") $sqli = "AND (t2.checks='1' OR t2.checks='3')";
    else if ($checklist_selected == "1") $sqli = "AND (t2.checks='2' OR t2.checks='3')";

    $sql_load_data = "SELECT t1.id_employee, name_employee, nhom, ca_kip FROM acc_infomation t1, checklist_strap_card_id t2 WHERE t1.id_employee=t2.id_employee AND t1.trang_thai='Working' $sqli";
    if ($db->num_rows($sql_load_data)) {
        foreach ($db->fetch_assoc($sql_load_data, 0) as $data_employee) {
            $emp = $data_employee["id_employee"];
            //lấy dữ liệu của tháng
            $sql_get_data_check = "SELECT du_lieu FROM checklist_strap_data WHERE id_employee='$emp' AND nam_thang='$year_selected $month_selected' AND che_do='$checklist_selected'";
            if ($db->num_rows($sql_get_data_check)) {
                $data_check = $db->fetch_assoc($sql_get_data_check, 1);
                $data[] = array_merge(
                    array("id_emp" => $emp, "name_emp" => $data_employee['name_employee'], "nhom" => $data_employee['nhom'], "ca_kip" => $data_employee['ca_kip']),
                    json_decode($data_check['du_lieu'], true)
                );
            }
        }
    }
    echo json_encode($data);
    $db->close();
}


require '../assets/phpexcel/vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Color;

if (isset($_POST['data_select'])) {
    if ($_POST['data_select'] == 'exportE') {
        $htmlString = $_POST['datastring'];
        $htmlString = substr($htmlString, 0, strlen($htmlString) - 4077);
        $count_str = substr_count($htmlString, '<tr>');

        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Html();

        $spreadsheet = $reader->loadFromString($htmlString);

        $spreadsheet->getDefaultStyle()
            ->getFont()
            ->setName('Times New Roman')
            ->setSize(11);

        $sheet = $spreadsheet->getActiveSheet()->setTitle('Check'); //tạo font cho file Excel
        $sheet->getStyle('A1:AH2')->getFont()->setBold(true);
        $sheet->getColumnDimension('A')->setWidth(5);
        $sheet->getColumnDimension('B')->setWidth(15);
        $sheet->getColumnDimension('C')->setWidth(30);
        $sheet->getColumnDimension('D')->setWidth(6);
        $sheet->getColumnDimension('E')->setWidth(6);
        $sheet->getColumnDimension('F')->setWidth(6);
        $sheet->getColumnDimension('G')->setWidth(6);
        $sheet->getColumnDimension('H')->setWidth(6);
        $sheet->getColumnDimension('I')->setWidth(6);
        $sheet->getColumnDimension('J')->setWidth(6);
        $sheet->getColumnDimension('K')->setWidth(6);
        $sheet->getColumnDimension('L')->setWidth(6);
        $sheet->getColumnDimension('M')->setWidth(6);
        $sheet->getColumnDimension('N')->setWidth(6);
        $sheet->getColumnDimension('O')->setWidth(6);
        $sheet->getColumnDimension('P')->setWidth(6);
        $sheet->getColumnDimension('Q')->setWidth(6);
        $sheet->getColumnDimension('R')->setWidth(6);
        $sheet->getColumnDimension('S')->setWidth(6);
        $sheet->getColumnDimension('T')->setWidth(6);
        $sheet->getColumnDimension('U')->setWidth(6);
        $sheet->getColumnDimension('V')->setWidth(6);
        $sheet->getColumnDimension('W')->setWidth(6);
        $sheet->getColumnDimension('X')->setWidth(6);
        $sheet->getColumnDimension('Y')->setWidth(6);
        $sheet->getColumnDimension('Z')->setWidth(6);
        $sheet->getColumnDimension('AA')->setWidth(6);
        $sheet->getColumnDimension('AB')->setWidth(6);
        $sheet->getColumnDimension('AC')->setWidth(6);
        $sheet->getColumnDimension('AD')->setWidth(6);
        $sheet->getColumnDimension('AE')->setWidth(6);
        $sheet->getColumnDimension('AF')->setWidth(6);
        $sheet->getColumnDimension('AG')->setWidth(6);
        $sheet->getColumnDimension('AH')->setWidth(6);


        $sheet->getRowDimension(1)->setRowHeight(20);
        $sheet->getRowDimension(2)->setRowHeight(20);

        //tạo đường kẻ
        $sheet->getStyle('A1:AH' . $count_str)
            ->getBorders()
            ->getAllBorders()
            ->setBorderStyle(Border::BORDER_THIN)
            ->setColor(new Color('FF000000'));
        //căn chỉnh
        $sheet->getStyle('A1:AH' . $count_str)->getAlignment()->setWrapText(true);
        $sheet->setAutoFilter('A2:AH2');
        $sheet->getStyle('A1:AH' . $count_str)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A1:AH' . $count_str)->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);


        $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save('Excel/DanhSachQuetthe.xlsx');
        echo 'Excel/DanhSachQuetthe.xlsx';
    }
}
