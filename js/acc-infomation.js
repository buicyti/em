var header_title = 'EM - Danh sách nhân viên SMD';
var part_val = [''];
var part_dis = [''];
var data_select_part = [''];
var data_select_shift = [''];
var table;
$(document).ready(function () {
    //load_permission();
    load_data();
});


/* 
let tree1 = new Tree('.select-group', {
    data: [{ id: 'All', text: 'All', children: [{ id: 'SMD1', text: 'SMD1' }, { id: 'SMD2', text: 'SMD2' }] }],
    closeDepth: 3,
    loaded: function () {
        this.values = ['All'];
    },
    onChange: function () {
        data_select_group = this.values;
    }
});



let tree3 = new Tree('.select-shift', {
    data: [{ id: 'Common', text: 'Common' }, { id: '2Shift2 A', text: '2Shift2 A' }, { id: '2Shift2 B', text: '2Shift2 B' }, { id: '3Shift2 A', text: '3Shift2 A' }, { id: '3Shift2 B', text: '3Shift2 B' }, { id: '3Shift2 C', text: '3Shift2 C' }],
    closeDepth: 3,
    loaded: function () {
        this.values = ['Common', '2Shift2 A', '2Shift2 B', '3Shift2 A', '3Shift2 B', '3Shift2 C'];
    },
    onChange: function () {
        data_select_shift = this.values;
    }
});



function load_permission() {
    $.ajax({
        type: "post",
        url: "php/checklist-view.php",
        data: { load_permission: "quyen" },
        dataType: "json",
        success: function (result) {
            $.each(result, function (key, item) {
                part_val = item["val"];
                part_dis = item["dis"];
            });

            let tree2 = new Tree('.select-part', {
                data: [{ id: 'Audit', text: 'Audit' }, { id: 'EQ', text: 'EQ' }, { id: 'Mgt', text: 'MGT' }, { id: 'MM', text: 'MM' }, { id: 'PQC', text: 'PQC' }, { id: '3M', text: 'PRO-3M' }, { id: 'PRD', text: 'PROD' }],
                closeDepth: 3,
                loaded: function () {
                    //this.values = ['Audit','EQ','Mgt','MM','PQC','3M','PRD'];
                    this.values = part_val;
                    this.disables = part_dis;
                },
                onChange: function () {
                    data_select_part = this.values;
                }
            });

            //load_data(); //load danh sách nhân viên trong nhóm
        },
        error: function (xhr, status, error) {
            console.error(xhr);
        }
    });
} */

