<?php

require_once '../core/init.php';

if (isset($_POST['action'])) {
    if($_POST['action'] == 'check_idcard'){
        $idCard = $_POST['data'];
        $sql_check_cardid = "SELECT id_employee FROM checklist_strap_card_id WHERE card_id='$idCard'";
        if($db->num_rows($sql_check_cardid) == 1){
            $sql_check_cardid = "SELECT t1.id_employee, name_employee, nhom, ca_kip FROM checklist_strap_card_id t1, acc_infomation t2 WHERE t1.id_employee=t2.id_employee AND card_id='$idCard'";
            $dl = $db->fetch_assoc($sql_check_cardid, 1);
            echo json_encode(array("ma" => 1, "color" => "orange", "tb" => "Mã thẻ đã tồn tại", "id_emp" => $dl['id_employee'], "name_emp" => $dl['name_employee'], "nhom" => $dl['nhom'], "ca" => $dl['ca_kip']));
        } else if($db->num_rows($sql_check_cardid) > 1){
            echo json_encode(array("ma" => 2, "color" => "red", "tb" => "Mã thẻ này bị trùng ID. Cần liên hệ người quản lý để xử lý!"));
        } else {
            echo json_encode(array("ma" => 3, "color" => "green", "tb" => "Mã thẻ OK"));
        }
        $db->close();
    }
    elseif($_POST['action'] == 'check_idemp'){
        $idEmp= $_POST['data'];
        $sql_check_idEmp = "SELECT id_employee, name_employee, nhom, ca_kip FROM acc_infomation WHERE id_employee='$idEmp'";
        if($db->num_rows($sql_check_idEmp)){
            $dl = $db->fetch_assoc($sql_check_idEmp, 1);
            $sql_check_idcard = "SELECT * FROM checklist_strap_card_id WHERE id_employee='$idEmp'";
            if($db->num_rows($sql_check_idcard) == 1) echo json_encode(array("ma" => 1, "color" => "orange", "tb" => "Đã có thông tin cho ID này!", "id_emp" => $dl['id_employee'], "name_emp" => $dl['name_employee'], "nhom" => $dl['nhom'], "ca" => $dl['ca_kip']));
            elseif($db->num_rows($sql_check_idcard) > 1) echo json_encode(array("ma" => 4, "color" => "red", "tb" => "Tồn tại 2 ID này trong bảng IdCard. Liên hệ người quản lý để được xử lý!"));
            else echo json_encode(array("ma" => 2, "color" => "green", "tb" => "Thông tin OK", "id_emp" => $dl['id_employee'], "name_emp" => $dl['name_employee'], "nhom" => $dl['nhom'], "ca" => $dl['ca_kip']));
        } else {
            echo json_encode(array("ma" => 3, "color" => "red", "tb" => "Không có thông tin ID này trong danh sách nhân viên. Liên hệ người quản lý để được xử lý!"));
        }
        $db->close();
    } elseif($_POST['action'] == 'showMap'){
        $sql_get_list_map = "SELECT t1.id_employee, name_employee, nhom, ca_kip, card_id FROM checklist_strap_card_id t1, acc_infomation t2 WHERE t1.id_employee=t2.id_employee";
        if($db->num_rows($sql_get_list_map)){
            foreach($db->fetch_assoc($sql_get_list_map, 0) as $listmap){
                $listmap['card_id'] = (strlen($listmap['card_id']) == 10 ? substr($listmap['card_id'], 0, 4).'****'.substr($listmap['card_id'], -2, strlen($listmap['card_id'])) : 'Lỗi');
                $dulieu[] = array("idemp" => $listmap['id_employee'], 'nameemp' => $listmap['name_employee'], 'nhom' => $listmap['nhom'], 'ca' => $listmap['ca_kip'], 'cardid' => $listmap['card_id']);
            }
            echo json_encode($dulieu);
        }
    } elseif($_POST['action'] == 'insertToTab'){
        $db->query("INSERT INTO checklist_strap_card_id(id_employee, card_id, checks) VALUES ('". $_POST['idemp'] ."', '". $_POST['idcard'] ."', '0')");
        $db->close();
        echo 'Thêm mới dữ liệu thành công';
    } elseif($_POST['action'] == 'updateByIdcard'){
        $db->query("UPDATE checklist_strap_card_id SET id_employee='". $_POST['idemp'] ."' WHERE card_id='". $_POST['idcard'] ."'");
        $db->close();
        echo 'Cập nhật dữ liệu theo ID Card';
    } elseif($_POST['action'] == 'updateByIdemp'){
        $db->query("UPDATE checklist_strap_card_id SET card_id='". $_POST['idcard'] ."' WHERE id_employee='". $_POST['idemp'] ."'");
        $db->close();
        echo 'Cập nhật theo ID Nhân viên';
    }
}

