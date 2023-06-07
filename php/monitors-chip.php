<?php
	require_once '../core/init.php';

if (isset($_POST['line_selected']))
{
    $_line_list = $_POST['line_selected'];
    $data_check = null;
    foreach($_line_list as $_line){
        $sql_get_data_chipvacuum = "SELECT * FROM monitor_current_time WHERE vi_tri='Chip mounter' AND ten_line='$_line' ORDER BY ten_line ASC";
        if($db->num_rows($sql_get_data_chipvacuum)){
            //$dulieu = $db->fetch_assoc($sql_get_data_chipvacuum, 1);
            $dulieu = json_decode($db->fetch_assoc($sql_get_data_chipvacuum, 1)['du_lieu'], true);
                if(isset($dulieu['Base1'])) $data_check[$_line]['Base1'] = $dulieu['Base1'];
                if(isset($dulieu['Base2'])) $data_check[$_line]['Base2'] = $dulieu['Base2'];
                if(isset($dulieu['Base3'])) $data_check[$_line]['Base3'] = $dulieu['Base3'];
                if(isset($dulieu['Base4'])) $data_check[$_line]['Base4'] = $dulieu['Base4'];
                if(isset($dulieu['Base5'])) $data_check[$_line]['Base5'] = $dulieu['Base5'];
                if(isset($dulieu['Base6'])) $data_check[$_line]['Base6'] = $dulieu['Base6'];
                if(isset($dulieu['Lastmodify'])) $data_check[$_line]['Lastmodify'] = $dulieu['Lastmodify'];
        }
    }
    $data_check['Current time'] = $date_current;
    echo json_encode($data_check);
    
    
}
?>