<?php

require_once '../core/init.php';
//tải xuống html
if (isset($_POST['action'])) {
    if($_POST['action'] == 'load-line'){
        $list_line = $_POST['line_selected'];
        $data_all_line = null;
        foreach($list_line as $line){
            $sql_data_line = "SELECT * FROM current_machine_status t1,sf_machine_list t2 WHERE t1.machine_id = t2.machine_id AND line_name='$line' ORDER BY t1.machine_no ASC";
            
            if($db->num_rows($sql_data_line)){
                foreach($db->fetch_assoc($sql_data_line, 0) as $data_line){
                    $data_all_line[$line][$data_line['machine_name']] = $data_line['machine_picture'];
                }
            }
        }
        echo json_encode($data_all_line);
    }
    elseif($_POST['action'] == 'load-machine-data'){
        $list_line = $_POST['line_selected'];
        $data_all_machine = null;
        foreach($list_line as $line){
            $sql_data_line = "SELECT * FROM current_machine_status t1,sf_machine_list t2 WHERE t1.machine_id = t2.machine_id AND line_name='$line' ORDER BY t1.machine_no ASC";
            
            if($db->num_rows($sql_data_line)){
                foreach($db->fetch_assoc($sql_data_line, 0) as $data_line){
                    $cycletime = $data_line['cycle_time_lane1'] + $data_line['cycle_time_lane2'] + 4;
                    $data_all_machine[$line][$data_line['machine_name']] = array($data_line['machine_status'], $cycletime);
                }
            }
        }
        echo json_encode($data_all_machine);
    }
    elseif($_POST['action'] == 'load-line-data'){
        $list_line = $_POST['line_selected'];
        $data_all_line = null;
        foreach($list_line as $line){
            $sql_data_line = "SELECT * FROM current_line_status WHERE line_name='$line'";
            
            if($db->num_rows($sql_data_line)){
                $data_line = $db->fetch_assoc($sql_data_line, 1);
                $data_all_line[$line] = array($data_line['current_model'], $data_line['next_model'], round($data_line['lob_inline'], 2), $data_line['line_status'], $data_line['chip_quantity'], $data_line['total_losstime']);
            }
        }
        echo json_encode($data_all_line);
    }
    elseif($_POST['action'] == 'get_modal_lob_chip'){
        $linename = $_POST['linename'];
        if(date("H", strtotime($date_current)) < 8) $date = date("Y-m-d", strtotime($date_current . "- 1 days"));
        else $date = date("Y-m-d", strtotime($date_current));

        $sql_check_date = "SELECT * FROM sf_lob WHERE thoi_gian='$date'";
        if($db->num_rows($sql_check_date)){//update
            $sql_update_lob_chip = "UPDATE sf_lob SET lob_chip=JSON_SET(lob_chip, '$.$linename', (SELECT lob_chip FROM current_line_status WHERE line_name='$linename')) WHERE thoi_gian='$date'";
            $db->query($sql_update_lob_chip);
        }
        else{//insert
            $sql_insert_lob_chip = "INSERT INTO sf_lob(thoi_gian, lob_chip, lob_inline) VALUES('$date', JSON_INSERT('{}', '$.$linename', (SELECT lob_chip FROM current_line_status WHERE line_name='$linename')), '{}')";
            $db->query($sql_insert_lob_chip);
        }
    }
    elseif($_POST['action'] == 'get_modal_lob_inline'){
        $linename = $_POST['linename'];
        if(date("H", strtotime($date_current)) < 8) $date = date("Y-m-d", strtotime($date_current . "- 1 days"));
        else $date = date("Y-m-d", strtotime($date_current));

        $sql_check_date = "SELECT * FROM sf_lob WHERE thoi_gian='$date'";
        if($db->num_rows($sql_check_date)){//update
            $sql_update_lob_inline = "UPDATE sf_lob SET lob_inline=JSON_SET(lob_inline, '$.$linename', (SELECT lob_inline FROM current_line_status WHERE line_name='$linename')) WHERE thoi_gian='$date'";
            $db->query($sql_update_lob_inline);
        }
        else{//insert
            $sql_insert_lob_inline = "INSERT INTO sf_lob(thoi_gian, lob_chip, lob_inline) VALUES('$date', '{}', JSON_INSERT('{}', '$.$linename', (SELECT lob_inline FROM current_line_status WHERE line_name='$linename')))";
            $db->query($sql_insert_lob_inline);
        }
    }
    elseif($_POST['action'] == 'get_data_lob_line'){
        $linename = $_POST['linename'];
        if(date("H", strtotime($date_current)) < 8) $date = date("Y-m-d", strtotime($date_current . "- 1 days"));
        else $date = date("Y-m-d", strtotime($date_current));
        $date_7last = date("Y-m-d", strtotime($date . "- 7 days"));

        $sql_get_log_line_lob = "SELECT thoi_gian, lob_chip, lob_inline FROM sf_lob WHERE (thoi_gian BETWEEN '$date_7last' AND '$date') ORDER BY stt ASC";
        if($db->num_rows($sql_get_log_line_lob)){
            foreach($db->fetch_assoc($sql_get_log_line_lob, 0) as $log_line_lob_chip){
                $data_lob = json_decode($log_line_lob_chip["lob_chip"], true);
                if(isset($data_lob[$linename])) $data_log["data_chip"][] = $data_lob[$linename];
                else $data_log["data_chip"][] = 0;

                $data_lob = json_decode($log_line_lob_chip["lob_inline"], true);
                if(isset($data_lob[$linename])) $data_log["data_tong"][] = $data_lob[$linename];
                else $data_log["data_tong"][] = 0;

                $data_log["days"][] = date("d/m", strtotime($log_line_lob_chip["thoi_gian"]));
            }
            echo json_encode($data_log);
        }
    }
}


?>