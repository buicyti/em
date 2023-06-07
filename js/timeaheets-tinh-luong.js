var header_title = 'EM - Tính Lương';
var luong_chuc_vu = {'Member': 0, 'Sub Leader': 600000, 'Leader':1000000, 'Sub Part Leader':3000000, 'Part Leader':7000000};
var luong_vi_tri = {
    'OP': {'Bậc 1': 4870000, 'Bậc 2': 0,'Bậc 3': 0,'Bậc 4': 0,'Bậc 5': 0,'Bậc 6': 0,'Bậc 7': 0,'Bậc 8': 0,'Bậc 9': 0,'Bậc 10': 0, 'Bậc 11': 0, 'Bậc 12': 0,'Bậc 13': 0,'Bậc 14': 0,'Bậc 15': 0,'Bậc 16': 0,'Bậc 17': 0,'Bậc 18': 0,'Bậc 19': 0,'Bậc 20': 0},
    'Tech': {'Bậc 1': 0, 'Bậc 2': 0,'Bậc 3': 0,'Bậc 4': 0,'Bậc 5': 0,'Bậc 6': 0,'Bậc 7': 0,'Bậc 8': 0,'Bậc 9': 0,'Bậc 10': 0},
    'Senior Tech': {'Bậc 1': 0, 'Bậc 2': 0,'Bậc 3': 0,'Bậc 4': 0,'Bậc 5': 0,'Bậc 6': 0}, //,'Bậc 7': 0,'Bậc 8': 0,'Bậc 9': 0,'Bậc 10': 0
    'Expert Tech': {'Bậc 1': 7990000, 'Bậc 2': 0,'Bậc 3': 0,'Bậc 4': 0,'Bậc 5': 0,'Bậc 6': 0,'Bậc 7': 0,'Bậc 8': 0,'Bậc 9': 0,'Bậc 10': 0},
    'Master Tech': {'Bậc 1': 0, 'Bậc 2': 0,'Bậc 3': 0,'Bậc 4': 0,'Bậc 5': 0,'Bậc 6': 0,'Bậc 7': 0,'Bậc 8': 0,'Bậc 9': 0,'Bậc 10': 0},
    'Junior Staff': {'Bậc 1': 0, 'Bậc 2': 0,'Bậc 3': 0,'Bậc 4': 0,'Bậc 5': 0,'Bậc 6': 0,'Bậc 7': 0,'Bậc 8': 0,'Bậc 9': 0,'Bậc 10': 0},
    'Staff': {'Bậc 1': 0, 'Bậc 2': 0,'Bậc 3': 0,'Bậc 4': 0,'Bậc 5': 0,'Bậc 6': 0,'Bậc 7': 0,'Bậc 8': 0,'Bậc 9': 0,'Bậc 10': 0},
    'Senior Staff': {'Bậc 1': 0, 'Bậc 2': 0,'Bậc 3': 0,'Bậc 4': 0,'Bậc 5': 0,'Bậc 6': 0,'Bậc 7': 0,'Bậc 8': 0,'Bậc 9': 0,'Bậc 10': 0},
    'AM': {'Bậc 1': 0, 'Bậc 2': 0,'Bậc 3': 0,'Bậc 4': 0,'Bậc 5': 0,'Bậc 6': 0,'Bậc 7': 0,'Bậc 8': 0,'Bậc 9': 0,'Bậc 10': 0}
};

var luong_mbo = {
    'OP':{'C': 0 , 'B': 0, 'B+': 200000, 'A': 450000, 'SS':750000},
    'Tech':{'C': 0 , 'B': 0, 'B+': 300000, 'A': 600000, 'SS':1000000},
    'Manager':{'C': 0 , 'B': 0, 'B+': 500000, 'A': 1000000, 'SS':1500000}
}
 var holidays = ['2022-04-30','2022-05-01','2022-09-02'];
var du_lieu_ot;
var dt_search;
//tải dữ liệu chức vụ
function chon_chuc_vu(){
    $.each(luong_chuc_vu, function(key, val) {
        $('#chuc-vu').append("<option value='" + val + "'>" + key + "</option>");
    });
}


