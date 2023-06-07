
<?php
require_once '../core/init.php';
//$id_line = trim(htmlspecialchars(addslashes($_POST['line_selected'])));

if (isset($_POST['line_selected'])) {
	//$date_current = $db->fetch_assoc('SELECT CURRENT_TIMESTAMP()',1)['CURRENT_TIMESTAMP()'];// lấy thời gian của server làm thời gian mặc định
	$data_log = [];
	$id_line = $_POST['line_selected'];
	$action = $_POST['action'];
	if($action == 'data'){
		foreach($id_line as $line){
			$sql_get_log = "SELECT * FROM monitor_current_time WHERE vi_tri='Reflow' AND ten_line='$line' AND thoi_gian > (NOW() - INTERVAL 15 MINUTE) ORDER BY ten_line ASC";	
			if ($db->num_rows($sql_get_log)) {
				$log = $db->fetch_assoc($sql_get_log, 1);
				$dulieu = json_decode($log["du_lieu"], true);
				$data_log[$log['ten_line']] = array("Maker" => $dulieu["Maker"], "Model" => $dulieu["Model"], "HC2Connect" => $dulieu["HC2Connect"], "Temp" => $dulieu["Temp"], "Humi" => $dulieu["Humi"], "Lastupdate" => $log["thoi_gian"]);
			}
		}
		$data_log['Current time'] = $date_current;
		echo json_encode($data_log);
	}
	elseif($action == 'html'){
		foreach($id_line as $line){
			$sql_get_log = "SELECT * FROM monitor_current_time WHERE vi_tri='Reflow' AND ten_line='$line' ORDER BY ten_line ASC";	
			if ($db->num_rows($sql_get_log)) {
				$log = $db->fetch_assoc($sql_get_log, 1);
				$dulieu = json_decode($log["du_lieu"], true);
				$data_log[$log['ten_line']] = array("Maker" => $dulieu["Maker"], "Model" => $dulieu["Model"]);
			}
			else $data_log[$line] = array("Maker" => "None", "Model" => "None");
		}
		echo json_encode($data_log);
	}

}
?>

<?php
/* 	require_once '../core/init.php';

if (isset($_POST['line_selected']))
{
    $id_line = $_POST['line_selected'];
    foreach ($id_line as $key => $idd_line) {
        $data_rf = array("Temp" => "N/A", "Humi" => "N/A", "mMaker" => "N/A", "mModel" => "N/A", 'HC2Connect' => '0');
		
 			$data_color_T = 'gray';
 			$data_color_H = 'gray';
 			$data_color_L = 'gray';
            $data_color_HC2 = '<span class="gray">Không kết nối</span>';

        $sql_get_data_new = "SELECT * FROM monitor_reflow WHERE mLine = '$idd_line' ORDER BY id DESC"; // lấy dữ liệu mới nhất
        if($db->num_rows($sql_get_data_new)){
            $data_rf = $db->fetch_assoc($sql_get_data_new,1);
            if ($data_rf['Temp'] < 70) $data_color_T = 'green';
				else $data_color_T = 'red';
				if ($data_rf['Humi'] < 20 && $data_rf['Humi'] > 0) $data_color_H = 'green';
				else $data_color_H = 'red';
				if (floor(abs(strtotime($date_current) - strtotime($data_rf['Lastupdate'])) / 60) < 10) {
                    $data_color_L = 'green';
					if($data_rf['HC2Connect'] == 0) $data_color_HC2 = '<span class="red">HC2 mất kết nối</span>';
                    elseif($data_rf['HC2Connect'] == 1) $data_color_HC2 = '<span class="green">HC2 đang kết nối</span>';
                    elseif($data_rf['HC2Connect'] == 2) $data_color_HC2 = ''; //TSM không kết nối HC2
                }
				else {
                    $data_color_L = 'red';
                    if($data_rf['HC2Connect'] == 2) $data_color_HC2 = ''; //TSM không kết nối HC2
					else $data_color_HC2 = '<span class="red">HC2 mất kết nối</span>';
                } 
                
				
				$data_rf['Temp'] = $data_rf['Temp'].' °C';
				$data_rf['Humi'] = $data_rf['Humi'].' %';
        }

        echo '<div class="col">
    			<div class="card border-light mb-3" style="max-height: 600px;">
      			    <div class="card-header">
                      <b class="'.$data_color_L.'">'.$idd_line.'</b>
                    </div>
      			    <div class="card-body bgReflow">
                        <div class="thrf_t">
        			        <span class="thrf_l"><span class="'.$data_color_T.'">'.$data_rf['Temp'].'</span><br/><span class="'.$data_color_H.'">'.$data_rf['Humi'].'</span></span>
                            <span class="thrf_r">'.$data_rf['mMaker'].'<br/>'.$data_rf['mModel'].'</span>
                        </div>
                        <div class="thrf_b">
                            '.$data_color_HC2.'
                        </div>
      			    </div>
    			</div>
  			</div>';
    }
}

//cảnh báo lỗi
if (isset($_POST['alertify'])){
	$alert = [];
 	$id_line = $_POST['alertify'];
	foreach ($id_line as $idd_line) {
		$a = '';
		$sql_get_TH_new = "SELECT * FROM monitor_reflow WHERE mLine = '$idd_line' ORDER BY id DESC"; // lấy dữ liệu mới nhất
		if ($db->num_rows($sql_get_TH_new)){
			$data_TH = $db->fetch_assoc($sql_get_TH_new, 1);
			if ($data_TH['Temp'] > 70 || $data_TH['Temp'] < 0) $a .= 'Nhiệt độ nằm ngoài phạm vi quy định: ' . $data_TH["Temp"] . '°C<br/>';			
			if ($data_TH['Humi'] > 20 || $data_TH['Humi'] < 0) $a .= 'Độ ẩm nằm ngoài phạm vi quy định: ' . $data_TH["Humi"] . '%<br/>';
            if ($data_TH['HC2Connect'] == 0) $a .= 'Mất kết nối HC2<br/>';
			if (floor(abs(strtotime($date_current) - strtotime($data_TH['Lastupdate'])) / 60) > 60) $a .= 'Mất kêt nối từ ' . date('Y-m-d H:i', strtotime($data_TH['Lastupdate'])) . '<br/>';
		}
		if(strlen($a) > 10) $alert[$idd_line] = $a;
	 }
	 echo json_encode($alert);
}
 */
?>