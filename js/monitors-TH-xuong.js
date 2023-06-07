var header_title = 'EM - Quản lý nhiệt độ Xưởng';
let random_color = ["#000000", "#FFEBCD", "#0000FF", "#8A2BE2", "#A52A2A", "#DEB887", "#5F9EA0", "#7FFF00", "#D2691E", "#FF7F50", "#6495ED", "#FFF8DC", "#DC143C", "#00FFFF", "#00008B", "#008B8B", "#B8860B", "#A9A9A9", "#006400", "#A9A9A9", "#BDB76B", "#8B008B", "#556B2F", "#FF8C00", "#9932CC", "#8B0000", "#E9967A", "#8FBC8F", "#483D8B", "#2F4F4F", "#2F4F4F", "#00CED1", "#9400D3", "#FF1493", "#00BFFF", "#696969", "#696969", "#1E90FF", "#B22222", "#FFFAF0", "#228B22", "#FF00FF", "#DCDCDC"]
var idChart = []
$(function () {

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
            monthNames: ['Tháng Giêng', 'Tháng Hai', 'Tháng Ba', 'Tháng Tư', 'Tháng Năm', 'Tháng Sáu', 'Tháng Bảy', 'Tháng Tám', 'Tháng Chín', 'Tháng Mười', 'Tháng Mười Một', 'Tháng Mười hai'],
            firstDay: 1
        }
    }, cb);

    cb(start, end);

});

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
                    this.values = ['HS_SMD003', 'HS_SMD007', 'HS_SMD012', 'HS_SMD016', 'HS_SMD021', 'HS_SMD025', 'HS_SMD028', 'HS_SMD031', 'Interposer04', 'Interposer08'];
                    this.disables = ['HS_SMD001', 'HS_SMD002', 'HS_SMD004', 'HS_SMD005', 'HS_SMD006', 'HS_SMD008', 'HS_SMD009',
                                    'HS_SMD010', 'HS_SMD011', 'HS_SMD013', 'HS_SMD014', 'HS_SMD015', 'HS_SMD017', 'HS_SMD018',
                                    'HS_SMD019', 'HS_SMD020', 'HS_SMD022', 'HS_SMD023', 'HS_SMD024', 'HS_SMD026', 'HS_SMD027',
                                    'HS_SMD028', 'HS_SMD029', 'HS_SMD030', 'HS_SMD032', 'HS_SMD033', 'HS_SMDSVC',
                                    'Interposer01','Interposer02','Interposer03','Interposer05','Interposer06','Interposer07'
                                    ];
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
                data: [{ id: 'lineno', text: 'Hansol', children: data1}],
                closeDepth: 3,
                loaded: function () {
                    this.values = ['HS_SMD003', 'HS_SMD007', 'HS_SMD012', 'HS_SMD016', 'HS_SMD021', 'HS_SMD025', 'HS_SMD028', 'HS_SMD031', 'Interposer04', 'Interposer08'];
                    this.disables = ['HS_SMD001', 'HS_SMD002', 'HS_SMD004', 'HS_SMD005', 'HS_SMD006', 'HS_SMD008', 'HS_SMD009',
                                    'HS_SMD010', 'HS_SMD011', 'HS_SMD013', 'HS_SMD014', 'HS_SMD015', 'HS_SMD017', 'HS_SMD018',
                                    'HS_SMD019', 'HS_SMD020', 'HS_SMD022', 'HS_SMD023', 'HS_SMD024', 'HS_SMD026', 'HS_SMD027',
                                    'HS_SMD028', 'HS_SMD029', 'HS_SMD030', 'HS_SMD032', 'HS_SMD033', 'HS_SMDSVC',
                                    'Interposer01','Interposer02','Interposer03','Interposer05','Interposer06','Interposer07'
                                    ];
                    $('.select-line .treejs ul li ul li').addClass('treejs-node__close');
                },
                onChange: function () {
                    data_line = this.values;
                }
            }) */


async function loadhtml() {
    await
    $('#THSMD').empty();
    sapxep = $('#sapxep').val();
    idChart = [];
    if (dataLine.length > 0) {
        if (sapxep == 1) {
            $.each(dataLine, function (key, line) {
                $('#THSMD').append('<div class="col" id="line' + line + '" style="font-size: ' + 54 / swap_horizontal + 'px;">' +
                    '<div class="card mb-2 bg-light" style="max-height: 600px;">' +
                    '<div class="card-header"><b class="text-secondary">' + line + '</b></div>' +
                    '<div class="card-body">' +
                    '<small class="text-muted d-flex justify-content-around flex-row mb-3">' +
                    '<div class="d-flex flex-column">' +
                    '<span>N/độ: N/A</span>' +
                    '<span>Đ/ẩm: N/A</span>' +
                    '</div><div class="d-flex flex-column">' +
                    '<span>eCO<sub>2</sub>: N/A</span>' +
                    '<span>TVOC: N/A</span>' +
                    '</div></small>' +
                    '<canvas id="myChart' + line + '"></canvas>' +
                    '</div>' +
                    '</div>' +
                    '</div>')
                load_chart(line)

            })
        }
    }
    else $('#THSMD').append('<div class="fw-bold d-flex justify-content-around align-items-center fs-1 text-uppercase" style="width: 100%; height: calc(100vh - 6rem)">Hãy chọn ít nhất 1 line</div>')
}

