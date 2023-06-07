// prettier-ignore
var header_title = 'EM - Quản lý Độ ẩm tủ linh kiện đắt tiền';
var idChart = []
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
                    this.values = ['Khu 1', 'Khu 2', 'Khu 3', 'Khu 4'];
                    this.disables = ['Khu 5 (Interpose)'];
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

       /*  new Tree('.select-line', {
            data: [{ id: 'lineno', text: 'Hansol', children: data1 }],
            closeDepth: 3,
            loaded: function() {
                this.values = ['Khu 1', 'Khu 2', 'Khu 3', 'Khu 4']
                this.disables = ['Khu 5 (Interpose)']
                $('.select-line .treejs ul li ul li').addClass('treejs-node__close');
            },
            onChange: function() {
                data_line = this.values;
            }
        }) */


async function load_html() {
    await
    $('#THSMD').empty();
    idChart = []
    if(dataLine.length > 0){ 
        $.each(dataLine, function (key, line) { 
            $('#THSMD').append('<div class="col" id="line'+ line +'" style="font-size: ' + 54 / swap_horizontal + 'px;">' +
            '<div class="card mb-2 bg-light" style="max-height: 600px;">' +
            '<div class="card-header"><div class="d-flex justify-content-between"><span class="fw-bold text-secondary">' + line + '</span><span class="">N/a</span></div></div>' +
            '<div class="card-body">' +
            '<canvas id="myChart' + line + '"></canvas>' +
            '</div>' +
            '</div>' +
            '</div>')
        load_chart(line)
        });
    }
    else $('#THSMD').append('<div class="fw-bold d-flex justify-content-around align-items-center fs-1 text-uppercase" style="width: 100%; height: calc(100vh - 6rem)">Hãy chọn ít nhất 1 line</div>')
}

function load_line_selected() {
    //console.log(data);
    starttime = $('#reportrange div:eq(0) p:eq(1)').text();
    endtime = $('#reportrange div:eq(1) p:eq(1)').text();
    $.ajax({
        type: "POST",
        url: "php/monitors-tu-LKDT.php",
        dataType: "json",
        data: { line_selected: dataLine },
        //cache: false,
        success: function(data) {
            thalert = [];
            key = 0;
            current_time = data['Current time']
            delete data['Current time']
            jQuery.each(data, function(line, val) {
                temp = $(val['Temp']).get(-1)
                humi = $(val['Humi']).get(-1)
                timr = $(val['Time_update']).get(-1)
                a = '';
                //nếu line nào chưa cập nhật thì xóa hàng đó đến khi lấy đc gtri
                while (temp == 0 && humi == 0) {
                    val['Temp'].pop()
                    val['Humi'].pop()
                    val['Time_update'].pop()
                    temp = $(val['Temp']).get(-1)
                    humi = $(val['Humi']).get(-1)
                    timr = $(val['Time_update']).get(-1)
                }
                if (temp === undefined && humi === undefined) {
                    timr = 'text-secondary'
                    temp = ''
                    humi = ''
                } 
                else if (Date.parse(current_time) - Date.parse(timr) > 600000) {
                    a += 'Mất kết nối từ ' + timr + '<br/>'
                    timr = 'text-danger'
                } 
                else timr = 'text-success'

                if (temp == '') temp = ''
                else if (temp >= 18 && temp <= 28) temp = '<b class="text-success">' + temp + '°C</b>'
                else {
                    a += 'Nhiệt độ nằm ngoài phạm vi quy định: ' + temp + '°C<br/>'
                    temp = '<b class="text-danger">' + temp + '°C</b>'
                }

                if (humi == '') humi = ''
                else if (humi >= 0 && humi <= 10) humi = '<b class="text-success">' + humi + '%</b>'
                else {
                    a += 'Độ ẩm nằm ngoài phạm vi quy định: ' + humi + '%<br/>'
                    humi = '<b class="text-danger">' + humi + '%</b>'
                }

                if (a.length > 10) {
                    thalert[key] = line + '|' + a
                    key++
                }
                //load dữ liệu vào html    val['Temp'], val['Humi'], val['Time_update']
                $('#line' + line + ' .card .card-header .d-flex span:eq(0)').removeClass('text-secondary text-danger text-success').addClass(timr)
                $('#line' + line + ' .card .card-header .d-flex span:eq(1)').html(temp + ' ' + humi)
                //cập nhật biểu đồ
                idChart[line].data.labels = val['Time_update']
                idChart[line].data.datasets[0].data = val['Temp']
                idChart[line].data.datasets[1].data = val['Humi']
                idChart[line].update()
            })

        },
        error: function(xhr, status, error) {
            //console.error(xhr);
        }
    });
};

function load_alertify(dataaa) {
    time = 0
    $.each(dataaa, function(i, val) {
        setTimeout(function() {
            al = val.split("|")
            alertify.error('<b>' + al[0] + '</b><br/>' + al[1], 5);
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
                        type: "linear",
                        display: true,
                        position: "left",
                        min: 0,
                        max: 120,
                        ticks: { color: "rgb(0, 99, 220)", stepSize: 10 },
                        title: { display: true, text: "Nhiệt độ (°C)", font: { family: "Times New Roman", size: 27 / swap_horizontal }, color: "rgb(0, 99, 220)" }
                    },
                    y1: {
                        type: "linear",
                        display: true,
                        position: "right",
                        min: 0,
                        max: 100,
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



var setreload;
var setAlertify;
$('#btn-Xac-nhan').on('click',async function() {
    swap_horizontal = $('input[name="kt-ngang"]').val();
    $('#THSMD').removeClass();
    $('#THSMD').addClass('row row-cols-' + swap_horizontal);
    clearInterval(setreload);
    await load_line;
    await load_html()
    setreload = setInterval(function() { load_line_selected(); }, 10000);
    load_line_selected();
    if (document.querySelector('#flexCheckChecked').checked && dataLine.length > 0 && thalert.length > 0) load_alertify(thalert)


});
$(document).ready(async function() {
    swap_horizontal = $('input[name="kt-ngang"]').val();
    await load_line;
    await load_html()
    setreload = setInterval(function() { load_line_selected() }, 10000);
    load_line_selected();
});