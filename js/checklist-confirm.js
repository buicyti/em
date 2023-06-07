var header_title = 'EM - Checklist Strap';
var editor  //biến chỉnh sửa
var tabDanhsach


$(document).ready(function () {
    modalNhanvien = new bootstrap.Modal($('#modalNhanvien'))
    load_data()
    load_absent()
});
/* 
let tree1 = new Tree('.select-group', {
    data: [{ id: 'All', text: 'All', children: [{ id: 'SMD1', text: 'SMD1' }, { id: 'SMD2', text: 'SMD2' }] }],
    closeDepth: 3,
    loaded: function() {
        this.values = ['All'];
    },
    onChange: function() {
        data_select_group = this.values;
    }
});



let tree3 = new Tree('.select-shift', {
    data: [{ id: 'Common', text: 'Common' },
        { id: '2Shift2 A', text: '2Shift2 A' },
        { id: '2Shift2 B', text: '2Shift2 B' },
        { id: '3Shift2 A', text: '3Shift2 A' },
        { id: '3Shift2 B', text: '3Shift2 B' },
        { id: '3Shift2 C', text: '3Shift2 C' }
    ],
    closeDepth: 3,
    loaded: function() {
        this.values = ['Common', '2Shift2 A', '2Shift2 B', '3Shift2 A', '3Shift2 B', '3Shift2 C'];
    },
    onChange: function() {
        data_select_shift = this.values;
    }
}); */

function load_data() {

    $.ajax({
        type: "post",
        url: "php/checklist-confirm.php",
        data: { data_select: 'dsnv' },
        dataType: "json",
        success: function (data) {

            $('#danhsach').append('<tfoot><tr><th>STT</th><th>Mã Nhân viên</th><th>Tên Nhân viên</th><th>Nhóm</th><th>Ca/Kíp</th><th>Dép</th><th>Wrist</th></tr></tfoot>');
            $('#danhsach tfoot th').each(function () {
                var title = $(this).text();
                $(this).html('<input type="text" class="form-control" placeholder="' + title + '" />');
            });

            tabDanhsach = $('#danhsach').DataTable({
                //dom: "Bfrtip",
                data: data,
                columns: [{
                    title: "STT",
                    render: function (data, type, row, meta) {
                        return meta.row + 1;
                    }// This contains the row index
                },
                //{data: 'stt', title: 'STT', className: "dt-center"},
                { data: 'id_employee', title: 'Mã', className: "dt-center" },
                { data: 'name_employee', title: 'Tên nhân viên', className: "dt-center", width: "200px" },
                { data: 'nhom', title: 'Nhóm', className: "dt-center" },
                { data: 'ca_kip', title: 'Ca', className: "dt-center", width: "80px" },
                { data: 'shoe', title: 'Dép', className: "dt-center", width: "30px" },
                { data: 'wrist', title: 'Strap', className: "dt-center", width: "30px" },

                    /* {
                        data: 'shoe',
                        title: 'Dép',
                        render: function ( data, type, row ) {
                            if ( type === 'display' ) {
                                return '<input type="checkbox" class="shoe">';
                            }
                            return data;
                        }
                    },
                    {
                        data: 'wrist',
                        title: 'Strap',
                        render: function ( data, type, row ) {
                            if ( type === 'display' ) {
                                return '<input type="checkbox" class="wrist">';
                            }
                            return data;
                        }
                    } */
                ],/* 
                columnDefs: [
                    {
                        className: 'dt-center'
                    }
                  ],  */
                rowCallback: function (row, data) {
                    // Set the checked state of the checkbox in the table
                    /* $('input.shoe', row).prop( 'checked', data.shoe == "Y" );
                    $('input.wrist', row).prop( 'checked', data.wrist == "Y" ); */
                    if (data.shoe == "Y") {
                        $('td:eq(5)', row).html('<b class="text-success">Y</b>');
                    }
                    else if (data.shoe == "N") {
                        $('td:eq(5)', row).html('<b class="text-danger">N</b>');
                    }
                    if (data.wrist == "Y") {
                        $('td:eq(6)', row).html('<b class="text-success">Y</b>');
                    }
                    else if (data.wrist == "N") {
                        $('td:eq(6)', row).html('<b class="text-danger">N</b>');
                    }
                },
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
                initComplete: function () {
                    // Apply the search
                    this.api()
                        .columns()
                        .every(function () {
                            var that = this;

                            $('input', this.footer()).on('keyup change clear', function () {
                                if (that.search() !== this.value) {
                                    that.search(this.value).draw();
                                }
                            });
                        });
                },
                processing: true, // tiền xử lý trước
                aLengthMenu: [[10, 20, 50], [10, 20, 50]], // danh sách số trang trên 1 lần hiển thị bảng
                order: [[0, 'asc']] //sắp xếp giảm dần theo cột thứ 1
            })


            //sự kiện click lấy dữ liệu theo hàng
            $('#danhsach tbody').on('click', 'tr', function () {
                var data = tabDanhsach.row(this).data()
                //console.log(data)
                $('#modalNhanvien .modal-dialog .modal-content .modal-body .container-fluid .row:eq(0) .col-8').html(data['id_employee'])
                $('#modalNhanvien .modal-dialog .modal-content .modal-body .container-fluid .row:eq(1) .col-8').html(data['name_employee'])
                $('#modalNhanvien .modal-dialog .modal-content .modal-body .container-fluid .row:eq(2) .col-8').html(data['nhom'])
                $('#modalNhanvien .modal-dialog .modal-content .modal-body .container-fluid .row:eq(3) .col-8').html(data['ca_kip'])
                //$('#wristCheck').prop("checked", true )
                $('#shoeCheck').prop('checked', data.shoe == "Y")
                $('#wristCheck').prop('checked', data.wrist == "Y")
                modalNhanvien.show()
            })

        },
        error: function (xhr, status, error) {
            console.error(xhr);
        }
    });


}


