<?php
require_once '../core/init.php';
    $IP_address = "192.168.1.1";
    $MAC = "FF-FF-FF-FF-FF-FF";
    $Line_id = "HS_SMD041";
    $Temp = "25.00";
    $Humi = "40.00";
    $eCO2 = "0";
    $TVOC = "0";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
        if (isset($_POST['Lineid'])) $Line_id = $_POST["Lineid"];
        if (isset($_POST['IP'])) $IP_address = $_POST["IP"];
        if (isset($_POST['MAC'])) $MAC = $_POST["MAC"];
        if (isset($_POST['Temp'])) $Temp = $_POST["Temp"];
        if (isset($_POST['Humi'])) $Humi = $_POST["Humi"];
        if (isset($_POST['eco2'])) $eCO2 = $_POST["eco2"];
        if (isset($_POST['tvoc'])) $TVOC = $_POST["tvoc"];
        

        $sql_check_line = "SELECT stt FROM monitor_current_time WHERE ten_line='$Line_id' AND vi_tri='Xưởng' ORDER BY stt DESC";
        if($db->num_rows($sql_check_line)){// kiểm tra có dũ liệu chưa, nếu có thì UPDATE, chưa thì INSERT
            //$sql = "UPDATE monitor_current_time SET du_lieu='$Temp|$Humi|$eCO2|$TVOC' WHERE ten_line='$Line_id' AND vi_tri='Xưởng'";
            $sql = "UPDATE monitor_current_time SET du_lieu=JSON_SET(du_lieu, '$.Temp', $Temp, '$.Humi', $Humi, '$.eCO2', $eCO2, '$.TVOC', $TVOC, '$.IP', '$IP_address', '$.MAC', '$MAC') WHERE ten_line='$Line_id' AND vi_tri='Xưởng'";
            $db -> query($sql);
        }
        else {
            //nếu không có dữ liệu trong bảng thì thêm dòng mới
            //$sql = "INSERT INTO monitor_current_time(ten_line, vi_tri, du_lieu) VALUES ('$Line_id', 'Xưởng', '$Temp|$Humi|$eCO2|$TVOC')";
            $sql = "INSERT INTO monitor_current_time(ten_line, vi_tri, du_lieu) VALUES('$Line_id', 'Xưởng', JSON_INSERT('{}', '$.Temp', $Temp, '$.Humi', $Humi, '$.eCO2', $eCO2, '$.TVOC', $TVOC, '$.IP', '$IP_address', '$.MAC', '$MAC'))";
            $db -> query($sql);
        }
        $db -> close();
    }
    else {
    echo "KHÔNG CÓ DỮ LIỆU HTTP POST.";
    }
?>