function load_current_data(){
    $.ajax({
        type: "POST",
        url: "php/monitors-TH-xuong.php",
        data: {line_selected: dataLine, sapxep: "current"},
        dataType: "json",
        success: function (response) {
            //console.log(response)
            current_time = response['Current time']
            delete response['Current time']
            jQuery.each(response, function(line, val){
                temp = val['Temp']
                humi = val['Humi']
                co2 = val['CO2']
                tvoc = val['TVOC']
                timr = val['Lastmodify']
                if (temp === undefined && humi === undefined) {
                    timr = 'text-secondary'
                    temp = ''
                    humi = ''
                    co2 = ''
                    tvoc = ''
                } 
                else if (Date.parse(current_time) - Date.parse(timr) > 300000) timr = 'text-danger'
                else timr = 'text-success'

                if (temp == '') temp = ''
                else if (temp >= 18 && temp <= 28) temp = '<b class="text-success">N/độ: ' + temp + '°C</b>'
                else temp = '<b class="text-danger">N/độ: ' + temp + '°C</b>'
                
                if (humi == '') humi = ''
                else if (humi >= 40 && humi <= 60) humi = '<b class="text-success">Đ/ẩm: ' + humi + '%</b>'
                else humi = '<b class="text-danger">Đ/ẩm: ' + humi + '%</b>'

                if (co2 == '') co2 = ''
                else if (co2 >= 400 && co2 <= 2400) co2 = '<b class="text-success">eCO<sub>2</sub>: ' + co2 + 'ppm</b>'
                else co2 = '<b class="text-danger">eCO<sub>2</sub>: ' + co2 + 'ppm</b>'

                if (tvoc == '') tvoc = ''
                else if (tvoc >= 0 && tvoc <= 3000) tvoc = '<b class="text-success">TVOC: ' + tvoc + 'ppb</b>'
                else tvoc = '<b class="text-danger">TVOC: ' + tvoc + 'ppb</b>'

                //hiện ra html
                $('#line' + line + ' .card .card-header b').removeClass('text-secondary text-danger text-success').addClass(timr)
                $('#line' + line + ' .card .card-body .text-muted .flex-column:eq(0)').html(temp + humi);
                $('#line' + line + ' .card .card-body .text-muted .flex-column:eq(1)').html(co2 + tvoc);
            })
        },
        error: function (xhr, status, error) {
            console.error(xhr);
        }
    });
}

