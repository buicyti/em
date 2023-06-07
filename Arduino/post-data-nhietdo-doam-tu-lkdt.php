<?php
require_once '../core/init.php';

    $Line_id = "HS_SMD001";
    $MAC = "FF-FF-FF-FF-FF-FF";
    $Temp = "25.00";
    $Humi = "40.00";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
        if (isset($_POST['Lineid'])) $Line_id = $_POST["Lineid"];
        if (isset($_POST['IP'])) $IP_address = $_POST["IP"];
        if (isset($_POST['MAC'])) $MAC = $_POST["MAC"];
        if (isset($_POST['Temp'])) $Temp = $_POST["Temp"];
        if (isset($_POST['Humi'])) $Humi = $_POST["Humi"];


        $sql_check_line = "SELECT stt FROM monitor_current_time WHERE ten_line='$Line_id' AND vi_tri='Tủ LKĐT' ORDER BY stt DESC";
        if($db->num_rows($sql_check_line)){// kiểm tra có dũ liệu chưa, nếu có thì UPDATE, chưa thì INSERT
            $sql = "UPDATE monitor_current_time SET du_lieu=JSON_SET(du_lieu, '$.Temp', $Temp, '$.Humi', $Humi, '$.IP', '$IP_address', '$.MAC', '$MAC') WHERE ten_line='$Line_id' AND vi_tri='Tủ LKĐT'";
            $db -> query($sql);
        }
        else {
            //nếu không có dữ liệu trong bảng thì thêm dòng mới
            $sql = "INSERT INTO monitor_current_time(ten_line, vi_tri, du_lieu) VALUES('$Line_id', 'Tủ LKĐT', JSON_INSERT('{}', '$.Temp', $Temp, '$.Humi', $Humi, '$.IP', '$IP_address', '$.MAC', '$MAC'))";
            $db -> query($sql);
        }
        $db -> close();
    }
    else {
        echo "KHÔNG CÓ DỮ LIỆU HTTP POST.";
    }

?>