function load_data() {
    $.ajax({
        type: "post",
        url: "php/acc-infomation.php",
        data: { data_select: 'dsnv' },
        dataType: "json",
        success: function (data) {
            //console.log(data)
            columns = []
            tfoot = ""
            columnNames = Object.keys(data[0])
            colTitle = ['STT', 'Mã nhân viên', 'Tên nhân viên', 'Giới tính', 'Ngày vào', 'Khối', 'Vị trí', 'Cấp bậc', 'Chức danh', 'Nhóm', 'Ca / Kíp', 'Công việc', 'Ngày sinh',
                'Số điện thoại 1', 'Số điện thoại 2', 'HKTT (Thôn)', 'HKTT (Xã)', 'HKTT (Huyện)', 'HKTT (Tỉnh)', 'TT (Thôn)', 'TT (Xã)', 'TT (Huyện)', 'TT (Tỉnh)',
                'CMT/CCCD', 'Trường', 'Chuyên ngành', 'Năm tốt nghiệp', 'Tuyến xe', 'Điểm đón', 'Ảnh đại diện', 'Trạng thái']

            for (var i in columnNames) {
                columns.push({ data: columnNames[i], title: colTitle[i] })
                tfoot += '<th>"' + colTitle[i] + '"</th>'
            }
            $('#example tfoot tr').append(tfoot)

            table = $('#example').DataTable({
                data: data,
                columns: columns,
                columnDefs: [
                    {
                        "targets": "_all",
                        "className": "dt-center"
                    },{
                        "targets": [7, 29, 30],
                        "visible": false
                    },{
                        "targets": [0, 3],
                        "width": "50px"
                    },{
                        "targets": [1, 11],
                        "width": "120px"
                    },{
                        "targets": [2],
                        "width": "200px"
                    },{
                        "targets": [24],
                        "width": "400px"
                    },{
                        "targets": [25, 28],
                        "width": "300px"
                    },{
                        "targets": "_all",
                        "width": "100px"
                    }
                ],
                fixedColumns:   {
                        left: 3
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
                },//tìm kiếm
                initComplete: function () {
                    this.api()
                        .columns()
                        .every(function () {
                            var column = this;
                            var select = $('<select class="form-select"><option value=""></option></select>')
                                .appendTo($(column.footer()).empty())
                                .on('change', function () {
                                    var val = $.fn.dataTable.util.escapeRegex($(this).val());
         
                                    column.search(val ? '^' + val + '$' : '', true, false).draw();
                                });
         
                            column
                                .data()
                                .unique()
                                .sort()
                                .each(function (d, j) {
                                    select.append('<option value="' + d + '">' + d + '</option>');
                                });
                        });
                },
                dom: 'Bfrtip',
                scrollX: true,
                processing: true, // tiền xử lý trước
                aLengthMenu: [[10, 20, 50, -1], [10, 20, 50, 'All']], // danh sách số trang trên 1 lần hiển thị bảng
                order: [[0, 'asc']] //sắp xếp giảm dần theo cột thứ 1
            });


            $('#example tbody').on('click', 'tr', function () {
                var data = table.row(this).data()
                $('#show_modal').html('<div class="container-fluid"><div class="main-body"><div class="row gutters-sm"><div class="col-md-4 mb-3">' +
                    '<div class="card"><div class="card-body"><div class="d-flex flex-column align-items-center text-center">' +
                    '<img src="assets/images/avatars/' + data['anh_dai_dien'] + '" alt="' + data['name_employee'] + '" class="rounded-circle anh_dai_dien" id="avatar' + data['id_employee'] + '">' +
                    '<div class="mt-3">' +
                    '<h4>' + data['name_employee'] + '</h4>' +
                    '<p class="text-secondary mb-1">' + data['id_employee'] + '</p>' +
                    '<p class="text-muted font-size-sm">' + data['chuc_danh'] + '</p>' +
                    '<!--button class="btn btn-primary">Follow</button>' +
                    '<button class="btn btn-outline-primary">Message</button-->' +
                    '</div></div></div></div></div>' +

                    '<div class="col-md-8 overflow-auto" style="height: 500px"><div class="card mb-3"><div class="card-body">' +
                    '<div class="row"><div class="col-sm-3"><h6 class="mb-0">Tên nhân viên</h6></div><div class="col-sm-9 text-secondary">' + data['name_employee'] + '</div></div><hr>' +
                    '<div class="row"><div class="col-sm-3"><h6 class="mb-0">Ngày sinh</h6></div><div class="col-sm-9 text-secondary">' + data['ngay_sinh'] + '</div></div><hr>' +
                    '<div class="row"><div class="col-sm-3"><h6 class="mb-0">Khối làm việc</h6></div><div class="col-sm-9 text-secondary">' + data['khoi'] + '</div></div><hr>' +
                    '<div class="row"><div class="col-sm-3"><h6 class="mb-0">Vị trí</h6></div><div class="col-sm-9 text-secondary">' + data['vi_tri'] + '</div></div><hr>' +
                    '<div class="row"><div class="col-sm-3"><h6 class="mb-0">Bậc lương</h6></div><div class="col-sm-9 text-secondary">' + data['cap_bac'] + '</div></div><hr>' +
                    '<div class="row"><div class="col-sm-3"><h6 class="mb-0">Chức danh</h6></div><div class="col-sm-9 text-secondary">' + data['chuc_danh'] + '</div></div><hr>' +
                    '<div class="row"><div class="col-sm-3"><h6 class="mb-0">Nhóm</h6></div><div class="col-sm-9 text-secondary">' + data['nhom'] + '</div></div><hr>' +
                    '<div class="row"><div class="col-sm-3"><h6 class="mb-0">Ca / Kíp</h6></div><div class="col-sm-9 text-secondary">' + data['ca_kip'] + '</div></div><hr>' +
                    '<div class="row"><div class="col-sm-3"><h6 class="mb-0">Công việc</h6></div><div class="col-sm-9 text-secondary">' + data['cong_viec'] + '</div></div><hr>' +
                    '<div class="row"><div class="col-sm-3"><h6 class="mb-0">Số điện thoại (Cá nhân)</h6></div><div class="col-sm-9 text-secondary">' + data['sdt1'] + '</div></div><hr>' +
                    '<div class="row"><div class="col-sm-3"><h6 class="mb-0">Số điện thoại (Người thân)</h6></div><div class="col-sm-9 text-secondary">' + data['sdt2'] + '</div></div><hr>' +
                    '<div class="row"><div class="col-sm-3"><h6 class="mb-0">Địa chỉ (Hộ khẩu thường trú)</h6></div><div class="col-sm-9 text-secondary">' + data['hktt_thon'] + ' - ' + data['hktt_xa'] + ' - ' + data['hktt_huyen'] + ' - ' + data['hktt_tinh'] + '</div></div><hr>' +
                    '<div class="row"><div class="col-sm-3"><h6 class="mb-0">Địa chỉ (Địa chỉ tạm trú)</h6></div><div class="col-sm-9 text-secondary">' + data['ht_thon'] + ' - ' + data['hktt_xa'] + ' - ' + data['ht_huyen'] + ' - ' + data['ht_tinh'] + '</div></div><hr>' +
                    '<div class="row"><div class="col-sm-3"><h6 class="mb-0">Trường (cấp cao nhât)</h6></div><div class="col-sm-9 text-secondary">' + data['truong'] + '</div></div><hr>' +
                    '<div class="row"><div class="col-sm-3"><h6 class="mb-0">Chuyên ngành</h6></div><div class="col-sm-9 text-secondary">' + data['chuyen_nganh'] + '</div></div><hr>' +
                    '<div class="row"><div class="col-sm-3"><h6 class="mb-0">Tuyến xe</h6></div><div class="col-sm-9 text-secondary">' + data['tuyen_xe'] + '</div></div><hr>' +
                    '<div class="row"><div class="col-sm-3"><h6 class="mb-0">Điểm đón</h6></div><div class="col-sm-9 text-secondary">' + data['diem_don'] + '</div></div>' +
                    '</div></div></div></div></div></div>')
                new bootstrap.Modal(document.getElementById('modalThongtin')).show()

                var modal = document.getElementById("myModal");

                // Get the image and insert it inside the modal - use its "alt" text as a caption
                var img = document.getElementById('avatar' + data['id_employee']);
                var modalImg = document.getElementById("avatar");
                img.onclick = function () {
                    modal.style.display = "block";
                    modalImg.src = this.src;
                }
                // Get the <span> element that closes the modal
                var span = document.getElementsByClassName("close")[0];
                // When the user clicks on <span> (x), close the modal
                span.onclick = function () {
                    modal.style.display = "none";
                }
            });

        },
        error: function (xhr, status, error) {
            console.error(xhr);
        }
    })
}

$('#Upload-DSNV').on('click', function () {
    //Lấy ra files
    var file_data = $('#file').prop('files')[0];
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
        form_data.append('phpOffice', 'import_DSNV')
        
        //sử dụng ajax post
        $.ajax({
            url: 'php/acc-infomation.php',
            dataType: 'text',
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,
            type: 'post',
            success: function (res) {
                $('.status').css('display', 'block');
                $('.status').text(res);
                $('#file').val('');
                //load_data();
            }
        });
    } else {
        $('.status').text('Chỉ được upload file Excel');
        $('#file').val('');
    }
    return false;
});