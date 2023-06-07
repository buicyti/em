var header_title = 'EM - Theo dõi Vacuum block Printer';

const load_line = new Promise((resolve, reject) => {
    $.ajax({
        type: "POST",
        url: "php/line.php",
        data: { action: 'line' },
        dataType: "json",
        success: function (data_line) {
            new Tree('.select-line', {
                data: [{ id: 'lineno', text: 'Hansol', children: data_line }],
                closeDepth: 3,
                loaded: function () {
                    this.values = ['lineno'];
                    $('.select-line .treejs ul li ul li').addClass('treejs-node__close');
                },
                onChange: function () {
                    dataLine = this.values;
                    resolve(dataLine);
                }
            })
        }
    });
})

        /* new Tree('.select-line', {
            data: [{ id: 'lineno', text: 'Hansol', children: data1 }],
            closeDepth: 3,
            loaded: function () {
                this.values = ['lineno'];
                $('.select-line .treejs ul li ul li').addClass('treejs-node__close');
            },
            onChange: function () {
                data_line = this.values;
            }
        }) */

function load_line_selected() {
    //console.log(data);
    //$('#THSMD').empty();
    $.ajax({
        type: "POST",
        url: "php/monitors-printer.php",
        dataType: "json",
        data: { line_selected: dataLine },
        //cache: false,
        success: function (data) {
            console.log(data)
            columns = [
                { data: 'STT', title: 'STT', className: 'dt-center' },
                { data: 'Lines', title: 'LINE', className: 'dt-center align-middle' },
                { data: 'Machines', title: 'MACHINE', className: 'dt-center align-middle' },
                { data: 'Model', title: 'MODEL', className: 'dt-center' },
                { data: 'Value', title: 'VACUUM BLOCK', className: 'dt-center' },
                { data: 'CYCLE_TIME_MEAN', title: 'CYCLE TIME MEAN', className: 'dt-center' },
                { data: 'CYCLE_TIME', title: 'CYCLE TIME', className: 'dt-center' },
                { data: 'PCB_TEMP', title: 'PCB TEMP', className: 'dt-center' },
                { data: 'MASK_TEMP', title: 'MASK_TEMP', className: 'dt-center' },
                { data: 'HUMIDITY', title: 'HUMIDITY', className: 'dt-center' },
                { data: 'MASK_VACUUM_SPEED', title: 'MASK VACUUM SPEED', className: 'dt-center' },
                { data: 'VACUUM_FORCE_MAX', title: 'VACUUM FORCE MAX', className: 'dt-center' },
                { data: 'PRINT_FORCE_MIN', title: 'PRINT FORCE MIN', className: 'dt-center' },
                { data: 'PRINT_FORCE_MAX', title: 'PRINT FORCE MAX', className: 'dt-center' },
                { data: 'MASK_PCB_X_DISTANCE', title: 'MASK PCB X DISTANCE', className: 'dt-center' },
                { data: 'MASK_PCB_Y_DISTANCE', title: 'MASK PCB Y DISTANCE', className: 'dt-center' },
                { data: 'MASK_PCB_SHRINKAGE_RATIO', title: 'MASK PCB SHRINKAGE RATIO', className: 'dt-center' },
                { data: 'MASK_PCB_X_DISTANCE_AVG', title: 'MASK PCB X DISTANCE AVG', className: 'dt-center' },
                { data: 'MASK_PCB_Y_DISTANCE_AVG', title: 'MASK PCB Y DISTANCE AVG', className: 'dt-center' },
                { data: 'MASK_PCB_SHRINKAGE_RATIO_AVG', title: 'MASK PCB SHRINKAGE RATIO AVG', className: 'dt-center' }
            ]

            datatable = $('#example').DataTable({
                data: data,
                columns: columns,
                rowsGroup: [1, 2], //gộp dòng
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
            //$('#THSMD').html(data);
        },
        error: function (xhr, status, error) {
            console.error(xhr);
        }
    });
};

var timereload = 10 * 60 * 1000;
var setreload;
var setAlertify;
$('#btn-Xac-nhan').on('click',async function () {
    await load_line;
    clearInterval(setreload);
    //console.log(timereload);
    setreload = setInterval(function () {
        timereload = $('input[name="time_st_reload"]').val() * 60 * 1000;
        datatable.destroy()
        load_line_selected()
    }, timereload);
    datatable.destroy()
    load_line_selected();
});
$(document).ready(async function() {
    await load_line;
    load_line_selected()
    setreload = setInterval(() => {
        timereload = $('input[name="time_st_reload"]').val() * 60 * 1000;
        datatable.destroy()
        load_line_selected()
    }, timereload);
});