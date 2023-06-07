<?php
    require_once '../core/init.php';
    if (isset($_POST['action'])){
        $action = $db->escape($_POST['action']);
        if($action == "insertLog"){
            $vitri = $db->escape($_POST['vitri']);
            $insert_data_3d = "INSERT INTO monitor_current_time_3day(vi_tri, du_lieu) VALUES ('$vitri', (SELECT CONCAT('{', GROUP_CONCAT(CONCAT('\"', ten_line, '\": ', du_lieu)), '}') FROM monitor_current_time WHERE vi_tri='$vitri' AND thoi_gian > (NOW() - INTERVAL 15 MINUTE) ORDER BY ten_line ASC))";
            $db->query($insert_data_3d);
            echo '<li>'. $date_current .'&ensp;Thêm dữ liệu '. $vitri .' thành công</li><br/>';
            if($vitri == "Xưởng"){
                $insert_data_log = "INSERT INTO monitor_current_time_log(vi_tri, du_lieu) VALUES ('Xưởng', (SELECT CONCAT('{', GROUP_CONCAT(CONCAT('\"', ten_line, '\": ', du_lieu)), '}') FROM monitor_current_time WHERE vi_tri='Xưởng' AND thoi_gian > (NOW() - INTERVAL 15 MINUTE) ORDER BY ten_line ASC))";
                $db->query($insert_data_log);
                echo '<li>'. $date_current .'&ensp;Thêm dữ liệu xưởng thành công</li><br/>';
            }
        } elseif($action == "delLog"){
            $vitri = $db->escape($_POST['vitri']);
            $sql_data_del = "DELETE FROM monitor_current_time_3day WHERE vi_tri='$vitri' AND thoi_gian < (NOW() - INTERVAL 3 DAY)";
            $db->query($sql_data_del);
        } elseif($action == "updateLOB"){
            //lấy dữ liệu giờ hiện tại
            $_date = date("Y-m-d", strtotime($date_current));
            $_hour = date("H", strtotime($date_current));
            $sql_lob_chip_log_hour = "SELECT lob_chip, lob_inline FROM sf_lob_hour WHERE time_date='$_date' AND time_hour='$_hour'";
            if($db->num_rows($sql_lob_chip_log_hour)) {
             $chip_cycle_max = json_decode($db->fetch_assoc($sql_lob_chip_log_hour, 1)['lob_chip'], true);
             $inline_cycle_max = json_decode($db->fetch_assoc($sql_lob_chip_log_hour, 1)['lob_inline'], true);
            }else {
             $chip_cycle_max = [];
             $inline_cycle_max = [];
             $db->query("INSERT INTO sf_lob_hour(time_date, time_hour, lob_chip, lob_inline) VALUES('$_date', '$_hour', '{}', '{}')");
            }
            //lấy danh sách line
            $sql_load_line_list = "SELECT line_name FROM current_line_status ORDER BY line_name ASC";
            if($db->num_rows($sql_load_line_list)){
                foreach($db->fetch_assoc($sql_load_line_list, 0) as $line){
                    $linename = $line['line_name'];
                    //cập nhật chip LOB
                    $sql_update_lob_chip = "UPDATE current_line_status SET lob_chip = (SELECT (SUM(t1.cycle_time_lane1 + t1.cycle_time_lane2 + 4)/COUNT(*))/MAX(t1.cycle_time_lane1 + t1.cycle_time_lane2 + 4)*100 AS LOB FROM current_machine_status t1, sf_machine_list t2 WHERE t1.machine_id=t2.machine_id AND t2.machine_name LIKE 'Chip%' AND t1.last_modified > (NOW() - INTERVAL 15 MINUTE) AND t1.line_name='$linename' AND (t1.cycle_time_lane1 + t1.cycle_time_lane2) > 0) WHERE line_name='$linename'";
                    $db->query($sql_update_lob_chip);
                    echo '<li>'. $date_current .'&ensp;Cập nhật LOB CHIP line '. $linename .' thành công</li><br/>';
                    //cập nhật tổng LOB
                    $sql_update_lob_sum = "UPDATE current_line_status SET lob_inline = (SELECT (SUM(t1.cycle_time_lane1 + t1.cycle_time_lane2 + 4)/COUNT(*))/MAX(t1.cycle_time_lane1 + t1.cycle_time_lane2 + 4)*100 AS LOB FROM current_machine_status t1, sf_machine_list t2 WHERE t1.machine_id=t2.machine_id AND (t2.machine_name LIKE 'Chip%' OR t2.machine_name LIKE 'Printer%' OR t2.machine_name LIKE '%AOI' OR t2.machine_name='Shield can') AND t1.last_modified > (NOW() - INTERVAL 15 MINUTE) AND t1.line_name='$linename' AND (t1.cycle_time_lane1 + t1.cycle_time_lane2) > 0) WHERE line_name='$linename'";
                    $db->query($sql_update_lob_sum);
                    echo '<li>'. $date_current .'&ensp;Cập nhật LOB line '. $linename .' thành công</li><br/>';
                
                    //cập nhật LOB theo giờ
                    if(!isset($chip_cycle_max[$linename])) $chip_cycle_max[$linename] = 0;
                    if(!isset($inline_cycle_max[$linename])) $inline_cycle_max[$linename] = 0;
                    $sql_lob_chip_current = "SELECT lob_chip, lob_inline FROM current_line_status WHERE line_name='$linename'";
                    if($db->num_rows($sql_lob_chip_current)){
                        $cycle_line = $db->fetch_assoc($sql_lob_chip_current, 1);
                        if($cycle_line['lob_chip'] > $chip_cycle_max[$linename]){
                            $chip_cycle_max[$linename] = $cycle_line['lob_chip'];
                            $db->query("UPDATE sf_lob_hour SET lob_chip=JSON_SET(lob_chip, '$.$linename', '". $cycle_line['lob_chip']. "') WHERE time_date='$_date' AND time_hour='$_hour'");
                        } 
                        if($cycle_line['lob_inline'] > $inline_cycle_max[$linename]){
                            $chip_cycle_max[$linename] = $cycle_line['lob_inline'];
                            $db->query("UPDATE sf_lob_hour SET lob_inline=JSON_SET(lob_inline, '$.$linename', '". $cycle_line['lob_inline']. "') WHERE time_date='$_date' AND time_hour='$_hour'");
                        }
                    }
                }
            }
        }

    }

    /* public void update_lob()
        {
            DataTable tbl = mySQL.laydulieu("SELECT line_name FROM current_line_status ORDER BY line_name ASC");
            foreach (DataRow data in tbl.Rows)
            {
                //update lob chip
                string sql_update_lob_chip = "UPDATE current_line_status SET lob_chip = (SELECT (SUM(t1.cycle_time_lane1 + t1.cycle_time_lane2 + 4)/COUNT(*))/MAX(t1.cycle_time_lane1 + t1.cycle_time_lane2 + 4)*100 AS LOB FROM current_machine_status t1, sf_machine_list t2 WHERE t1.machine_id=t2.machine_id AND t2.machine_name LIKE 'Chip%' AND t1.line_name='" + data["line_name"].ToString() + "' AND (t1.cycle_time_lane1 + t1.cycle_time_lane2) > 0) WHERE line_name='" + data["line_name"].ToString() + "'";
                mySQL.xulyMySQL(sql_update_lob_chip);
                //update tổng LOB
                string sql_update_lob_sum = "UPDATE current_line_status SET lob_inline = (SELECT (SUM(t1.cycle_time_lane1 + t1.cycle_time_lane2 + 4)/COUNT(*))/MAX(t1.cycle_time_lane1 + t1.cycle_time_lane2 + 4)*100 AS LOB FROM current_machine_status t1, sf_machine_list t2 WHERE t1.machine_id=t2.machine_id AND (t2.machine_name LIKE 'Chip%' OR t2.machine_name LIKE 'Printer%' OR t2.machine_name LIKE '%AOI' OR t2.machine_name='Shield can') AND t1.line_name='" + data["line_name"].ToString() + "' AND (t1.cycle_time_lane1 + t1.cycle_time_lane2) > 0) WHERE line_name='" + data["line_name"].ToString() + "'";
                mySQL.xulyMySQL(sql_update_lob_sum);
            }

            //txtLog.Text += current_times + "    Cập nhật dữ liệu LOB thành công.\r\n";
        } */


?>