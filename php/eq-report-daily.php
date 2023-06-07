<?php
	require_once '../core/init.php';
    $db->set_char('utf8mb4');
    if (isset($_POST['action'])){
        $action = $_POST['action'];
        if($action == "loadUser"){
            echo json_encode($data_user);
        }
        elseif($action == "loadTable"){
            $selectLine = $_POST['selectLine'];
            $selectMachine = $_POST['selectMachine'];
            $selectShift = $_POST['selectShift'];
            $selectGroup = $_POST['selectGroup'];
            $starttime = $_POST['starttime'];
            $endtime = $_POST['endtime'];
            $sql_load_machine = "SELECT * FROM eq_report_daily";
            if($db->num_rows($sql_load_machine)){
                echo json_encode($db->fetch_assoc($sql_load_machine, 0));
            }
        }
        elseif($action == "GuiBaocao"){
            $modal_day = $_POST['modal_day'];
            $modal_shift = $_POST['modal_shift'];
            $modal_Group = $_POST['modal_Group'];
            $modal_line = $_POST['modal_line'];
            $modal_machine = $_POST['modal_machine'];
            $lblVande = $_POST['lblVande'];
            $lblNguyennhan = $_POST['lblNguyennhan'];
            $lblKhacphuc = $_POST['lblKhacphuc'];
            $modal_losstime = $_POST['modal_losstime'];
            $modal_stt = $_POST['modal_stt'];
            $lblNote = $_POST['lblNote'];
            /* $ = $_POST[''];
            $ = $_POST[''];
            $ = $_POST[''];
            $ = $_POST[''];
            $ = $_POST['']; */
            //kiểm tra dữ liệu đầu vào
            if(!validateDate($modal_day)) $tb = 'Định dạng thời gian nhập vào không hợp lệ';
            //if(!in_array($modal_shift, $dataShift)) $tb = 'Định dạng ca nhập vào không hợp lệ';
            //đoạn trên để làm sau đê

            $sql_insert_report = "INSERT INTO `eq_report_daily`(`ngay_thang_nam`, `_nhom`, `ca_kip`, `_line`, `_machine`, `van_de`, `nguyen_nhan`, `khac_phuc`, `loss_time`, `tinh_trang`, `_note`, `id_employee`) VALUES ('$modal_day','$modal_Group','$modal_shift','$modal_line','$modal_machine','$lblVande','$lblNguyennhan','$lblKhacphuc','$modal_losstime','$modal_stt','$lblNote','" . $data_user['user_id'] . "')";
            $db->query($sql_insert_report);
            $tb = 'Đã thêm';
            echo $tb;
        }
        
        $db->close();
    }



    function validateDate($date, $format = 'Y-m-d')
    {
        $d = DateTime::createFromFormat($format, $date);
        // The Y ( 4 digits year ) returns TRUE for any integer with any number of digits so changing the comparison from == to === fixes the issue.
        return $d && $d->format($format) === $date;
    }

?>