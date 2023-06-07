var header_title = 'EM - Machine Assets';

$('#import_excel').on('click', function () {
    $('#form_import').removeClass('hidden');
});

$('#upload').on('click', function () {
    //Lấy ra files
    var file_data = $('#file').prop('files')[0];
    //lấy ra kiểu file
    var type = file_data.type;
    //console.log(type);
    //Xét kiểu file được upload
    var match = ["application/vnd.openxmlformats-officedocument.spreadsheetml.sheet",
                "application/vnd.ms-excel.sheet.macroEnabled.12",
                "application/vnd.ms-excel"];
    //kiểm tra kiểu file
    if (type == match[0] || type == match[1] || type == match[2]) {
        //khởi tạo đối tượng form data
        var form_data = new FormData();
        //thêm files vào trong form data
        form_data.append('file', file_data);
        //sử dụng ajax post
        $.ajax({
            url: 'php/machines-assets.php', // gửi đến file upload.php 
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
            }
        });
    } else {
        $('.status').text('Chỉ được upload file Excel');
        $('#file').val('');
    }
    return false;
});




$(document).ready(function(){
    $.ajax({
        type: "post",
        url: "php/machines-assets.php",
        data: {load: 'data'},
        dataType: 'text',
        success: function (data) {
            $('#tblAsset').html(data);
            $('#example').dataTable({
                "language": {
                "sProcessing":   "Đang xử lý...",
                "sLengthMenu":   "Xem _MENU_ mục",
                "sZeroRecords":  "Không tìm thấy dòng nào phù hợp",
                "sInfo":         "Đang xem _START_ đến _END_ trong tổng số _TOTAL_ mục",
                "sInfoEmpty":    "Đang xem 0 đến 0 trong tổng số 0 mục",
                "sInfoFiltered": "(được lọc từ _MAX_ mục)",
                "sInfoPostFix":  "",
                "sSearch":       "Tìm:",
                "sUrl":          "",
                "oPaginate": {
                    "sFirst":    "Đầu",
                    "sPrevious": "Trước",
                    "sNext":     "Tiếp",
                    "sLast":     "Cuối"
                    }
                },
                "processing": true, // tiền xử lý trước
                "aLengthMenu": [[10, 20, 50], [10, 20, 50]], // danh sách số trang trên 1 lần hiển thị bảng
                "order": [[ 1, 'desc' ]] //sắp xếp giảm dần theo cột thứ 1
            });
        },
        error: function(xhr, status, error) {
            console.error(xhr);
        }
    });
});