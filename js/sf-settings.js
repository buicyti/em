var header_title = 'EM - Cấu hình line';
var selectMachine = []

function loadline() {
    html = '<select class="form-select" id="listLine">'
    $(data1).each(function (keyk, valk) {
        $(valk['children']).each(function (key, val) {
            html += '<option value="' + val['text'] + '">' + val['text'] + '</option>'
        })
    })
    html += '</select>'
    $('#loadline').html(html);
    html = '';

    $("#listLine").change(function () {
        //alert("Handler for .change() called.");
        $.ajax({
            type: "POST",
            url: "php/sf-setting.php",
            data: { action: 'lay-thong-tin-line', line_id: $("#listLine").val() },
            dataType: "json",
            success: function (res) {
                $('#listMachi').multiSelect('deselect_all')
                $(res).each(function (key, val) {
                    $('#listMachi').multiSelect('select', val);
                });
            },
            error: function () {
                $('#listMachi').multiSelect('deselect_all')
            }
        });
    });
}


$.ajax({
    type: "POST",
    url: "php/sf-setting.php",
    data: { action: 'lay-ds-machine' },
    dataType: "json",
    success: function (listMachine) {
        html = '<select id="listMachi" multiple="multiple">'
        $(listMachine).each(function (key, value) {
            html += '<option value="' + value + '">' + value + '</option>'
        })
        html += '</select>'
        $('.showMachine').html(html);//load ra ds line

        //tạo Multi select
        $('#listMachi').multiSelect({ keepOrder: true })
        
    },
    error: function (xhr, status, error) {
        console.log(xhr + status + error)
    }
})


$('#selectall').on('click', function(){
    $('#listMachi').multiSelect('select_all')
})
$('#deselectall').on('click', function(){
    $('#listMachi').multiSelect('deselect_all')
})
$('.btn.btn-danger').on('click', function(){
    $.ajax({
        type: "POST",
        url: "php/sf-setting.php",
        data: { action: 'delete-ds-line', del_line: $('#listLine').val()},
        dataType: "text",
        success: function (dataa) {
            alert(dataa)
        },
        error: function (xhr, status, error) {
            console.log(xhr + status + error)
        }
    })
})
$('.btn.btn-success').on('click', function(){
    selectMachine = []
    $('.ms-selection .ms-list .ms-selected').each(function() {
        selectMachine.push($(this).text());
        });
    $.ajax({
        type: "POST",
        url: "php/sf-setting.php",
        data: {action: 'update-ds-line', update_line: $('#listLine').val(), selectedMachine: selectMachine},
        dataType: "text",
        success: function (response) {
            alert(response)
        }
    });
})


$(document).ready(function () {
    loadline()
});