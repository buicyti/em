var header_title = 'EM - LOB';
var myChart
var dataTotal
//Hiện danh sách line
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



$(function() {

    var start = moment().subtract(6, 'days');
    var end = moment();

    function cb(start, end) {
        //$('#reportrange span').html(start.format('DD/MM/YYYY') + '-' + end.format('DD/MM/YYYY'));

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
        format: 'DD/MM/YYYY',
        locale: {
            customRangeLabel: 'Tùy Chọn',
            daysOfWeek: ['CN', 'T2', 'T3', 'T4', 'T5', 'T6', 'T7'],
            monthNames: ['Tháng Một', 'Tháng Hai', 'Tháng Ba', 'Tháng Tư', 'Tháng Năm', 'Tháng Sáu', 'Tháng Bảy', 'Tháng Tám', 'Tháng Chín', 'Tháng Mười', 'Tháng Mười Một', 'Tháng Mười Hai'],
            firstDay: 1
        }
    }, cb);

    cb(start, end);
});

function load_data_lob(){
    starttime = $('#reportrange div:eq(0) p:eq(1)').text();
    endtime = $('#reportrange div:eq(1) p:eq(1)').text();
 
    

    $.ajax({
        type: "POST",
        url: "php/sf-lob.php",
        data: { action: 'get_lob_line',line_selected: dataLine, starttime: starttime, endtime: endtime},
        dataType: "json",
        success: function (response) {
            //console.log(response)
            dataTotal = response
            chartsort(response)
            //tạo Header cho bảng
            colDayChip = Object.keys(response.table[0].CHIP)
            colDayInline = Object.keys(response.table[0].INLINE)
            var thead = '<thead><tr><th rowspan="2">STT</th><th rowspan="2">LINE</th><th colspan="2" class="dt-center">AVERAGE</th>'
                thead += '<th colspan="'+ colDayChip.length +'" class="dt-center">CHIP</th>'
                thead += '<th colspan="'+ colDayInline.length +'" class="dt-center">INLINE</th>'  
                thead += '</tr><tr><th>CHIP</th><th>INLINE</th>'

                //header dòng trên
            for(var i = 0; i< colDayChip.length ;i++){
                thead += '<th>' + colDayChip[i] + '</th>'
            }
            for(var i = 0; i< colDayInline.length ;i++){
                thead += '<th>' + colDayInline[i] + '</th>'
            }
            thead += '</tr></thead>'
            $('#example').html(thead)

            //header dòng dưới
            columns = [
                { data: 'STT', title: 'STT', className: 'dt-center', width: "50px"},
                { data: 'LINE', title: 'LINE', className: 'dt-center', width: "150px"},
                { data: 'AVGChip', className: 'dt-center', width: "100px"},
                { data: 'AVGInline',className: 'dt-center', width: "100px"}
            ]
            sort1 = [2]
            sort2 = [3]
            for (var i = 0; i < colDayChip.length; i++) {
                columns.push({ data: 'CHIP.'+ colDayChip[i], className: 'dt-center', width: "100px"})
                sort1.push(i+4)
            }
            for (var i = 0; i < colDayInline.length; i++) {
                columns.push({ data: 'INLINE.'+ colDayInline[i], className: 'dt-center', width: "100px"})
                sort2.push(i + 4 + colDayInline.length)
            }
            //tính toán lại dữ liệu
            for(var i = 0;i < dataTotal.table.length ; i++){
                avgChip = collect(dataTotal.table[i].CHIP).filter().values().avg().toFixed(2)
                avgInline = collect(dataTotal.table[i].INLINE).filter().values().avg().toFixed(2)
                if (isNaN(avgChip)) dataTotal.table[i].AVGChip = 0
                else dataTotal.table[i].AVGChip = avgChip
                if (isNaN(avgInline)) dataTotal.table[i].AVGInline = 0
                else dataTotal.table[i].AVGInline = avgInline
            }
            //hiển thị bảng
            datatable = $('#example').DataTable({
                data: response['table'],
                columns: columns,
                columnDefs: [
                    {   render: function ( data, type, row ) {
                            if(data*1 >= 95 ) return '<span class="text-success">' + (data*1).toFixed(1) + "%</span>";
                            else if(data*1 < 95 && data*1 >= 85) return '<span class="text-warning">' + (data*1).toFixed(1) + "%</span>";
                            else if(data*1 < 85 && data*1 > 0) return '<span class="fw-bold text-danger">' + (data*1).toFixed(1) + "%</span>";
                            else return (data*1).toFixed(1) + "%";
                             },
                        targets: sort1 },
                    {   render: function ( data, type, row ) {
                            if(data*1 >= 85 ) return '<span class="text-success">' + (data*1).toFixed(1) + "%</span>";
                            else if(data*1 < 85 && data*1 >= 70) return '<span class="text-warning">' + (data*1).toFixed(1) + "%</span>";
                            else if(data*1 < 70 && data*1 > 0) return '<span class="fw-bold text-danger">' + (data*1).toFixed(1) + "%</span>";
                            else return (data*1).toFixed(1) + "%";
                             },
                        targets: sort2 }
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
            
        },
        error: function(xhr, status, error) {
            console.error(xhr);
        }
    });
}

myChart = new Chart(
    $("#SumLOB"), {
        type: "bar",
        data: {
            labels: 0,
            datasets: [{ label: "Chip mouter", yAxisID: "y", backgroundColor: "rgb(51, 153, 255)", borderColor: "rgb(51, 153, 255)", borderWidth: 2, radius: 0, data: 0, tension: 0.4 },
                { label: "Inline", yAxisID: "y", backgroundColor: "rgb(51, 255, 153)", borderColor: "rgb(51, 255, 153)", borderWidth: 2, radius: 0, data: 0, tension: 0.4 },
                { label: "TARGET", backgroundColor: "rgb(255, 0, 0)", borderColor: "rgb(255, 0, 0)", borderWidth: 2, radius: 0, data: 0, tension: 0.4, type: 'line'}
            ]
        },
        options: {
            scales: {
                x: {
                    ticks: { display: true, font: { family: "Times New Roman", size: 12, weight: "bold", }, maxTicksLimit: 0 },
                    title: { display: true, text: "Biểu đồ LOB", font: { family: "Times New Roman", size: 24, weight: "bold"}},
                    grid: { display: true}
                },
                y: {
                    type: "linear",
                    display: true,
                    position: "left",
                    min: 0,
                    max: 100,
                    ticks: { color: "rgb(0, 99, 220)", stepSize: 10 },
                    title: { display: true, text: "LOB", font: { family: "Times New Roman", size: 12 }, color: "rgb(0, 99, 220)" }
                }
            },
            interaction: { intersect: false, mode: "index" },
            plugins: {
                legend: { display: false, labels: { font: { size: 8 } } }
            }
        }
    }
)

function chartsort(data) {
    seLOB = $('#seLOB').val()
    sxLOB = $('#sxLOB').val()
    soLOB = $('#soLOB').val()

    if(sxLOB == 1 && soLOB == 1) data.chart = collect(data.chart).sortBy('lines').all()
    else if(sxLOB == 1 && soLOB == 2) data.chart = collect(data.chart).sortByDesc('lines').all()
    else if(sxLOB == 2 && soLOB == 1) data.chart = collect(data.chart).sortBy('data_chip').all()
    else if(sxLOB == 2 && soLOB == 2) data.chart = collect(data.chart).sortByDesc('data_chip').all()

    //khai báo biến cho biểu đồ
    var tabline = ["AVERAGE"]
    var tabdatachip = [collect(data.chart).where('data_chip', '>', 0).avg('data_chip')]
    var tabdatainline = [collect(data.chart).where('data_inline', '>', 0).avg('data_inline')]
    var tabtarget = [95]
    $.each(data.chart, function (key, val) { 
        tabline.push(val.lines)
        tabdatachip.push(val.data_chip)
        tabdatainline.push(val.data_inline)
        tabtarget.push(val.target)
    });

    myChart.data.labels = tabline
    myChart.data.datasets[0].data = tabdatachip
    myChart.data.datasets[1].data = tabdatainline
    myChart.data.datasets[2].data = tabtarget
    
    if(seLOB == 2 ) myChart.data.datasets[1].data = 0
    if(seLOB == 3 ) myChart.data.datasets[0].data = 0

    myChart.update()
    
  }


$(document).ready(async function() {
    await load_line;
    load_data_lob()
});

$('#sxLOB').on('change', function(){
    chartsort(dataTotal)
})
$('#soLOB').on('change', function(){
    chartsort(dataTotal)
})
$('#seLOB').on('change', function(){
    chartsort(dataTotal)
})
$('#btn-Xac-nhan').on('click', function () {
    //xóa bảng và dữ liệu trong bảng
    datatable.destroy()
    $('#example').empty()
    load_data_lob()
});