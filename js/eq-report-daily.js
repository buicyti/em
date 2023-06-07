var header_title = 'EM - Báo cáo hàng ngày'
//tải danh sách line
let tree = new Tree('.select-line', {
    data: [{ id: 'lineno', text: 'Hansol', children: data1 }],
    closeDepth: 3,
    loaded: function () {
        this.values = ['Khu1', 'Khu2', 'Khu3', 'Khu4', 'Khu5'];
        //this.disables = ['Khu2', 'Khu3', 'Khu4', 'Khu5'];
        $('.select-line .treejs ul li ul li').addClass('treejs-node__close');
    },
    onChange: function () {
        data_line = this.values;
    }
});

$(function () {

    var start = moment().subtract(0, 'days');
    var end = moment();

    function cb(start, end) {
        $('#reportrange div:eq(0) p:eq(1)').html(start.format('DD/MM/YYYY'));
        $('#reportrange div:eq(1) p:eq(1)').html(end.format('DD/MM/YYYY'));
    }

    $('#reportrange').daterangepicker({
        startDate: start,
        endDate: end,
        showWeekNumbers: false,
        ranges: {
            'Hôm nay': [moment(), moment()],
            'Hôm qua': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            '7 ngày trước': [moment().subtract(6, 'days'), moment()],
            '30 ngày trước': [moment().subtract(29, 'days'), moment()],
            'Tháng này': [moment().startOf('month'), moment().endOf('month')],
            'Tháng trước': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        },
        opens: 'right',
        buttonClasses: ['btn btn-default'],
        applyClass: 'btn-small btn-primary',
        cancelClass: 'btn-small',
        locale: {
            customRangeLabel: 'Tùy Chọn',
            daysOfWeek: ['CN', 'T2', 'T3', 'T4', 'T5', 'T6', 'T7'],
            monthNames: ['Tháng Giêng', 'Tháng Hai', 'Tháng Ba', 'Tháng Tư', 'Tháng Năm', 'Tháng Sáu', 'Tháng Bảy', 'Tháng Tám', 'Tháng Chín', 'Tháng Mười', 'Tháng Mười Một', 'Tháng Mười hai'],
            firstDay: 1
        }
    }, cb);

    cb(start, end);

});
function loadmodal() {
    $('#modal-day').text(moment().format('DD/MM/YYYY'))
    $('#modal-day').daterangepicker({
        startDate: moment().format("HH") <= 8 ? startday = moment().subtract(1, 'days') : moment(),
        singleDatePicker: true,
        showDropdowns: true,
        minYear: 2014,
        maxYear: 2050,
        drops: 'down',
        showWeekNumbers: true,
        autoApply: true,
        locale: {
            format: 'DD/MM/YYYY',
            customRangeLabel: 'Tùy Chọn',
            daysOfWeek: ['CN', 'T2', 'T3', 'T4', 'T5', 'T6', 'T7'],
            monthNames: ['Tháng Giêng', 'Tháng Hai', 'Tháng Ba', 'Tháng Tư', 'Tháng Năm', 'Tháng Sáu', 'Tháng Bảy', 'Tháng Tám', 'Tháng Chín', 'Tháng Mười', 'Tháng Mười Một', 'Tháng Mười hai'],
            firstDay: 1
        }
    }, function (start, end, label) {
        $('#modal-day').text(start.format('DD/MM/YYYY'))
        //console.log(start.format('YYYY-MM-DD'))
    })

    //tải danh sách máy
    $.each(dataMachine, function (key, val) {
        $('#modal-machine').append('<option value="' + val + '">' + val + '</option>')
    });
    //tải ds ca/kíp
    $.each(dataShift, function (key, val) {
        $('#modal-shift').append('<option value="' + val + '">' + val + '</option>')
    });
    //tải ds ca/kíp
    $.each(dataGroup, function (key, val) {
        $('#modal-Group').append('<option value="' + val + '">' + val + '</option>')
    });
    //tải ds line
    $.each(data1, function (key, val) {
        $('#modal-line').append('<optgroup label="' + val.text + '"></optgroup>')
        $.each(val.children, function (key1, val1) {
            $('#modal-line optgroup:eq(' + key + ')').append('<option value="' + val1.text + '">' + val1.text + '</option>')
        });
    });
    //tải ds tình trạng
    $.each(dataTinhtrang, function (key, val) {
        $('#modal-stt').append('<option value="' + val + '">' + val + '</option>')
    });


    $.ajax({
        type: "POST",
        url: "php/eq-report-daily.php",
        data: { action: 'loadUser' },
        dataType: "json",
        success: function (data) {
            if (data.job == 1) $('#modal-Group option[value="MK"]').prop('selected', true)
            else if (data.job == 2) $('#modal-Group option[value="EGN"]').prop('selected', true)

            $('#selectGroup, #modal-Group').trigger('change')
        }
    });
};

