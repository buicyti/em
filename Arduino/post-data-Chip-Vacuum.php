<?php
require_once '../core/init.php';

    $Line_id = "HS_SMD001";
    $IP_address = "192.168.0.1";
    $mac_address = "00-00-00-00-00-00";
    $Base1 = 'None';
    $Base2 = 'None';
    $Base3 = 'None';
    $Base4 = 'None';
    $Base5 = 'None';
    $Base6 = 'None';

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
        if(isset($_POST["Lineid"])) $Line_id = $_POST["Lineid"];
        if(isset($_POST["IP"])) $IP_address = $_POST["IP"];
        if(isset($_POST["mac"])) $mac_address = $_POST["mac"];
        if(isset($_POST["B1"])) $Base1 = $_POST["B1"];
        if(isset($_POST["B2"])) $Base2 = $_POST["B2"];
        if(isset($_POST["B3"])) $Base3 = $_POST["B3"];
        if(isset($_POST["B4"])) $Base4 = $_POST["B4"];
        if(isset($_POST["B5"])) $Base5 = $_POST["B5"];
        if(isset($_POST["B6"])) $Base6 = $_POST["B6"];
        
        
        $sql_check_line = "SELECT stt FROM monitor_current_time WHERE ten_line='$Line_id' AND vi_tri='Chip mounter' ORDER BY stt DESC";
        if($db->num_rows($sql_check_line)){
            // kiểm tra có dũ liệu chưa, nếu có thì UPDATE
            $sql = "UPDATE monitor_current_time SET du_lieu=JSON_SET(du_lieu, '$.Base1', '$Base1', '$.Base2', '$Base2', '$.Base3', '$Base3', '$.Base4', '$Base4', '$.Base5', '$Base5', '$.Base6', '$Base6', '$.Lastmodify', '$date_current', '$.IP', '$IP_address', '$.MAC', '$mac_address') WHERE ten_line='$Line_id' AND vi_tri='Chip mounter'";
            $db -> query($sql);
        }
        else {
            //nếu không có dữ liệu trong bảng thì thêm dòng mới
            $sql = "INSERT INTO monitor_current_time(ten_line, vi_tri, du_lieu) VALUES('$Line_id', 'Chip mounter', JSON_INSERT('{}', '$.Base1', '$Base1', '$.Base2', '$Base2', '$.Base3', '$Base3', '$.Base4', '$Base4', '$.Base5', '$Base5', '$.Base6', '$Base6', '$.Lastmodify', '$date_current', '$.IP', '$IP_address', '$.MAC', '$mac_address'))";
            $db -> query($sql);
        }
        $db -> close();
    }
    else {
    echo "KHÔNG CÓ DỮ LIỆU HTTP POST.";
    }

?>