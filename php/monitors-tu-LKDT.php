<?php
require_once '../core/init.php';
//$id_line = trim(htmlspecialchars(addslashes($_POST['line_selected'])));

if (isset($_POST['line_selected'])) {

	//$date_current = $db->fetch_assoc('SELECT CURRENT_TIMESTAMP()',1)['CURRENT_TIMESTAMP()'];// lấy thời gian của server làm thời gian mặc định
	$id_line = $_POST['line_selected'];
	//$id_line = $db->escape($_POST['line_selected']);

		$sql_get_TH_log = "SELECT * FROM monitor_current_time_3day WHERE vi_tri='Tủ LKĐT' ORDER BY stt ASC";
		$data_log_TH = null;
		if ($db->num_rows($sql_get_TH_log)) {
			foreach ($db->fetch_assoc($sql_get_TH_log, 0) as $key => $TH_log) {
				$dulieu = json_decode($TH_log["du_lieu"], true);
				foreach ($id_line as $line) {
					if (isset($dulieu[$line])) {
						$data_log_TH[$line]['Temp'][] = $dulieu[$line]["Temp"];
						$data_log_TH[$line]['Humi'][] = $dulieu[$line]["Humi"];
					} else {
						$data_log_TH[$line]['Temp'][] = 0;
						$data_log_TH[$line]['Humi'][] = 0;
					}
					$data_log_TH[$line]['Time_update'][] = $TH_log['thoi_gian'];
				}
				$dulieu = null;
			}
		}
		$data_log_TH['Current time'] = $date_current;
		echo json_encode($data_log_TH);
	
}