function load_table() {
    selectMachine = $('#selectMachine').val();
    if (selectMachine.length == 0) selectMachine = '';
    selectShift = $('#selectShift').val();
    if (selectShift.length == 0) selectShift = '';
    selectGroup = $('#selectGroup').val();
    if (selectGroup.length == 0) selectGroup = '';

    starttime = $('#reportrange div:eq(0) p:eq(1)').text();
    endtime = $('#reportrange div:eq(1) p:eq(1)').text();

    $.ajax({
        type: "POST",
        url: "php/eq-report-daily.php",
        data: {
            action: 'loadTable', selectLine: data_line, selectMachine: selectMachine,
            selectShift: selectShift, selectGroup: selectGroup, starttime: starttime, endtime: endtime
        },
        dataType: "json",
        success: function (data) {
            //console.log(data)
            tabDailyReport.clear().rows.add(data).draw();

            //tính toán dữ liệu theo line
            var countLine = [], countLoss = []
            $.each(data_line, function (key, val) {
                countLine[key] = 0
                countLoss[key] = 0
                $.each(data, function (key1, val1) {
                    if (val == val1['_line']) {
                        countLine[key]++
                        countLoss[key] = countLoss[key] + val1['loss_time'] * 1
                    }
                })
            });
            idChartLine.data.labels = data_line
            idChartLine.data.datasets[0].data = countLoss
            idChartLine.data.datasets[1].data = countLine
            idChartLine.update()
        },
        error: function (xhr, status, error) {
            console.error(xhr);
        }
    });
}
//tải danh sách máy
/* $.ajax({
    type: "POST",
    url: "php/eq-report-daily.php",
    data: {action: 'loadMachine'},
    dataType: "json",
    success: function (data) {
        console.log(data)
        $.each(data, function (k, val) { 
            $('#selectLine').append('<option value="'+val['machine_name']+'">'+val['machine_name']+'</option>')
        });
        $('#selectLine').selectpicker()
    },
    error: function (xhr, status, error) {
        console.error(xhr);
    }
}); */
$(document).ready(function () {
    //tải danh sách máy
    $.each(dataMachine, function (key, val) {
        $('#selectMachine').append('<option value="' + val + '">' + val + '</option>')
    });
    $('#selectMachine').selectpicker()
    //tải ds ca/kíp
    $.each(dataShift, function (key, val) {
        $('#selectShift').append('<option value="' + val + '">' + val + '</option>')
    });
    $('#selectShift').selectpicker()
    //tải ds ca/kíp
    $.each(dataGroup, function (key, val) {
        $('#selectGroup').append('<option value="' + val + '">' + val + '</option>')
    });
    $('#selectGroup').selectpicker()

    loadmodal()

    //khai báo bảng hiển thị thông tin
    tabDailyReport = $('#tabDailyReport').DataTable({
        //data: data,
        columns: [{
            title: "STT",
            render: function (data, type, row, meta) {
                return meta.row + 1;
            }// This contains the row index
        },
        { data: 'ngay_thang_nam', title: 'Ngày' },
        { data: '_nhom', title: 'Nhóm' },
        { data: 'ca_kip', title: 'Ca' },
        { data: '_line', title: 'Line' },
        { data: '_machine', title: 'Machine' },
        { data: 'van_de', title: 'Vấn đề' },
        { data: 'nguyen_nhan', title: 'Nguyên nhân' },
        { data: 'khac_phuc', title: 'Khắc phục' },
        { data: 'loss_time', title: 'Loss time' },
        { data: 'hinh_anh', title: 'Hình ảnh' },
        { data: 'tinh_trang', title: 'Tình trạng' },
        { data: '_note', title: 'Lưu ý' },
        ],
        columnDefs: [
            {
                targets: "_all",
                className: "dt-center align-middle",
                defaultContent: ""
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
                text: 'Chụp ảnh',
                idName: 'haha',
                action: function (e, dt, node, config) {
                

                }
            }
        ],
        scrollX: true,
        scrollY: '70vh',
        scrollCollapse: true,
        paging: false,
        processing: true, // tiền xử lý trước
        //aLengthMenu: [[10, 20, 50, -1], [10, 20, 50, 'All']], // danh sách số trang trên 1 lần hiển thị bảng
        order: [[0, 'asc']] //sắp xếp giảm dần theo cột thứ 1
    });
    //khai báo biểu đồ thống kê loss theo line
    idChartLine = new Chart(
        $('#lossTimeLine'), {
        type: "bar",
        data: {
            labels: [0],
            datasets: [
                { label: "Loss time", yAxisID: "y", borderColor: "rgb(0, 99, 220)", backgroundColor: "rgb(0, 99, 220)", borderWidth: 2, radius: 1, data: [0], tension: 0.4, type: 'line' },
                { label: "Tỉ lệ lỗi", yAxisID: "y1", borderColor: "rgb(255, 150, 132)", backgroundColor: "rgb(255, 150, 132)", borderWidth: 2, radius: 1, data: [0], tension: 0.4 }
            ]
        },
        options: {
            scales: {
                x: {
                    ticks: { display: true, font: { family: "Times New Roman", size: 14, weight: "italic", }, /* maxTicksLimit: 20 */ },
                    title: { display: false, font: { family: "Times New Roman", size: 18, weight: "Bold", }, text: 'chartName' },
                    //grid: { display: false}
                },
                y: {
                    type: "linear", display: true, position: "left", min: 0, /* max: 120, */
                    ticks: { color: "rgb(0, 99, 220)", stepSize: 10 },
                    title: { display: true, font: { family: "Times New Roman", size: 14 }, color: "rgb(0, 99, 220)" }
                },
                y1: {
                    type: "linear", display: true, position: "right", min: 0, /* max: 100, */
                    ticks: { color: "rgb(255, 150, 132)", stepSize: 10 },
                    // grid line settings
                    grid: { drawOnChartArea: false },
                    title: { display: true, text: "Loss time", font: { family: "Times New Roman", size: 14 }, color: "rgb(255, 150, 132)" }
                }
            },
            interaction: {
                intersect: false,
                mode: "index",
            },

        }
    }
    );
    idChartLine.options.scales.y.title.text = idChartLine.data.datasets[0].label
    idChartLine.options.scales.y1.title.text = idChartLine.data.datasets[1].label
    load_table()
});

