

<!-- <div class="container-fluid">
	<div class="row"> -->
		<div class="col-md-auto chat-sidepanel">
				<div class="search-box">
					<!--i class="bi bi-search"></i-->
					<input placeholder="Tìm kiếm ở đây" type="text"/>
				</div>
				<div class="chat-list" id="list-user-group">
					<!----------Tải danh sách user vào đây--------->
				</div>
				<div class="bottom-bar">
					<button id="btn-public-chat" type="button" class="btnn">Chát nhóm</button>
					<button id="btn-private-chat" type="button" class="btnn active">Chát riêng</button>
      			</div>
		</div>
		<div class="col chat-content">
			<div class="messages">
				<ul class="chatBox" id="chatbox">
					<!---------ds tin nhắn-------------->
				</ul>
			</div>
			<div class="chat-box-tray">
				<input type="text" name="send_mess" placeholder="Nhập tin nhắn ở đây..." id="i_smile">
				<i class="bi bi-chat-right-heart" id="i_sticker"></i>
				<i class="bi bi-mic"></i>
				<i class="bi bi-send" id="i-send"></i>
			</div>
		</div>
	<!-- </div>
</div> -->



<?php
$page_js[] = "js/chat.js";
?>