function load_line_selected() {
    sapxep = $('#sapxep').val();
    starttime = $('#reportrange div:eq(0) p:eq(1)').text();
    endtime = $('#reportrange div:eq(1) p:eq(1)').text();
    $.ajax({
        type: "POST",
        url: "php/monitors-TH-xuong.php",
        dataType: "json",
        data: { line_selected: dataLine, sapxep: sapxep, starttime: starttime, endtime: endtime },
        //cache: false,
        success: function (data) {
            //console.log(data)
            current_time = data['Current time']
            delete data['Current time']
            if (sapxep == 1) {
                thalert = [];
                key = 0;
                jQuery.each(data, function (line, val) {
                    temp = $(val['Temp']).get(-1)
                    humi = $(val['Humi']).get(-1)
                    co2 = $(val['CO2']).get(-1)
                    tvoc = $(val['TVOC']).get(-1)
                    timr = $(val['Time_update']).get(-1)
                    a = '';
                    //nếu line nào chưa cập nhật thì xóa hàng đó đến khi lấy đc gtri
                    while (temp == 0 && humi == 0) {
                        val['Temp'].pop()
                        val['Humi'].pop()
                        val['CO2'].pop()
                        val['TVOC'].pop()
                        val['Time_update'].pop()
                        temp = $(val['Temp']).get(-1)
                        humi = $(val['Humi']).get(-1)
                        co2 = $(val['CO2']).get(-1)
                        tvoc = $(val['TVOC']).get(-1)
                        timr = $(val['Time_update']).get(-1)
                    }
                    if (temp === undefined && humi === undefined) {
                        timr = 'text-secondary'
                        temp = ''
                        humi = ''
                        co2 = ''
                        tvoc = ''
                    } else if (Date.parse(current_time) - Date.parse(timr) > 300000) {
                        a += 'Mất kết nối từ ' + timr + '<br/>'
                        timr = 'text-danger'
                    } else timr = 'text-success'
                    if (temp == '') temp = ''
                    else if (temp >= 18 && temp <= 28) temp = '<b class="text-success">N/độ: ' + temp + '°C</b>'
                    else {
                        a += 'Nhiệt độ nằm ngoài phạm vi quy định: ' + temp + '°C<br/>'
                        temp = '<b class="text-danger">N/độ: ' + temp + '°C</b>'
                    }
                    if (humi == '') humi = ''
                    else if (humi >= 40 && humi <= 60) humi = '<b class="text-success">Đ/ẩm: ' + humi + '%</b>'
                    else {
                        a += 'Độ ẩm nằm ngoài phạm vi quy định: ' + humi + '%<br/>'
                        humi = '<b class="text-danger">Đ/ẩm: ' + humi + '%</b>'
                    }

                    if (co2 == '') co2 = ''
                    else if (co2 >= 400 && co2 <= 2400) co2 = '<b class="text-success">eCO<sub>2</sub>: ' + co2 + 'ppm</b>'
                    else {
                        a += 'CO2 nằm ngoài phạm vi quy định: ' + co2 + 'ppm<br/>'
                        co2 = '<b class="text-danger">eCO<sub>2</sub>: ' + co2 + 'ppm</b>'
                    }

                    if (tvoc == '') tvoc = ''
                    else if (tvoc >= 0 && tvoc <= 3000) tvoc = '<b class="text-success">TVOC: ' + tvoc + 'ppb</b>'
                    else {
                        a += 'TVOC nằm ngoài phạm vi quy định: ' + tvoc + 'ppb<br/>'
                        tvoc = '<b class="text-danger">TVOC: ' + tvoc + 'ppb</b>'
                    }

                    if (a.length > 10) {
                        thalert[key] = line + '|' + a
                        key++
                    }
                    //hiện ra html
                    $('#line' + line + ' .card .card-header b').removeClass('text-secondary text-danger text-success').addClass(timr)
                    $('#line' + line + ' .card .card-body .text-muted .flex-column:eq(0)').html(temp + humi);
                    $('#line' + line + ' .card .card-body .text-muted .flex-column:eq(1)').html(co2 + tvoc);
                    //cập nhật biểu đồ
                    idChart[line].data.labels = val['Time_update']
                    idChart[line].data.datasets[0].data = val['Temp']
                    idChart[line].data.datasets[1].data = val['Humi']
                    idChart[line].update()

                })
            } else if (sapxep == 2) {
                $('#THSMD').append('<div class="col-12">' +
                    '<div class="card bg-light mb-3">' +
                    '<div class="card-body">' +
                    '<canvas id="myChartTemperature"></canvas>' +
                    '</div>' +
                    '</div>' +
                    '</div>' +

                    '<div class="col-12">' +
                    '<div class="card bg-light mb-3">' +
                    '<div class="card-body">' +
                    '<canvas id="myChartHumidity"></canvas>' +
                    '</div>' +
                    '</div>' +
                    '</div>')

                let data_temp = []
                let data_humi = []
                let line
                i = 0
                j = 0
                $.each(data['Temp'], function (indexInArray, valueOfElement) {
                    data_temp[i] = { label: indexInArray, borderColor: random_color[i], borderWidth: 2, radius: 0, data: valueOfElement, tension: 0.4 }
                    line = indexInArray;
                    i++
                });
                $.each(data['Humi'], function (indexInArray, valueOfElement) {
                    data_humi[j] = { label: indexInArray, borderColor: random_color[j], borderWidth: 2, radius: 0, data: valueOfElement, tension: 0.4 }
                    j++
                });
                load_chart_Temp(data['Time_update'][line], data_temp)
                load_chart_Humi(data['Time_update'][line], data_humi)
            }

        },
        error: function (xhr, status, error) {
            //console.error(xhr);
        }
    });
};

function load_alertify(dataaa) {
    time = 0
    $.each(dataaa, function (i, val) {
        setTimeout(function () {
            alertify.error('<b>' + val.split("|")[0] + '</b><br/>' + val.split("|")[1], 5);
        }, time * 1000);
        time++;
    });
};

