<?php
require_once '../core/init.php';

if(isset($_POST['data'])){

	$data = $_POST['data'];
	$time_st_reload = $_POST['time_st_reload'];
	$kt_doc = $_POST['kt_doc'];
	$kt_ngang = $_POST['kt_ngang'];
	$display_type = $_POST['display_type'];
	$line_selected = $_POST['line_selected'];
	$machine_selected = $_POST['machine_selected'];
	//echo $display_type;

	if($display_type == "line_type"){
		foreach ($data as $key => $value) {
			$sql_get_list_machine = "SELECT * FROM monitor_pc_infomation WHERE line_machine = '" . $line_selected ."|" . $value ."' ORDER BY id DESC";
			if ($db->num_rows($sql_get_list_machine)) $data_machine_line = $db->fetch_assoc($sql_get_list_machine, 1);
			else $data_machine_line = array("id" => "N/A","line_machine" => "N/A","pc_name" => "N/A","pc_ip" => "N/A","pc_mac" => "N/A","pc_cpu" => "N/A","pc_ram" => "N/A","pc_apptoInstall" => "N/A","pc_apptoremove" => "N/A","pc_os" => "N/A","pc_name_cpu" => "N/A","time_stamp" => "N/A");
				//echo var_dump($data_machine_line);
				echo '<div class="col-md-3"><div class="card sticky-top mb-3">
					<div class="card-header">
						<b>'.$line_selected.' - '.$value.'</b>
					</div>
					<div class="card-body">
						<div class="card-text"><b>PC Name:</b> <span >' . $data_machine_line["pc_name"] . '</span></div>
						<div class="card-text"><b>OS Version:</b> <span >' . $data_machine_line["pc_os"] . '</span></div>
						<div class="card-text"><b>CPU Name:</b> <span >' . $data_machine_line["pc_name_cpu"] . '</span></div>
						<div class="card-text"><b>PC IP:</b> <span >' . $data_machine_line["pc_ip"] . '</span></div>
						<div class="card-text"><b>PC MAC:</b> <span >' . $data_machine_line["pc_mac"] . '</span></div>
						<div class="card-text"><b>PC CPU:</b> <span >' . $data_machine_line["pc_cpu"] . '</span></div>
						<div class="card-text"><b>PC RAM:</b> <span >' . $data_machine_line["pc_ram"] . '</span></div>
						<div class="card-text"><b>App Install:</b> <span >' . $data_machine_line["pc_apptoInstall"] . '</span></div>
						<div class="card-text"><b>PC to Remove:</b> <span >' . $data_machine_line["pc_apptoremove"] . '</span></div>
					</div>
				</div></div>';
		}
	}
	else if($display_type == "machine_type"){
		foreach ($data as $key => $value) {
			$sql_get_list_machine = "SELECT * FROM monitor_pc_infomation WHERE line_machine = '" . $value ."|" . $machine_selected ."' ORDER BY id DESC";
			if ($db->num_rows($sql_get_list_machine)) $data_machine_line = $db->fetch_assoc($sql_get_list_machine, 1);
			else $data_machine_line = array("id" => "N/A","line_machine" => "N/A","pc_name" => "N/A","pc_ip" => "N/A","pc_mac" => "N/A","pc_cpu" => "N/A","pc_ram" => "N/A","pc_apptoInstall" => "N/A","pc_apptoremove" => "N/A","pc_os" => "N/A","pc_name_cpu" => "N/A","time_stamp" => "N/A");
				//echo var_dump($data_machine_line);
				echo '<div class="col-md-3"><div class="card sticky-top mb-3">
					<div class="card-header">
						<b>'.$value.' - '.$machine_selected.'</b>
					</div>
					<div class="card-body">
						<div class="card-text"><b>PC Name:</b> <span >' . $data_machine_line["pc_name"] . '</span></div>
						<div class="card-text"><b>OS Version:</b> <span >' . $data_machine_line["pc_os"] . '</span></div>
						<div class="card-text"><b>CPU Name:</b> <span >' . $data_machine_line["pc_name_cpu"] . '</span></div>
						<div class="card-text"><b>PC IP:</b> <span >' . $data_machine_line["pc_ip"] . '</span></div>
						<div class="card-text"><b>PC MAC:</b> <span >' . $data_machine_line["pc_mac"] . '</span></div>
						<div class="card-text"><b>PC CPU:</b> <span >' . $data_machine_line["pc_cpu"] . '</span></div>
						<div class="card-text"><b>PC RAM:</b> <span >' . $data_machine_line["pc_ram"] . '</span></div>
						<div class="card-text"><b>App Install:</b> <span >' . $data_machine_line["pc_apptoInstall"] . '</span></div>
						<div class="card-text"><b>PC to Remove:</b> <span >' . $data_machine_line["pc_apptoremove"] . '</span></div>
					</div>
				</div></div>';
		}	
	}
	




	/*if($display_type = "1"){
		$sql_get_list_machine = "SELECT * FROM monitor_pc_infomation WHERE line_machine = '$line_selected.'|'.$data[0]' ORDER BY id DESC";
		if ($db->num_rows($sql_get_list_machine)){
			$data_TH = $db->fetch_assoc($sql_get_list_machine, 1);
			echo var_dump($data_TH);
		}
	}*/
}




?>
