header_title = 'EM - Tập tin';
$('#uploadFile').on('click', function (e) {
    e.preventDefault();

    $('.status').empty()
    var formData = new FormData();
    var totalSize = 0;
    // Read selected files
    var totalfiles = $('#fileUpload').get(0).files.length;
    if (totalfiles > 20) {
        $('.status').append('<div class="alert alert-danger">Tổng số File không được quá 20!</div>');
        return;
    }
    for (var i = 0; i < totalfiles; i++) {
        formData.append("fileUpload[]", $('#fileUpload').get(0).files[i]);
        if ($('#fileUpload').get(0).files[i].size >= 104857600) $('.status').append('<div class="alert alert-danger">Kích thước File <b>' + $('#fileUpload').get(0).files[i].name + '</b> quá 100Mb!</div>');
        totalSize += $('#fileUpload').get(0).files[i].size
    }
    formData.append("action", "uploadFile");

    if (totalSize >= 104857600) {
        $('.status').append('<div class="alert alert-danger">Tổng kích thước các File quá 100Mb!</div>');
        return;
    }
    $('.box-progress-bar').removeClass('hidden');
    $('.progress-bar').width('0%');
    $.ajax({
        url: 'php/file.php',
        type: 'POST',
        xhr: function () {
            var myXhr = $.ajaxSettings.xhr();
            if (myXhr.upload) {
                myXhr.upload.addEventListener('progress', function (event) {
                    var percent = 0;
                    if (event.lengthComputable) {
                        percent = Math.ceil(event.loaded / event.total * 100);
                    }
                    $('.progress-bar').animate({ width: percent + '%' });
                    $('.progress-bar').html(percent + '%');
                }, false);
            }
            return myXhr;
        },
        success: function (data) {
            loadFileList()
            $('.status').html(data)
        },
        data: formData,
        cache: false,
        contentType: false,
        processData: false
    });
    return false;
})
function loadFileList() {
    $.ajax({
        type: "POST",
        url: "php/file.php",
        data: { action: 'loadFileList' },
        dataType: "json",
        success: function (data) {
            tabFileList.clear().rows.add(data).draw();
        }
    });
}
$(document).ready(function () {
    //lấy tên miền
    $.ajax({
        type: "POST",
        url: "php/file.php",
        data: { action: 'loadDomain' },
        dataType: "text",
        success: function (data) {
            $_DOMAIN = $.trim(data)
        }
    });
    //tạo bảng
    tabFileList = $('#tabFile').DataTable({
        columns: [
            {
                title: '<input class="form-check-input" name="checkAll" type="checkbox" value="">',
                render: function () {
                    return '<input class="form-check-input" type="checkbox">'
                }
            },
            {
                title: "STT",
                render: function (data, type, row, meta) {
                    return meta.row + 1;
                }// This contains the row index
            },
            { data: 'slug_file', title: 'Tên File' },
            { data: 'type_file', title: 'Định dạng' },
            { data: 'size_file', title: 'Kích thước' },
            { data: 'status_file', title: 'Tình trạng' },
            { data: 'date_upload', title: 'Thời gian tải lên' },
            { data: 'employee_up', title: 'Người tải lên' },
            {
                title: 'Quản lý',
                targets: -1,
                data: null,
                width: "70px",
                defaultContent: '<i class="bi bi-trash btn btn-sm btn-danger"></i>',
            }
        ],
        columnDefs: [
            {
                targets: "_all",
                className: "dt-center align-middle",
                defaultContent: ""
            },{ 
                targets: 0, 
                orderable: false 
            }
        ],
        drawCallback: function (settings) {
            //console.log(settings)
            $('#tabFile tbody tr td:nth-child(2),td:nth-child(3),td:nth-child(4),td:nth-child(5),td:nth-child(6),td:nth-child(7),td:nth-child(8)').off('click').on('click', function () {
                var d = tabFileList.row(this).data();
                $('#modalFileShow .modal-dialog .modal-content .modal-body .container .row .col-6:eq(0) ul li:eq(0) span').html(d.slug_file)
                $('#modalFileShow .modal-dialog .modal-content .modal-body .container .row .col-6:eq(0) ul li:eq(1) span').html(d.type_file)
                $('#modalFileShow .modal-dialog .modal-content .modal-body .container .row .col-6:eq(0) ul li:eq(2) span').html(d.size_file)
                $('#modalFileShow .modal-dialog .modal-content .modal-body .container .row .col-6:eq(0) ul a').attr('href', $_DOMAIN + d.url_file)
                $('#modalFileShow .modal-dialog .modal-content .modal-body .container .row .col-6:eq(1) ul li:eq(0) input').val($_DOMAIN + d.url_file)
                $('#modalFileShow .modal-dialog .modal-content .modal-body .container .row .col-6:eq(1) ul li:eq(1) input').val('<a href="' + $_DOMAIN + d.url_file + '">' + d.slug_file + '</a>')
                $('#modalFileShow').modal('show')
            })
            //nút xoá
            $('#tabFile tbody tr td:nth-child(9) i').off('click').on('click', function () {
                file_info = tabFileList.rows($(this).parent()).data()[0];
                
                $('#modalXacnhan .modal-dialog .modal-content .modal-body p:eq(0)').html('Bạn có muốn <b>Xoá thông tin</b> của File này?<br/>')
                $('#modalXacnhan .modal-dialog .modal-content .modal-footer button:eq(1)').html('Xoá thông tin')
                $('#modalXacnhan .modal-dialog .modal-content .modal-footer button:eq(1)').removeClass('btn-primary btn-danger').addClass('btn-danger')
                $('#modalXacnhan .modal-dialog .modal-content .modal-footer button:eq(1)').off('click').on('click', function () {
                    $.ajax({
                        type: "POST",
                        url: "php/file.php",
                        data: { action: 'delFile', file_info: file_info },
                        dataType: "text",
                        success: function (data) {
                           loadFileList()
                        },
                        error: function (err) {
                            console.error(err)
                        }
                    });
                })
                $('#modalXacnhan').modal('show')
            })

            //nút check All
            $('#tabFile tbody tr td:nth-child(1) input[type="checkbox"]').prop('checked', $('input[name="checkAll"]').is(":checked"))
            $('input[name="checkAll"]').off('change').on('change', function () {

                $('#tabFile tbody tr td:nth-child(1) input[type="checkbox"]').prop('checked', $(this).is(":checked"))
            })
            //nút check từng dòng
            $('#tabFile tbody tr td:nth-child(1) input[type="checkbox"]').off('change').on('change', function () {

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
        dom: 'Bfrtip',
        buttons: [
            {
                text: 'Xoá',
                idName: 'delAll',
                action: function (e, dt, node, config) {
                    var checkAll = $('#tabFile tbody').find('input[type="checkbox"]:checked')
                    modalThongtin = []
                    $.each(checkAll, function (key, val) {
                        modalThongtin[key] = tabFileList.rows($(val).parent()).data()[0]
                    });
                    if (checkAll.length > 0) {
                        $('#modalXacnhan .modal-dialog .modal-content .modal-body p:eq(0)').html('Bạn có muốn <b>Xoá tất cả thông tin</b> của File được chọn trong trang này?<br/>')
                        $('#modalXacnhan .modal-dialog .modal-content .modal-footer button:eq(1)').html('Xoá thông tin')
                        $('#modalXacnhan .modal-dialog .modal-content .modal-footer button:eq(1)').removeClass('btn-primary btn-danger').addClass('btn-danger')
                        $('#modalXacnhan .modal-dialog .modal-content .modal-footer button:eq(1)').off('click').on('click', function () {
                            $.ajax({
                                type: "POST",
                                url: "php/file.php",
                                data: { action: 'delAllFile', file_info: modalThongtin },
                                dataType: "text",
                                success: function (data) {
                                   loadFileList()
                                },
                                error: function (err) {
                                    console.error(err)
                                }
                            });
                        })
                        $('#modalXacnhan').modal('show')
                    }
                }
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
        //scrollX: true,
        //scrollY: '70vh',
        //scrollCollapse: true,
        //paging: false,
        processing: true, // tiền xử lý trước
        aLengthMenu: [[10, 20, 50, -1], [10, 20, 50, 'All']], // danh sách số trang trên 1 lần hiển thị bảng
        order: [[1, 'asc']] //sắp xếp giảm dần theo cột thứ 1
    })

    loadFileList()
});
