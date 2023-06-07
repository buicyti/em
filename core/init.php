<?php

// Require các thư viện PHP
require_once ($_SERVER['DOCUMENT_ROOT'] . '/EM/core/DB.php');
require_once ($_SERVER['DOCUMENT_ROOT'] . '/EM/core/Session.php');
require_once ($_SERVER['DOCUMENT_ROOT'] . '/EM/core/Functions.php');

	
// Kết nối database
$db = new DB();
$db->connect();
$db->set_char('utf8');

// Biến điạ chỉ website
$_DOMAIN = 'http://' . $_SERVER["SERVER_NAME"] . '/EM/';

//tạo biến ghi thời gian hiện tại
date_default_timezone_set('Asia/Ho_Chi_Minh');
$date_current = $db->fetch_assoc('SELECT CURRENT_TIMESTAMP()',1)['CURRENT_TIMESTAMP()'];// lấy thời gian của server làm thời gian mặc định


// Khởi tạo session
$session = new Session();
$session->start();

// Kiểm tra session
if ($session->get() != '')
{
	$user = $session->get();
}
else
{
	$user = '';
}

// Nếu đăng nhập
if ($user)
{
	// Lấy dữ liệu tài khoản
	$sql_get_data_user = "SELECT * FROM accounts,acc_infomation WHERE accounts.user_name = '$user' AND accounts.user_id = acc_infomation.id_employee";
	if ($db->num_rows($sql_get_data_user))
	{
		$data_user = $db->fetch_assoc($sql_get_data_user, 1);
	}
}

?>