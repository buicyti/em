<?php
require_once '../core/init.php';



if (isset($_POST['get_data_TH'])){
    $get_data_TH = $_POST['get_data_TH'];
    $data_current_th = array("line" => array(),"temp" => array(),"humi" => array(), 'TOK' => 0, 'TNG' => 0, 'HOK' => 0, 'HNG' => 0);
    if($get_data_TH == "THxuong"){
        $sql_current_THxuong = "SELECT * FROM monitor_current_time WHERE vi_tri='Xưởng' ORDER BY ten_line ASC";
        if($db->num_rows($sql_current_THxuong)){
            foreach($db->fetch_assoc($sql_current_THxuong, 0) as $dt_line){
                $data_current_th['line'][] = $dt_line['ten_line'];
                //$tach_dl = explode('|', $dt_line['du_lieu']);
                $tach_dl = json_decode($dt_line["du_lieu"], true);
                if(isset($tach_dl["Temp"])) {
                    $data_current_th['temp'][] = $tach_dl["Temp"];
                    if($tach_dl["Temp"] >= 18 && $tach_dl["Temp"] <= 28) $data_current_th['TOK']++ ;
                    else $data_current_th['TNG']++;
                }
                else {
                    $data_current_th['temp'][] = 0;
                    $data_current_th['TNG']++;
                }

                if(isset($tach_dl["Humi"])) {
                    $data_current_th['humi'][] = $tach_dl["Humi"];
                    if($tach_dl["Humi"] >= 40 && $tach_dl["Humi"] <= 60) $data_current_th['HOK']++ ;
                    else $data_current_th['HNG']++;
                }
                else{
                    $data_current_th['humi'][] = 0;
                    $data_current_th['HNG']++;
                }
            }
            echo json_encode($data_current_th);
        }
    }

    elseif($get_data_TH == "THtuLKDT"){
        $sql_current_THxuong = "SELECT * FROM monitor_current_time WHERE vi_tri='Tủ LKĐT' ORDER BY ten_line ASC";
        if($db->num_rows($sql_current_THxuong)){
            foreach($db->fetch_assoc($sql_current_THxuong, 0) as $dt_line){
                $data_current_th['line'][] = $dt_line['ten_line'];
                //$tach_dl = explode('|', $dt_line['du_lieu']);
                $tach_dl = json_decode($dt_line["du_lieu"], true);
                if(isset($tach_dl["Temp"])) {
                    $data_current_th['temp'][] = $tach_dl["Temp"];
                    if($tach_dl["Temp"] >= 18 && $tach_dl["Temp"] <= 28) $data_current_th['TOK']++ ;
                    else $data_current_th['TNG']++;
                }
                else {
                    $data_current_th['temp'][] = 0;
                    $data_current_th['TNG']++;
                }

                if(isset($tach_dl["Humi"])) {
                    $data_current_th['humi'][] = $tach_dl["Humi"];
                    if($tach_dl["Humi"] >= 0 && $tach_dl["Humi"] <= 10) $data_current_th['HOK']++ ;
                    else $data_current_th['HNG']++;
                }
                else{
                    $data_current_th['humi'][] = 0;
                    $data_current_th['HNG']++;
                }
                /* $data_current_th['temp'][] = $tach_dl["Temp"];
                $data_current_th['humi'][] = $tach_dl["Humi"];

                if($tach_dl["Temp"] >= 18 && $tach_dl["Temp"] <= 28) $data_current_th['TOK']++ ;
                else $data_current_th['TNG']++;
                if($tach_dl["Humi"] >= 0 && $tach_dl["Humi"] <= 10) $data_current_th['HOK']++ ;
                else $data_current_th['HNG']++; */
            }
            echo json_encode($data_current_th);
        }
    }

    elseif($get_data_TH == "THreflow"){
        $sql_current_THxuong = "SELECT * FROM monitor_current_time WHERE vi_tri='Reflow' ORDER BY ten_line ASC";
        if($db->num_rows($sql_current_THxuong)){
            foreach($db->fetch_assoc($sql_current_THxuong, 0) as $dt_line){
                $data_current_th['line'][] = $dt_line['ten_line'];
                //$tach_dl = explode('|', $dt_line['du_lieu']);
                $tach_dl = json_decode($dt_line["du_lieu"], true);
                if(isset($tach_dl["Temp"])) {
                    $data_current_th['temp'][] = $tach_dl["Temp"];
                    if($tach_dl["Temp"] > 0 && $tach_dl["Temp"] < 70) $data_current_th['TOK']++ ;
                    else $data_current_th['TNG']++;
                }
                else {
                    $data_current_th['temp'][] = 0;
                    $data_current_th['TNG']++;
                }

                if(isset($tach_dl["Humi"])) {
                    $data_current_th['humi'][] = $tach_dl["Humi"];
                    if($tach_dl["Humi"] >= 0 && $tach_dl["Humi"] <= 20) $data_current_th['HOK']++ ;
                    else $data_current_th['HNG']++;
                }
                else{
                    $data_current_th['humi'][] = 0;
                    $data_current_th['HNG']++;
                }
                /* $data_current_th['temp'][] = $tach_dl["Temp"];
                $data_current_th['humi'][] = $tach_dl["Humi"];

                if($tach_dl["Temp"] > 0 && $tach_dl["Temp"] < 70) $data_current_th['TOK']++ ;
                else $data_current_th['TNG']++;
                if($tach_dl["Humi"] >= 0 && $tach_dl["Humi"] <= 20) $data_current_th['HOK']++ ;
                else $data_current_th['HNG']++; */
            }
            echo json_encode($data_current_th);
        }
    }


    elseif($get_data_TH == "VCprinter"){
        $data_newest_TH = array("line" => array(),"M1" => array(),"M2" => array(), 'OK' => 0, 'NG' => 0);
        $sql_get_list_line = "SELECT DISTINCT ten_line FROM monitor_current_time WHERE vi_tri LIKE 'Printer%'";
        if($db->num_rows($sql_get_list_line)){
            foreach($db->fetch_assoc($sql_get_list_line, 0) as $line_idd){
                $data_newest_TH['line'][] = $line_idd['ten_line'];
                //m1
                $sql_line_THxuong = "SELECT du_lieu FROM monitor_current_time WHERE ten_line='". $line_idd['ten_line'] ."' AND vi_tri='Printer 1'";
                if($db->num_rows($sql_line_THxuong)){
                    $data_line_THxuong = json_decode($db->fetch_assoc($sql_line_THxuong, 1)['du_lieu'], true);
                    if(isset($data_line_THxuong['Vaccuum block']['Value'])) {
                        $data_newest_TH['M1'][] = $data_line_THxuong['Vaccuum block']['Value'];
                        if($data_line_THxuong['Vaccuum block']['Value'] > 14) $data_newest_TH['OK']++;
                        else $data_newest_TH['NG']++;
                    }
                    else $data_newest_TH['M1'][] = 0;
                }
                else{
                    $data_newest_TH['M1'][] = 0;
                }

                //m2
                $sql_line_THxuong = "SELECT du_lieu FROM monitor_current_time WHERE ten_line='". $line_idd['ten_line'] ."' AND vi_tri='Printer 2'";
                if($db->num_rows($sql_line_THxuong)){
                    $data_line_THxuong = json_decode($db->fetch_assoc($sql_line_THxuong, 1)['du_lieu'], true);
                    if(isset($data_line_THxuong['Vaccuum block']['Value'])) {
                        $data_newest_TH['M2'][] = $data_line_THxuong['Vaccuum block']['Value'];
                        if($data_line_THxuong['Vaccuum block']['Value'] > 14) $data_newest_TH['OK']++;
                        else $data_newest_TH['NG']++;
                    }
                    else $data_newest_TH['M2'][] = 0;
                }
                else{
                    $data_newest_TH['M2'][] = 0;
                }
            }
            
            echo json_encode($data_newest_TH);
        }

        /* $sql_get_list_line = "SELECT DISTINCT line_id FROM monitor_printer";
        if($db->num_rows($sql_get_list_line)){
            foreach($db->fetch_assoc($sql_get_list_line, 0) as $line_idd){
                //echo implode($line_idd);
                $data_newest_line_THxuong = $db->fetch_assoc("SELECT line_id, vacuum_block FROM monitor_printer WHERE line_id='".implode($line_idd)."' AND machine='M1' ORDER BY id DESC", 1);
                $data_newest_TH['line'][] = $data_newest_line_THxuong['line_id'];
                $data_newest_TH['M1'][] = $data_newest_line_THxuong['vacuum_block'];
                if($data_newest_line_THxuong['vacuum_block'] > 14 && $data_newest_line_THxuong['vacuum_block'] < 30) $data_newest_TH['OK']++ ;
                else $data_newest_TH['NG']++;

                $data_newest_line_THxuong = $db->fetch_assoc("SELECT line_id, vacuum_block FROM monitor_printer WHERE line_id='".implode($line_idd)."' AND machine='M2' ORDER BY id DESC", 1);
                $data_newest_TH['M2'][] = $data_newest_line_THxuong['vacuum_block'];
                if($data_newest_line_THxuong['vacuum_block'] > 14 && $data_newest_line_THxuong['vacuum_block'] < 30) $data_newest_TH['OK']++ ;
                else $data_newest_TH['NG']++;
            } */
            
        //}
    }
}
