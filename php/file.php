

<?php
require_once '../core/init.php';
if (!isset($user)) die();
if (isset($_POST['action'])) {
	$action = trim(addslashes(htmlspecialchars($_POST['action'])));
	if ($action == 'loadDomain') {
		echo $_DOMAIN;
	} elseif ($action == 'uploadFile' && isset($_FILES['fileUpload'])) {
		$tb = '';
		foreach ($_FILES['fileUpload']['name'] as $name => $value) {
			$dir = "../upload/";
			$name_file = stripslashes($_FILES['fileUpload']['name'][$name]);
			$source_file = $_FILES['fileUpload']['tmp_name'][$name];
			$size_file = $_FILES['fileUpload']['size'][$name]; // Dung lượng file
			// Lấy ngày, tháng, năm hiện tại
			$day_current = substr($date_current, 8, 2);
			$month_current = substr($date_current, 5, 2);
			$year_current = substr($date_current, 0, 4);

			// Tạo folder năm hiện tại
			if (!is_dir($dir . $year_current)) mkdir($dir . $year_current . '/');
			// Tạo folder tháng hiện tại
			if (!is_dir($dir . $year_current . '/' . $month_current)) mkdir($dir . $year_current . '/' . $month_current . '/');
			// Tạo folder ngày hiện tại
			if (!is_dir($dir . $year_current . '/' . $month_current . '/' . $day_current)) mkdir($dir . $year_current . '/' . $month_current . '/' . $day_current . '/');

			$path_file = $dir . $year_current . '/' . $month_current . '/' . $day_current . '/' . $name_file; // Đường dẫn thư mục chứa file
			if (file_exists($path_file))
				$tb .= '<div class="alert alert-danger">File <b>' . $name_file . '</b> đã tồn tại!</div>';
			else {
				move_uploaded_file($source_file, $path_file); // Upload file
				$type_file = strtolower(pathinfo($path_file, PATHINFO_EXTENSION));
				$url_file = substr($path_file, 3); // Đường dẫn file

				// Thêm dữ liệu vào table
				$sql_up_file = "INSERT INTO files(slug_file, url_file, type_file, size_file, employee_up) VALUES ('$name_file', '$url_file', '$type_file', '$size_file', '".$data_user['name_employee']."')";
				$db->query($sql_up_file);
				$tb .= '<div class="alert alert-success">Thêm thành công file <b>' . $name_file . '</b></div>';
			}
		}
		echo $tb;
	} elseif ($action == 'loadFileList') {
		$sql_load_list = "SELECT * FROM files";
		$data_file = array();
		if ($db->num_rows($sql_load_list)) {
			foreach ($db->fetch_assoc($sql_load_list, 0) as $k => $dulieu) {
				$status_f = (file_exists('../' . $dulieu["url_file"]) ? "Tồn tại" : "Không tồn tại");
				if ($dulieu["size_file"] < 1024) {
					$size_f = $dulieu["size_file"] . ' B';
				} else if ($dulieu["size_file"] < 1048576) {
					$size_f = round($dulieu["size_file"] / 1024) . ' KB';
				} else if ($dulieu["size_file"] > 1048576) {
					$size_f = round($dulieu["size_file"] / 1024 / 1024) . ' MB';
				}
				$data_file[] = array("id_file" => $dulieu["id_file"], "slug_file" => $dulieu["slug_file"], "type_file" => $dulieu["type_file"], "size_file" => $size_f, "date_upload" => $dulieu["date_upload"], "status_file" => $status_f, "url_file" => $dulieu["url_file"], "employee_up" => $dulieu["employee_up"]);
			}
			echo json_encode($data_file);
		}
	} elseif ($action == 'delFile' && $data_user['part'] == 10) {
		$file_info = $_POST['file_info'];
		if (file_exists('../' . $file_info['url_file']))
			unlink('../' . $file_info['url_file']);
		$sql_delete_file = "DELETE FROM files WHERE id_file = '" . $file_info['id_file'] . "'";
		$db->query($sql_delete_file);
	}elseif ($action == 'delAllFile' && $data_user['part'] == 10) {
		$file_info = $_POST['file_info'];
		foreach($file_info as $fi){
			if (file_exists('../' . $fi['url_file']))
				unlink('../' . $fi['url_file']);
			$sql_delete_file = "DELETE FROM files WHERE id_file = '" . $fi['id_file'] . "'";
			$db->query($sql_delete_file);
		}
		
	}
	$db->close();
}




die();
// Nếu đăng nhập
if ($user) {
	if ($action == 'delete_file') {
		$idd_file = $_POST['idd_file'];
		$sql_check_permission = "SELECT * FROM accounts WHERE user_name='$user'";
		if ($db->num_rows($sql_check_permission)) {
			$data_per = $db->fetch_assoc($sql_check_permission, 1);
			if ($data_per['part'] != 10) {
				echo 'Bạn không đủ quyền để xóa File!';
			} else {
				$sql_check_id_file_exist = "SELECT * FROM files WHERE id = '$idd_file'";
				if ($db->num_rows($sql_check_id_file_exist)) {
					$data_files = $db->fetch_assoc($sql_check_id_file_exist, 1);
					if (file_exists('../' . $data_files['url_file'])) {
						unlink('../' . $data_files['url_file']);
					}

					$sql_delete_file = "DELETE FROM files WHERE id = '$idd_file'";
					$db->query($sql_delete_file);
					$db->close();
					echo 'Thành công!';
				}
			}
		}
	} elseif ($action == 'delete_file_list') {
		$sql_check_permission = "SELECT * FROM accounts WHERE user_name='$user'";
		if ($db->num_rows($sql_check_permission)) {
			$data_per = $db->fetch_assoc($sql_check_permission, 1);
			if ($data_per['part'] != 10) {
				echo 'Bạn không đủ quyền để xóa File!';
			} else {
				foreach ($_POST['id_files'] as $key => $id_files) {
					$sql_check_id_files_exist = "SELECT * FROM files WHERE id = '$id_files'";
					if ($db->num_rows($sql_check_id_files_exist)) {
						$data_files = $db->fetch_assoc($sql_check_id_files_exist, 1);
						if (file_exists('../' . $data_files['url_file'])) {
							unlink('../' . $data_files['url_file']);
						}

						$sql_delete_img = "DELETE FROM files WHERE id = '$id_files'";
						$db->query($sql_delete_img);
					}
				}
				$db->close();
			}
		}
	}
}



?>