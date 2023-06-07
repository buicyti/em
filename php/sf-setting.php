
<?php

require_once '../core/init.php';

if (isset($_POST['action'])) {
    if ($_POST['action'] == 'lay-thong-tin-line') {
        $line_name = $_POST['line_id'];
        $sql_lay_thong_tin_line = "SELECT machine_name FROM current_machine_status t1, sf_machine_list t2 WHERE line_name='$line_name' AND t1.machine_id = t2.machine_id ORDER BY t1.machine_no ASC";
        if ($db->num_rows($sql_lay_thong_tin_line)) {
            foreach ($db->fetch_assoc($sql_lay_thong_tin_line, 0) as $data_machine) {
                $list_machine[] = $data_machine['machine_name'];
            }
        }
        echo json_encode($list_machine);
    } elseif ($_POST['action'] == 'lay-ds-machine') {
        $sql_lay_ds_machine = "SELECT machine_name FROM sf_machine_list WHERE machine_pc='0' OR machine_pc='1' ORDER BY id_no ASC";
        if ($db->num_rows($sql_lay_ds_machine)) {
            foreach ($db->fetch_assoc($sql_lay_ds_machine, 0) as $data_machine) {
                $list_machine[] = $data_machine['machine_name'];
            }
        }
        echo json_encode($list_machine);
    } elseif ($_POST['action'] == 'delete-ds-line') {
        $del_line = $_POST['del_line'];
        if($data_user['part'] == 10){ //kiểm tra có đủ quyền để xóa không?
            $sql_check_line = "SELECT id_no FROM current_machine_status WHERE line_name='$del_line'";
            $sql_del_line = "DELETE FROM current_machine_status WHERE line_name='$del_line'";
            if($db->num_rows($sql_check_line)){
                $db->query($sql_del_line);
                $db-> close();
            echo 'Xóa thông tin line '. $del_line .' thành công';
            }
            else echo 'Không tồn tại thông tin của line ' . $del_line;
        }
        else echo 'Bạn không có quyền xóa thông tin line!';
    } elseif ($_POST['action'] == 'update-ds-line') {
        $update_line = $_POST['update_line'];
        $selectedMachine = $_POST['selectedMachine'];
        
        foreach($db->fetch_assoc("SELECT * FROM sf_machine_list", 0) as $list){
            $machine[$list['machine_name']] = $list['machine_id'];
        }
        if($data_user['part'] == 10){ //kiểm tra có đủ quyền để xóa không?
            foreach($selectedMachine as $key => $machi){
                $key = $key + 1;
                $sql_update_machine = "SELECT id_no FROM current_machine_status WHERE line_name='$update_line' AND machine_id='" . $machine[$machi]. "'";
                if($db->num_rows($sql_update_machine)){//update
                    $sql_update_machine = "UPDATE current_machine_status SET machine_no='$key' WHERE id_no='". $db -> fetch_assoc($sql_update_machine,1)['id_no'] ."'";
                    $db->query($sql_update_machine);
                    echo "Cập nhật thành công". $machi;
                }
                else {//insert
                    $sql_update_machine = "INSERT INTO current_machine_status(line_name, machine_no, machine_id) VALUES('$update_line', '$key', '" . $machine[$machi]. "')";
                    $db->query($sql_update_machine);
                    echo "Thêm dữ liệu   thành công". $machi;
                }
            }
            $db -> close();
        }
        else echo 'Bạn không có quyền xóa thông tin line!';
    }
}
