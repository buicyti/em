var header_title = 'EM - Hệ thống theo dõi LOB';
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
        /* new Tree('.select-line', {
            data: [{ id: 'lineno', text: 'Hansol', children: data1 }],
            closeDepth: 3,
            loaded: function() {
                this.values = ['lineno']
                $('.select-line .treejs ul li ul li').addClass('treejs-node__close');
            },
            onChange: function() {
                data_line = this.values;
            }
        }) */


async function load_line_selected() {
    await
    $('#THSMD').empty()
    var html = ''
    await
    $.ajax({
        type: "POST",
        url: "php/sf-home.php",
        dataType: "json",
        data: { action: 'load-line', line_selected: dataLine },
        //cache: false,
        success: function (data) {
            if (data !== null) {
                $.each(data, function (keyL, valL) {
                    html += '<div class="production-line" id="line' + keyL + '">' +
                        '<div class="row">' +
                        '<div class="col-12">' +
                        '<div class="line-header">' +
                        '<div class="title-bg">' +
                        '<div class="title-icon" nameline="' + keyL + '" data-bs-toggle="modal" data-bs-target="#modalLOB">' +
                        '<span class="btn-icon" tabindex="0" role="button" aria-disabled="false" aria-label="upload picture">' +
                        '<svg focusable="false" viewBox="0 0 24 24" aria-hidden="true">' +
                        '<path d="M3 17h18v2H3zm0-7h18v5H3zm0-4h18v2H3z"></path>' +
                        '</svg>' +
                        '</span>' +
                        '</div>' +
                        '<h4 class="title">' + keyL + '</h4>' +
                        '<div class="line-LOB good"><span title="LOB Result" class=""></span></div>' +
                        '</div>' +
                        '<div class="line-header-content">' +
                        '<h6 class="model" title="The model is running">MODEL BSM-A1234/XYZ</h6>' +
                        '<h6 class="nextModel" title="The next model will be changed">NEXT MODEL BSM-A1234/JQK</h6>' +
                        '</div>' +
                        '</div>' +
                        '<div class="line-body">' +
                        '<div class="list-machine">'
                    $.each(valL, function (keyM, valM) {
                        html += '<div class="card card-machine design-icon" style="margin: 0px -2px 0px 2px;">' +
                            '<div class="card-body">' +
                            '<img class="card-img-top" src="assets/images/machine_small/' + valM + '">' +
                            '<div class="alarm-tower">' +
                            '<span class="alarm-light alarm-danger"></span>' +
                            '<span class="alarm-light alarm-warning"></span>' +
                            '<span class="alarm-light alarm-working"></span>' +
                            '</div>' +
                            '<div class="card-sm-info"><span>' + keyM + '</span></div>' +
                            '<div class="card-cycle-time">0</div>' +
                            '</div>' +
                            '</div>'
                    });
                    html += '</div>' +
                        '</div>' +
                        '<div class="line-status" style="height: 100%;">' +
                        '<p class="loss-time" title="Loss time"><span class="loss-time-unit">Lt.</span>0" 0s</p>' +
                        '<div class="throughput" title="Sản lượng máy chip"><span class="throughput-unit">CHIP Qty</span>' +
                        '<p class="throughput-value">0</p>' +
                        '</div>' +
                        '<p class="efficiency" title="LOB TOTAL">0.0%</p>' +
                        '<p class="status-text">WAITING</p>' +
                        '</div>' +
                        '</div>' +
                        '</div>' +
                        '</div>'
                })
            }
            else html = '<div class="fw-bold d-flex justify-content-around align-items-center fs-1 text-uppercase" style="width: 100%; height: calc(100vh - 6rem)">Không có dữ liệu</div>'
            $('#THSMD').html(html)
            modalLOB()
        },
        error: function (xhr, status, error) {
            // console.error(xhr);
            $('#THSMD').append('<div class="fw-bold d-flex justify-content-around align-items-center fs-1 text-uppercase" style="width: 100%; height: calc(100vh - 6rem)">Hãy chọn ít nhất 1 line</div>')
        }
    })
}

function modalLOB() {
    $('.title-icon').on('click', function () {
        var linename = $(this).attr('nameline')
        $('#modalLOBLabel').html('CẬP NHẬP LOB LINE ' + linename)
        document.getElementById('modal_lob_chip').setAttribute('nameline', linename)
        document.getElementById('modal_lob_inline').setAttribute('nameline', linename)

        $.ajax({
            type: "POST",
            url: "php/sf-home.php",
            data: { action: 'get_data_lob_line', linename: linename },
            dataType: "json",
            success: function (response) {
                //console.log(response)
                myChart.data.labels = response["days"]
                myChart.data.datasets[0].data = response["data_chip"]
                myChart.data.datasets[1].data = response["data_tong"]
                myChart.options.scales.x.title.text = 'Biểu đồ LOB line ' + linename
                myChart.update()
            }
        });

    })
}

