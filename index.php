<?php
include_once 'includes/header.php';
if (!$user) {
  new Redirect($_DOMAIN . 'account/signin.php'); // Trở về trang đăng nhập
}
?>

<div class="container-fluid">
  <div class="row">
    <div class="col-md-auto sidebar" id="sidebar">
      <div class="logo">
        <div class="logo-full">
          <svg width="200" height="46" alt="Logo">
            <g transform="translate(0.000000,49.000000) scale(0.100000,-0.100000)" stroke="none">
              <path fill="#0056A3" d="M10 370 l0 -60 55 0 55 0 0 60 0 60 -55 0 -55 0 0 -60z" />
              <path fill="#001C36" d="M230 245 l0 -185 50 0 50 0 0 75 0 75 65 0 65 0 0 -76 0 -75 48 3 47 3 0 38 c-1 20 -2 102 -3 182 l-2 145 -45 0 -44 0 -3 -67 -3 -68 -62 -3 -63 -3 0 71 0 70 -50 0 -50 0 0 -185z" />
              <path fill="#001C36" d="M1850 245 l0 -185 40 0 40 0 0 185 0 185 -40 0 -40 0 0 -185z" />
              <path fill="#001C36" d="M680 330 c-35 -9 -70 -41 -70 -66 0 -10 13 -14 40 -14 22 0 40 5 40 10 0 19 46 33 69 21 35 -19 27 -49 -16 -56 -117 -20 -143 -37 -143 -91 0 -51 28 -74 93 -74 29 0 58 5 65 12 9 9 15 9 24 0 7 -7 28 -12 48 -12 l36 0 -4 113 c-5 127 -12 142 -78 157 -45 11 -57 11 -104 0z m100 -170 c0 -40 -40 -68 -75 -52 -43 20 -27 54 32 72 42 13 43 12 43 -20z" />
              <path fill="#001C36" d="M1048 321 c-30 -15 -38 -16 -42 -5 -3 9 -21 14 -46 14 l-40 0 0 -135 0 -135 45 0 45 0 0 86 c0 99 10 124 48 124 45 0 52 -16 52 -118 l0 -93 43 3 42 3 -3 100 c-3 133 -6 144 -47 161 -44 18 -53 18 -97 -5z" />
              <path fill="#001C36" d="M1603 321 c-50 -23 -75 -65 -75 -127 0 -83 53 -134 139 -134 60 0 91 16 121 60 20 29 23 44 20 88 -5 62 -41 106 -97 122 -49 13 -60 13 -108 -9z m98 -60 c19 -15 24 -29 24 -64 0 -53 -17 -77 -56 -77 -41 0 -63 38 -56 92 9 64 45 84 88 49z" />
              <path fill="#001C36" d="M1282 320 c-28 -12 -46 -51 -38 -85 7 -27 35 -43 116 -67 34 -10 45 -18 45 -33 0 -16 -8 -21 -35 -23 -22 -2 -38 2 -45 11 -15 21 -91 26 -87 7 12 -56 59 -76 158 -68 67 6 98 31 98 82 0 48 -16 63 -91 80 -72 16 -93 33 -66 54 24 17 40 15 63 -8 21 -21 90 -28 90 -9 0 6 -13 24 -29 40 -27 26 -36 29 -93 28 -35 0 -73 -4 -86 -9z" />
              <path fill="#007F26" d="M12 128 l3 -63 50 0 50 0 3 63 3 62 -56 0 -56 0 3 -62z" />
            </g>
          </svg><br />
          Hansol Electronic Vietnam
        </div>

        <div class="logo-narrow">
          <svg width="46" height="46" alt="Logo">
            <g transform="translate(0.000000,46.000000) scale(0.100000,-0.100000)" stroke="none">
              <path fill="#0056A3" d="M10 375 l0 -75 45 0 45 0 0 75 0 75 -45 0 -45 0 0 -75z" />
              <path fill="#001C36" d="M190 235 l0 -215 40 0 40 0 0 85 0 85 50 0 50 0 0 -85 0 -85 40 0 40 0 0 215 0 215 -40 0 -40 0 0 -80 0 -80 -50 0 -50 0 0 80 0 80 -40 0 -40 0 0 -215z" />
              <path fill="#007F26" d="M10 95 l0 -75 45 0 45 0 0 75 0 75 -45 0 -45 0 0 -75z" />
            </g>
          </svg>
        </div>

      </div>

      <div class="nav" id="accordion-sidebar" style="overflow-x: hidden;">
        <div class="nav-item" tabindex="0" data-toggle="tooltip" title="Home" data-bs-placement="right">
          <a class="nav-link" href="<?php echo $_DOMAIN; ?>"><span class="nav-icon bi bi-bar-chart-fill"></span>Home</a>
        </div>

        <div class="nav-title">Monitoring</div>

        <div class="nav-item" data-toggle="tooltip" title="DAT" data-bs-placement="right">
          <a class="nav-link" href="<?php echo $_DOMAIN; ?>monitor-dat"><span class="nav-icon bi bi-calendar2-heart"></span>DAT</a>
        </div>

        <div class="nav-item" data-toggle="tooltip" title="Printer" data-bs-placement="right">
          <a class="nav-link" href="<?php echo $_DOMAIN; ?>monitor-printer"><span class="nav-icon bi bi-printer"></span>Printer</a>
        </div>

        <div class="nav-item" data-toggle="tooltip" title="Chip Mouter" data-bs-placement="right">
          <a class="nav-link" href="<?php echo $_DOMAIN; ?>monitor-chip"><span class="nav-icon bi bi-cpu"></span>Chip Mouter</a>
        </div>

        <div class="nav-group-item">
          <a id="flush-heading1" class="nav-link nav-btn-collapsed collapsed" data-bs-toggle="collapse" href="#flush-collapse1" aria-expanded="false" aria-controls="flush-collapse1">
            <span class="nav-icon bi bi-thermometer-snow"></span>Nhiệt độ - độ ẩm
          </a>
          <div id="flush-collapse1" class="collapse" aria-labelledby="flush-heading1" data-bs-parent="#accordion-sidebar">
            <div class="nav-item" data-toggle="tooltip" title="Nhiệt độ - độ ẩm xưởng" data-bs-placement="right">
              <a class="nav-link" href="<?php echo $_DOMAIN; ?>monitor-nhiet-do-va-do-am-xuong"><span class="nav-icon bi bi-thermometer"></span>Xưởng</a>
            </div>
            <div class="nav-item" data-toggle="tooltip" title="Nhiệt độ - độ ẩm tủ LKĐT" data-bs-placement="right">
              <a class="nav-link" href="<?php echo $_DOMAIN; ?>monitor-nhiet-do-va-do-am-tu-LKDT"><span class="nav-icon bi bi-thermometer-half"></span>Tủ LKĐT</a>
            </div>
          </div>
        </div>

        <div class="nav-item" data-toggle="tooltip" title="Monitor Reflow" data-bs-placement="right">
          <a class="nav-link" href="<?php echo $_DOMAIN; ?>monitor-reflow"><span class="nav-icon bi bi-funnel"></span>Reflow</a>
        </div>

        <div class="nav-item" data-toggle="tooltip" title="PC Infomation" data-bs-placement="right">
          <a class="nav-link" href="<?php echo $_DOMAIN; ?>monitor-pc-infomation"><span class="nav-icon bi bi-windows"></span>PC Infomation</a>
        </div>

        <div class="nav-title">Equipment Report</div>
        <div class="nav-item" data-toggle="tooltip" title="Báo cáo hàng ngày" data-bs-placement="right">
          <a class="nav-link" href="<?php echo $_DOMAIN; ?>eq-report-daily"><span class="nav-icon bi bi-clipboard-check"></span>Báo cáo hàng ngày</a>
        </div>

        <div class="nav-title">Checklists strap</div>

        <div class="nav-item" data-toggle="tooltip" title="Xem" data-bs-placement="right">
          <a class="nav-link" href="<?php echo $_DOMAIN; ?>checklist-show"><span class="nav-icon bi bi-clipboard-check"></span>Checklists view</a>
        </div>

        <div class="nav-item" data-toggle="tooltip" title="Cập nhật Nhân viên nghỉ" data-bs-placement="right">
          <a class="nav-link" href="<?php echo $_DOMAIN; ?>checklist-confirm"><span class="nav-icon bi bi-check-circle-fill"></span>Absent Employee</a>
        </div>

        <div class="nav-item" data-toggle="tooltip" title="Cập nhật mã thẻ" data-bs-placement="right">
          <a class="nav-link" href="<?php echo $_DOMAIN; ?>checklist-mapping"><span class="nav-icon bi bi-geo-alt"></span>Mapping</a>
        </div>

        <div class="nav-title">Smart Factory</div>

        <div class="nav-item" data-toggle="tooltip" title="Theo dõi line" data-bs-placement="right">
          <a class="nav-link" href="<?php echo $_DOMAIN; ?>sf-home"><span class="nav-icon bi bi-house"></span>Home</a>
        </div>

        <div class="nav-item" data-toggle="tooltip" title="Thực tại" data-bs-placement="right">
          <a class="nav-link" href="<?php echo $_DOMAIN; ?>sf-lob"><span class="nav-icon bi bi-speedometer2"></span>LOB</a>
        </div>

        <div class="nav-item" data-toggle="tooltip" title="Cài đặt" data-bs-placement="right">
          <a class="nav-link" href="<?php echo $_DOMAIN; ?>sf-settings"><span class="nav-icon bi bi-gear"></span>Cài đặt</a>
        </div>





        <div class="nav-title">Timesheets</div>

        <div class="nav-item" data-toggle="tooltip" title="Chấm công" data-bs-placement="right">
          <a class="nav-link" href="<?php echo $_DOMAIN; ?>cham-cong"><span class="nav-icon bi bi-calendar-week"></span>Chấm công</a>
        </div>

        <div class="nav-item" data-toggle="tooltip" title="Tính lương" data-bs-placement="right">
          <a class="nav-link" href="<?php echo $_DOMAIN; ?>tinh-luong"><span class="nav-icon bi bi-calculator"></span>Tính lương</a>
        </div>

        <div class="nav-title">Machine infomation</div>

        <div class="nav-item" data-toggle="tooltip" title="Tài sản trên line" data-bs-placement="right">
          <a class="nav-link" href="<?php echo $_DOMAIN; ?>machine-assets"><span class="nav-icon bi bi-info-circle"></span>Assets</a>
        </div>




        <div class="nav-title">Tool</div>

        <div class="nav-item" data-toggle="tooltip" title="Phòng Chat" data-bs-placement="right">
          <a class="nav-link" href="<?php echo $_DOMAIN; ?>chat-room"><span class="nav-icon bi bi-chat"></span>Chat</a>
        </div>
        <div class="nav-item" data-toggle="tooltip" title="Tập tin" data-bs-placement="right">
          <a class="nav-link" href="<?php echo $_DOMAIN; ?>file"><span class="nav-icon bi bi-file"></span>File</a>
        </div>

        <div class="nav-group-item">
          <a id="flush-heading2" class="nav-link nav-btn-collapsed collapsed" data-bs-toggle="collapse" href="#flush-collapse2" aria-expanded="false" aria-controls="flush-collapse2">
            <span class="nav-icon bi bi-person-rolodex"></span>Tài khoản
          </a>
          <div id="flush-collapse2" class="collapse" aria-labelledby="flush-heading2" data-bs-parent="#accordion-sidebar">
            <div class="nav-item" data-toggle="tooltip" title="Thông tin nhân viên" data-bs-placement="right">
              <a class="nav-link" href="<?php echo $_DOMAIN; ?>user-infomation"><span class="nav-icon bi bi-people-fill"></span>Thông tin nhân viên</a>
            </div>
            <div class="nav-item" data-toggle="tooltip" title="Quản lý tài khoản" data-bs-placement="right">
              <a class="nav-link" href="<?php echo $_DOMAIN; ?>acc-admin"><span class="nav-icon bi bi-gear"></span>Quản lý</a>
            </div>
            <div class="nav-item" data-toggle="tooltip" title="Đăng xuất" data-bs-placement="right">
              <a class="nav-link" href="<?php echo $_DOMAIN; ?>log-out"><span class="nav-icon bi bi-box-arrow-left"></span>Đăng xuất</a>
            </div>
          </div>
        </div>

      </div>
      <div class="bottom"><b class="bi bi-chevron-left"></b></div>
      <div class="tooltip-sidebar" style="display: none;">Tooltip text</div>
    </div>
    <div class="col mainbar">
      <div class="row top">
        <div class="col header-menu">
          <button class="header-toggler" type="button"><i class="bi bi-justify"></i></button>
          <span class="header-title"></span>
        </div>

        
          <div class="col-md-auto header-icon" style="margin-top: 2rem;">
            <i class="bi bi-search" style="color: #000;" data-toggle="tooltip" title="Tìm kiếm" data-bs-placement="bottom"></i>
            <i class="bi bi-camera" id="save_web" data-toggle="tooltip" title="Chụp ảnh trang" data-bs-placement="bottom"></i>
            <i class="bi bi-file-earmark-excel-fill" style="color: #008000;" id="export_excel" data-toggle="tooltip" title="Xuất sang Excel" data-bs-placement="bottom"></i>
          </div>
          <div class="col-md-auto dropdown" style="margin-top: 20px;">
            <img class="avatar" src="<?php if (!file_exists('assets/images/avatars/'. $data_user["anh_dai_dien"])) echo $_DOMAIN . 'assets/images/user-profile.png'; else echo $_DOMAIN .'assets/images/avatars/'. $data_user["anh_dai_dien"]; ?>" alt="<?php echo $data_user["name_employee"]; ?>" alt="avatar" id="drd-avatar" data-bs-toggle="dropdown" aria-expanded="false" />
            <ul class="dropdown-menu dropdown-menu-white" aria-labelledby="drd-avatar">
              <li><a class="dropdown-item" href="#"><i class="bi bi-chat-dots-fill"></i> Messages<span class="badge badge-sm bg-success ms-2">42</span></a></li>
              <li><a class="dropdown-item" href="#"><i class="bi bi-chat-right-dots"></i> Comments<span class="badge badge-sm bg-warning ms-2">2</span></a></li>
              <li><a class="dropdown-item" href="#"><i class="bi bi-person-badge-fill"></i> Profile</a></li>
              <li>
                <hr class="dropdown-divider">
              </li>
              <li><a class="dropdown-item" href="<?php echo $_DOMAIN; ?>account/signout.php"><i class="bi bi-box-arrow-right"></i> Logout</a></li>
            </ul>
          </div>
      </div>
      <div class="row home">

        <?php
        //include_once 'content.php';
        // Phân trang content
        // Lấy tham số tab
        if (isset($_GET['tab'])) {
          $tab = trim(addslashes(htmlspecialchars($_GET['tab'])));
        } else {
          $tab = '';
        }

        // Nếu có tham số tab
        if ($tab != '') {
          // Hiển thị template chức năng theo tham số tab
          if ($tab == 'home') require_once 'home.php';
          else if ($tab == '404') require_once '404.php';
          else if ($tab == 'monitor-nhiet-do-va-do-am-xuong') require_once 'monitors/nhietdovadoamxuong.php';
          else if ($tab == 'monitor-nhiet-do-va-do-am-tu-LKDT') require_once 'monitors/doamtulkdt.php';
          else if ($tab == 'monitor-pc-infomation') require_once 'monitors/pc-infomations.php';
          else if ($tab == 'chat-room') require_once 'chatbox.php';
          else if ($tab == 'file') require_once 'file.php';
          else if ($tab == 'monitor-dat') require_once 'monitors/dat.php';
          else if ($tab == 'monitor-reflow') require_once 'monitors/reflow.php';
          else if ($tab == 'monitor-printer') require_once 'monitors/printer.php';
          else if ($tab == 'monitor-function') require_once 'monitors/function.php';
          else if ($tab == 'monitor-chip') require_once 'monitors/chip.php';
          else if ($tab == 'cham-cong') require_once 'timesheets/cham-cong.php';
          else if ($tab == 'tinh-luong') require_once 'timesheets/tinh-luong.php';
          else if ($tab == 'machine-assets') require_once 'machines/assets.php';
          else if ($tab == 'checklist-show') require_once 'checklist_strap/show.php';
          else if ($tab == 'checklist-confirm') require_once 'checklist_strap/confirm.php';
          else if ($tab == 'checklist-mapping') require_once 'checklist_strap/mapping.php';
          else if ($tab == 'user-infomation') require_once 'account/infomation.php';

          else if ($tab == 'sf-home') require_once 'SmartFactory/home.php';
          else if ($tab == 'sf-lob') require_once 'SmartFactory/lob.php';
          else if ($tab == 'sf-settings') require_once 'SmartFactory/settings.php';

          else if ($tab == 'eq-report-daily') require_once 'EQ Report/Daily.php';

          else if ($tab == 'acc-admin') require_once 'account/admin.php';

          else require_once '404.php';
        }
        // Ngược lại không có tham số tab
        else {
          // Hiển thị template bảng điều khiển
          require_once 'home.php';
        }

        ?>

      </div>
    </div>
  </div>
</div>

<?php
$page_js[] = "assets\js\html2canvas.js";
//$page_js[] = "assets\js\html2canvas.min.js";
$page_js[] = "js/main.js";
include_once 'includes/footer.php';
?>