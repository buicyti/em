var header_title = 'EM - Mapping thẻ'
var maso1 = 0, maso2 = 0

$('#btnMap').on('click', function () {
    var _ma = 0
    if(maso1 == 1 && maso2 == 2){
        _ma = 1
        data = jQuery.parseJSON('{"action": "updateByIdcard", "idcard": "'+ $('#fliIDCard').val() +'", "idemp": "'+ $('#fliEmployeeID').val() +'"}');
        $('#btnHelp').css({'display': 'none'})
    } else if(maso1 == 3 && maso2 == 1){
        _ma = 1
        data = jQuery.parseJSON('{"action": "updateByIdemp", "idcard": "'+ $('#fliIDCard').val() +'", "idemp": "'+ $('#fliEmployeeID').val() +'"}');
        $('#btnHelp').css({'display': 'none'})
    } else if(maso1 == 3 && maso2 == 2){
        _ma = 1
        data = jQuery.parseJSON('{"action": "insertToTab", "idcard": "'+ $('#fliIDCard').val() +'", "idemp": "'+ $('#fliEmployeeID').val() +'"}');
        $('#btnHelp').css({'display': 'none'})
    } else {
        _ma = 0
        $('#btnHelp').css({'display': 'block', 'color': 'red'})
        $('#btnHelp').text('Có thông tin chưa chính xác!')
    }
    if(_ma == 1){
        $.ajax({
            type: "POST",
            url: "php/checklist-mapping.php",
            data: data,
            dataType: "text",
            success: function (response) {
                $('#btnHelp').css({'display': 'block', 'color': 'green'})
                $('#btnHelp').text(response)
                $('#btnMap').attr("disabled", true);
            }
        });
        _ma = 0
        maso1 = 0
        maso2 = 0
    }
    $.ajax({
        type: "POST",
        url: "php/checklist-mapping.php",
        data: {action: 'showMap'},
        dataType: "json",
        success: function (response) {
            tabMap.clear().rows.add(response).draw()
        }
    });
});

$('#fliIDCard, #fliEmployeeID').on("focusin", function(){
    $('#btnMap').attr("disabled", true);
})

$('#fliIDCard').on("focusout change", function () {
    if($('#fliIDCard').val() == "") return
    $('#btnMap').removeAttr("disabled");
    $.ajax({
        type: "POST",
        url: "php/checklist-mapping.php",
        data: {action: 'check_idcard', data: $('#fliIDCard').val()},
        dataType: "json",
        success: function (response) {
            $('#idCardHelp').css({'display': 'block', 'color': response["color"]});//hiện ra thông báo
            $('#idCardHelp').text(response["tb"]);
            maso1 = response['ma']
            if(maso1 == 1){
                $('#fliEmployeeID').val(response['id_emp'])
                $('#fliEmployeeName').val(response['name_emp'])
                $('#fliGr').val(response['nhom'])
                $('#fliCa').val(response['ca'])
            }
        }
    });
});

$('#fliEmployeeID').on("focusout change", function () {
    if($('#fliEmployeeID').val() == "") return
    $('#btnMap').removeAttr("disabled");
    $.ajax({
    type: "POST",
    url: "php/checklist-mapping.php",
    data: {action: 'check_idemp', data: $('#fliEmployeeID').val()},
    dataType: "json",
    success: function (response) {
        $('#idEmployeeHelp').css({'display': 'block', 'color': response["color"]});//hiện ra thông báo
            $('#idEmployeeHelp').text(response["tb"]);
            maso2 = response['ma']
            if(maso2 == 1 || maso2 == 2){
                $('#fliEmployeeID').val(response['id_emp'])
                $('#fliEmployeeName').val(response['name_emp'])
                $('#fliGr').val(response['nhom'])
                $('#fliCa').val(response['ca'])
            }
    }
   });
});

function load_list_mapping(){
    $.ajax({
        type: "POST",
        url: "php/checklist-mapping.php",
        data: {action: 'showMap'},
        dataType: "json",
        success: function (response) {
            tabMap = $('#tabMap').DataTable({
                data: response,
                columns: [
                    {title: "STT",render: function (data, type, row, meta) {return meta.row + 1;}},// This contains the row index
                    {data: 'idemp', title: 'Mã NV'},
                    {data: 'nameemp', title: 'Tên NV'},
                    {data: 'nhom', title: 'Nhóm'},
                    {data: 'ca', title: 'Ca / Kíp'},
                    {data: 'cardid', title: 'Mã thẻ'}
                ]
            })
        }
    });
 }
$(document).ready(function () {
    load_list_mapping()
});