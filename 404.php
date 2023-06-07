<?php
require_once 'includes/header.php';
?>
<title>404 Not Found</title>

	<div class="container" style="height: 100%; display: flex; justify-content: center; align-items: center;">
		<div class="row justify-content-center justify-content-middle align-middle">
			
				<div class="clearfix">
					<h1 class="float-start display-3 me-4">404</h1>
					<h4 class="pt-3">Oops! Có gì đó sai sai.</h4>
					<p class="text-medium-emphasis">Đường dẫn bạn truy cập không tồn tại.</p>
				</div>
				<div class="input-group">
					<span class="input-group-text bi bi-search"></span>
					<input class="form-control" id="prependedInput" size="16" type="text" placeholder="Bạn đang tìm kiếm điều gì?">
					<button class="btn btn-info" type="button">Tìm kiếm</button>
				</div>
				<div class=""><a href="<?php echo $_DOMAIN; ?>">Trở về trang chủ</a></div>
			</div>
	</div>