function load_absent() {
    $.ajax({
        type: "POST",
        url: "php/checklist-confirm.php",
        data: { data_select: 'list_absent' },
        dataType: "json",
        success: function (response) {
            //console.log(response)
            tabAbsent = $('#tababsent').DataTable({
                data: response,
                columns: [
                    //{title: "STT", render: function (data, type, row, meta) {return meta.row + 1;}},
                    { data: 'emp_id', title: 'Mã NV' },
                    { data: 'emp_name', title: 'Tên NV' },
                    { data: 'nhom', title: 'Nhóm' },
                    { data: 'ca', title: 'Ca' },
                    { data: 'che_do', title: 'Chế độ' }
                ]
            })
        },
        error: function (xhr, status, error) {
            console.error(xhr);
        }
    });
}
//khi ấn nút thêm trên modal
$('#modalNhanvien .modal-dialog .modal-content .modal-body .btn-primary').on('click', function () {
    $('#modalNhanvien .modal-dialog .modal-content .modal-body .container-fluid .row:eq(0) .col-8').html('<input type="text" class="form-control">')
    $('#modalNhanvien .modal-dialog .modal-content .modal-body .container-fluid .row:eq(1) .col-8').html('<input type="text" class="form-control">')
    var nhom = '<select class="form-select">' +
        '<option>Mgt</option>' +
        '<option>MM</option>' +
        '<option>MM2</option>' +
        '<option>PRD</option>' +
        '<option>PRD2</option>' +
        '<option>EQ</option>' +
        '<option>EQ2</option>' +
        '<option>PQC</option>' +
        '<option>PQC2</option>' +
        '<option>3M</option>' +
        '</select>'
    $('#modalNhanvien .modal-dialog .modal-content .modal-body .container-fluid .row:eq(2) .col-8').html(nhom)
    var ca = '<select class="form-select">' +
        '<option>Common</option>' +
        '<option>2Shift2 A</option>' +
        '<option>2Shift2 B</option>' +
        '<option>3Shift2 A</option>' +
        '<option>3Shift2 B</option>' +
        '<option>3Shift2 C</option>' +
        '</select>'
    $('#modalNhanvien .modal-dialog .modal-content .modal-body .container-fluid .row:eq(3) .col-8').html(ca)
})

//khi ấn nút sửa trên modal
$('#modalNhanvien .modal-dialog .modal-content .modal-body .btn-info').on('click', function () {
    var nhom = '<select class="form-select">' +
        '<option value="Mgt">Mgt</option>' +
        '<option value="MM">MM</option>' +
        '<option value="MM2">MM2</option>' +
        '<option value="PRD">PRD</option>' +
        '<option value="PRD2">PRD2</option>' +
        '<option value="EQ">EQ</option>' +
        '<option value="EQ2">EQ2</option>' +
        '<option value="PQC">PQC</option>' +
        '<option value="PQC2">PQC2</option>' +
        '<option value="3M">3M</option>' +
        '</select>'
    var valnhom = $('#modalNhanvien .modal-dialog .modal-content .modal-body .container-fluid .row:eq(2) .col-8').text()
    $('#modalNhanvien .modal-dialog .modal-content .modal-body .container-fluid .row:eq(2) .col-8').html(nhom)
    $('#modalNhanvien .modal-dialog .modal-content .modal-body .container-fluid .row:eq(2) .col-8 option[value="' + valnhom + '"]').attr('selected', 'selected');
    var ca = '<select class="form-select">' +
        '<option value="">Common</option>' +
        '<option value="2Shift2 A">2Shift2 A</option>' +
        '<option value="2Shift2 B">2Shift2 B</option>' +
        '<option value="3Shift2 A">3Shift2 A</option>' +
        '<option value="3Shift2 B">3Shift2 B</option>' +
        '<option value="3Shift2 C">3Shift2 C</option>' +
        '</select>'

    var valca = $('#modalNhanvien .modal-dialog .modal-content .modal-body .container-fluid .row:eq(3) .col-8').text()
    $('#modalNhanvien .modal-dialog .modal-content .modal-body .container-fluid .row:eq(3) .col-8').html(ca)
    $('#modalNhanvien .modal-dialog .modal-content .modal-body .container-fluid .row:eq(3) .col-8 option[value="' + valca + '"]').attr('selected', 'selected');

})


