var header_title = 'EM - Theo dõi nhiệt độ ống khí thải';
var dataLine = 'qq'
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


async function load_html() {
    await
        $('#THSMD').empty();
    await
        $.ajax({
            type: "POST",
            url: "php/monitors-reflow.php",
            dataType: "json",
            data: { line_selected: dataLine, action: 'html' },
            //cache: false,
            success: function (data) {
                //console.log(Object.keys(data).length + data_line)

                //delete data['Current time']

                if (Object.keys(data).length > 0) {
                    jQuery.each(data, function (line, val) {
                        $('#THSMD').append('<div class="col" id="line' + line + '">' +
                            '<div class="card border-light mb-3" style="max-height: 600px;">' +
                            '<div class="card-header">' +
                            '<b class="text-secondary">' + line + '</b>' +
                            '</div>' +
                            '<div class="card-body bgReflow">' +
                            '<div class="thrf_t">' +
                            '<span class="thrf_l"></span>' +
                            '<span class="thrf_r">' + $.trim(val["Maker"]) + '<br/>' + $.trim(val["Model"]) + '</span>' +
                            '</div>' +
                            '<div class="thrf_b"></div>' +
                            '</div>' +
                            '</div>' +
                            '</div>')
                    })
                }
                else $('#THSMD').append('<div class="fw-bold d-flex justify-content-around align-items-center fs-1 text-uppercase" style="width: 100%; height: calc(100vh - 6rem)">Không có dữ liệu</div>')
            },
            error: function (xhr, status, error) {
                //console.error(xhr);
                $('#THSMD').append('<div class="fw-bold d-flex justify-content-around align-items-center fs-1 text-uppercase" style="width: 100%; height: calc(100vh - 6rem)">Hãy chọn ít nhất 1 line</div>')
            }
        });
}


function load_line_selected() {
    $.ajax({
        type: "POST",
        url: "php/monitors-reflow.php",
        dataType: "json",
        data: { line_selected: dataLine, action: 'data' },
        //cache: false,
        success: function (data) {
            //console.log(data)
            thalert = [];
            key = 0;
            current_time = data['Current time']
            delete data['Current time']
            jQuery.each(data, function (line, val) {
                a = '';
                if (Date.parse(current_time) - Date.parse(val["thoi_gian"]) > 30000) {
                    a += 'Mất kết nối từ ' + val["thoi_gian"] + '<br/>'
                    val["thoi_gian"] = 'text-danger'
                    if (val["HC2Connect"] == 2) val["HC2Connect"] = ''
                    else val["HC2Connect"] = '<span class="text-danger">HC2 mất kết nối</span>'
                } else {
                    val["thoi_gian"] = 'text-success'
                    if (val["HC2Connect"] == 0) val["HC2Connect"] = '<span class="text-danger">HC2 mất kết nối</span>'
                    else if (val["HC2Connect"] == 1) val["HC2Connect"] = '<span class="text-success">HC2 đang kết nối</span>'
                    else if (val["HC2Connect"] == 2) val["HC2Connect"] = ''
                }
                if (val["Temp"] >= 0 && val["Temp"] <= 70) val["Temp"] = '<span class="text-success">' + val["Temp"] + '°C</span>'
                else {
                    a += 'Nhiệt độ nằm ngoài phạm vi quy định: ' + val["Temp"] + '°C<br/>'
                    val["Temp"] = '<span class="text-danger">' + val["Temp"] + '°C</span>'
                }
                if (val["Humi"] >= 0 && val["Humi"] <= 20) val["Humi"] = '<span class="text-success">' + val["Humi"] + '%</span>'
                else {
                    a += 'Độ ẩm nằm ngoài phạm vi quy định: ' + val["Humi"] + '%<br/>'
                    val["Humi"] = '<span class="text-danger">' + val["Humi"] + '%</span>'
                }

                if (a.length > 10) {
                    thalert[key] = line + '|' + a
                    key++
                }
                //tải dữ liệu
                $('#line' + line + ' .card .card-header b').removeClass('text-secondary text-danger text-success').addClass(val["thoi_gian"])
                $('#line' + line + ' .card .card-body .thrf_t .thrf_l').html(val["Temp"] + '<br/>' + val["Humi"])
                $('#line' + line + ' .card .card-body .thrf_b').html(val["HC2Connect"])
            })


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
            al = val.split("|")
            alertify.error('<b>' + al[0] + '</b><br/>' + al[1], 5);
        }, time * 1000);
        time++;
    });
};


var setreload;
var setAlertify;
$('#btn-Xac-nhan').on('click',async function () {
    swap_horizontal = $('input[name="kt-ngang"]').val();
    $('.thrf_t').css('font-size: ' + 48 / swap_horizontal + 'px')
    $('#THSMD').removeClass();
    $('#THSMD').addClass('row row-cols-' + swap_horizontal);
    clearInterval(setreload);

    await load_line;
    await load_html();
    load_line_selected();
    setreload = setInterval(function () { load_line_selected(); }, 10000);

    clearInterval(setAlertify);
    setAlertify = setInterval(function () { load_alertify(); }, 60 * 1000);
    load_alertify();
});
$(document).ready(async function () {
    await load_line;
    await load_html();
    load_line_selected();
    setreload = setInterval(function () { load_line_selected(); }, 10000);
});