<?php
	require_once '../core/init.php';
	//$id_line = trim(htmlspecialchars(addslashes($_POST['line_selected'])));
 	
if (isset($_POST['line_selected']))
{
    $id_line = $_POST['line_selected'];
    $stt = 0;
    //$data_printer[] = null;
    foreach ($id_line as $idd_line) {
        for($i = 1; $i <=2;$i++){
            $sql_get_data_printer = "SELECT * FROM monitor_current_time WHERE vi_tri='Printer $i' AND ten_line='$idd_line'";// OR vi_tri='Printer 2'
            if($db->num_rows($sql_get_data_printer)){
                $dulieu = $db->fetch_assoc($sql_get_data_printer, 1);
                $decode_dulieu = json_decode($dulieu['du_lieu'], true);
                /* $data_printer[] = array('STT' => $stt, 'Lines' => $dulieu['ten_line'], 'Machines' => $dulieu['vi_tri'], 'Model' => $decode_dulieu['Common'],
                    'CYCLE_TIME_MEAN' => $decode_dulieu['Machine Status']['CYCLE_TIME_MEAN'], 'CYCLE_TIME' => $decode_dulieu['Machine Status']['CYCLE_TIME'], 'PCB_TEMP' => $decode_dulieu['Machine Status']['PCB_TEMP'], 'MASK_TEMP' => $decode_dulieu['Machine Status']['MASK_TEMP'], 'HUMIDITY' => $decode_dulieu['Machine Status']['HUMIDITY'], 'MASK_VACUUM_SPEED' => $decode_dulieu['Machine Status']['MASK_VACUUM_SPEED'],
                    'VACUUM_FORCE_MAX' => $decode_dulieu['Product State']['VACUUM_FORCE_MAX'], 'PRINT_FORCE_MIN' => $decode_dulieu['Product State']['PRINT_FORCE_MIN'], 'PRINT_FORCE_MAX' => $decode_dulieu['Product State']['PRINT_FORCE_MAX'], 'MASK_PCB_X_DISTANCE' => $decode_dulieu['Product State']['MASK_PCB_X_DISTANCE'], 'MASK_PCB_Y_DISTANCE' => $decode_dulieu['Product State']['MASK_PCB_Y_DISTANCE'], 'MASK_PCB_SHRINKAGE_RATIO' => $decode_dulieu['Product State']['MASK_PCB_SHRINKAGE_RATIO'], 'MASK_PCB_X_DISTANCE_AVG' => $decode_dulieu['Product State']['MASK_PCB_X_DISTANCE_AVG'], 'MASK_PCB_Y_DISTANCE_AVG' => $decode_dulieu['Product State']['MASK_PCB_Y_DISTANCE_AVG'], 'MASK_PCB_SHRINKAGE_RATIO_AVG' => $decode_dulieu['Product State']['MASK_PCB_SHRINKAGE_RATIO_AVG'] ); */
                $data_printer[$stt]['STT'] = $stt + 1;
                if(isset($dulieu['ten_line'])) $data_printer[$stt]['Lines'] = $dulieu['ten_line'];
                else $data_printer[$stt]['Lines'] = 'None';
                if(isset($dulieu['vi_tri'])) $data_printer[$stt]['Machines'] = $dulieu['vi_tri'];
                else $data_printer[$stt]['Machines'] = 'None';
                //
                if(isset($decode_dulieu['Vaccuum block']['Value'])) $data_printer[$stt]['Value'] = $decode_dulieu['Vaccuum block']['Value'];
                else $data_printer[$stt]['Value'] = 0;
                if(isset($decode_dulieu['Vaccuum block']['Lastmodify'])) $data_printer[$stt]['Lastmodify'] = $decode_dulieu['Vaccuum block']['Lastmodify'];
                else $data_printer[$stt]['Lastmodify'] = 0;
                //
                if(isset($decode_dulieu['Common'])) $data_printer[$stt]['Model'] = $decode_dulieu['Common'];
                else $data_printer[$stt]['Model'] = 'None';
                if(isset($decode_dulieu['Machine Status']['CYCLE_TIME_MEAN'])) $data_printer[$stt]['CYCLE_TIME_MEAN'] = $decode_dulieu['Machine Status']['CYCLE_TIME_MEAN'];
                else $data_printer[$stt]['CYCLE_TIME_MEAN'] = 0;
                if(isset($decode_dulieu['Machine Status']['CYCLE_TIME'])) $data_printer[$stt]['CYCLE_TIME'] = $decode_dulieu['Machine Status']['CYCLE_TIME'];
                else $data_printer[$stt]['CYCLE_TIME'] = 0;
                if(isset($decode_dulieu['Machine Status']['PCB_TEMP'])) $data_printer[$stt]['PCB_TEMP'] = $decode_dulieu['Machine Status']['PCB_TEMP'];
                else $data_printer[$stt]['PCB_TEMP'] = 0;
                if(isset($decode_dulieu['Machine Status']['MASK_TEMP'])) $data_printer[$stt]['MASK_TEMP'] = $decode_dulieu['Machine Status']['MASK_TEMP'];
                else $data_printer[$stt]['MASK_TEMP'] = 0;
                if(isset($decode_dulieu['Machine Status']['HUMIDITY'])) $data_printer[$stt]['HUMIDITY'] = $decode_dulieu['Machine Status']['HUMIDITY'];
                else $data_printer[$stt]['HUMIDITY'] = 0;
                if(isset($decode_dulieu['Machine Status']['MASK_VACUUM_SPEED'])) $data_printer[$stt]['MASK_VACUUM_SPEED'] = $decode_dulieu['Machine Status']['MASK_VACUUM_SPEED'];
                else $data_printer[$stt]['MASK_VACUUM_SPEED'] = 0;
                if(isset($decode_dulieu['Product State']['VACUUM_FORCE_MAX'])) $data_printer[$stt]['VACUUM_FORCE_MAX'] = $decode_dulieu['Product State']['VACUUM_FORCE_MAX'];
                else $data_printer[$stt]['VACUUM_FORCE_MAX'] = 0;
                if(isset($decode_dulieu['Product State']['PRINT_FORCE_MIN'])) $data_printer[$stt]['PRINT_FORCE_MIN'] = $decode_dulieu['Product State']['PRINT_FORCE_MIN'];
                else $data_printer[$stt]['PRINT_FORCE_MIN'] = 0;
                if(isset($decode_dulieu['Product State']['PRINT_FORCE_MAX'])) $data_printer[$stt]['PRINT_FORCE_MAX'] = $decode_dulieu['Product State']['PRINT_FORCE_MAX'];
                else $data_printer[$stt]['PRINT_FORCE_MAX'] = 0;
                if(isset($decode_dulieu['Product State']['MASK_PCB_X_DISTANCE'])) $data_printer[$stt]['MASK_PCB_X_DISTANCE'] = $decode_dulieu['Product State']['MASK_PCB_X_DISTANCE'];
                else $data_printer[$stt]['MASK_PCB_X_DISTANCE'] = 0;
                if(isset($decode_dulieu['Product State']['MASK_PCB_Y_DISTANCE'])) $data_printer[$stt]['MASK_PCB_Y_DISTANCE'] = $decode_dulieu['Product State']['MASK_PCB_Y_DISTANCE'];
                else $data_printer[$stt]['MASK_PCB_Y_DISTANCE'] = 0;
                if(isset($decode_dulieu['Product State']['MASK_PCB_SHRINKAGE_RATIO'])) $data_printer[$stt]['MASK_PCB_SHRINKAGE_RATIO'] = $decode_dulieu['Product State']['MASK_PCB_SHRINKAGE_RATIO'];
                else $data_printer[$stt]['MASK_PCB_SHRINKAGE_RATIO'] = 0;
                if(isset($decode_dulieu['Product State']['MASK_PCB_X_DISTANCE_AVG'])) $data_printer[$stt]['MASK_PCB_X_DISTANCE_AVG'] = $decode_dulieu['Product State']['MASK_PCB_X_DISTANCE_AVG'];
                else $data_printer[$stt]['MASK_PCB_X_DISTANCE_AVG'] = 0;
                if(isset($decode_dulieu['Product State']['MASK_PCB_Y_DISTANCE_AVG'])) $data_printer[$stt]['MASK_PCB_Y_DISTANCE_AVG'] = $decode_dulieu['Product State']['MASK_PCB_Y_DISTANCE_AVG'];
                else $data_printer[$stt]['MASK_PCB_Y_DISTANCE_AVG'] = 0;
                if(isset($decode_dulieu['Product State']['MASK_PCB_SHRINKAGE_RATIO'])) $data_printer[$stt]['MASK_PCB_SHRINKAGE_RATIO'] = $decode_dulieu['Product State']['MASK_PCB_SHRINKAGE_RATIO'];
                else $data_printer[$stt]['MASK_PCB_SHRINKAGE_RATIO'] = 0;
                if(isset($decode_dulieu['Product State']['MASK_PCB_SHRINKAGE_RATIO_AVG'])) $data_printer[$stt]['MASK_PCB_SHRINKAGE_RATIO_AVG'] = $decode_dulieu['Product State']['MASK_PCB_SHRINKAGE_RATIO_AVG'];
                else $data_printer[$stt]['MASK_PCB_SHRINKAGE_RATIO_AVG'] = 0;
                
                
                $stt++;
            }
        }
        
        
 		/* $data_color_vc = array('gray','gray');
 		$data_color_L = array('gray','gray');
         $data_vc1 = array('vacuum_block' => '', 'time_update' => 'Chưa cập nhật');
         $data_vc2 = array('vacuum_block' => '', 'time_update' => 'Chưa cập nhật');
         
		$sql_get_vc_m1 = "SELECT * FROM monitor_printer WHERE line_id = '$idd_line' AND machine = 'M1' ORDER BY id DESC"; // lấy dữ liệu mới nhất
        if ($db->num_rows($sql_get_vc_m1)){
            $data_vc1 = $db->fetch_assoc($sql_get_vc_m1, 1);
            if ($data_vc1['vacuum_block'] < 30 && $data_vc1['vacuum_block'] > 10) $data_color_vc[0] = 'green';
			else $data_color_vc[0] = 'red';
            if (floor(abs(strtotime($date_current) - strtotime($data_vc1['time_update'])) / 60) < 60) $data_color_L[0] = 'green';
			else $data_color_L[0] = 'red';
        }

        $sql_get_vc_m2 = "SELECT * FROM monitor_printer WHERE line_id = '$idd_line' AND machine = 'M2' ORDER BY id DESC"; // lấy dữ liệu mới nhất
        if ($db->num_rows($sql_get_vc_m2)){
            $data_vc2 = $db->fetch_assoc($sql_get_vc_m2, 1);
            if ($data_vc2['vacuum_block'] < 30 && $data_vc2['vacuum_block'] > 10) $data_color_vc[1] = 'green';
			else $data_color_vc[1] = 'red';
            if (floor(abs(strtotime($date_current) - strtotime($data_vc2['time_update'])) / 60) < 60) $data_color_L[1] = 'green';
			else $data_color_L[1] = 'red';
        }

        echo '<div class="col">
    			<div class="card border-light mb-3" style="max-height: 600px;">
      			<div class="card-header"><b>'.$idd_line.'</b></div>
      			<div class="card-body">
        			<div class="row">
                        <div class="col-6">
                            <b classs="'.$data_color_L[0].'">Máy 1</b>
                            <div class="card-text">Vacuum: <b class="'.$data_color_vc[0].'">'.$data_vc1["vacuum_block"].'</b> (m/s)</div>
                            <div class="card-text">Lass update: '.$data_vc1["time_update"].'</div>
                        </div>
                        <div class="col-6">
                            <b classs="'.$data_color_L[1].'">Máy 2</b>
                            <div class="card-text">Vacuum: <b class="'.$data_color_vc[1].'">'.$data_vc2["vacuum_block"].'</b> (m/s)</div>
                            <div class="card-text">Lass update: '.$data_vc2["time_update"].'</div>
                        </div>
                    </div>
      			</div>
    			</div>
  			</div>'; */
    }
    echo json_encode($data_printer);
}