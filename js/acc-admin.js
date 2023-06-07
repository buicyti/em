var header_title = 'EM - Quản lý tài khoản'
var html_groups = '<select style="border: none; background-color: transparent; -moz-appearance: none;-webkit-appearance: none;appearance: none;"><option value="0">Khách</option><option value="1">Audit</option><option value="2">EQ</option><option value="3">MGT</option><option value="4">MM</option><option value="5">PQC</option><option value="6">3M</option><option value="7">PRD</option></select>';
var html_position = '<select style="border: none; background-color: transparent; -moz-appearance: none;-webkit-appearance: none;appearance: none;"><option value="0">Khách</option><option value="1">PLD</option><option value="2">SPLD</option><option value="3">LD</option><option value="4">SLD</option><option value="5">Member</option></select>'
var html_job = '<select style="border: none; background-color: transparent; -moz-appearance: none;-webkit-appearance: none;appearance: none;"><option value="0">Khách</option><option value="1">MK</option><option value="2">EGN</option><option value="3">CHIP</option><option value="4">CMD</option><option value="5">PM</option></select>'


function loadAcc() {
    $.ajax({
        type: "POST",
        url: "php/acc-admin.php",
        data: { action: 'loadAccounts' },
        dataType: "json",
        success: function (data) {
            tabAccountList.clear().rows.add(data).draw();
        }
    });
}

