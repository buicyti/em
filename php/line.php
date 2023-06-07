<?php
require_once '../core/init.php';
if (isset($_POST['action'])){
    $data_line = [];
    $sql_line_area = "SELECT DISTINCT line_area FROM line ORDER BY stt ASC";
    if($db->num_rows($sql_line_area)){
        foreach($db->fetch_assoc($sql_line_area, 0) as $key => $area){
            $data_line[$key] = array('id' => $area['line_area'], 'text' => $area['line_area'], 'children' => []);
            $sql_line_name = "SELECT * FROM line WHERE line_area='". $area['line_area']. "' ORDER BY stt ASC";
            if($db->num_rows($sql_line_name)){
                foreach($db->fetch_assoc($sql_line_name, 0) as $line_name){
                    $data_line[$key]['children'][] = array('id' => $line_name['line_name'], 'text' => $line_name['line_name']);
                }
            }
        }
    }
    echo json_encode($data_line);
}



?>