//tải dữ liệu cấp bậc
function chon_bac_luong1(){
    $.each(luong_vi_tri, function(key, val) {
        $('#bac-luong1').append("<option value='" + key + "'>" + key + "</option>");
    });
}

function chon_bac_luong2(){
    $('#bac-luong2').empty();
    $.each(luong_vi_tri[$('#bac-luong1').val()], function(key, val) {
        $('#bac-luong2').append("<option value='" + val + "'>" + key + "</option>");
    });
}

function chon_mbo(){
    $('#mbo').empty();
    if($('#chuc-vu :selected').text() == 'Member' && $('#bac-luong1').val() == 'OP'){
        $.each(luong_mbo['OP'], function(key, val) {
            $('#mbo').append("<option value='" + val + "'>" + key + "</option>");
        });
    }
    else if($('#chuc-vu :selected').text() == 'Member' && $('#bac-luong1').val().indexOf("Tech") >= 0){
        $.each(luong_mbo['Tech'], function(key, val) {
            $('#mbo').append("<option value='" + val + "'>" + key + "</option>");
        });
    }
    else{
        $.each(luong_mbo['Manager'], function(key, val) {
            $('#mbo').append("<option value='" + val + "'>" + key + "</option>");
        });
    }
    
}

$('#tingting').on('click', function(){
    var thang_cong = new Array();
    var nam_cong = new Array();
    var ngay_lv_trong_thang = 0;
    var h_lv_t = 0;
    var luong = {'luong': 0, 'tru_kl': 0, 'luong_70': 0, 'tru_dimuon':0,'thuc_linh':0 };
    var phu_cap = {'ca_dem':0, 'bonusT7':0,'dem_45p': 0, 'chuyen_can': 0, 'doi_song': 0, 'ky_nang': 0, 'trach_nhiem': 0,'che_do_nu': 0};
    var OT = {'OT150': 0, 'OT200': 0, 'OT270': 0, 'OT300': 0, 'OT390': 0, }
    var khau_tru = {'bhxh': 0, 'bhyt': 0, 'bhtn': 0, 'doan_phi': 0, 'thue_tncn': 0, 'khac': 0};
    var luong_1h = 0;
    var thue_TNCN = {'tong_thu_nhap_chiu_thue': 0, 'giam_tru': 0, 'chiu_thue': 0};

    thang_cong[0] = $('#thang-cong').val();
    nam_cong[0] = $('#nam-cong').val();
    if(thang_cong[0] == 1) {thang_cong[1] = 12; nam_cong[1] = nam_cong[0] - 1;}
    else {thang_cong[1] = thang_cong[0] - 1; nam_cong[1] = nam_cong[0];}
    ngay_lv_trong_thang = workingDaysBetweenDates(nam_cong[1] + '-' + thang_cong[1] + '-11',nam_cong[0] + '-' + thang_cong[0] + '-10'); //đếm số ngày làm việc trong tháng
    T7_trong_thang = dem_T7(nam_cong[1] + '-' + thang_cong[1] + '-11',nam_cong[0] + '-' + thang_cong[0] + '-10');
    //thông báo thời gian làm việc
    $('#thang-nam').html('Từ: 11/' + thang_cong[1] +'/' + nam_cong[1] + ' đến 10/'  + thang_cong[0] +'/' + nam_cong[0] +
                         '<br/>Ngày làm việc trong tháng: ' + ngay_lv_trong_thang +
                         '<br/> Tổng số giờ làm việc trong tháng: ' + Math.floor(T7_trong_thang*2 + ngay_lv_trong_thang*9.2));
    $("#thang-nam").css("display", "block");
    luong['luong'] = $('#bac-luong2').val();
    phu_cap['trach_nhiem'] = $('#chuc-vu').val();

    if(Math.floor(T7_trong_thang*2 + ngay_lv_trong_thang*9.2) > 208) h_lv_t = 208;
    else h_lv_t = Math.floor(T7_trong_thang*2 + ngay_lv_trong_thang*9.2);

    luong_1h = (luong['luong']*1 + $('#chuc-vu').val()*1 + $('#pc_ds span').text()*1 + $('#pc_kn span').text()*1)/h_lv_t ;

    luong['tru_kl'] = luong['luong']/(ngay_lv_trong_thang*9.2)*($('#cong_nglk').text() * 9 + $('#cong_nghi70').text() * 9);
    luong['luong_70'] = luong['luong']/(ngay_lv_trong_thang*9.2)*($('#cong_nghi70').text() * 9 * 0.7);
    luong['tru_dimuon'] = luong['luong']/(ngay_lv_trong_thang*9.2)*($('#cong_dmvs').text());
    luong['thuc_linh'] = luong['luong']*1 - luong['tru_kl'] - luong['tru_dimuon'];

    thue_TNCN['tong_thu_nhap_chiu_thue'] += luong['luong_70'] + luong['thuc_linh'];

    $('#luong-co-ban').html(LamTronSo(luong['thuc_linh']));//xuất ra số lương thực linh
    $('#luong-70').html(LamTronSo(luong['luong_70']));//xuất ra số lương 70%


    //Các khoản phụ cấp cơ bản
    phu_cap['ca_dem'] = luong_1h * $('#cong_cadem').text() * 0.3 * 7.2;
    phu_cap['bonusT7'] = luong_1h * $('#cong_ot200t7').text() * 2;
    phu_cap['dem_45p'] = luong_1h * $('#cong_cadem').text() * 2 * 0.75;
    if(($('#cong_nglk').text()*1 + $('#cong_dmvs').text()/9) < 1) {phu_cap['chuyen_can'] = 200000;}
    else if(($('#cong_nglk').text()*1 + $('#cong_dmvs').text()/9) == 1) {phu_cap['chuyen_can'] = 100000;}
    else phu_cap['chuyen_can'] = 0;
    phu_cap['doi_song'] = $('#pc_ds span').text() - $('#pc_ds span').text()/(ngay_lv_trong_thang*9.2) * ($('#cong_nglk').text() * 9 + $('#cong_nghi70').text() * 9 * 0.3 + $('#cong_dmvs').text());
    phu_cap['ky_nang'] =  $('#pc_kn span').text() - $('#pc_kn span').text()/(ngay_lv_trong_thang*9.2) * ($('#cong_nglk').text() * 9 + $('#cong_nghi70').text() * 9 * 0.3 + $('#cong_dmvs').text());
    phu_cap['trach_nhiem'] = phu_cap['trach_nhiem'] - phu_cap['trach_nhiem']/(ngay_lv_trong_thang*9.2) * ($('#cong_nglk').text() * 9 + $('#cong_nghi70').text() * 9 * 0.3 + $('#cong_dmvs').text());
    phu_cap['che_do_nu'] = $('#pc_cdn span').text() * luong_1h * 2;

    
    thue_TNCN['tong_thu_nhap_chiu_thue'] += phu_cap['chuyen_can'] + phu_cap['doi_song'] + phu_cap['ky_nang'] + phu_cap['trach_nhiem'];

    $('#luong-chuyen-can').html(LamTronSo(phu_cap['chuyen_can']));
    $('#luong-doi-song').html(LamTronSo(phu_cap['doi_song']));
    $('#luong-ky-nang').html(LamTronSo(phu_cap['ky_nang']));
    $('#luong-trach-nhiem').html(LamTronSo(phu_cap['trach_nhiem']));
    $('#luong-pc-ca-dem').html(LamTronSo(phu_cap['ca_dem']));
    $('#che-do-nu').html(LamTronSo(phu_cap['che_do_nu']));

    //Em yêu của mình
    $('#thuong-mbo').html(LamTronSo($('#mbo').val()));
    $('#xep-loai-mbo').html('<b>' + $('#mbo :selected').text() + '</b>');

    ///////mỗi thứ 7 đi làm có 2h đầu không tính vào OT nhưng vẫn đc trả xèng
    $('#bonus-t7').html(LamTronSo(phu_cap['bonusT7']));
    

    //OT
    OT['OT150'] = luong_1h * $('#cong_ot150').text() * 1.5;
    OT['OT200'] = luong_1h * $('#cong_ot200').text() * 2;
    OT['OT270'] = luong_1h * $('#cong_ot270').text() * 2.7;
    OT['OT300'] = luong_1h * $('#cong_ot300').text() * 3;
    OT['OT390'] = luong_1h * $('#cong_ot390').text() * 3.9;

    thue_TNCN['tong_thu_nhap_chiu_thue'] += luong_1h * ($('#cong_ot150').text()*1 + $('#cong_ot200').text()*1 + $('#cong_ot270').text()*1 + $('#cong_ot300').text()*1 + $('#cong_ot390').text()*1 + $('#cong_ot200t7').text()*1)
    
    $('#tong-ot').html(LamTronSo(sumArray(OT) + phu_cap['dem_45p']*1));
    $('#tong-thu-nhap').html(LamTronSo(sumArray(OT) + sumArray(phu_cap) + luong['luong_70']*1 + luong['thuc_linh']*1 + $('#mbo').val()*1))

    ////Khấu trừ
    khau_tru['bhxh'] = (luong['luong']*1 + $('#chuc-vu').val()*1 + $('#pc_ds span').text()*1 + $('#pc_kn span').text()*1) * 0.08; //8% lương cơ bản và các loại phụ cấp trừ chuyên cần
    khau_tru['bhyt'] = (luong['luong']*1 + $('#chuc-vu').val()*1 + $('#pc_ds span').text()*1 + $('#pc_kn span').text()*1) * 0.015;
    khau_tru['bhtn'] = (luong['luong']*1 + $('#chuc-vu').val()*1 + $('#pc_ds span').text()*1 + $('#pc_kn span').text()*1) * 0.01;
    khau_tru['doan_phi'] = luong_vi_tri['OP']['Bậc 1'] * 0.01; //1% lương cơ bản của OP 1

    thue_TNCN['giam_tru'] += sumArray(khau_tru);
    thue_TNCN['giam_tru'] += $('#nguoi-phu-thuoc span').text()*4400000 //lương cơ sở

    thue_TNCN['chiu_thue'] = thue_TNCN['tong_thu_nhap_chiu_thue'] - 11000000 -thue_TNCN['giam_tru']; // thu nhập chịu thế sau giảm trừ
    
    if(thue_TNCN['chiu_thue'] > 0 && thue_TNCN['chiu_thue'] <= 5000000 ) khau_tru['thue_tncn'] = thue_TNCN['chiu_thue'] * 0.05 ;
    else if(thue_TNCN['chiu_thue'] > 5000001 && thue_TNCN['chiu_thue'] < 10000000 ) khau_tru['thue_tncn'] = thue_TNCN['chiu_thue'] * 0.1 - 250000;
    else if(thue_TNCN['chiu_thue'] > 10000001 && thue_TNCN['chiu_thue'] < 18000000 ) khau_tru['thue_tncn'] = thue_TNCN['chiu_thue'] * 0.15 - 750000;
    else if(thue_TNCN['chiu_thue'] > 18000001 && thue_TNCN['chiu_thue'] < 32000000 ) khau_tru['thue_tncn'] = thue_TNCN['chiu_thue'] * 0.2 - 1650000;
    else if(thue_TNCN['chiu_thue'] > 32000001 && thue_TNCN['chiu_thue'] < 52000000 ) khau_tru['thue_tncn'] = thue_TNCN['chiu_thue'] * 0.25 - 3250000;
    else if(thue_TNCN['chiu_thue'] > 52000001 && thue_TNCN['chiu_thue'] < 80000000 ) khau_tru['thue_tncn'] = thue_TNCN['chiu_thue'] * 0.3 - 5850000;
    else if(thue_TNCN['chiu_thue'] > 80000001 ) khau_tru['thue_tncn'] = thue_TNCN['chiu_thue'] * 0.35 - 9850000;
    
    //in ra các khoản khấu trừ
    $('#tru-bhxh').html(LamTronSo(khau_tru['bhxh']));
    $('#tru-bhyt').html(LamTronSo(khau_tru['bhyt']));
    $('#tru-bhtn').html(LamTronSo(khau_tru['bhtn']));
    $('#tru-doan-phi').html(LamTronSo(khau_tru['doan_phi']));
    $('#tru-thue-tncn').html(LamTronSo(khau_tru['thue_tncn']));
    $('#tong-khau-tru').html(LamTronSo(sumArray(khau_tru)));
    //in ra tooltiptong-ot
    $("#luong-co-ban").attr('title','<b>Lương cơ bản: </b>' + luong['luong'] + '<br/>' + '<b>Trừ không lương + 70%: </b>' + LamTronSo(luong['tru_kl']) + '<br/>' + '<b>Trừ đi muộn: </b>' + LamTronSo(luong['tru_dimuon']));
    $("#tong-ot").attr('title','Phụ cấp đêm: ' + LamTronSo(phu_cap['ca_dem']) + '<br/>OT 150%: ' + LamTronSo(OT['OT150']) + '<br/>OT 200%: ' + LamTronSo(OT['OT200']) + '<br/>OT 270%: ' + LamTronSo(OT['OT270']) + '<br/>OT 300%: ' + LamTronSo(OT['OT300']) + '<br/>OT 390%: ' + LamTronSo(OT['OT390']) );
    $('[data-toggle="tooltip_c"]').tooltip('dispose');
    $('[data-toggle="tooltip_c"]').tooltip()

    //in ra thu nhập thực lĩnh
    $('#thu-nhap-thuc-linh').html(LamTronSo(sumArray(OT) + sumArray(phu_cap) + luong['luong_70']*1 + luong['thuc_linh']*1 + $('#mbo').val()*1 - sumArray(khau_tru)));
    
});