$(document).ready(function () {


    //khai báo bảng hiển thị thông tin
    tabAccountList = $('#tabAccountList').DataTable({
        //data: data,
        columns: [
            {
                title: '<input class="form-check-input" name="checkAll" type="checkbox" value="">',
                render: function () {
                    return '<input class="form-check-input" type="checkbox">'
                }
            }, {
                title: "STT",
                render: function (data, type, row, meta) {
                    return meta.row + 1;
                }// This contains the row index
            },
            { data: 'user_name', title: 'Tên tài khoản' },
            { data: 'user_id', title: 'Mã nhân viên' },
            { data: 'name_employee', title: 'Tên nhân viên' },
            { data: 'part', title: 'Nhóm' },
            { data: 'position', title: 'Vị trí' },
            { data: 'job', title: 'Công việc' },
            { data: 'status', title: 'Trạng thái' },
            { data: 'registration_time', title: 'Ngày đăng ký' },
            { data: 'last_login', title: 'Đăng nhập lần cuối' },
            {
                title: 'Quản lý',
                targets: -1,
                data: null,
                width: "100px",
                defaultContent: '<button type="button" class="btn btn-primary btn-sm me-1">Sửa</button><button type="button" class="btn btn-danger btn-sm">Xoá</button>',
            }
        ],
        columnDefs: [
            {
                targets: "_all",
                className: "dt-center align-middle",
                defaultContent: ""
            },
            { targets: 0, orderable: false },
            {
                targets: 5,
                createdCell: function (td, cellData, rowData, row, col) {
                    $(td).html(html_groups)
                    $(td).children('select').val(cellData)
                }
            },
            {
                targets: 6,
                createdCell: function (td, cellData, rowData, row, col) {
                    $(td).html(html_position)
                    $(td).children('select').val(cellData)
                }
            },
            {
                targets: 7,
                createdCell: function (td, cellData, rowData, row, col) {
                    $(td).html(html_job)
                    $(td).children('select').val(cellData)
                }
            },
            {
                targets: 8,
                createdCell: function (td, cellData, rowData, row, col) {
                    if (cellData == 1) {
                        $(td).removeClass('text-success text-danger').addClass('text-success')
                        $(td).html('Kích hoạt')
                    }
                    else {
                        $(td).removeClass('text-success text-danger').addClass('text-danger')
                        $(td).html('Chưa kích hoạt')
                    }
                },
                width: "80px"
            }
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
        dom: 'Bfrtip',
        buttons: ['excelHtml5',
            {
                text: 'Sửa',
                idName: 'editAll',
                action: function (e, dt, node, config) {
                    var checkAll = $('#tabAccountList tbody').find('input[type="checkbox"]:checked')
                    modalThongtin = []
                    stt = 'edit'
                    $.each(checkAll, function (key, val) {
                        modalThongtin[key] = tabAccountList.rows($(val).parent()).data()[0]
                    });
                    if (checkAll.length > 0) {
                        $('#modalXacnhan .modal-dialog .modal-content .modal-body p:eq(0)').html('Bạn có muốn <b>Sửa tất cả thông tin</b> cho tài khoản được chọn trong trang này?')
                        $('#modalXacnhan .modal-dialog .modal-content .modal-footer button:eq(1)').html('Sửa thông tin')
                        $('#modalXacnhan .modal-dialog .modal-content .modal-footer button:eq(1)').removeClass('btn-primary btn-danger').addClass('btn-primary')

                        $('#modalXacnhan').modal('show')
                    }
                }
            },
            {
                text: 'Xoá',
                idName: 'delAll',
                action: function (e, dt, node, config) {
                    var checkAll = $('#tabAccountList tbody').find('input[type="checkbox"]:checked')
                    modalThongtin = []
                    stt = 'del'
                    $.each(checkAll, function (key, val) {
                        modalThongtin[key] = tabAccountList.rows($(val).parent()).data()[0]
                    });
                    if (checkAll.length > 0) {
                        $('#modalXacnhan .modal-dialog .modal-content .modal-body p:eq(0)').html('Bạn có muốn <b>Xoá tất cả thông tin</b> cho tài khoản được chọn trong trang này?<br/>')
                        $('#modalXacnhan .modal-dialog .modal-content .modal-footer button:eq(1)').html('Xoá thông tin')
                        $('#modalXacnhan .modal-dialog .modal-content .modal-footer button:eq(1)').removeClass('btn-primary btn-danger').addClass('btn-danger')

                        $('#modalXacnhan').modal('show')
                    }
                }
            }
        ],
        drawCallback: function (settings) {//khi load trang mới thì gọi lại các sự kiện trên từng dòng
            //các sự kiện trong bảng
            //khi ấn vào cột trạng thái
            $('#tabAccountList tbody tr td:nth-child(9)').off('click')
            $('#tabAccountList tbody tr td:nth-child(9)').on('click', function () {
                var data = tabAccountList.cell(this).data();
                if (data == 1) {
                    tabAccountList.cell(this).data(0)
                    $(this).removeClass('text-success text-danger').addClass('text-danger')
                    $(this).html('Chưa kích hoạt')
                }
                else {
                    tabAccountList.cell(this).data(1)
                    $(this).removeClass('text-success text-danger').addClass('text-success')
                    $(this).html('Kích hoạt')
                }
            })
            //khi ấn vào cột vị trí
            $('#tabAccountList tbody tr td:nth-child(6)').off('change')
            $('#tabAccountList tbody tr td:nth-child(6)').on('change', function () {
                slt = $(this).children('select').find(":selected").val()
                tabAccountList.cell(this).data(slt)
                $(this).html(html_groups)
                $(this).children('select').val(slt)
            })

            //khi ấn vào cột vị trí
            $('#tabAccountList tbody tr td:nth-child(7)').off('change')
            $('#tabAccountList tbody tr td:nth-child(7)').on('change', function () {
                slt = $(this).children('select').find(":selected").val()
                tabAccountList.cell(this).data(slt)
                $(this).html(html_position)
                $(this).children('select').val(slt)
            })
            //khi ấn vào cột vị trí
            $('#tabAccountList tbody tr td:nth-child(8)').off('change')
            $('#tabAccountList tbody tr td:nth-child(8)').on('change', function () {
                slt = $(this).children('select').find(":selected").val()
                tabAccountList.cell(this).data(slt)
                $(this).html(html_job)
                $(this).children('select').val(slt)
            })
            //nút sửa
            $('#tabAccountList tbody tr td:nth-child(12) button:nth-child(1)').off('click')
            $('#tabAccountList tbody tr td:nth-child(12) button:nth-child(1)').on('click', function () {
                modalThongtin = []
                stt = 'edit'
                modalThongtin[0] = tabAccountList.rows($(this).parent()).data()[0];
                $('#modalXacnhan .modal-dialog .modal-content .modal-body p:eq(0)').html('Bạn có muốn <b>Sửa thông tin</b> cho tài khoản này?')
                $('#modalXacnhan .modal-dialog .modal-content .modal-footer button:eq(1)').html('Sửa thông tin')
                $('#modalXacnhan .modal-dialog .modal-content .modal-footer button:eq(1)').removeClass('btn-primary btn-danger').addClass('btn-primary')

                $('#modalXacnhan').modal('show')
            })
            //nút xoá
            $('#tabAccountList tbody tr td:nth-child(12) button:nth-child(2)').off('click')
            $('#tabAccountList tbody tr td:nth-child(12) button:nth-child(2)').on('click', function () {
                modalThongtin = []
                stt = 'del'
                modalThongtin[0] = tabAccountList.rows($(this).parent()).data()[0];
                $('#modalXacnhan .modal-dialog .modal-content .modal-body p:eq(0)').html('Bạn có muốn <b>Xoá thông tin</b> cho tài khoản này?<br/>')
                $('#modalXacnhan .modal-dialog .modal-content .modal-footer button:eq(1)').html('Xoá thông tin')
                $('#modalXacnhan .modal-dialog .modal-content .modal-footer button:eq(1)').removeClass('btn-primary btn-danger').addClass('btn-danger')

                $('#modalXacnhan').modal('show')
            })
            //nút check All
            $('#tabAccountList tbody tr td:nth-child(1) input[type="checkbox"]').prop('checked', $('input[name="checkAll"]').is(":checked"))
            $('input[name="checkAll"]').off('change')
            $('input[name="checkAll"]').on('change', function () {

                $('#tabAccountList tbody tr td:nth-child(1) input[type="checkbox"]').prop('checked', $(this).is(":checked"))
            })
            //nút check từng dòng
            $('#tabAccountList tbody tr td:nth-child(1) input[type="checkbox"]').off('change')
            $('#tabAccountList tbody tr td:nth-child(1) input[type="checkbox"]').on('change', function () {

                var totalCou = $(this).parent().parent().parent().find('input[type="checkbox"]').length
                var cou = $(this).parent().parent().parent().find('input[type="checkbox"]:checked').length
                $('input[name="checkAll"]').prop('checked', true)
                if (cou == 0) {
                    $('input[name="checkAll"]').prop('indeterminate', false)
                    $('input[name="checkAll"]').prop('checked', false)
                }
                else if (cou > 0 && cou < totalCou) {
                    $('input[name="checkAll"]').prop('indeterminate', true)
                }
                else if (cou == totalCou) {
                    $('input[name="checkAll"]').prop('indeterminate', false)
                }
            })
        },
        scrollX: true,
        //scrollY: '70vh',
        scrollCollapse: true,
        //paging: false,
        processing: true, // tiền xử lý trước
        //aLengthMenu: [[10, 20, 50, -1], [10, 20, 50, 'All']], // danh sách số trang trên 1 lần hiển thị bảng
        order: [[1, 'asc']] //sắp xếp giảm dần theo cột thứ 1
    });

    loadAcc()
    //modalXacnhan = new bootstrap.Modal($('#modalXacnhan'))
});



$('#modalXacnhan .modal-dialog .modal-content .modal-footer button:eq(1)').on('click', function () {
    $.ajax({
        type: "POST",
        url: "php/acc-admin.php",
        data: { action: 'changeStatus', dtStt: modalThongtin, stt: stt },
        dataType: "text",
        success: function (data) {
            $('input[name="checkAll"]').prop('indeterminate', false)
            $('input[name="checkAll"]').prop('checked', false)
            loadAcc()
        },
        error: function (err) {
            console.error(err)
        }
    });
})