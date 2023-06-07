header_title = 'EM - Chat'
var user_selected = null;
var type_chat = 0;


//Lấy danh sách người dùng
$('#btn-private-chat').on('click',function(){
    $('#btn-public-chat').removeClass('active');
    $('#btn-private-chat').addClass('active');
    load_list_user();
    get_id_user();
    type_chat = 0;
});
//Lấy danh sách nhóm
$('#btn-public-chat').on('click',function(){
    $('#btn-private-chat').removeClass('active');
    $('#btn-public-chat').addClass('active');
    //load_list_group();
    load_list_group();
    get_id_group();
    type_chat = 1;
});
//////Gửi tin nhắn đi
function send_to_mess(){
    value = $('input[name="send_mess"]').val();
     if(value=='') return;
        if((value.match(/\(\:(.*?)\:\)/g) || []).length == 1 && value.match(/\(\:(.*?)\:\)/g) == value) $('#chatbox').append('<li class="sticker_me">' + value.replace(/\(\:(.*?)\:\)/gi, '<img src="assets/images/emojis/popo/$1.png" alt"$1"">') + '</li>');
        else $('#chatbox').append('<li class="me">' + value.replace(/\(\:(.*?)\:\)/gi, '<img src="assets/images/emojis/popo/$1.png" alt"$1"">') + '</li>');
        $.ajax({
            type: "post",
            url: "php/chat.php",
            data: {send_mess: value, send_to_user: user_selected, send_type: type_chat},
            dataType: "text",
            success: function (response) {
              //  console.log(response);
            }
        });
        $('input[name="send_mess"]').val('');

        //nhảy xuống cuối trang
        //$('.messages').scrollTop($('.messages')[0].scrollHeight);
        $('.messages').animate({
            scrollTop: $('.messages')[0].scrollHeight
         }, 500);
}
 $('input[name="send_mess"]').keydown(function (e) { 
     if(e.keyCode == 13) {
        send_to_mess();
     }
 });


 $('#i-send').click(function (e) { 
    send_to_mess();
 });


 function ChangeToSlug(slug)
 {
     slug = slug.toLowerCase();
     slug = slug.replace(/á|à|ả|ạ|ã|ă|ắ|ằ|ẳ|ẵ|ặ|â|ấ|ầ|ẩ|ẫ|ậ/gi, 'a');
     slug = slug.replace(/é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ/gi, 'e');
     slug = slug.replace(/i|í|ì|ỉ|ĩ|ị/gi, 'i');
     slug = slug.replace(/ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ/gi, 'o');
     slug = slug.replace(/ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự/gi, 'u');
     slug = slug.replace(/ý|ỳ|ỷ|ỹ|ỵ/gi, 'y');
     slug = slug.replace(/đ/gi, 'd');
     slug = slug.replace(/\`|\~|\!|\@|\#|\||\$|\%|\^|\&|\*|\(|\)|\+|\=|\,|\.|\/|\?|\>|\<|\'|\"|\:|\;|_/gi, '');
     slug = slug.replace(/ /gi, "-");
     slug = slug.replace(/\-\-\-\-\-/gi, '-');
     slug = slug.replace(/\-\-\-\-/gi, '-');
     slug = slug.replace(/\-\-\-/gi, '-');
     slug = slug.replace(/\-\-/gi, '-');
     slug = '@' + slug + '@';
     slug = slug.replace(/\@\-|\-\@|\@/gi, '');
     //$('.slug').val(slug);
     return slug;
 }


 //Hàm lấy danh sách tất cả người dùng
function load_list_user(){
    $.ajax({
        type: "post",
        url: "php/chat.php",
        data: {show_list: 'list_user'},
        //dataType: "dataType",
        success: function (data) {
            $('#list-user-group').html(data);
        },
        error: function(xhr, status, error) {
            console.error(xhr)
        }
    });
}
 //Hàm lấy danh sách tất cả nhóm
 function load_list_group(){
    $.ajax({
        type: "post",
        url: "php/chat.php",
        data: {show_list: 'list_group'},
        //dataType: "dataType",
        success: function (data) {
            $('#list-user-group').html(data);
        },
        error: function(xhr, status, error) {
            console.error(xhr)
        }
    });
    $(document).on('click','input[name="btn_creat_group"]', function(){
        group_name = $('input[name="creat_group"]').val();
        if(group_name == '') alert('Không được để trống');
        else
        $.ajax({
            type: "post",
            url: "php/chat.php",
            data: {creat_gr_name: group_name},
            dataType: "text",
        });
        setTimeout(function(){},2000);
        load_list_group();
     });
}
//Hàm lấy tên người dùng được chọn và tải tất cả tin nhắn
function get_id_user(){
    $.ajax({
        type: "post",
        url: "php/chat.php",
        data: {get_list: 'list_user'},
        dataType: "json",
        success: function (response) {
            //console.log(response);
            $.each(response, function (indexInArray, valueOfElement) { 
                $(document).on('click', '#user_'+valueOfElement, function(){
                    //console.log(valueOfElement);
                    user_selected = valueOfElement;
                    $('#list-user-group div').removeClass('active');
                    $('#user_'+valueOfElement).addClass('active');
                    load_user_mess(valueOfElement);
                });
            });
        },
        error: function(xhr, status, error) {
            console.error(xhr)
        }
    });
    //console.log('qq');
}

//Hàm lấy tên nhóm được chọn và tải tất cả tin nhắn
function get_id_group(){
    $.ajax({
        type: "post",
        url: "php/chat.php",
        data: {get_list: 'list_group'},
        dataType: "json",
        success: function (response) {
            //console.log(response);
            $.each(response, function (indexInArray, valueOfElement) { 
                $(document).on('click', '#group_'+indexInArray, function(){
                    //console.log(valueOfElement);
                    user_selected = valueOfElement;
                    $('#list-user-group div').removeClass('active');
                    $('#group_'+indexInArray).addClass('active');
                    load_group_mess(valueOfElement);
                });
            });
        },
        error: function(xhr, status, error) {
            console.error(xhr)
        }
    });
    //console.log('qq');
}
//Tải tin nhắn
function load_user_mess(username){
    //console.log(username);
    $.ajax({
        type: "post",
        url: "php/chat.php",
        data: {load_mess: username},
        dataType: "text",
        success: function (data) {
            $('#chatbox').html(data);
            //nhảy xuống cuối trang
            $('.messages').animate({
            scrollTop: $('.messages')[0].scrollHeight
            }, 500);
        }
    });
}

function load_group_mess(gr_id){
    //console.log(username);
    $.ajax({
        type: "post",
        url: "php/chat.php",
        data: {group_mess: gr_id},
        //dataType: "text",
        success: function (data) {
            $('#chatbox').html(data);
            //nhảy xuống cuối trang
            $('.messages').animate({
                scrollTop: $('.messages')[0].scrollHeight
                }, 500);
        }
    });
}

function load_new_mess(){
    //console.log(user_selected);
    $.ajax({
        type: "post",
        url: "php/chat.php",
        data: {load_new_mess: user_selected, type_chat: type_chat},
        dataType: "text",
        success: function (data) {
            $('#chatbox').append(data);
            if(data.length > 10)
            //nhảy xuống cuối trang
            //window.scrollTo(0,document.querySelector('.messages').scrollHeight);
            $('.messages').animate({
                scrollTop: $('.messages')[0].scrollHeight
            }, 500);
        },
        error: function(xhr, status, error) {
            console.error(xhr)
        }
    });
}

$(document).ready(function () {
    setInterval(function(){
        //load_list_user();
        //get_id_user();
    }, 10000);
    //if(user_selected !== null){
    setInterval(function(){
        load_new_mess();
    },100);
    //}
    load_list_user();
    get_id_user();
    //$('#i_smile').emojiPicker();
});

/**Smileeeeeeeeeeeeeeee */

$('.chat-box-tray').append('<span id="emoji-panel-btn" class="emoji-panel-btn"></span>'); //tạo nút

$('#emoji-panel-btn').click(function(e) {
    e.stopPropagation();
    e.preventDefault();
    if (!$('.emoji-panel').is(':visible')) {
        $('.chat-box-tray').append('<div class="emoji-panel"> <ul class="nav nav-tabs" id="myTab" role="tablist"> <li class="nav-item" role="presentation"><a class="nav-link active" id="smile1-tab" data-bs-toggle="tab" href="#smile1" role="tab" aria-controls="smile1" aria-selected="true">😀</a></li> <li class="nav-item" role="presentation"><a class="nav-link" id="smile2-tab" data-bs-toggle="tab" href="#smile2" role="tab" aria-controls="smile2" aria-selected="false">🦉</a></li> <li class="nav-item" role="presentation"><a class="nav-link" id="smile3-tab" data-bs-toggle="tab" href="#smile3" role="tab" aria-controls="smile3" aria-selected="false">🥝</a></li> <li class="nav-item" role="presentation"><a class="nav-link" id="smile4-tab" data-bs-toggle="tab" href="#smile4" role="tab" aria-controls="smile4" aria-selected="false">⚽️</a></li> <li class="nav-item" role="presentation"><a class="nav-link" id="smile5-tab" data-bs-toggle="tab" href="#smile5" role="tab" aria-controls="smile5" aria-selected="false">🚀</a></li> <li class="nav-item" role="presentation"><a class="nav-link" id="smile6-tab" data-bs-toggle="tab" href="#smile6" role="tab" aria-controls="smile6" aria-selected="false">🧱</a></li> <li class="nav-item" role="presentation"><a class="nav-link" id="smile7-tab" data-bs-toggle="tab" href="#smile7" role="tab" aria-controls="smile7" aria-selected="false">💖</a></li> </ul> <div class="tab-content" id="myTabContent"> <div class="tab-pane fade show active emoji-tab" id="smile1" role="tabpanel" aria-labelledby="smile1-tab"><span>😀</span><span>😃</span><span>😄</span><span>😁</span><span>😆</span><span>😅</span><span>😂</span><span>🤣</span><span>😊</span><span>😇</span><span>🙂</span><span>🙃</span><span>😉</span><span>😌</span><span>😍</span><span>🥰</span><span>😘</span><span>😗</span><span>😙</span><span>😚</span><span>😋</span><span>😛</span><span>😝</span><span>😜</span><span>🤪</span><span>🤨</span><span>🧐</span><span>🤓</span><span>😎</span><span>🤩</span><span>🥳</span><span>😏</span><span>😒</span><span>😞</span><span>😔</span><span>😟</span><span>😕</span><span>🙁</span><span>☹️</span><span>😣</span><span>😖</span><span>😫</span><span>😩</span><span>🥺</span><span>😢</span><span>😭</span><span>😤</span><span>😠</span><span>😡</span><span>🤬</span><span>🤯</span><span>😳</span><span>🥵</span><span>🥶</span><span>😱</span><span>😨</span><span>😰</span><span>😥</span><span>😓</span><span>🤗</span><span>🤔</span><span>🤭</span><span>🤫</span><span>🤥</span><span>😶</span><span>😐</span><span>😑</span><span>😬</span><span>🙄</span><span>😯</span><span>😦</span><span>😧</span><span>😮</span><span>😲</span><span>🥱</span><span>😴</span><span>🤤</span><span>😪</span><span>😵</span><span>🤐</span><span>🥴</span><span>🤢</span><span>🤮</span><span>🤧</span><span>😷</span><span>🤒</span><span>🤕</span><span>🤑</span><span>🤠</span><span>😈</span><span>👿</span><span>👹</span><span>👺</span><span>🤡</span><span>💩</span><span>👻</span><span>💀</span><span>☠️</span><span>👽</span><span>👾</span><span>🤖</span><span>🎃</span><span>😺</span><span>😸</span><span>😹</span><span>😻</span><span>😼</span><span>😽</span><span>🙀</span><span>😿</span><span>😾</span><span>👋</span><span>🤚</span><span>🖐</span><span>✋</span><span>🖖</span><span>👌</span><span>🤏</span><span>✌️</span><span>🤞</span><span>🤟</span><span>🤘</span><span>🤙</span><span>👈</span><span>👉</span><span>👆</span><span>🖕</span><span>👇</span><span>☝️</span><span>👍</span><span>👎</span><span>✊</span><span>👊</span><span>🤛</span><span>🤜</span><span>👏</span><span>🙌</span><span>👐</span><span>🤲</span><span>🤝</span><span>🙏</span><span>✍️</span><span>💅</span><span>🤳</span><span>💪</span><span>🦾</span><span>🦵</span><span>🦿</span><span>🦶</span><span>👣</span><span>👂</span><span>🦻</span><span>👃</span><span>🧠</span><span>🦷</span><span>🦴</span><span>👀</span><span>👁</span><span>👅</span><span>👄</span><span>💋</span><span>🩸</span><span>🧳</span><span>🌂</span><span>☂️</span><span>🧵</span><span>🧶</span><span>👓</span><span>🕶</span><span>🥽</span><span>🥼</span><span>🦺</span><span>👔</span><span>👕</span><span>👖</span><span>🧣</span><span>🧤</span><span>🧥</span><span>🧦</span><span>👗</span><span>👘</span><span>🥻</span><span>🩱</span><span>🩲</span><span>🩳</span><span>👙</span><span>👚</span><span>👛</span><span>👜</span><span>👝</span><span>🎒</span><span>👞</span><span>👟</span><span>🥾</span><span>🥿</span><span>👠</span><span>👡</span><span>🩰</span><span>👢</span><span>👑</span><span>👒</span><span>🎩</span><span>🎓</span><span>🧢</span><span>⛑</span><span>💄</span><span>💍</span><span>💼</span></div> <div class="tab-pane fade emoji-tab" id="smile2" role="tabpanel" aria-labelledby="smile2-tab"><span>🐶</span><span>🐱</span><span>🐭</span><span>🐹</span><span>🐰</span><span>🦊</span><span>🐻</span><span>🐼</span><span>🐻</span><span>🐨</span><span>🐯</span><span>🦁</span><span>🐮</span><span>🐷</span><span>🐽</span><span>🐸</span><span>🐵</span><span>🙈</span><span>🙉</span><span>🙊</span><span>🐒</span><span>🐔</span><span>🐧</span><span>🐦</span><span>🐤</span><span>🐣</span><span>🐥</span><span>🦆</span><span>🦅</span><span>🦉</span><span>🦇</span><span>🐺</span><span>🐗</span><span>🐴</span><span>🦄</span><span>🐝</span><span>🐛</span><span>🦋</span><span>🐌</span><span>🐞</span><span>🐜</span><span>🦟</span><span>🦗</span><span>🕷</span><span>🕸</span><span>🦂</span><span>🐢</span><span>🐍</span><span>🦎</span><span>🦖</span><span>🦕</span><span>🐙</span><span>🦑</span><span>🦐</span><span>🦞</span><span>🦀</span><span>🐡</span><span>🐠</span><span>🐟</span><span>🐬</span><span>🐳</span><span>🐋</span><span>🦈</span><span>🐊</span><span>🐅</span><span>🐆</span><span>🦓</span><span>🦍</span><span>🦧</span><span>🐘</span><span>🦛</span><span>🦏</span><span>🐪</span><span>🐫</span><span>🦒</span><span>🦘</span><span>🐃</span><span>🐂</span><span>🐄</span><span>🐎</span><span>🐖</span><span>🐏</span><span>🐑</span><span>🦙</span><span>🐐</span><span>🦌</span><span>🐩</span><span>🦮</span><span>🐕</span><span>🐈</span><span>🐓</span><span>🦃</span><span>🦚</span><span>🦜</span><span>🦢</span><span>🦩</span><span>🕊</span><span>🐇</span><span>🦝</span><span>🦨</span><span>🦡</span><span>🦦</span><span>🦥</span><span>🐁</span><span>🐀</span><span>🐿</span><span>🦔</span><span>🐾</span><span>🐉</span><span>🐲</span><span>🌵</span><span>🎄</span><span>🌲</span><span>🌳</span><span>🌴</span><span>🌱</span><span>🌿</span><span>☘️</span><span>🍀</span><span>🎍</span><span>🎋</span><span>🍃</span><span>🍂</span><span>🍁</span><span>🍄</span><span>🐚</span><span>🌾</span><span>💐</span><span>🌷</span><span>🌹</span><span>🥀</span><span>🌺</span><span>🌸</span><span>🌼</span><span>🌻</span><span>🌞</span><span>🌝</span><span>🌛</span><span>🌜</span><span>🌚</span><span>🌕</span><span>🌖</span><span>🌗</span><span>🌘</span><span>🌑</span><span>🌒</span><span>🌓</span><span>🌔</span><span>🌙</span><span>🌎</span><span>🌍</span><span>🌏</span><span>🪐</span><span>💫</span><span>⭐️</span><span>🌟</span><span>✨</span><span>⚡️</span><span>☄️</span><span>💥</span><span>🔥</span><span>🌪</span><span>🌈</span><span>☀️</span><span>🌤</span><span>⛅️</span><span>🌥</span><span>☁️</span><span>🌦</span><span>🌧</span><span>⛈</span><span>🌩</span><span>🌨</span><span>❄️</span><span>☃️</span><span>⛄️</span><span>🌬</span><span>💨</span><span>💧</span><span>💦</span><span>☔️</span><span>☂️</span><span>🌊</span><span>🌫</span></div> <div class="tab-pane fade emoji-tab" id="smile3" role="tabpanel" aria-labelledby="smile3-tab"><span>🍏</span><span>🍎</span><span>🍐</span><span>🍊</span><span>🍋</span><span>🍌</span><span>🍉</span><span>🍇</span><span>🍓</span><span>🍈</span><span>🍒</span><span>🍑</span><span>🥭</span><span>🍍</span><span>🥥</span><span>🥝</span><span>🍅</span><span>🍆</span><span>🥑</span><span>🥦</span><span>🥬</span><span>🥒</span><span>🌶</span><span>🌽</span><span>🥕</span><span>🧄</span><span>🧅</span><span>🥔</span><span>🍠</span><span>🥐</span><span>🥯</span><span>🍞</span><span>🥖</span><span>🥨</span><span>🧀</span><span>🥚</span><span>🍳</span><span>🧈</span><span>🥞</span><span>🧇</span><span>🥓</span><span>🥩</span><span>🍗</span><span>🍖</span><span>🦴</span><span>🌭</span><span>🍔</span><span>🍟</span><span>🍕</span><span>🥪</span><span>🥙</span><span>🧆</span><span>🌮</span><span>🌯</span><span>🥗</span><span>🥘</span><span>🥫</span><span>🍝</span><span>🍜</span><span>🍲</span><span>🍛</span><span>🍣</span><span>🍱</span><span>🥟</span><span>🦪</span><span>🍤</span><span>🍙</span><span>🍚</span><span>🍘</span><span>🍥</span><span>🥠</span><span>🥮</span><span>🍢</span><span>🍡</span><span>🍧</span><span>🍨</span><span>🍦</span><span>🥧</span><span>🧁</span><span>🍰</span><span>🎂</span><span>🍮</span><span>🍭</span><span>🍬</span><span>🍫</span><span>🍿</span><span>🍩</span><span>🍪</span><span>🌰</span><span>🥜</span><span>🍯</span><span>🥛</span><span>🍼</span><span>☕️</span><span>🍵</span><span>🧃</span><span>🥤</span><span>🍶</span><span>🍺</span><span>🍻</span><span>🥂</span><span>🍷</span><span>🥃</span><span>🍸</span><span>🍹</span><span>🧉</span><span>🍾</span><span>🧊</span><span>🥄</span><span>🍴</span><span>🍽</span><span>🥣</span><span>🥡</span><span>🥢</span><span>🧂</span></div> <div class="tab-pane fade emoji-tab" id="smile4" role="tabpanel" aria-labelledby="smile4-tab"><span>⚽️</span><span>🏀</span><span>🏈</span><span>⚾️</span><span>🥎</span><span>🎾</span><span>🏐</span><span>🏉</span><span>🥏</span><span>🎱</span><span>🪀</span><span>🏓</span><span>🏸</span><span>🏒</span><span>🏑</span><span>🥍</span><span>🏏</span><span>🥅</span><span>⛳️</span><span>🪁</span><span>🏹</span><span>🎣</span><span>🤿</span><span>🥊</span><span>🥋</span><span>🎽</span><span>🛹</span><span>🛷</span><span>⛸</span><span>🥌</span><span>🎿</span><span>⛷</span><span>🏂</span><span>🪂</span><span>🏋️</span><span>🏋️</span><span>🤼</span><span>🤸</span><span>⛹️</span><span>🤺</span><span>🤾</span><span>🏌️</span><span>🏇</span><span>🧘</span><span>🏄</span><span>🏊</span><span>🤽</span><span>🚣</span><span>🧗</span><span>🚵</span><span>🚴</span><span>🏆</span><span>🥇</span><span>🥈</span><span>🥉</span><span>🏅</span><span>🎖</span><span>🏵</span><span>🎗</span><span>🎫</span><span>🎟</span><span>🎪</span><span>🤹</span><span>🎭</span><span>🩰</span><span>🎨</span><span>🎬</span><span>🎤</span><span>🎧</span><span>🎼</span><span>🎹</span><span>🥁</span><span>🎷</span><span>🎺</span><span>🎸</span><span>🪕</span><span>🎻</span><span>🎲</span><span>♟</span><span>🎯</span><span>🎳</span><span>🎮</span><span>🎰</span><span>🧩</span></div> <div class="tab-pane fade emoji-tab" id="smile5" role="tabpanel" aria-labelledby="smile5-tab"><span>🚗</span><span>🚕</span><span>🚙</span><span>🚌</span><span>🚎</span><span>🏎</span><span>🚓</span><span>🚑</span><span>🚒</span><span>🚐</span><span>🚚</span><span>🚛</span><span>🚜</span><span>🦯</span><span>🦽</span><span>🦼</span><span>🛴</span><span>🚲</span><span>🛵</span><span>🏍</span><span>🛺</span><span>🚨</span><span>🚔</span><span>🚍</span><span>🚘</span><span>🚖</span><span>🚡</span><span>🚠</span><span>🚟</span><span>🚃</span><span>🚋</span><span>🚞</span><span>🚝</span><span>🚄</span><span>🚅</span><span>🚈</span><span>🚂</span><span>🚆</span><span>🚇</span><span>🚊</span><span>🚉</span><span>✈️</span><span>🛫</span><span>🛬</span><span>🛩</span><span>💺</span><span>🛰</span><span>🚀</span><span>🛸</span><span>🚁</span><span>🛶</span><span>⛵️</span><span>🚤</span><span>🛥</span><span>🛳</span><span>⛴</span><span>🚢</span><span>⚓️</span><span>⛽️</span><span>🚧</span><span>🚦</span><span>🚥</span><span>🚏</span><span>🗺</span><span>🗿</span><span>🗽</span><span>🗼</span><span>🏰</span><span>🏯</span><span>🏟</span><span>🎡</span><span>🎢</span><span>🎠</span><span>⛲️</span><span>⛱</span><span>🏖</span><span>🏝</span><span>🏜</span><span>🌋</span><span>⛰</span><span>🏔</span><span>🗻</span><span>🏕</span><span>⛺️</span><span>🏠</span><span>🏡</span><span>🏘</span><span>🏚</span><span>🏗</span><span>🏭</span><span>🏢</span><span>🏬</span><span>🏣</span><span>🏤</span><span>🏥</span><span>🏦</span><span>🏨</span><span>🏪</span><span>🏫</span><span>🏩</span><span>💒</span><span>🏛</span><span>⛪️</span><span>🕌</span><span>🕍</span><span>🛕</span><span>🕋</span><span>⛩</span><span>🛤</span><span>🛣</span><span>🗾</span><span>🎑</span><span>🏞</span><span>🌅</span><span>🌄</span><span>🌠</span><span>🎇</span><span>🎆</span><span>🌇</span><span>🌆</span><span>🏙</span><span>🌃</span><span>🌌</span><span>🌉</span><span>🌁</span></div> <div class="tab-pane fade emoji-tab" id="smile6" role="tabpanel" aria-labelledby="smile6-tab"><span>⌚️</span><span>📱</span><span>📲</span><span>💻</span><span>⌨️</span><span>🖥</span><span>🖨</span><span>🖱</span><span>🖲</span><span>🕹</span><span>🗜</span><span>💽</span><span>💾</span><span>💿</span><span>📀</span><span>📼</span><span>📷</span><span>📸</span><span>📹</span><span>🎥</span><span>📽</span><span>🎞</span><span>📞</span><span>☎️</span><span>📟</span><span>📠</span><span>📺</span><span>📻</span><span>🎙</span><span>🎚</span><span>🎛</span><span>🧭</span><span>⏱</span><span>⏲</span><span>⏰</span><span>🕰</span><span>⌛️</span><span>⏳</span><span>📡</span><span>🔋</span><span>🔌</span><span>💡</span><span>🔦</span><span>🕯</span><span>🪔</span><span>🧯</span><span>🛢</span><span>💸</span><span>💵</span><span>💴</span><span>💶</span><span>💷</span><span>💰</span><span>💳</span><span>💎</span><span>⚖️</span><span>🧰</span><span>🔧</span><span>🔨</span><span>⚒</span><span>🛠</span><span>⛏</span><span>🔩</span><span>⚙️</span><span>🧱</span><span>⛓</span><span>🧲</span><span>🔫</span><span>💣</span><span>🧨</span><span>🪓</span><span>🔪</span><span>🗡</span><span>⚔️</span><span>🛡</span><span>🚬</span><span>⚰️</span><span>🪦</span><span>⚱️</span><span>🏺</span><span>🔮</span><span>📿</span><span>🧿</span><span>💈</span><span>⚗️</span><span>🔭</span><span>🔬</span><span>🕳</span><span>🩹</span><span>🩺</span><span>💊</span><span>💉</span><span>🩸</span><span>🧬</span><span>🦠</span><span>🧫</span><span>🧪</span><span>🌡</span><span>🧹</span><span>🧺</span><span>🧻</span><span>🚽</span><span>🚰</span><span>🚿</span><span>🛁</span><span>🛀</span><span>🧼</span><span>🪒</span><span>🧽</span><span>🧴</span><span>🛎</span><span>🔑</span><span>🗝</span><span>🚪</span><span>🪑</span><span>🛋</span><span>🛏</span><span>🛌</span><span>🧸</span><span>🖼</span><span>🛍</span><span>🛒</span><span>🎁</span><span>🎈</span><span>🎏</span><span>🎀</span><span>🎊</span><span>🎉</span><span>🎎</span><span>🏮</span><span>🎐</span><span>🧧</span><span>✉️</span><span>📩</span><span>📨</span><span>📧</span><span>💌</span><span>📥</span><span>📤</span><span>📦</span><span>🏷</span><span>📪</span><span>📫</span><span>📬</span><span>📭</span><span>📮</span><span>📯</span><span>📜</span><span>📃</span><span>📄</span><span>📑</span><span>🧾</span><span>📊</span><span>📈</span><span>📉</span><span>🗒</span><span>🗓</span><span>📆</span><span>📅</span><span>🗑</span><span>📇</span><span>🗃</span><span>🗳</span><span>🗄</span><span>📋</span><span>📁</span><span>📂</span><span>🗂</span><span>🗞</span><span>📰</span><span>📓</span><span>📔</span><span>📒</span><span>📕</span><span>📗</span><span>📘</span><span>📙</span><span>📚</span><span>📖</span><span>🔖</span><span>🧷</span><span>🔗</span><span>📎</span><span>🖇</span><span>📐</span><span>📏</span><span>🧮</span><span>📌</span><span>📍</span><span>✂️</span><span>🖊</span><span>🖋</span><span>✒️</span><span>🖌</span><span>🖍</span><span>📝</span><span>✏️</span><span>🔍</span><span>🔎</span><span>🔏</span><span>🔐</span><span>🔒</span><span>🔓</span></div> <div class="tab-pane fade emoji-tab" id="smile7" role="tabpanel" aria-labelledby="smile7-tab"><span>❤️</span><span>🧡</span><span>💛</span><span>💚</span><span>💙</span><span>💜</span><span>🖤</span><span>🤍</span><span>🤎</span><span>💔</span><span>❣️</span><span>💕</span><span>💞</span><span>💓</span><span>💗</span><span>💖</span><span>💘</span><span>💝</span><span>💟</span><span>☮️</span><span>✝️</span><span>☪️</span><span>🕉</span><span>☸️</span><span>✡️</span><span>🔯</span><span>🕎</span><span>☯️</span><span>☦️</span><span>🛐</span><span>⛎</span><span>♈️</span><span>♉️</span><span>♊️</span><span>♋️</span><span>♌️</span><span>♍️</span><span>♎️</span><span>♏️</span><span>♐️</span><span>♑️</span><span>♒️</span><span>♓️</span><span>🆔</span><span>⚛️</span><span>🉑</span><span>☢️</span><span>☣️</span><span>📴</span><span>📳</span><span>🈶</span><span>🈚️</span><span>🈸</span><span>🈺</span><span>🈷️</span><span>✴️</span><span>🆚</span><span>💮</span><span>🉐</span><span>㊙️</span><span>㊗️</span><span>🈴</span><span>🈵</span><span>🈹</span><span>🈲</span><span>🅰️</span><span>🅱️</span><span>🆎</span><span>🆑</span><span>🅾️</span><span>🆘</span><span>❌</span><span>⭕️</span><span>🛑</span><span>⛔️</span><span>📛</span><span>🚫</span><span>💯</span><span>💢</span><span>♨️</span><span>🚷</span><span>🚯</span><span>🚳</span><span>🚱</span><span>🔞</span><span>📵</span><span>🚭</span><span>❗️</span><span>❕</span><span>❓</span><span>❔</span><span>‼️</span><span>⁉️</span><span>🔅</span><span>🔆</span><span>〽️</span><span>⚠️</span><span>🚸</span><span>🔱</span><span>⚜️</span><span>🔰</span><span>♻️</span><span>✅</span><span>🈯️</span><span>💹</span><span>❇️</span><span>✳️</span><span>❎</span><span>🌐</span><span>💠</span><span>Ⓜ️</span><span>🌀</span><span>💤</span><span>🏧</span><span>🚾</span><span>♿️</span><span>🅿️</span><span>🛗</span><span>🈳</span><span>🈂️</span><span>🛂</span><span>🛃</span><span>🛄</span><span>🛅</span><span>🚹</span><span>🚺</span><span>🚼</span><span>⚧</span><span>🚻</span><span>🚮</span><span>🎦</span><span>📶</span><span>🈁</span><span>🔣</span><span>ℹ️</span><span>🔤</span><span>🔡</span><span>🔠</span><span>🆖</span><span>🆗</span><span>🆙</span><span>🆒</span><span>🆕</span><span>🆓</span><span>0️⃣</span><span>1️⃣</span><span>2️⃣</span><span>3️⃣</span><span>4️⃣</span><span>5️⃣</span><span>6️⃣</span><span>7️⃣</span><span>8️⃣</span><span>9️⃣</span><span>🔟</span><span>🔢</span><span>#️⃣</span><span>*️⃣</span><span>⏏️</span><span>▶️</span><span>⏸</span><span>⏯</span><span>⏹</span><span>⏺</span><span>⏭</span><span>⏮</span><span>⏩</span><span>⏪</span><span>⏫</span><span>⏬</span><span>◀️</span><span>🔼</span><span>🔽</span><span>➡️</span><span>⬅️</span><span>⬆️</span><span>⬇️</span><span>↗️</span><span>↘️</span><span>↙️</span><span>↖️</span><span>↕️</span><span>↔️</span><span>↪️</span><span>↩️</span><span>⤴️</span><span>⤵️</span><span>🔀</span><span>🔁</span><span>🔂</span><span>🔄</span><span>🔃</span><span>🎵</span><span>🎶</span><span>➕</span><span>➖</span><span>➗</span><span>✖️</span><span>♾</span><span>💲</span><span>💱</span><span>™️</span><span>©️</span><span>®️</span><span>〰️</span><span>➰</span><span>➿</span><span>🔚</span><span>🔙</span><span>🔛</span><span>🔝</span><span>🔜</span><span>✔️</span><span>☑️</span><span>🔘</span><span>🔴</span><span>🟠</span><span>🟡</span><span>🟢</span><span>🔵</span><span>🟣</span><span>⚫️</span><span>⚪️</span><span>🟤</span><span>🔺</span><span>🔻</span><span>🔸</span><span>🔹</span><span>🔶</span><span>🔷</span><span>🔳</span><span>🔲</span><span>▪️</span><span>▫️</span><span>◾️</span><span>◽️</span><span>◼️</span><span>◻️</span><span>🟥</span><span>🟧</span><span>🟨</span><span>🟩</span><span>🟦</span><span>🟪</span><span>⬛️</span><span>⬜️</span><span>🟫</span><span>🔈</span><span>🔇</span><span>🔉</span><span>🔊</span><span>🔔</span><span>🔕</span><span>📣</span><span>📢</span><span>💬</span><span>💭</span><span>🗯</span><span>♠️</span><span>♣️</span><span>♥️</span><span>♦️</span><span>🃏</span><span>🎴</span><span>🀄️</span><span>🕐</span><span>🕑</span><span>🕒</span><span>🕓</span><span>🕔</span><span>🕕</span><span>🕖</span><span>🕗</span><span>🕘</span><span>🕙</span><span>🕚</span><span>🕛</span><span>🕜</span><span>🕝</span><span>🕞</span><span>🕟</span><span>🕠</span><span>🕡</span><span>🕢</span><span>🕣</span><span>🕤</span><span>🕥</span><span>🕦</span><span>🕧</span></div> </div> </div>');
    }
    else {
        $('.emoji-panel').remove();
    }
    $('.emoji-tab span').click(function() {
        $('#i_smile').val($('#i_smile').val() + $(this).html());
    });
});
$('body').click(function(e) {
    if (!(e.target).closest('.emoji-panel')) {
        if ($('.emoji-panel').is(':visible')) {
            $('.emoji-panel').remove();
        }
    }
    if (!(e.target).closest('.sticker-panel')) {
        if ($('.sticker-panel').is(':visible')) {
            $('.sticker-panel').remove();
        }
    }
}); //ẩn khi click vị trí khác

/**Smileeeeeeeeeeeeeeee */
$('#i_sticker').click(function(e) {
    e.stopPropagation();
    e.preventDefault();
    if (!$('.sticker-panel').is(':visible')) {
        $('.chat-box-tray').append('<div class="sticker-panel"><ul class="nav nav-tabs" id="myTab" role="tablist"> <li class="nav-item" role="presentation"><a class="nav-link active" id="smile1-tab" data-bs-toggle="tab" href="#sticker1" role="tab" aria-controls="sticker1" aria-selected="true">Popo</a></li> <li class="nav-item" role="presentation"><a class="nav-link" id="sticker2-tab" data-bs-toggle="tab" href="#sticker2" role="tab" aria-controls="sticker2" aria-selected="false">Updating</a></li></ul><div class="tab-content" id="myTabContent"> <div class="tab-pane fade show active emoji-tab" id="sticker1" role="tabpanel" aria-labelledby="sticker1-tab"></div><div class="tab-pane fade emoji-tab" id="sticker2" role="tabpanel" aria-labelledby="sticker2-tab">...</div> </div> </div>');
        $('#sticker1').append('<img src="assets/images/emojis/popo/adore.png" alt="adore">');
        $('#sticker1').append('<img src="assets/images/emojis/popo/after_boom.png" alt="after_boom">');
        $('#sticker1').append('<img src="assets/images/emojis/popo/ah.png" alt="ah">');
        $('#sticker1').append('<img src="assets/images/emojis/popo/amazed.png" alt="amazed">');
        $('#sticker1').append('<img src="assets/images/emojis/popo/angry.png" alt="angry">');
        $('#sticker1').append('<img src="assets/images/emojis/popo/bad_smelly.png" alt="bad_smelly">');
        $('#sticker1').append('<img src="assets/images/emojis/popo/baffle.png" alt="baffle">');
        $('#sticker1').append('<img src="assets/images/emojis/popo/beat_brick.png" alt="beat_brick">');
        $('#sticker1').append('<img src="assets/images/emojis/popo/beat_plaster.png" alt="beat_plaster">');
        $('#sticker1').append('<img src="assets/images/emojis/popo/beat_shot.png" alt="beat_shot">');
        $('#sticker1').append('<img src="assets/images/emojis/popo/beated.png" alt="beated">');
        $('#sticker1').append('<img src="assets/images/emojis/popo/beauty.png" alt="beauty">');
        $('#sticker1').append('<img src="assets/images/emojis/popo/big_smile.png" alt="big_smile">');
        $('#sticker1').append('<img src="assets/images/emojis/popo/boss.png" alt="boss">');
        $('#sticker1').append('<img src="assets/images/emojis/popo/burn_joss_stick.png" alt="burn_joss_stick">');
        $('#sticker1').append('<img src="assets/images/emojis/popo/byebye.png" alt="byebye">');
        $('#sticker1').append('<img src="assets/images/emojis/popo/canny.png" alt="canny">');
        $('#sticker1').append('<img src="assets/images/emojis/popo/cold.png" alt="cold">');
        $('#sticker1').append('<img src="assets/images/emojis/popo/confident.png" alt="confident">');
        $('#sticker1').append('<img src="assets/images/emojis/popo/confuse.png" alt="confuse">');
        $('#sticker1').append('<img src="assets/images/emojis/popo/cool.png" alt="cool">');
        $('#sticker1').append('<img src="assets/images/emojis/popo/cry.png" alt="cry">');
        $('#sticker1').append('<img src="assets/images/emojis/popo/choler.png" alt="choler">');
        $('#sticker1').append('<img src="assets/images/emojis/popo/doubt.png" alt="doubt">');
        $('#sticker1').append('<img src="assets/images/emojis/popo/dribble.png" alt="dribble">');
        $('#sticker1').append('<img src="assets/images/emojis/popo/embarrassed.png" alt="embarrassed">');
        $('#sticker1').append('<img src="assets/images/emojis/popo/extreme_sexy_girl.png" alt="extreme_sexy_girl">');
        $('#sticker1').append('<img src="assets/images/emojis/popo/feel_good.png" alt="feel_good">');
        $('#sticker1').append('<img src="assets/images/emojis/popo/go.png" alt="go">');
        $('#sticker1').append('<img src="assets/images/emojis/popo/haha.png" alt="haha">');
        $('#sticker1').append('<img src="assets/images/emojis/popo/hell_boy.png" alt="hell_boy">');
        $('#sticker1').append('<img src="assets/images/emojis/popo/hungry.png" alt="hungry">');
        $('#sticker1').append('<img src="assets/images/emojis/popo/look_down.png" alt="look_down">');
        $('#sticker1').append('<img src="assets/images/emojis/popo/matrix.png" alt="matrix">');
        $('#sticker1').append('<img src="assets/images/emojis/popo/misdoubt.png" alt="misdoubt">');
        $('#sticker1').append('<img src="assets/images/emojis/popo/nosebleed.png" alt="nosebleed">');
        $('#sticker1').append('<img src="assets/images/emojis/popo/oh.png" alt="oh">');
        $('#sticker1').append('<img src="assets/images/emojis/popo/ops.png" alt="ops">');
        $('#sticker1').append('<img src="assets/images/emojis/popo/pudency.png" alt="pudency">');
        $('#sticker1').append('<img src="assets/images/emojis/popo/rap.png" alt="rap">');
        $('#sticker1').append('<img src="assets/images/emojis/popo/sad.png" alt="sad">');
        $('#sticker1').append('<img src="assets/images/emojis/popo/sexy_girl.png" alt="sexy_girl">');
        $('#sticker1').append('<img src="assets/images/emojis/popo/shame.png" alt="shame">');
        $('#sticker1').append('<img src="assets/images/emojis/popo/smile.png" alt="smile">');
        $('#sticker1').append('<img src="assets/images/emojis/popo/spiderman.png" alt="spiderman">');
        $('#sticker1').append('<img src="assets/images/emojis/popo/still_dreaming.png" alt="still_dreaming">');
        $('#sticker1').append('<img src="assets/images/emojis/popo/sure.png" alt="sure">');
        $('#sticker1').append('<img src="assets/images/emojis/popo/surrender.png" alt="surrender">');
        $('#sticker1').append('<img src="assets/images/emojis/popo/sweat.png" alt="sweat">');
        $('#sticker1').append('<img src="assets/images/emojis/popo/sweet_kiss.png" alt="sweet_kiss">');
        $('#sticker1').append('<img src="assets/images/emojis/popo/tire.png" alt="tire">');
        $('#sticker1').append('<img src="assets/images/emojis/popo/too_sad.png" alt="too_sad">');
        $('#sticker1').append('<img src="assets/images/emojis/popo/waaaht.png" alt="waaaht">');
        $('#sticker1').append('<img src="assets/images/emojis/popo/what.png" alt="what">');
    }
    else {
        $('.sticker-panel').remove();
    }
    $('.emoji-tab img').click(function() {
        $('#i_smile').val($('#i_smile').val() + '(:' + $(this).attr("alt") + ':)');
    });
});