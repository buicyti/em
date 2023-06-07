<?php
require_once '../core/init.php';

    $Line_id = "HS_SMD003";
    $Vacuum = "25.00";
    $Machine = "Printer 1";
    $IP_address = "192.168.0.1";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST['Lineid'])) $Line_id = $_POST["Lineid"];
        if (isset($_POST['IP'])) $IP_address = $_POST["IP"];
        if (isset($_POST['Machineid'])) $Machine = $_POST["Machineid"];
        if (isset($_POST['Vacuum'])) $Vacuum = $_POST["Vacuum"];
        

        $sql_check_line = "SELECT stt FROM monitor_current_time WHERE ten_line='$Line_id' AND vi_tri='$Machine' ORDER BY stt DESC";
        if($db->num_rows($sql_check_line)){
            // kiểm tra có dũ liệu chưa, nếu có thì UPDATE, chưa thì INSERT
            //$sql = "UPDATE monitor_current_time SET du_lieu='$Temp|$Humi|$eCO2|$TVOC' WHERE ten_line='$Line_id' AND vi_tri='Xưởng'";
            $sql = "UPDATE monitor_current_time SET du_lieu=JSON_SET(du_lieu, '$.Vaccuum block', JSON_OBJECT('Value', $Vacuum, 'Lastmodify', '$date_current', 'IP', '$IP_address')) WHERE ten_line='$Line_id' AND vi_tri='$Machine'";
            $db -> query($sql);
        }
        else {
            //nếu không có dữ liệu trong bảng thì thêm dòng mới
            //$sql = "INSERT INTO monitor_current_time(ten_line, vi_tri, du_lieu) VALUES ('$Line_id', 'Xưởng', '$Temp|$Humi|$eCO2|$TVOC')";
            $sql = "INSERT INTO monitor_current_time(ten_line, vi_tri, du_lieu) VALUES('$Line_id', '$Machine', JSON_INSERT('{}', '$.Vaccuum block', JSON_INSERT('{}','$.Value', $Vacuum, '$.Lastmodify', '$date_current', '$.IP', '$IP_address')))";
            $db -> query($sql);
        }
        $db -> close();


    }
    else {
    echo "KHÔNG CÓ DỮ LIỆU HTTP POST.";
    }

?>