<?php
require_once '../core/init.php';
//tải xuống html
if (isset($_POST['action'])) {
    if($_POST['action'] == 'get_lob_line'){
        $list_line = $_POST['line_selected'];
        $starttime = date('Y-m-d', strtotime(str_replace('/', '-', $_POST['starttime'])));
        $endtime = date('Y-m-d', strtotime(str_replace('/', '-', $_POST['endtime'])));
        $i = 0;

        $sql_get_log_line_lob = "SELECT thoi_gian, lob_chip, lob_inline FROM sf_lob WHERE (thoi_gian BETWEEN '$starttime' AND '$endtime') ORDER BY stt ASC";
        if($db->num_rows($sql_get_log_line_lob)){
            foreach($db->fetch_assoc($sql_get_log_line_lob, 0) as $log_line_lob_chip){
                 foreach($list_line as $linename){
                    $olb = date("d/m", strtotime($log_line_lob_chip['thoi_gian']));

                    $data_lob = json_decode($log_line_lob_chip["lob_chip"], true);
                    if(isset($data_lob[$linename])) {
                        $data_log[$linename]["data_chip"][] = $data_lob[$linename];
                        $data_olg[$linename]["CHIP"][$olb] = $data_lob[$linename];
                    }
                    else {
                        $data_log[$linename]["data_chip"][] = 0;
                        $data_olg[$linename]["CHIP"][$olb] = 0;
                    }

                    $data_lob = json_decode($log_line_lob_chip["lob_inline"], true);
                    if(isset($data_lob[$linename])) {
                        $data_log[$linename]["data_inline"][] = $data_lob[$linename];
                        $data_olg[$linename]["INLINE"][$olb] = $data_lob[$linename];
                    }
                    else {
                        $data_log[$linename]["data_inline"][] = 0;
                        $data_olg[$linename]["INLINE"][$olb] = 0;
                    }
                }
            }
            /* //chuyển mảng lob về trung bình cộng
            $data_send['chart']['lines'][] = "AVERAGE";
            $data_send['chart']['data_chip'][] = 1000;
            $data_send['chart']['data_inline'][] = 1000;
            $data_send['chart']['target'][] = 95; */
            foreach($list_line as $linename){
                $i++;
                $data_olg[$linename]['STT'] = $i;
                $data_olg[$linename]['LINE'] = $linename;
                $data_olg[$linename]['AVGChip'] = 0;
                $data_olg[$linename]['AVGInline'] = 0;
                 $data_log[$linename]["data_chip"] = array_diff($data_log[$linename]["data_chip"], array(0));
                if(count($data_log[$linename]["data_chip"]) > 0) $data_log[$linename]["data_chip"] = array_sum($data_log[$linename]["data_chip"]) / count($data_log[$linename]["data_chip"]);
                else $data_log[$linename]["data_chip"] = 0;

                $data_log[$linename]["data_inline"] = array_diff($data_log[$linename]["data_inline"], array(0));
                if(count($data_log[$linename]["data_inline"]) > 0) $data_log[$linename]["data_inline"] = array_sum($data_log[$linename]["data_inline"]) / count($data_log[$linename]["data_inline"]);
                else $data_log[$linename]["data_inline"] = 0;
                /*
                //chuyển vào biến hiện biểu đồ
                $data_send['chart']['lines'][] = $linename;
                $data_send['chart']['data_chip'][] = $data_log[$linename]["data_chip"];
                $data_send['chart']['data_inline'][] = $data_log[$linename]["data_inline"];
                $data_send['chart']['target'][] = 95; */

                $data_send['chart'][] = array('lines' => $linename, 'data_chip' => $data_log[$linename]["data_chip"], 'data_inline' => $data_log[$linename]["data_inline"], 'target' => 95);

                //chuyển vào biến hiện bảng
                $data_send['table'][] = $data_olg[$linename];
            }
           /*  $data_chip_lob_average = array_diff($data_send['chart']['data_chip'], array(0, 1000));
            if(count($data_chip_lob_average) > 0) $data_send['chart']['data_chip'][0] = array_sum($data_chip_lob_average) / count($data_chip_lob_average);
            else $data_send['chart']['data_chip'][0] = 0;
            $data_inline_lob_average = array_diff($data_send['chart']['data_inline'], array(0, 1000));
            if(count($data_inline_lob_average) > 0) $data_send['chart']['data_inline'][0] = array_sum($data_inline_lob_average) / count($data_inline_lob_average);
            else $data_send['chart']['data_inline'][0] = 0; */

            echo json_encode($data_send);
        }
        else echo json_encode(array('chart' => 0, 'table' => [array('STT' => 0, 'LINE'=> "Không có dữ liệu được tìm thấy!")]));
    }
}
?>