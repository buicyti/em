<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Document</title>
</head>

<body>
	<div class="thumbnail">
		<img class="phongto" src="http://localhost/EM/assets/images/avatars/Anh-avatar-dep-quyet-tam-mua-thi-590x600.jpg" alt="ahiiiiiiiiiii">
	</div>

  <div class="wrap">
    <div class="thumbnai1" data-image="http://localhost/EM/assets/images/avatars/Anh-avatar-dep-quyet-tam-mua-thi-590x600.jpg"></div>
	
	</div>
		
	<div class="wrap">
		<div class="item" data-image="http://localhost/EM/assets/images/avatars/Anh-avatar-dep-quyet-tam-mua-thi-590x600.jpg"></div>
		<div class="item" data-image="https://i.pinimg.com/564x/0f/56/be/0f56beba1a491ba57d1cf750b75e5b52.jpg"></div>
		<div class="item" data-image="https://i.pinimg.com/564x/90/63/7c/90637cd3472463965a02270cecb67e53.jpg"></div>
  	</div>


    <script type="text/javascript" src="http://localhost/EM/assets/jquery/jquery-3.6.0.min.js"></script>
	
</body>

</html>



<style>
	.phongto {
		/* position: absolute;
		top: 50%;
		left: 50%; */
		width: 100px;
		height: 100px;
		border-radius: 50%;
		transition: all 1s ease;
		-webkit-transition: all 1s ease;
		-moz-transition: all 1s ease;
		-o-transition: all 1s ease;
	}

	.phongto:hover {
		transform: scale(5, 5);
		-webkit-transform: scale(5, 5);
		-moz-transform: scale(5, 5);
		-o-transform: scale(5, 5);
		-ms-transform: scale(5, 5);
	}

.thumbnai1{
  width: 100px;
  height: 100px;
}

	.wrap {
  margin-top: 100px;
  display: flex;
  justify-content: center;
  flex-wrap: wrap;
}

.item {
  width: 300px;
  height: 500px;
  margin: 0 15px;
  position: relative;
  overflow: hidden;
}

.img {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-repeat: no-repeat;
  background-position: center;
  background-size: cover;
}
</style>

<script>
	$(function() {
  var zoom = function(elm) {
    elm
      .on('mouseover', function() {
        $(this).children('.img').css({'transform': 'scale(2)'});
      })
      .on('mouseout', function() {
        $(this).children('.img').css({'transform': 'scale(1)'});
      })
      .on('mousemove', function(e) {
        $(this).children('.img').css({'transform-origin': ((e.pageX - $(this).offset().left) / $(this).width()) * 100 + '% ' + ((e.pageY - $(this).offset().top) / $(this).height()) * 100 +'%'});
      })
  }

  $('.item').each(function() {
    $(this)
      .append('<div class="img"></div>')
      .children('.img').css({'background-image': 'url('+ $(this).data('image') +')'});
    zoom($(this));
  })

  $('.thumbnai1').ready(function(){
    $(this)
      .append('<div class="img"></div>')
      .children('.img').css({'background-image': 'url('+ $(this).data('image') +')'});
    zoom($(this));
  })
})
</script>