myChart = new Chart(
    $("#chartLOBChip"), {
    type: "bar",
    data: {
        labels: 0,
        datasets: [{ label: "LOB Chip mouter", yAxisID: "y", backgroundColor: "rgb(0, 99, 220)", borderColor: "rgb(0, 99, 220)", borderWidth: 2, radius: 0, data: 0, tension: 0.4 },
        { label: "LOB Inline", yAxisID: "y", backgroundColor: "rgb(255, 150, 132)", borderColor: "rgb(255, 150, 132)", borderWidth: 2, radius: 0, data: 0, tension: 0.4 }
        ]
    },
    options: {
        scales: {
            x: {
                ticks: { display: true, font: { family: "Times New Roman", size: 12, weight: "bold", }, maxTicksLimit: 10 },
                title: { display: true, text: "Biểu đồ LOB line " },
                //grid: { display: false}
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

function load_machine_data() {
    $.ajax({
        type: "POST",
        url: "php/sf-home.php",
        dataType: "json",
        data: { action: 'load-machine-data', line_selected: dataLine },
        //cache: false,
        success: function (data) {
            $.each(data, function (keyL, valL) {
                var stt = 0
                $.each(valL, function (keyM, valM) {
                    const lampMachine = $('#line' + keyL + ' .row .col-12 .line-body .list-machine .card:eq(' + stt + ')')
                    if (valM[0] == 0) lampMachine.removeClass("working warning danger");
                    else if (valM[0] == 1) lampMachine.removeClass("working warning danger").addClass("working");
                    else if (valM[0] == 2) lampMachine.removeClass("working warning danger").addClass("warning");
                    else if (valM[0] == 3) lampMachine.removeClass("working warning danger").addClass("danger");

                    const cycleMachine = $('#line' + keyL + ' .row .col-12 .line-body .list-machine .card:eq(' + stt + ') .card-body .card-cycle-time')
                    if (valM[1] == 4) cycleMachine.html('0')
                    else cycleMachine.html(valM[1].toFixed(1))
                    stt++
                })
            })
        },
        error: function (xhr, status, error) {
            //console.error(xhr);
        }
    })
}
function load_line_data() {
    $.ajax({
        type: "POST",
        url: "php/sf-home.php",
        dataType: "json",
        data: { action: 'load-line-data', line_selected: dataLine },
        //cache: false,
        success: function (data) {
            $.each(data, function (keyL, valL) {
                const model = $('#line' + keyL + ' .row .col-12 .line-header .line-header-content .model')
                const nextModel = $('#line' + keyL + ' .row .col-12 .line-header .line-header-content .nextModel')
                model.html(valL[0])
                if (valL[0] == valL[1]) nextModel.html('')
                else nextModel.html('Next: ' + valL[1])

                const lob = $('#line' + keyL + ' .row .col-12 .line-status .efficiency')
                if (valL[2] > 80) lob.removeClass("good warning danger").addClass("good")
                else if (valL[2] > 60 && valL[2] <= 80) lob.removeClass("good warning danger").addClass("warning")
                else lob.removeClass("good warning danger").addClass("danger")
                lob.html(valL[2] + '%')

                const lineStatus = $('#line' + keyL + ' .row .col-12 .line-status')
                const textStatus = $('#line' + keyL + ' .row .col-12 .line-status .status-text')
                if (valL[3] == 0) {//khi không có dữ liệu
                    lineStatus.removeClass("working warning danger")
                    textStatus.html("WAITING")
                }
                else if (valL[3] == 1) {//khi line chạy
                    lineStatus.removeClass("working warning danger").addClass("working")
                    textStatus.html("WORKING")
                }
                else if (valL[3] == 2) {//khi line đổi model khác
                    lineStatus.removeClass("working warning danger").addClass("warning")
                    textStatus.html("CHANGING")
                }
                else if (valL[3] == 3) {//khi line dừng
                    lineStatus.removeClass("working warning danger").addClass("danger")
                    textStatus.html("STOPPING")
                }

                $('#line' + keyL + ' .row .col-12 .line-status .throughput .throughput-value').html(valL[4])
                $('#line' + keyL + ' .row .col-12 .line-status .loss-time').html('<span class="loss-time-unit">Lt.</span>' + Math.floor(valL[5] / 60) + '" ' + valL[5] % 60 + 's')

            })
        },
        error: function (xhr, status, error) {
            //console.error(xhr);
        }
    })
}
$('#modal_lob_chip').on('click', function () {
    linename = $(this).attr('nameline')
    $.ajax({
        type: "POST",
        url: "php/sf-home.php",
        data: { action: 'get_modal_lob_chip', linename: linename },
        dataType: "text",
        success: function (response) {
            //console.log(response)
        },
        error: function (xhr, status, error) {
            console.error(xhr);
        }
    });
})
$('#modal_lob_inline').on('click', function () {
    linename = $(this).attr('nameline')
    $.ajax({
        type: "POST",
        url: "php/sf-home.php",
        data: { action: 'get_modal_lob_inline', linename: linename },
        dataType: "text",
        success: function (response) {
            //console.log(response)
        },
        error: function (xhr, status, error) {
            console.error(xhr);
        }
    });
})
var setreload;
$('#btn-Xac-nhan').on('click',async function () {
    $('#THSMD').removeClass();
    await load_line_selected()
    load_line_data()
    clearInterval(setreload);
    setreload = setInterval(function () {
        load_machine_data()
        load_line_data()
    }, 5000);
    load_machine_data();


});
$(document).ready(async function () {
    await load_line;
    await load_line_selected()
    setreload = setInterval(function () {
        load_machine_data()
        load_line_data()
    }, 5000);
    load_machine_data();
    load_line_data()
});