function workingDaysBetweenDates(d0, d1) {
    var startDate = parseDate(d0);
    var endDate = parseDate(d1);  
    if (endDate < startDate) return 0; //Kiểm tra đầu vào, nếu ngày kết thúc nhỏ hơn ngày bắt đầu thì cho bằng 0
    // Tính toán khoảng cách ngày
    startDate.setHours(0,0,0,1);
    endDate.setHours(23,59,59,999);
    var days = Math.ceil((endDate - startDate) / (1000 * 60 * 60 * 24));
    //trừ đi 2 ngày cuối tuần cho tuần ở giữa
    var weeks = Math.floor(days / 7);
    days = days - (weeks * 2);
    // Xử lý các trường hợp đặc biệt, lấy số ngày trong tuần (CN = 0, T2 = 1,...., T7 = 6)
    var startDay = startDate.getDay();
    var endDay = endDate.getDay();
    // Xóa ngày cuối tuần chưa được xóa trước đó. Đoạn này hơi loằng ngoằng nhưng kệ
    if (startDay - endDay > 1) days = days - 2;
    // Xóa ngày bắt đầu nếu khoảng thời gian bắt đầu vào Chủ nhật nhưng kết thúc trước Thứ Bảy
    if (startDay == 0 && endDay != 6) days = days - 1;
    // Xóa ngày kết thúc nếu khoảng thời gian kết thúc vào thứ Bảy nhưng bắt đầu sau Chủ nhật
    if (endDay == 6 && startDay != 0) days = days - 1;
    //IN RA
    return days;
}
function dem_T7(ngay_bat_dau, ngay_ket_thuc) {
    var startDate = parseDate(ngay_bat_dau);
    var endDate = parseDate(ngay_ket_thuc);  
    if (endDate < startDate) return 0; //Kiểm tra đầu vào, nếu ngày kết thúc nhỏ hơn ngày bắt đầu thì cho bằng 0
    
    var numWorkDays = 0;
    var currentDate = startDate;
    while (currentDate <= endDate) {
        // kiểm tra ngày lễ có trùng T7 ko, nếu trùng thì bỏ qua
        if (currentDate.getDay() == 6) numWorkDays++; // nếu là T7 thì tăng lên
        currentDate.setDate(currentDate.getDate() + 1); //cộng thêm 1ngay tiếp theo
    }
    return numWorkDays;
}

