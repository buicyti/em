<!DOCTYPE html>
<html lang="en">
<?php
// Require database & thông tin chung
  @require_once($_SERVER['DOCUMENT_ROOT'] . '/EM/core/init.php');
?>
<head>
<meta charset="UTF-8"/>
	<base href="./">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,Chorme,Firefox">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
  <meta name="description" content="Design by Engineer Team">
  <meta name="author" content="Tư Đồ">
  <meta name="keyword" content="Thiết kế trên nền Bootstrap 5, Sidebar,...">
	<title>EM</title>
	<link rel="icon" href="<?php echo $_DOMAIN; ?>assets/images/favicon.ico" type="image/x-icon">
	<!-- Liên kết Bootstrap CSS -->
  <link rel="stylesheet" href="<?php echo $_DOMAIN; ?>assets/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="<?php echo $_DOMAIN; ?>assets/bootstrap/bootstrap-icons/bootstrap-icons.css">
  <link rel="stylesheet" href="<?php echo $_DOMAIN; ?>css/style.css">
  <!-- CSS Sidebar -->
  <link rel="stylesheet" href="<?php echo $_DOMAIN; ?>css/simplebar.css" type="text/css" media="all" />

</head>
<body>
<div class="animated-text">
    <span class="letter">E</span>
    <span class="letter">N</span>
    <span class="letter">J</span>
    <span class="letter">O</span>
    <span class="letter">Y</span>
    <span class="letter"> </span>
    <span class="letter">M</span>
    <span class="letter">Y</span>
    <span class="letter"> </span>
    <span class="letter">L</span>
    <span class="letter">I</span>
    <span class="letter">F</span>
    <span class="letter">E</span>
  </div>

  <style>


.animated-text {
  display: inline-block;
}

.letter {
  display: inline-block;
  animation: tiltIn 10s forwards;
  animation-delay: calc(var(--delay) * 0.15s);
}

@keyframes tiltIn {
  from {
    transform: skewX(-40deg) skewY(0deg);
    opacity: 1;
  }
  to {
    transform: skewX(0deg) skewY(0deg);
    opacity: 1;
  }
}



  </style>

    <script type="text/javascript" src="<?php echo $_DOMAIN; ?>assets/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script type="text/javascript" src="<?php echo $_DOMAIN; ?>assets/jquery/jquery-3.6.0.min.js"></script>
    <script type="text/javascript" src="<?php echo $_DOMAIN; ?>js/simplebar.min.js"></script>

    
    <script>
      
const letters = document.querySelectorAll('.letter');

function showLetters() {
  letters.forEach((letter, index) => {
    setTimeout(() => {
      letter.classList.add('show');
    }, 200 * index);
  });
}

showLetters();
    
    </script>
</body>
</html>