$('#btn-Xac-nhan').on('click', function () {
    load_table();
})

//khi thay đổi nhóm thì thông tin cũng được cập nhật thêm
$('#selectGroup, #modal-Group').change(function () {
    if ($(this).val() == "EGN") {
        $('#modal-machine').prepend('<optgroup label="OutMachine"></optgroup>')
        $.each(dataMachineEGN, function (key, val) {
            $('#modal-machine optgroup[label="OutMachine"]').append('<option value="' + val + '">' + val + '</option>')
        });
        $('#modal-line').prepend('<optgroup label="OutLine"></optgroup>')
        $.each(dataLineEGN, function (key, val) {
            $('#modal-line optgroup[label="OutLine"]').append('<option value="' + val + '">' + val + '</option>')
        });
    }
    else {
        $('#modal-machine optgroup[label="OutMachine"]').remove();
        $('#modal-line optgroup[label="OutLine"]').remove();

    }

});

//khi ấn nút gửi trên modal
$('#exampleModal .modal-dialog .modal-content .modal-footer button:eq(0)').on('click', function (e) {
    modal_day = moment($('#modal-day').text(), 'DD/MM/YYYY').format('YYYY-MM-DD');
    modal_shift = $('#modal-shift').val();
    modal_Group = $('#modal-Group').val();
    modal_line = $('#modal-line').val();
    modal_machine = $('#modal-machine').val();
    lblVande = $('#lblVande').val();
    lblNguyennhan = $('#lblNguyennhan').val();
    lblKhacphuc = $('#lblKhacphuc').val();
    uploadImage = $('#uploadImage').val();
    modal_losstime = $('#modal-losstime').val();
    modal_stt = $('#modal-stt').val();
    lblNote = $('#lblNote').val();

    $.ajax({
        type: "POST",
        url: "php/eq-report-daily.php",
        data: {
            action: 'GuiBaocao', modal_day: modal_day, modal_shift: modal_shift, modal_Group: modal_Group,
            modal_line: modal_line, modal_machine: modal_machine, lblVande: lblVande, lblNguyennhan: lblNguyennhan,
            lblKhacphuc: lblKhacphuc, modal_losstime: modal_losstime, modal_stt: modal_stt, lblNote: lblNote
        },
        dataType: "text",
        success: function (data) {
            console.log(data)
            $('#exampleModal .modal-dialog .modal-content .modal-footer button:eq(0)').text('Đã gửi')
            setTimeout(function () {
                $('#exampleModal .modal-dialog .modal-content .modal-footer button:eq(0)').text('Gửi báo cáo')
            }, 5000)
        },
        error: function (xhr, status, error) {
            console.error(xhr);
        }
    });
})