function parseDate(input) {
	// Chuyển chữ sang ngày
  var parts = input.match(/(\d+)/g);
  return new Date(parts[0], parts[1]-1, parts[2]);
}

function LamTronSo(numbers) {
    return numbers.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",").split('.')[0];
}

function sumArray(mang){
    let sum = 0;
    $.each(mang, function (i, val) { 
        sum += mang[i];
    });
    return sum;
}

$('#nhap-cong span').click( function(){
    let dataa = prompt("Nhập giá trị:", 0);
    $(this).html(dataa);
});


$('#list-phu-cap span').click( function(){
    let dataa = prompt("Nhập giá trị:", 0);
    $(this).html(dataa);
});


var filter = {
    name: 'Lê Trí Hoàng'
  };
$('#btn-search').click(function(){
   /* tim_kiem = $('#name-user').val();
    dt_search= du_lieu_ot.filter(item => item.name.indexOf(tim_kiem) > -1);
    //thêm các id đc tìm thấy vào ô id
    $('#name-id').empty();
    $.each(dt_search, function(key, val) {
        $('#name-id').append("<option value='" + key + "'>" + val['id'] + "</option>");
    });
      
      console.log(dt_search)*/

      $.each(holidays, function(key, val){
        //if (currentDate.getDay() == 6 && val.getDay() != 6) numWorkDays++; // nếu là T7 thì tăng lên 
        alert(parseDate(val).getDay()) ;
    })
    alert(dem_T7('2022-04-11','2022-05-10'));
    alert(workingDaysBetweenDates('2022-04-11','2022-05-10'));

});

