
<?php
	require_once '../core/init.php';
	//Require tập tin autoload.php để tự động nạp thư viện PhpSpreadsheet
	require '../assets/phpexcel/vendor/autoload.php';
	//Khai báo sử dụng các thư viện cần thiết

	
	use PhpOffice\PhpSpreadsheet\Spreadsheet;
	use PhpOffice\PhpSpreadsheet\IOFactory;
	use PhpOffice\PhpSpreadsheet\Style\Alignment;
	use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
	use PhpOffice\PhpSpreadsheet\Style\Border;
	use PhpOffice\PhpSpreadsheet\Style\Color;
	use PhpOffice\PhpSpreadsheet\Style\Fill;
	use PhpOffice\PhpSpreadsheet\Chart\Chart;
	use PhpOffice\PhpSpreadsheet\Chart\Legend as ChartLegend;
	use PhpOffice\PhpSpreadsheet\Chart\PlotArea;
	use PhpOffice\PhpSpreadsheet\Chart\Title;
	use PhpOffice\PhpSpreadsheet\Chart\DataSeries;
	use PhpOffice\PhpSpreadsheet\Chart\DataSeriesValues;
	
	use PhpOffice\PhpSpreadsheet\Chart\Layout;

 	
if (isset($_POST['line_selected']))
{
	//$date_current = $db->fetch_assoc('SELECT CURRENT_TIMESTAMP()',1)['CURRENT_TIMESTAMP()'];// lấy thời gian của server làm thời gian mặc định
 		if(isset($_POST['line_selected'])) $id_line = $_POST['line_selected'];
 		if(isset($_POST['endtime'])) $endtime = $_POST['endtime'] . ' 23:59:59';
 		if(isset($_POST['starttime'])) $starttime = $_POST['starttime'] . ' 00:00:00';
 		if(isset($_POST['sapxep'])) $sapxep = $_POST['sapxep'];
 		
 		
 	if($sapxep == 1){ //tải dữ liệu phân biệt theo line
		$sql_get_TH_log = "SELECT * FROM monitor_current_time_3day WHERE vi_tri='Xưởng' ORDER BY stt ASC";
		$data_log_TH = null;
		if ($db->num_rows($sql_get_TH_log)) {
			foreach ($db->fetch_assoc($sql_get_TH_log, 0) as $key => $TH_log) {
				$dulieu = json_decode($TH_log["du_lieu"], true);
				foreach ($id_line as $line) {
					if (isset($dulieu[$line])) {
						$data_log_TH[$line]['Temp'][] = $dulieu[$line]["Temp"];
						$data_log_TH[$line]['Humi'][] = $dulieu[$line]["Humi"];
						$data_log_TH[$line]['CO2'][] = $dulieu[$line]["eCO2"];
						$data_log_TH[$line]['TVOC'][] = $dulieu[$line]["TVOC"];
					} else {
						$data_log_TH[$line]['Temp'][] = 0;
						$data_log_TH[$line]['Humi'][] = 0;
						$data_log_TH[$line]['CO2'][] = 0;
						$data_log_TH[$line]['TVOC'][] = 0;
					}
					$data_log_TH[$line]['Time_update'][] = $TH_log['thoi_gian'];
				}
				$dulieu = null;
			}
			$data_log_TH['Current time'] = $date_current;
		}
		echo json_encode($data_log_TH);
 	}
 	else if($sapxep == 2){ //tải dũư liệu phân biệt nhiệt độ và độ 

		$sql_get_TH_log = "SELECT * FROM monitor_current_time_log WHERE vi_tri='Xưởng' AND ( thoi_gian BETWEEN '" . date('Y-m-d H:i:s', strtotime(str_replace('/', '-', $starttime))) . "' AND '" . date('Y-m-d H:i:s', strtotime(str_replace('/', '-', $endtime))) . "') ORDER BY stt ASC"; // lấy dữ liệu theo ngày
		if ($db->num_rows($sql_get_TH_log)) {
			foreach ($db->fetch_assoc($sql_get_TH_log, 0) as $key => $TH_log) {
				$dulieu = json_decode($TH_log["du_lieu"], true);
				foreach ($id_line as $line) {
					if (isset($dulieu[$line])) {
						$data_log_TH[$line]['Temp'][] = $dulieu[$line]["Temp"];
						$data_log_TH[$line]['Humi'][] = $dulieu[$line]["Humi"];
						$data_log_TH[$line]['CO2'][] = $dulieu[$line]["eCO2"];
						$data_log_TH[$line]['TVOC'][] = $dulieu[$line]["TVOC"];
					}
					else{
						$data_log_TH['Temp'][$line][] = 0;
						$data_log_TH['Humi'][$line][] = 0;
						$data_log_TH['CO2'][$line][] = 0;
						$data_log_TH['TVOC'][$line][] = 0;
					}

					$data_log_TH['Time_update'][$line][] = $TH_log['thoi_gian'];
				}
			}
			echo json_encode($data_log_TH);
		}
		else echo '';
 	}

	 else if($sapxep == 3){
		$spreadsheet = new Spreadsheet();
		//$spreadsheet->getSheetByName('TempHumi');
		$spreadsheet -> getDefaultStyle()
			-> getFont()
			-> setName('Times New Roman')
			-> setSize(11);
			
		$sheet = $spreadsheet->getActiveSheet()->setTitle('Worksheet'); //tạo font cho file Excel

		$sheet -> setCellValue('B2', "THEO DÕI NHIỆT ĐỘ - ĐỘ ẨM XƯỞNG");
		$sheet -> mergeCells('B2:F2');
		$sheet -> getStyle('B2') -> getFont() -> setSize(20);
		$sheet -> getStyle('B2:F3') -> getFont() -> setBold(true);

		$sheet -> getColumnDimension('A') -> setWidth(5);
		$sheet -> getColumnDimension('B') -> setWidth(10);
		$sheet -> getColumnDimension('C') -> setWidth(18);
		$sheet -> getColumnDimension('D') -> setWidth(12);
		$sheet -> getColumnDimension('E') -> setWidth(12);
		$sheet -> getColumnDimension('F') -> setWidth(25);

		$sheet -> getRowDimension(2) -> setRowHeight(50);
		$sheet -> getRowDimension(3) -> setRowHeight(30);

		$sheet 	-> setCellValue('B3', 'Thứ tự')
				-> setCellValue('C3', 'Line')
				-> setCellValue('D3', 'Nhiệt độ')
				-> setCellValue('E3', 'Độ ẩm')
				-> setCellValue('F3', 'Thời gian');
		
		$sheet	-> setCellValue('H3','Tiêu chuẩn')
				-> setCellValue('H4','Nhiệt độ: 18°C ~ 28°C')
				-> setCellValue('H5','Độ ẩm: 40% ~ 60%');

		$i=4;
		//lấy dữ liệu
		$sql_get_TH_log = "SELECT * FROM monitor_current_time_log WHERE vi_tri='Xưởng' AND ( thoi_gian BETWEEN '" . date('Y-m-d H:i:s', strtotime(str_replace('/', '-', $starttime))) . "' AND '" . date('Y-m-d H:i:s', strtotime(str_replace('/', '-', $endtime))) . "') ORDER BY stt ASC"; // lấy dữ liệu theo ngày
		if ($db->num_rows($sql_get_TH_log)) {
			foreach ($db->fetch_assoc($sql_get_TH_log, 0) as $key => $TH_log) {
				$dulieu = json_decode($TH_log["du_lieu"], true);
				foreach ($id_line as $line) {
					if (isset($dulieu[$line])) {

						$sheet->setCellValue('B'.$i, $i-3);
						$sheet->setCellValue('C'.$i, $line);
						$sheet->setCellValue('D'.$i, $dulieu[$line]["Temp"]);
						if ($dulieu[$line]["Temp"] > 28 || $dulieu[$line]["Temp"]  < 18){
							$sheet -> getStyle('D'.$i) -> getFill() -> setFillType(Fill::FILL_SOLID) -> getStartColor() -> setARGB('FF0000');
						}
						$sheet->setCellValue('E'.$i, $dulieu[$line]["Humi"]);
						if ($dulieu[$line]["Humi"] > 60 || $dulieu[$line]["Humi"] < 40){
							$sheet -> getStyle('E'.$i) -> getFill() -> setFillType(Fill::FILL_SOLID) -> getStartColor() -> setARGB('FF0000');
						}
						$sheet->setCellValue('F'.$i, $TH_log['thoi_gian']);
						$i++;
					}
				}
			}
		}
		//tạo đường kẻ
		$sheet ->getStyle('B2:F'.$i-1)
			->getBorders()
			->getAllBorders()
			->setBorderStyle(Border::BORDER_THIN)
			->setColor(new Color('FF000000'));
		//căn chỉnh
		$sheet -> getStyle('B2:F'.$i-1) -> getAlignment() -> setWrapText(true);
		$sheet -> setAutoFilter('B3:F3');
		$sheet -> getStyle('B2:F'.$i-1) -> getAlignment() -> setHorizontal(Alignment:: HORIZONTAL_CENTER);
		$sheet -> getStyle('B2:F'.$i-1) -> getAlignment() -> setVertical(Alignment:: VERTICAL_CENTER);
		
		$dataSeriesLabels = [
			new DataSeriesValues(DataSeriesValues::DATASERIES_TYPE_STRING, 'Worksheet!$D$3', null, 1), //Nhiệt độ
			new DataSeriesValues(DataSeriesValues::DATASERIES_TYPE_STRING, 'Worksheet!$E$3', null, 1), // Độ ẩm
		];
		$xAxisTickValues = [
			new DataSeriesValues(DataSeriesValues::DATASERIES_TYPE_STRING, 'Worksheet!$F$4:$F$'.$i-1, null), // thời gian
			new DataSeriesValues(DataSeriesValues::DATASERIES_TYPE_STRING, 'Worksheet!$F$4:$F$'.$i-1, null), // thời gian
		];
		$dataSeriesValues = [
			new DataSeriesValues(DataSeriesValues::DATASERIES_TYPE_NUMBER, 'Worksheet!$D$4:$D$'.$i-1, null),
			new DataSeriesValues(DataSeriesValues::DATASERIES_TYPE_NUMBER, 'Worksheet!$E$4:$E$'.$i-1, null),
		];
		$series = new DataSeries(
			DataSeries::TYPE_LINECHART, // plotType
			DataSeries::GROUPING_STANDARD, // plotGrouping
			range(0, count($dataSeriesValues) - 1), // plotOrder
			$dataSeriesLabels, // plotLabel
			$xAxisTickValues, // plotCategory
			$dataSeriesValues        // plotValues
		);

		//gián giá trị cạnh biểu đồ
		/*$layout = new Layout();
		$layout->setShowVal(true);
		$layout->setShowPercent(true);*/

		// Set the series in the plot area
		$plotArea = new PlotArea(null, [$series]); //thay null bằng $layout
		// Set the chart legend
		$legend = new ChartLegend(ChartLegend::POSITION_TOPRIGHT, null, false);

		$title = new Title('BIỂU ĐỒ NHIỆT ĐỘ - ĐỘ ẨM XƯỞNG', null);
		$yAxisLabel = new Title('');

		// Create the chart
		$chart = new Chart(
			'chart1', // name
			$title, // title
			$legend, // legend
			$plotArea, // plotArea
			true, // plotVisibleOnly
			DataSeries::EMPTY_AS_GAP, // displayBlanksAs
			null, // xAxisLabel
			$yAxisLabel // yAxisLabel
		);

		// Set the position where the chart should appear in the worksheet
		$chart -> setTopLeftPosition('H7');
		$chart -> setBottomRightPosition('Y30');
		
		// Add the chart to the worksheet
		$sheet->addChart($chart);
		
		$writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
		$writer->setIncludeCharts(true);
		$callStartTime = microtime(true);
		$filename = "Excel/NhietdoVaDoamxuong " . date('dmY',strtotime(str_replace('/', '-', $starttime)))." - " . date('dmY',strtotime(str_replace('/', '-', $endtime))) . ".xlsx";
		$writer->save($filename);
		echo $filename;

		// đm test thì đc màaaaaaaaaaaaaaaaaaaaaaaaaaa
		//$writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
		//ob_end_clean();
        //header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        //header('Content-Disposition: attachment; filename="'. urlencode($filename).'"');
		//header('Cache-Control: max-age=0');
        //$writer->save('php://output') ;

		/* Here there will be some code where you create $spreadsheet 

		// redirect output to client browser
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="myfile.xlsx"');
		header('Cache-Control: max-age=0');

		$writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
		$writer->save('php://output');*/
	 }
	 elseif($sapxep = 'current'){
		$sql_get_current_data = "SELECT * FROM `monitor_current_time` WHERE `vi_tri`='Xưởng'";
		$data_log_TH = null;
		if($db->num_rows($sql_get_current_data)){
			foreach($db->fetch_assoc($sql_get_current_data, 0) as $key => $current_data){
				$dulieu = json_decode($current_data['du_lieu'], true);
				$data_log_TH[$current_data['ten_line']] = array('Temp' => $dulieu["Temp"], 'Humi' =>$dulieu["Humi"], 'CO2' => $dulieu['eCO2'], 'TVOC' => $dulieu['TVOC'], 'Lastmodify' => $current_data['thoi_gian']);

			}
			$data_log_TH['Current time'] = $date_current;
		}
		echo json_encode($data_log_TH);
	 }
}


