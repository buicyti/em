var header_title = 'EM - DAT';



function load_data() {
    $.ajax({
        type: "POST",
        url: "php/monitors-dat.php",
        dataType: "json",
        data: { send_dat: 'ds' },
        success: function (data) {
            console.log(data)
            datatable.clear();
            datatable.rows.add(data).draw()
            load_check();

            /*  $('#example tbody tr').on( 'click', 'td:eq(4)', function () {
                 //console.log( datatable.row( this ).data()['timer_on'] );
             }); */
            load_daterangepicker()
        },
        error: function (xhr, status, error) {
            console.error(xhr);
        }
    })
}

function load_check() {
    $('.isChecked').change(function () {
        if ($(this).is(':checked')) checkk = 1
        else checkk = 0

        id_line = $(this).attr('id').substr(7, 9)
        $.ajax({
            type: "POST",
            url: "php/monitors-dat.php",
            dataType: "text",
            data: { send_dat: 'send', checkk: checkk, id_line: id_line }
        })
    })

    $('.timeon').on('click', function () {
        timeronid = '#' + $(this).attr('id')
    })
    $('.timeoff').on('click', function () {
        timeroffid = '#' + $(this).attr('id')
    })


}

function load_daterangepicker() {
    $('#example tbody tr td .timeon').daterangepicker({
        singleDatePicker: true,
        timePicker: true,
        timePicker24Hour: true,
        timePickerSeconds: true,
        opens: 'right',
        drops: 'down',
        startDate: moment().startOf('hour')
    }, function (start) {
        $(timeronid).html(start.format('YYYY-MM-DD HH:mm:ss'))
        console.log(timeronid.substr(7, 9))
        $.ajax({
            type: "POST",
            url: "php/monitors-dat.php",
            dataType: "text",
            data: { send_dat: 'sendtimeonid', checkk: $(timeronid).text(), id_line: timeronid.substr(7, 9) },
            success: function (data) {
                console.log($('aaaaaaaaaaa'))
            },
            error: function (xhr, status, error) {
                console.error(status);
            }
        })
    });

    $('#example tbody tr td .timeoff').daterangepicker({
        singleDatePicker: true,
        timePicker: true,
        timePicker24Hour: true,
        timePickerSeconds: true,
        opens: 'right',
        drops: 'down',
        startDate: moment().startOf('hour')
    }, function (start) {
        $(timeroffid).html(start.format('YYYY-MM-DD HH:mm:ss'))
        $.ajax({
            type: "POST",
            url: "php/monitors-dat.php",
            dataType: "text",
            data: { send_dat: 'sendtimeoffid', checkk: $(timeroffid).text(), id_line: timeroffid.substr(8, 9) },
            success: function (data) {
                console.log($('aaaaaaaaaaa'))
            },
            error: function (xhr, status, error) {
                console.error(status);
            }
        })
    });
}

$(document).ready(function () {
    //setreload = setInterval(function () { load_data() }, 1000);
    load_data();
});

var datatable = $('#example').DataTable({
    columns: [
        { data: 'id', title: 'STT' },
        { data: 'line_id', title: 'Line' },
        { data: 'status', title: 'Trạng thái' },
        { data: 'remote_agent', title: 'Điều khiển' },
        { data: 'timer_on', title: 'HẸN GIỜ BẬT' },
        { data: 'timer_off', title: 'HẸN GIỜ TẮT' }
    ],
    language: {
        "sProcessing": "Đang xử lý...",
        "sLengthMenu": "Xem _MENU_ mục",
        "sZeroRecords": "Không tìm thấy dòng nào phù hợp",
        "sInfo": "Đang xem _START_ đến _END_ trong tổng số _TOTAL_ mục",
        "sInfoEmpty": "Đang xem 0 đến 0 trong tổng số 0 mục",
        "sInfoFiltered": "(được lọc từ _MAX_ mục)",
        "sInfoPostFix": "",
        "sSearch": "Tìm:",
        "sUrl": "",
        "oPaginate": {
            "sFirst": "Đầu",
            "sPrevious": "Trước",
            "sNext": "Tiếp",
            "sLast": "Cuối"
        }
    },
    processing: true, // tiền xử lý trước
    aLengthMenu: [[10, 20, 50], [10, 20, 50]], // danh sách số trang trên 1 lần hiển thị bảng
    order: [[0, 'asc']] //sắp xếp giảm dần theo cột thứ 1
})

$(datatable.table().body()).addClass('text-center align-middle');
$('#example_paginate').on('click', function () {
    load_daterangepicker()
    $('.timeon').on('click', function () {
        timeronid = '#' + $(this).attr('id')
    })
    $('.timeoff').on('click', function () {
        timeroffid = '#' + $(this).attr('id')
    })
})