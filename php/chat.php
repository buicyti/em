<?php
require_once '../core/init.php';

$db->set_char('utf8mb4');

if (isset($_POST['show_list'])) {
    $show_list = $_POST['show_list'];
    if ($show_list == 'list_user') {
        $sql_get_list_users = "SELECT * FROM accounts t1, acc_infomation t2 WHERE t1.user_id=t2.id_employee AND t1.user_name != '$user' ORDER BY id ASC";
        if($db->num_rows($sql_get_list_users)){
            $users_name = null;
            $users_displayname = null;
            $users_avatar = null;
            $last_mess = null;
            $num_mess_new = null;
            foreach ($db->fetch_assoc($sql_get_list_users, 0) as $key => $list_users) {
                // lấy thông tin người dùng
                $users_name = $list_users['user_name'];
                $users_displayname = $list_users['name_employee'];
                if($list_users['anh_dai_dien'] == null) $users_avatar = $_DOMAIN.'assets/images/user-profile.png';
                else $users_avatar = $_DOMAIN .'assets/images/avatars/'. $list_users['anh_dai_dien'];
                if (floor(abs(strtotime($date_current) - strtotime($list_users['last_login'])) / 60) < 60) $login_status = 'status-green';
				else $login_status = 'status-gray';
                //Lấy tin nhắn cuối cùng
                $sql_get_last_mess = "SELECT messages FROM chat WHERE (sender_userid='$user' AND reciever_userid='$users_name') OR (sender_userid='$users_name' AND reciever_userid='$user') ORDER BY chatid DESC ";
                if($db->num_rows($sql_get_last_mess)) $last_mess = $db->fetch_assoc($sql_get_last_mess,1)['messages'];
                else $last_mess = 'Bắt đầu nhắn tin nào!';
                //Lấy số tin nhắn chưa đọc
                $sql_get_num_mess_new = "SELECT status FROM chat WHERE sender_userid='$users_name' AND reciever_userid='$user' AND status='0'";
                $num_mess_new = $db->num_rows($sql_get_num_mess_new);
                if($num_mess_new > 0) $num_mess_new = '<span class="badge badge-sm bg-success ms-2">'.$num_mess_new.'</span>';
                else $num_mess_new = '';

                echo    '<div class="friend-drawer" id="user_'.$users_name.'">
                            <span class="'.$login_status.'"></span>
                            <img class="avatar" src="'.$users_avatar.'" alt="'.$users_displayname.'">
                            <div class="text">
                                <h6>'.$users_displayname.$num_mess_new.'</h6>
                                <p class="text-muted">'.$last_mess.'</p>
                            </div>
                            <span class="time text-muted small">13:21</span>
                        </div>';
            }
        }
    }
    elseif($show_list == 'list_group'){
        echo
        '   
        <div class="add-group">
            <input type="text" name="creat_group" placeholder="Tạo nhóm mới..."/>
            <input type="button" value="Tạo" name="btn_creat_group"/>
        </div>
        ';
        $sql_get_list_group = "SELECT DISTINCT reciever_userid FROM chat WHERE m_type='1' ORDER BY chatid DESC";
        if($db->num_rows($sql_get_list_group)){
            foreach($db->fetch_assoc($sql_get_list_group,0) as $key => $list_group){
                $group = $list_group['reciever_userid'];
                $data_last_mess = $db->fetch_assoc("SELECT messages FROM chat WHERE reciever_userid='$group' AND m_type='1' ORDER BY chatid DESC", 1)['messages'];
                echo '<div class="friend-drawer" id="group_'.$key.'">
                        <span class="status-green"></span>
                        <img class="avatar" src="'.$_DOMAIN.'assets/images/user-profile.png" alt="'.$list_group['reciever_userid'].'">
                        <div class="text">
                            <h6>'.$list_group['reciever_userid'].'</h6>
                            <p class="text-muted">'.$data_last_mess.'</p>
                        </div>
                        <span class="time text-muted small">13:21</span>
                    </div>';
            }
        }
    }
}