/* if (isset($_POST['alertify'])){
	$alert = [];
 	$id_line = $_POST['alertify'];
	foreach ($id_line as $idd_line) {
		$a = '';
		$sql_get_TH_new = "SELECT * FROM monitor_nhietdo_doam_xuong WHERE Line_id = '$idd_line' ORDER BY id DESC"; // lấy dữ liệu mới nhất
		if ($db->num_rows($sql_get_TH_new)){
			$data_TH = $db->fetch_assoc($sql_get_TH_new, 1);
			if ($data_TH['Temp'] > 28 || $data_TH['Temp'] < 18) $a .= 'Nhiệt độ nằm ngoài phạm vi quy định: ' . $data_TH["Temp"] . '°C<br/>';			
			if ($data_TH['Humi'] > 60 || $data_TH['Humi'] < 40) $a .= 'Độ ẩm nằm ngoài phạm vi quy định: ' . $data_TH["Humi"] . '%<br/>';
			if (floor(abs(strtotime($date_current) - strtotime($data_TH['TimeStamp'])) / 60) > 60) $a .= 'Mất kêt nối từ ' . date('Y-m-d H:i', strtotime($data_TH['TimeStamp'])) . '<br/>';
		}
		if(strlen($a) > 10) $alert[$idd_line] = $a;
	 }
	 echo json_encode($alert);
} */

?>