function load_chart(line) {
    idChart[line] = new Chart(
        $("#myChart" + line), {
        type: "line",
        data: {
            labels: [0],
            datasets: [{ label: "Nhiệt độ", yAxisID: "y", borderColor: "rgb(0, 99, 220)", borderWidth: 2, radius: 0, data: [0], tension: 0.4 },
            { label: "Độ ẩm", yAxisID: "y1", borderColor: "rgb(255, 150, 132)", borderWidth: 2, radius: 0, data: [0], tension: 0.4 }
            ]
        },
        options: {
            scales: {
                x: {
                    ticks: { display: false, font: { family: "Times New Roman", size: 8, weight: "italic", }, maxTicksLimit: 10 },
                    title: { display: false, text: "Biểu đồ nhiệt độ - Độ ẩm line" },
                    //grid: { display: false}
                },
                y: {
                    type: "linear", display: true, position: "left", min: 0, max: 120,
                    ticks: { color: "rgb(0, 99, 220)", stepSize: 10 },
                    title: { display: true, text: "Nhiệt độ (°C)", font: { family: "Times New Roman", size: 27 / swap_horizontal }, color: "rgb(0, 99, 220)" }
                },
                y1: {
                    type: "linear", display: true, position: "right", min: 0, max: 100,
                    ticks: { color: "rgb(255, 150, 132)", stepSize: 10 },
                    // grid line settings
                    grid: { drawOnChartArea: false },
                    title: { display: true, text: "Độ ẩm (%)", font: { family: "Times New Roman", size: 27 / swap_horizontal }, color: "rgb(255, 150, 132)" }
                },
            },
            interaction: { intersect: false, mode: "index" },
            plugins: {
                legend: { display: false, labels: { font: { size: 8 } } }
            }
        }
    }
    );
}

function load_chart_Temp(time, data) {
    myChartTemperature = new Chart(
        $("#myChartTemperature"), {
        type: "line",
        data: {
            labels: time,
            datasets: data
        },
        options: {
            scales: {
                x: {
                    ticks: { display: true, font: { family: "Times New Roman", size: 8, weight: "italic", }, maxTicksLimit: 20 },
                    title: { display: true, text: "Biểu đồ nhiệt độ line", font: { family: "Times New Roman", size: 16 }, color: "rgb(0, 99, 220)" },
                    //grid: { display: false}
                },
                y: {
                    type: "linear",
                    display: true,
                    position: "left",
                    min: 0,
                    max: 80,
                    ticks: { color: "rgb(0, 99, 220)", stepSize: 0 },
                    title: { display: true, text: "Nhiệt độ (°C)", font: { family: "Times New Roman", size: 11 }, color: "rgb(0, 99, 220)" }
                },
            },
            interaction: { intersect: false, mode: "index" },

        }
    }
    )
}

function load_chart_Humi(time, data) {
    myChartHumidity = new Chart(
        $("#myChartHumidity"), {
        type: "line",
        data: { labels: time, datasets: data },
        options: {
            scales: {
                x: {
                    ticks: { display: true, font: { family: "Times New Roman", size: 8, weight: "italic", }, maxTicksLimit: 20 },
                    title: { display: true, text: "Biểu đồ độ ẩm line", font: { family: "Times New Roman", size: 16 }, color: "rgb(255, 120, 112)" },
                    //grid: { display: false}
                },
                y: {
                    type: "linear",
                    display: true,
                    position: "left",
                    min: 0,
                    max: 100,
                    ticks: { color: "rgb(255, 150, 132)", stepSize: 0 },
                    title: { display: true, text: "Độ ẩm (%)", font: { family: "Times New Roman", size: 11 }, color: "rgb(255, 150, 132)" }
                },
            },
            interaction: { intersect: false, mode: "index" },
        }
    }
    )
}
async function load(){
    
}

var setreload;
var setAlertify;
$('#btn-Xac-nhan').on('click',async function () {
    swap_horizontal = $('input[name="kt-ngang"]').val();
    $('#THSMD').removeClass();
    $('#THSMD').addClass('row row-cols-' + swap_horizontal);
    await load_line;
    await loadhtml()
    load_line_selected();
    setreload = setInterval(() => { load_line_selected(); }, 1000 * 60 * 10);
    clearInterval(setreload);
    if (document.querySelector('#flexCheckChecked').checked && sapxep == "1" && dataLine.length > 0) load_alertify(thalert)


});
$(document).ready(async function () {
    swap_horizontal = $('input[name="kt-ngang"]').val();
    await load_line;
    await loadhtml()
    load_line_selected();
    load_current_data()
    setreload = setInterval(() => { load_line_selected(); }, 1000 * 60 * 10);
    setreload1 = setInterval(() => { load_current_data() }, 10 * 1000);
});


/* Xuất sang excel */
$('#export_excel').on('click', function () {
    sapxep = $('#sapxep').val();
    starttime = $('#reportrange div:eq(0) p:eq(1)').text();
    endtime = $('#reportrange div:eq(1) p:eq(1)').text();
    $("#loading").show(); //tạo 1 class phủ không cho thao tác
    $('#text-wait').html('Vui lòng chờ');
    $.ajax({
        type: "POST",
        url: "php/monitors-TH-xuong.php",
        data: { line_selected: data_line, sapxep: 3, starttime: starttime, endtime: endtime },
        success: function (response) {
            $("#loading").hide();
            window.location = "php/" + response;
        },
        error: function () {
            $("#loading").hide();
        }
    });
});