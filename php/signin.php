<?php

// Kết nối database và thông tin chung
require_once '../core/init.php';
if (isset($_POST['action']))
	{
		$action = trim(addslashes(htmlspecialchars($_POST['action'])));
		if ($action == 'login')
		{
			// Xử lý các giá trị 
			$user_signin = trim(htmlspecialchars(addslashes($_POST['user_signin'])));
			$pass_signin = trim(htmlspecialchars(addslashes($_POST['pass_signin'])));
			$checkbox = $_POST['check_box'];
			// Các biến xử lý thông báo
			$show_alert = '<script>$("#login .alert").removeClass("hidden");</script>';
			$hide_alert = '<script>$("#login .alert").addClass("hidden");</script>';
			$success = '<script>$("#login .alert").attr("class", "alert alert-success");</script>';
			$date_current = date('Y-m-d H:i:s');
			// Nếu giá trị rỗng
			if ($user_signin == '' || $pass_signin == '')
			{
				echo $show_alert.'Vui lòng điền đầy đủ thông tin.';
			}
			// Ngược lại
			else
			{
				$sql_check_user_exist = "SELECT user_name FROM accounts WHERE user_name = '$user_signin'";
				// Nếu tồn tại username
				if ($db->num_rows($sql_check_user_exist))
				{
					$pass_signin_md5 = md5($pass_signin);
					$sql_check_signin = "SELECT user_name, user_password FROM accounts WHERE user_name = '$user_signin' AND user_password = '$pass_signin_md5'";
					if ($db->num_rows($sql_check_signin))
					{
						$sql_check_stt = "SELECT user_name, user_password, status FROM accounts WHERE user_name = '$user_signin' AND user_password = '$pass_signin_md5' AND status = '1'";
						// Nếu username và password khớp và tài khoản không bị khoá (status = 1)
						if ($db->num_rows($sql_check_stt))
						{
							$sql_update_lastlogin = "UPDATE accounts SET last_login = '$date_current' WHERE user_name = '$user_signin'";
							$db->query($sql_update_lastlogin); //cập nhật thời gian đăng nhập
							// Lưu session
							$session->send($user_signin);
							$db->close(); // Đóng kết nối
							if($checkbox == true){
								setcookie('user',$user_signin,time()+3600,'/','',0,0);
								setcookie('pass',$pass_signin,time()+3600,'/','',0,0);
							}
							else{
								setcookie('user','',time()-3600,'/','',0,0);
								setcookie('pass','',time()-3600,'/','',0,0);
							}
							echo $show_alert.$success.'Đăng nhập thành công.';
							new Redirect($_DOMAIN); // Trở về trang index
						}
						else
						{
							echo $show_alert.'Tài khoản của bạn đã bị khoá hoặc chưa kích hoạt, vui lòng liên hệ quản trị viên để biết thêm thông tin chi tiết.';
						}
					}
					else
					{
						echo $show_alert.'Mật khẩu không chính xác.';
					}
				}
				// Ngược lại không tồn tại username
				else
				{
					echo $show_alert.'Tên đăng nhập không tồn tại.';
				}
			}
		}


		elseif ($action == 'signup'){
			// Xử lý các giá trị
			$username_reg = trim(htmlspecialchars(addslashes($_POST['username_reg'])));
			$userid_reg = trim(htmlspecialchars(addslashes($_POST['userid_reg'])));
			$pass_reg = trim(htmlspecialchars(addslashes($_POST['pass_reg'])));
			$re_pass_reg = trim(htmlspecialchars(addslashes($_POST['re_pass_reg'])));

			// Các biến xử lý thông báo
			$show_alert = '<script>$("#register .alert").removeClass("hidden");</script>';
			$hide_alert = '<script>$("#register .alert").addClass("hidden");</script>';
			$success = '<script>$("#register .alert").attr("class", "alert alert-success");</script>';

			// Kiểm tra tên đăng nhập
			$sql_check_un_exist = "SELECT user_name FROM accounts WHERE user_name = '$username_reg'";
			$sql_check_userid1 = "SELECT user_id FROM accounts WHERE user_id = '$userid_reg'";
			$sql_check_userid2 = "SELECT id_employee FROM acc_infomation WHERE id_employee = '$userid_reg'";

			if ($userid_reg == '' || $username_reg == '' || $pass_reg == '' || $re_pass_reg == '') {
				echo $show_alert.'Vui lòng điền đầy đủ thông tin.';
			} else if (strlen($userid_reg) !== 7) {
				echo $show_alert.'Mã nhân viên không đúng';
			} else if (strlen($username_reg) < 6 || strlen($username_reg) > 32) {
				echo $show_alert.'Tên đăng nhập nằm trong khoảng 6-32 ký tự.';
			} else if (preg_match('/\W/', $username_reg)) {
				echo $show_alert.'Tên đăng nhập không chứa kí tự đậc biệt và khoảng trắng.';
			} else if ($db->num_rows($sql_check_un_exist)) {
				echo $show_alert.'Tên đăng nhập đã tồn tại.';
			} else if ($db->num_rows($sql_check_userid1)) {
				echo $show_alert.'Mã nhân viên đã được sử dụng cho tài khoản khác';
			} else if ($db->num_rows($sql_check_userid2) <= 0) {
				echo $show_alert.'Không tồn tại mã nhân viên này trong danh sách';
			} else if (strlen($pass_reg) < 6) {
				echo $show_alert.'Mật khẩu quá ngắn.';
			} else if ($pass_reg != $re_pass_reg) {
				echo $show_alert.'Mật khẩu nhập lại không khớp.';
			} else {
				$pass_reg = md5($pass_reg);
				$sql_add_acc = "INSERT INTO accounts(user_name, user_password, user_id) VALUES ('$username_reg', '$pass_reg', '$userid_reg' )";
				$db->query($sql_add_acc);
				$db->close();

				echo $show_alert.$success.'Thêm tài khoản thành công.';
			}
		}

}
// Nếu có tồn tại phương thức post
// Ngược lại không tồn tại phương thức post
else
{
	new Redirect($_DOMAIN); // Trở về trang index
}

?>