
// Đăng nhập

var login = function() {
	$this = $('#login button');
	$this.html('Đang tải ...');

	// Gán các giá trị trong các biến
	$user_signin = $('#login #user_signin').val();
	$pass_signin = $('#login #pass_signin').val();
	$check_box = $('#login #checkLogin').is(':checked');

	// Nếu các giá trị rỗng
	if ($user_signin == '' || $pass_signin == '')
	{
		$('#login .alert').removeClass('hidden');
		$('#login .alert').html('Vui lòng điền đầy đủ thông tin.');
		$this.html('Đăng nhập');
	}
	// Ngược lại
	else
	{
		$.ajax({
			url : '../php/signin.php',
			type : 'POST',
			data : {
				user_signin : $user_signin,
				pass_signin : $pass_signin,
				check_box: $check_box,
				action: 'login'
			}, success : function(data) {
				$('#login .alert').removeClass('hidden');
				$('#login .alert').html(data);
				$this.html('Đăng nhập');
			}, error : function() {
				$('#login .alert').removeClass('hidden');
				$('#login .alert').html('Không thể đăng nhập vào lúc này, hãy thử lại sau.');
				$this.html('Đăng nhập');
			}
		});
	}
}



var signup = function(){
	$this = $('#register button');
	$this.html('Đang tải .....');
	
	// Gán các giá trị trong các biến
	$username_reg = $('#register #username-reg').val();
	$userid_reg = $('#register #userid-reg').val();
	$pass_reg = $('#register #pass-reg').val();
	$re_pass_reg = $('#register #re-pass-reg').val();

	if ($username_reg == '' || $userid_reg == '' || $pass_reg == '' || $re_pass_reg == '')
	{
		$('#register .alert').removeClass('hidden');
		$('#register .alert').html('Vui lòng điền đầy đủ thông tin.');
	}
	else
	{
		$.ajax({
			url : '../php/signin.php',
			type : 'POST',
			data : {
				username_reg: $username_reg,
				userid_reg : $userid_reg,
				pass_reg : $pass_reg,
				re_pass_reg : $re_pass_reg,
				action: 'signup'
			}, success : function(data) {
				$('#register .alert').html(data);
			}, error : function() {
				$('#register .alert').removeClass('hidden');
				$('#register .alert').html('Đã có lỗi xảy ra, hãy thử lại.');
				$this.html('Đăng ký');
				
			}  
		});
	}
}

	$('#login button').on('click', login);
	$('#login input').keypress( function(){
		if ((event.keyCode ? event.keyCode : event.which) == '13') login();
	});
	$('#login .group').eq(1).on('mousemove', function(){
		$('#showPassword').css("display", "block")
	})
	$('#login .group').eq(1).on('mouseleave', function(){
		$('#showPassword').css("display", "none")
	})

	$('#register button').on('click', signup);


  // Click event of the showPassword button
  $('#showPassword').on('click', function(){
 
    // Get the password field
    var passwordField = $('#pass_signin');
 
    // Get the current type of the password field will be password or text
    var passwordFieldType = passwordField.attr('type');
 
    // Check to see if the type is a password field
    if(passwordFieldType == 'password')
    {
        // Change the password field to text
        passwordField.attr('type', 'text');
 
        // Change the Text on the show password button to Hide
        $(this).val('Hide');
    } else {
        // If the password field type is not a password field then set it to password
        passwordField.attr('type', 'password');
 
        // Change the value of the show password button to Show
        $(this).val('Show');
    }
  });



  var rotatedeg = 0;
  $('#btnlogin').on('click', function(){
	$('#form #register').css("display", "none")
	$('#form #login').css("display", "block")
	$('#btnregister').removeClass("bg-active")
	$('#btnlogin').addClass("bg-active")
	rotatedeg = rotatedeg + 200;
	$('#rotate').css('transform', 'translate(-50%) rotate(' + rotatedeg + 'deg)')
  })
  $('#btnregister').on('click', function(){
	$('#form #login').css("display", "none")
	$('#form #register').css("display", "block")
	$('#btnlogin').removeClass("bg-active")
	$('#btnregister').addClass("bg-active")
	rotatedeg = rotatedeg + 200;
	$('#rotate').css('transform', 'translate(-50%) rotate(' + rotatedeg + 'deg)')
  })


  $(document).ready(function () {
	$('.ahi').css({'height': '100px'})
	//console.log(getPorts())
  });