/*$('#submit_files').on('click', function(){
    $.ajax({
        type: "post",
        url: "php/timesheet-tinh-luong.php",
        data: 'get-file',
        dataType: "json",
        success: function (data) {
            $('#name-id').empty();
            $.each(data, function(key, val) {
                $('#name-id').append("<option value='" + key + "'>" + val['id'] + "</option>");
            });
            du_lieu_ot = data;
            get_data();
        },
        error: function(xhr, status, error) {
            console.error(xhr);
        }
    });
});*/

$('#submit1').on('click', function () {
    var file_data = $('#file_up').prop('files')[0];
    //khởi tạo đối tượng form data
    var form_data = new FormData();
    //thêm files vào trong form data
    form_data.append('file_up', file_data);
    //sử dụng ajax post
    $.ajax({
        url: 'php/timesheet-tinh-luong.php',
        dataType: 'json',
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,
        type: 'post',
        success: function (data) {
            $('#name-id').empty();
            $.each(data, function(key, val) {
                $('#name-id').append("<option value='" + key + "'>" + val['id'] + "</option>");
            });
            du_lieu_ot = data;
            console.log(du_lieu_ot);
            get_data();
            //$('#thang-nam').html(data)
        },
        error: function(xhr, status, error) {
            console.error(xhr);
            //alert('Định dạng file bạn tải lên không thể đọc được')
        }
    });
});