if (isset($_POST['get_list'])) {
    $get_list = $_POST['get_list'];
    if($get_list == "list_user"){
        $sql_get_list_usersname = "SELECT user_name FROM accounts WHERE user_name != '$user' ORDER BY id ASC";
        if($db->num_rows($sql_get_list_usersname)){
            foreach ($db->fetch_assoc($sql_get_list_usersname, 0) as $key => $list_usersname) {
                $get_lists[] =$list_usersname['user_name'];
            }
            echo json_encode($get_lists);
        }
    }
    elseif($get_list == "list_group"){
        $sql_get_list_groupname = "SELECT DISTINCT reciever_userid FROM chat WHERE m_type='1' ORDER BY chatid DESC";
        if($db->num_rows($sql_get_list_groupname)){
            foreach ($db->fetch_assoc($sql_get_list_groupname, 0) as $key => $list_groupname) {
                $get_lists[] =$list_groupname['reciever_userid'];
            }
            echo json_encode($get_lists);
        }
    }
}
//tải tất cả tin nhắn đã đọc vào chatbox
if(isset($_POST['load_mess'])){
    $him_user = $_POST['load_mess'];
    $sql_get_user_mess = "SELECT * FROM chat WHERE (sender_userid='$user' AND reciever_userid='$him_user') OR (sender_userid='$him_user' AND reciever_userid='$user') ORDER BY chatid ASC ";
    if($db->num_rows($sql_get_user_mess)){
        foreach($db->fetch_assoc($sql_get_user_mess, 0) as $key => $data_mess){ //Tải tất cả tin nhắn
            $i_sticker = 0;
            if(substr_count($data_mess["messages"], '(:') == 1 && substr_count($data_mess["messages"], ':)') == 1 && strpos($data_mess["messages"], '(:') == 0 && strlen($data_mess["messages"]) - strpos($data_mess["messages"], ':)') - 1 == 1) $i_sticker = 1;
            
            $data_mess["messages"] = preg_replace('/\(\:(.*?)\:\)/isu', '<img src="assets/images/emojis/popo/$1.png" alt"$1">', $data_mess["messages"]);
            if($data_mess['sender_userid'] == $user){
                if($i_sticker) echo '<li class="sticker_me">'.$data_mess["messages"].'</li>';
                else echo '<li class="me">'.$data_mess["messages"].'</li>';
            }
            else if($data_mess['sender_userid'] == $him_user){
                if($i_sticker) echo '<li class="sticker_him">'.$data_mess["messages"].'</li>';
                else echo '<li class="him">'.$data_mess["messages"].'</li>';
            }
        }
        //Cập nhật tin đã đọc
        $sql_update_status = "UPDATE chat SET status='1' WHERE sender_userid='$him_user' AND reciever_userid='$user' AND status='0'";
        $db->query($sql_update_status);
        $db->close();
    }
}

if(isset($_POST['group_mess'])){
    $gr_id = $_POST['group_mess'];
    $sql_get_user_mess = "SELECT * FROM chat WHERE reciever_userid='$gr_id' AND m_type='1' ORDER BY chatid ASC ";
    if($db->num_rows($sql_get_user_mess)){
        //$him_mess_num = 0; // đếm số tin nhắn liên tục của người khác
        foreach($db->fetch_assoc($sql_get_user_mess, 0) as $key => $data_mess){ //Tải tất cả tin nhắn
            $i_sticker = '';
            if(substr_count($data_mess["messages"], '(:') == 1 && substr_count($data_mess["messages"], ':)') == 1 && strpos($data_mess["messages"], '(:') == 0 && strlen($data_mess["messages"]) - strpos($data_mess["messages"], ':)') - 1 == 1) $i_sticker = 'sticker_';
            
            $data_mess["messages"] = preg_replace('/\(\:(.*?)\:\)/isu', '<img src="assets/images/emojis/popo/$1.png" alt"$1">', $data_mess["messages"]);
            if($data_mess['sender_userid'] === $user){
                echo '<li class="'.$i_sticker.'me">'.$data_mess["messages"].'</li>';
                //$him_mess_num = 0; //đưa về 0
            }
            else
            {
                //$him_name = '';
                //$him_mess_num ++;
                $sql_lay_ten_user = "SELECT user_name,name_employee,anh_dai_dien FROM accounts t1, acc_infomation t2 WHERE t1.user_id=t2.id_employee AND t1.user_name='".$data_mess["sender_userid"]."'";
                if($db->num_rows($sql_lay_ten_user)){
                    $data_user = $db->fetch_assoc($sql_lay_ten_user , 1);
                    if($data_user['anh_dai_dien'] == null) $users_avatar = $_DOMAIN.'assets/images/user-profile.png';
                    else $users_avatar = $_DOMAIN . $data_user['anh_dai_dien'];

                    //if($him_mess_num == 1 && $him_name !== $data_user['user_name']){
                        echo '
                        <li class="him-group">
                            <img class="avatar" src="'.$users_avatar.'" alt="">
                            <div class="text">
                                <h6><b>'.$data_mess["sender_userid"].'</b></h6>
                                <div class="'.$i_sticker.'him">'.$data_mess["messages"].'</div>
                            </div>
                        </li>';
                        //$him_name = $data_user['user_name'];
                       // $him_mess_num = 0;
                    //}
                    //else
                   // echo '<div class="'.$i_sticker.'him" style="margin: 5px 0 5px 43px;">'.$data_mess["messages"].'</div>';
                }
            }
        }
        /*/Cập nhật tin đã đọc
        $sql_update_status = "UPDATE chat SET status='1' WHERE sender_userid='$him_user' AND reciever_userid='$user' AND status='0'";
        $db->query($sql_update_status);
        $db->close();*/
    }
}