function load_alert(id_html, _alert, _text) {
    $('.' + id_html).css('display', 'block');//hiện ra thông báo
    $('.' + id_html).removeClass('alert alert-success alert-danger').addClass('alert alert-' + _alert);
    $('.' + id_html).text(_text);
}

function add_employee_absent(data) {

}

/* Xuất danh sách nhân viên sang Excel*/
/* $('#ex-to-Excel-list-emp').on('click', function() {
    $("#loading").show(); //tạo 1 class phủ không cho thao tác
    $('#text-wait').html('Vui lòng chờ');
    $.ajax({
        type: "POST",
        url: "php/checklist-confirm.php",
        data: { phpOffice: 'export_DSNV', group_selected: data_select_group, part_selected: data_select_part, shift_selected: data_select_shift },
        success: function(response) {
            $("#loading").hide(); // ẩn lớp khi tải xong
            console.log(response)
            window.location = "php/" + response;
        },
        error: function() {
            $("#loading").hide(); // ẩn lớp khi lỗi
        }
    });
}); */


$('#Upload-DSNV').on('click', function () {
    if ($('#file').get(0).files.length === 0) return//kiểm tra nếu chưa chọn file thì dừng lại
    //Lấy ra files
    var file_data = $('#file').prop('files')[0];
    //lấy ra kiểu file
    var type = file_data.type;
    //Xét kiểu file được upload
    var match = ["application/vnd.openxmlformats-officedocument.spreadsheetml.sheet",
        "application/vnd.ms-excel.sheet.macroEnabled.12",
        "application/vnd.ms-excel"
    ];
    //kiểm tra kiểu file
    if (type == match[0] || type == match[1] || type == match[2]) {
        //khởi tạo đối tượng form data
        var form_data = new FormData();
        //thêm files vào trong form data
        form_data.append('file', file_data);
        form_data.append('phpOffice', 'import_DSNV')
        //sử dụng ajax post
        $.ajax({
            url: 'php/checklist-confirm.php',
            dataType: 'json',
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,
            type: 'post',
            success: function (res) {
                load_alert('status', res['alert'][0], res['alert'][1])
                $('#file').val('');
                tabDanhsach.clear().rows.add(res['data']).draw()
            },
            error: function (xhr, status, error) {
                console.error(xhr);
            }
        });
    } else {
        load_alert('status', 'danger', 'Chỉ được upload file Excel')
        $('#file').val('');
    }
    return false;
});

$('#btnabsent').on('click', function () {
    if ($('#file1').get(0).files.length !== 0) {
        //Lấy ra files
        var file_data = $('#file1').prop('files')[0];
        //lấy ra kiểu file
        var type = file_data.type;
        //console.log(type);
        //Xét kiểu file được upload
        var match = ["application/vnd.openxmlformats-officedocument.spreadsheetml.sheet",
            "application/vnd.ms-excel.sheet.macroEnabled.12",
            "application/vnd.ms-excel"
        ];
        //kiểm tra kiểu file
        if (type == match[0] || type == match[1] || type == match[2]) {
            //khởi tạo đối tượng form data
            var form_data = new FormData();
            //thêm files vào trong form data
            form_data.append('file', file_data);
            form_data.append('phpOffice', 'import_absent')
            //sử dụng ajax post
            $.ajax({
                url: 'php/checklist-confirm.php',
                dataType: 'json',
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                type: 'post',
                success: function (res) {
                    load_alert('status1', res[0], res[1])
                    $('#file1').val('');
                },
                error: function (xhr, status, error) {
                    console.error(xhr);
                }
            });
        } else {
            load_alert('status1', 'danger', 'Chỉ được upload file Excel')
            $('#file1').val('');
        }
    }

    if ($('#floatingTextarea2').val() !== "") {
        //console.log($('#floatingTextarea2').val())
        /* data_absent = $('#floatingTextarea2').val().split(/\r?\n/)
        $.each(data_absent, function (key, val) {
            data_absent[key] = val.split(/\t/)
        }); */
        $.ajax({
            type: "POST",
            url: "php/checklist-confirm.php",
            data: { data_select: 'add_data_absent', data: $('#floatingTextarea2').val() },
            dataType: "json",
            success: function (response) {
                load_alert('status1', response[0], response[1])
            },
            error: function (xhr, status, error) {
                console.error(xhr);
            }
        });
    }

});

