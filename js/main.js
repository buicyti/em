
var sidebar = 0;
var sidebarbot = 0;


/*$(document).ready(function(){
  $(document).ajaxStart(function() {
      $("#loading").show();
  });
  $(document).ajaxStop(function() {
      $("#loading").hide();
  });
});*/

$(window).resize(function() {
  if ($(window).width() > 1500) {
    $(':root')[0].style.cssText = "--cui-sidebar-width: 16rem;";
    $('.sidebar .bottom').html('<b class="bi bi-chevron-left"></b>');
    $('.nav-title').removeClass('hidden');

    $('.logo-narrow').css('display', 'none');
    $('.logo-full').css('display', 'block');
    $('.nav-title').css({ 'display': 'block' });
    sidebarbot = 0;
    sidebar = 1;
  }
  else {
    $(':root')[0].style.cssText = "--cui-sidebar-width: 3.5rem;";
    $('.sidebar .bottom').html('<b class="bi bi-chevron-right"></b>');
    $('.nav-title').addClass('hidden');

    $('.logo-narrow').css('display', 'block');
    $('.logo-full').css('display', 'none');
    $('.nav-title').css({ 'display': 'none' })
    sidebarbot = 1;
  }


});




$('.top .header-toggler').on('click', function () {
  if (sidebar == 1) {
    $('#sidebar').removeClass('hidden');
    sidebar = 0;
  }
  else if (sidebar == 0) {
    $('#sidebar').addClass('hidden')
    sidebar = 1;
  }
}); // ẩn/hiện thanh sidebar

$('.sidebar .bottom').on('click', function () {
  if (sidebarbot == 1) {
    $(':root')[0].style.cssText = "--cui-sidebar-width: 16rem;";
    $('.sidebar .bottom').html('<b class="bi bi-chevron-left"></b>');
    $('.nav-title').removeClass('hidden');

    $('.logo-narrow').css('display', 'none');
    $('.logo-full').css('display', 'block');
    $('.nav-title').css({ 'display': 'block' });
    sidebarbot = 0;
    sidebar = 1;
  }
  else if (sidebarbot == 0) {
    $(':root')[0].style.cssText = "--cui-sidebar-width: 3.5rem;";
    $('.sidebar .bottom').html('<b class="bi bi-chevron-right"></b>');
    $('.nav-title').addClass('hidden');

    $('.logo-narrow').css('display', 'block');
    $('.logo-full').css('display', 'none');
    $('.nav-title').css({ 'display': 'none' })
    sidebarbot = 1;
  }
}); // phóng to/thu nhỏ sidebar bằng nút ấn

if ( typeof header_title === "undefined") header_title = 'EM - Home';
else{
  $('.header-title').html(header_title);
  $('title').html(header_title);
}
$(document).ready(function () {
  
  $('[data-toggle="tooltip"]').tooltip();

  if($(document).width() < 1500){
    $(':root')[0].style.cssText = "--cui-sidebar-width: 3.5rem;";
    $('.sidebar .bottom').html('<b class="bi bi-chevron-right"></b>');
    $('.nav-title').addClass('hidden');

    $('.logo-narrow').css('display', 'block');
    $('.logo-full').css('display', 'none');
    $('.nav-title').css({ 'display': 'none' })
    sidebarbot = 1;
  }
  /*$('.nav-item').click(function(e){
    $('.nav-selected').removeClass('nav-selected');
    $(this).addClass('nav-selected');
    e.preventDefault();
  });*/
  }); //tô sáng thẻ được chọn

new SimpleBar($('#accordion-sidebar')[0], 
  { 
    autoHide: true,
    timeout: 1000
  });//trang trí thanh cuộn sidebar


$("#save_web").on("click", function () {
  $(".selected-items").height($(".selected-items").prop("scrollHeight"))
  window.scrollTo(0, 0);
  html2canvas(document.querySelector('body'), { scrollX: 0, scrollY: -window.scrollY }).then(function (canvas) {
    saveAs(canvas.toDataURL(), 'img' + $('#date_current').text() + '.png');
  });
  

  $(".selected-items").height("100%")
});


function saveAs(uri, filename) {

  var link = document.createElement('a');
  if (typeof link.download === 'string') {
    link.href = uri;
    link.download = filename
    document.body.appendChild(link)
    link.click();
    document.body.removeChild(link);
  }
  else {
    window.open(uri)
  }
}