//cập nhật tin nhắn của người đang nhắn tin
if(isset($_POST['load_new_mess'])){
    $him_user = $_POST['load_new_mess'];
    $type_chat = $_POST['type_chat'];
    if($type_chat == 0){ //hiện tin nhắn riêng mới
        $sql_get_new_mess = "SELECT messages FROM chat WHERE sender_userid='$him_user' AND reciever_userid='$user' AND status='0'";
        if($db->num_rows($sql_get_new_mess)){
            foreach($db->fetch_assoc($sql_get_new_mess, 0) as $data_mess){
                $i_sticker = '';
                if(substr_count($data_mess["messages"], '(:') == 1 && substr_count($data_mess["messages"], ':)') == 1 && strpos($data_mess["messages"], '(:') == 0 && strlen($data_mess["messages"]) - strpos($data_mess["messages"], ':)') - 1 == 1) $i_sticker = 'sticker_';
                $data_mess["messages"] = preg_replace('/\(\:(.*?)\:\)/isu', '<img src="assets/images/emojis/popo/$1.png" alt"$1">', $data_mess["messages"]);
                
                 echo '<li class="'.$i_sticker.'him">'.$data_mess["messages"].'</li>';
            }
            
        }
        //Cập nhật tin đã đọc
        $sql_update_status = "UPDATE chat SET status='1' WHERE sender_userid='$him_user' AND reciever_userid='$user' AND status='0'";
            $db->query($sql_update_status);
            $db->close();
    }
    elseif($type_chat == 1){ //hiện tin nhắn chát nhóm mới
        $sql_get_new_mess = "SELECT chatid,messages,user_readed,sender_userid,anh_dai_dien FROM chat t1,accounts t2, acc_infomation t3 WHERE t1.sender_userid = t2.user_name AND t2.user_id=t3.id_employee AND t1.sender_userid!='$user' AND t1.reciever_userid='$him_user' AND t1.user_readed NOT LIKE '%$user%'";
        $user_readed = '';
        if($db->num_rows($sql_get_new_mess)){
            foreach($db->fetch_assoc($sql_get_new_mess, 0) as $data_mess){
                $i_sticker = '';
                if(substr_count($data_mess["messages"], '(:') == 1 && substr_count($data_mess["messages"], ':)') == 1 && strpos($data_mess["messages"], '(:') == 0 && strlen($data_mess["messages"]) - strpos($data_mess["messages"], ':)') - 1 == 1) $i_sticker = 'sticker_';
                $data_mess["messages"] = preg_replace('/\(\:(.*?)\:\)/isu', '<img src="assets/images/emojis/popo/$1.png" alt"$1">', $data_mess["messages"]);
                $user_readed = $data_mess["user_readed"].$user.',';
                if($data_mess['anh_dai_dien'] == null) $users_avatar = $_DOMAIN.'assets/images/user-profile.png';
                    else $users_avatar = $_DOMAIN . 'assets/images/avatars/' . $data_mess['anh_dai_dien'];
                //echo $user_readed;
                echo '
                <li class="him-group">
                    <img class="avatar" src="'.$users_avatar.'" alt="">
                    <div class="text">
                        <h6><b>'.$data_mess["sender_userid"].'</b></h6>
                        <div class="'.$i_sticker.'him">'.$data_mess["messages"].'</div>
                    </div>
                </li>';

                //Cập nhật tin đã đọc
                $sql_update_status = "UPDATE chat SET user_readed='$user_readed' WHERE chatid='" . $data_mess["chatid"] . "'";
                $db->query($sql_update_status);
            }
            $db->close();
        }   
    }
}


//thêm dữ liệu vào MySQL 
if(isset($_POST['send_type'])){
    $send_type = $_POST['send_type'];
    $send_mess = $_POST['send_mess'];
    $send_to_user = $_POST['send_to_user'];
    //if($send_type == 'private'){
        $sql_add_mess = "INSERT INTO chat(sender_userid, reciever_userid, messages, m_type) VALUES('$user','$send_to_user','$send_mess','$send_type')";
        $db->query($sql_add_mess);
        $db->close();
        //echo 'Gửi thành công';
    //}
}


//tạo nhóm mới
if(isset($_POST['creat_gr_name'])){
    $creat_gr_name = $_POST['creat_gr_name'];
    $sql_add_gr = "INSERT INTO chat(sender_userid, reciever_userid, messages, m_type) VALUES('$user','$creat_gr_name','Bắt đầu chat nào','1')";
    $db->query($sql_add_gr);
    $db->close();
}
?>