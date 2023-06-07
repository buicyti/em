<?php
require_once '../core/init.php';


if (isset($_POST['send_dat'])) {
    if($_POST['send_dat'] == 'ds'){
        
        $sql_lay_ds_line = "SELECT * FROM monitor_dat";
        $dem = 1;
        if ($db->num_rows($sql_lay_ds_line)) {
            $data_ds_line = $db -> fetch_assoc($sql_lay_ds_line, 0);
            foreach($data_ds_line as $key => $data_load){
                if(strtotime($date_current) - strtotime($data_load["time_update"]) < 5 && $data_load["status"] == "1") $data_load["status"] = '<span class="text-success">Đang bật</span>';
                elseif(strtotime($date_current) - strtotime($data_load["time_update"]) < 5 && $data_load["status"] == "0") $data_load["status"] = '<span class="text-primary">Đang tắt</span>';
                else $data_load["status"] = '<span class="text-danger">Mất kết nối</span>';
    
                if($data_load["remote_agent"] == "0") $data_load["remote_agent"] = '<span class="form-check form-switch"><input class="isChecked form-check-input ms-2" type="checkbox" id="Checked' . $data_load["line_id"] . '"></span>';
                elseif($data_load["remote_agent"] == "1") $data_load["remote_agent"] = '<span class="form-check form-switch"><input class="isChecked form-check-input ms-2" type="checkbox" id="Checked' . $data_load["line_id"] . '" checked></span>';
                
                $data_load["timer_on"] = '<span class="timeon" id="timeon' . $data_load["line_id"] . '">'. $data_load["timer_on"] .'</span>';
                $data_load["timer_off"] = '<span class="timeoff" id="timeoff' . $data_load["line_id"] . '">'. $data_load["timer_off"] .'</span>';
                //$data_load["timer_on"] = '<input type="text" class="input timeon form-control" name="timeon' . $data_load["line_id"] . '" value="'. $data_load["timer_on"] .'">';
                $data_ds_line[$key] = $data_load;
            }
            echo json_encode($data_ds_line);
        }
    }
    elseif($_POST['send_dat'] == 'send'){
        $checkk = $_POST['checkk'];
        $id_line = $_POST['id_line'];
        $sql_remote_agent = "UPDATE monitor_dat SET remote_agent='$checkk', time_update=CURRENT_TIMESTAMP WHERE line_id='$id_line'";
        $db -> query($sql_remote_agent);
        $db -> close();
    }
    elseif($_POST['send_dat'] == 'sendtimeonid'){
        $checkk = $_POST['checkk'];
        $id_line = $_POST['id_line'];
        $sql_remote_agent = "UPDATE monitor_dat SET timer_on='$checkk', time_update=CURRENT_TIMESTAMP WHERE line_id='$id_line'";
        $db -> query($sql_remote_agent);
        $db -> close();
    }
    elseif($_POST['send_dat'] == 'sendtimeoffid'){
        $checkk = $_POST['checkk'];
        $id_line = $_POST['id_line'];
        $sql_remote_agent = "UPDATE monitor_dat SET timer_off='$checkk', time_update=CURRENT_TIMESTAMP WHERE line_id='$id_line'";
        $db -> query($sql_remote_agent);
        $db -> close();
    }
}

?>