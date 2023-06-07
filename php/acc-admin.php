<?php
	require_once '../core/init.php';
    //$db->set_char('utf8mb4');
    if (isset($_POST['action']) && $data_user['part'] == 10){
        $action = $_POST['action'];
        if($action == "loadAccounts"){
            $sql_load_accounts = "SELECT user_name,user_id,name_employee,part,position,job,status,registration_time,last_login FROM accounts t1, acc_infomation t2 WHERE t1.user_id = t2.id_employee AND t1.part != '10'";
            if($db->num_rows($sql_load_accounts)){
                echo json_encode($db->fetch_assoc($sql_load_accounts, 0)) ;
            }
        }
        elseif($action == "changeStatus"){
            $dtStt = $_POST['dtStt'];
            $stt = $_POST['stt'];
            $tb = '';
            if($stt == "edit"){
                foreach($dtStt as $key => $dt){
                    $sql_check_user_name = "SELECT user_name FROM accounts WHERE user_name='". $dt['user_name'] ."'";
                    if($db->num_rows($sql_check_user_name)){
                        $sql_update_acc = "UPDATE accounts SET status='". $dt['status'] ."',job='". $dt['job'] ."',position='". $dt['position'] ."',part='". $dt['part'] ."' WHERE user_name='". $dt['user_name'] ."'";
                        $db->query($sql_update_acc);
                        $tb .= 'Đã cập nhật thông tin của '. $dt['user_name'];
                    }
                    else $tb .= 'Không tồn tại tên tài khoản '. $dt['user_name'];
                }
            }
            elseif($stt == "del"){
                foreach($dtStt as $key => $dt){
                    $sql_check_user_name = "SELECT user_name FROM accounts WHERE user_name='". $dt['user_name'] ."'";
                    if($db->num_rows($sql_check_user_name)){
                        $sql_update_acc = "DELETE FROM accounts WHERE user_name='". $dt['user_name'] ."'";
                        $db->query($sql_update_acc);
                        $tb .= 'Đã xoá thông tin của '. $dt['user_name'];
                    }
                    else $tb .= 'Không tồn tại tên tài khoản '. $dt['user_name'];
                }
            }
           echo $tb;
        }
    }
    $db->close();
?>