function get_data(){
    //console.log(du_lieu_ot)
    $('#name-user').val(du_lieu_ot[$('#name-id').val()]['name']);
    $('#cong_ot150').html(du_lieu_ot[$('#name-id').val()]['OT150']);
    $('#cong_ot200').html(du_lieu_ot[$('#name-id').val()]['OT200']);
    $('#cong_ot200T7').html(du_lieu_ot[$('#name-id').val()]['OT200T7']);
    $('#cong_ot270').html(du_lieu_ot[$('#name-id').val()]['OT270']);
    $('#cong_ot300').html(du_lieu_ot[$('#name-id').val()]['OT300']);
    $('#cong_ot390').html(du_lieu_ot[$('#name-id').val()]['OT390']);
}

$(document).ready(function(){
    chon_chuc_vu();
    chon_bac_luong1();
    chon_bac_luong2();
    chon_mbo();
    //khi thay đổi bậc lương thì cập nhật lương và MBO mới cho từng bậc
    $('#bac-luong1').on('change', function (e) { 
        e.preventDefault();
        chon_bac_luong2();
        chon_mbo();
    });
    //khi thay đổi chức vụ thì thay đổi MBO
    $('#chuc-vu').on('change', function (e) { 
        e.preventDefault();
        chon_mbo();
    });

    $('#name-id').on('change', function (e) { 
        e.preventDefault();
        get_data();
    });

      
});

/*var startDate = new Date('2022-05-11');
var endDate = new Date('2022-06-10');
var numOfDates = getBusinessDatesCount(startDate,endDate);

function getBusinessDatesCount(startDate, endDate) {
    let count = 0;
    const curDate = new Date(startDate.getTime());
    while (curDate <= endDate) {
        const dayOfWeek = curDate.getDay();
        if(dayOfWeek !== 0 && dayOfWeek !== 6) count++;
        curDate.setDate(curDate.getDate() + 1);
    }
    return count;
}*/


