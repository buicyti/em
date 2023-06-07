var header_title = 'EM - Theo dõi Vacuum Chip Mouter';

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
                    this.values = ['Khu 1'] ;
                    this.disables = ['Khu2', 'Khu3', 'Khu4', 'Khu5'];
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
                this.values = ['Khu 1'] ;
                this.disables = ['Khu2', 'Khu3', 'Khu4', 'Khu5'];
                $('.select-line .treejs ul li ul li').addClass('treejs-node__close');
            },
            onChange: function () {
                data_line = this.values;
            }
        }) */


    var timereload = 10 * 60 * 1000;  
    var setreload;
    var setAlertify;
    //hàm lấy thông tin line
    function load_lineselected(){
        $.ajax({
            type: "post",
            url: "php/monitors-chip.php",
            data: {line_selected: dataLine},
            dataType: "json",
            success: function (data) {
                current_time = data['Current time']
                delete data['Current time']
                $.each(data, function(key, val){
                    Lastmodify = val['Lastmodify']
                    delete val['Lastmodify']

                    if (Date.parse(current_time) - Date.parse(Lastmodify) > 300000) timr = 'text-danger'
                    else timr = 'text-success'
                    //hiện ra trạng thái kết nối của line
                    $('#line' + key + ' .card .card-header b').removeClass('text-secondary text-danger text-success').addClass(timr)
                    $.each(val, function(handkey, handval){
                        handkey = handkey.substr(-1, 1) - 1
                        if(handval == "OK"){
                            $('#line' + key + ' .card .card-body .row .border:eq('+ handkey +')').removeClass('bg-secondary bg-success bg-danger').addClass('bg-success')
                            //$('#line' + key + ' .card .card-body .row .col:eq('+ handkey +')').html('OK')
                        }
                        else if(handval == "NG"){
                            $('#line' + key + ' .card .card-body .row .border:eq('+ handkey +')').removeClass('bg-secondary bg-success bg-danger').addClass('bg-danger')
                            //$('#line' + key + ' .card .card-body .row .col:eq('+ handkey +')').html('NG')
                        }
                        else{
                            $('#line' + key + ' .card .card-body .row .border:eq('+ handkey +')').removeClass('bg-secondary bg-success bg-danger').addClass('d-none')
                        }
                    })
                })
                
            },
            error: function(xhr, status, error) {
                console.error(xhr);
            }
        });
    }
    function loadhtml() {
        $('#THSMD').empty();
        idChart = []
        if (dataLine.length > 0) {
                $.each(dataLine, function (key, line) {
                    $('#THSMD').append('<div class="col" id="line' + line + '" style="font-size: ' + 54 / swap_horizontal + 'px;">' +
                        '<div class="card mb-2 bg-light" style="max-height: 600px;">' +
                        '<div class="card-header"><b class="text-secondary">' + line + '</b></div>' +
                        '<div class="card-body">' +
                        
                        '<div class="row justify-content-center row-cols-md-4 row-cols-lg-5 row-cols-xl-6">'+
                        '<div class="col-xl-2 col-md-4 col-lg-3 p-2 text-center border bg-secondary">M1</div>'+
                        '<div class="col-xl-2 col-md-4 col-lg-3 p-2 text-center border bg-secondary">M2</div>'+
                        '<div class="col-xl-2 col-md-4 col-lg-3 p-2 text-center border bg-secondary">M3</div>'+
                        '<div class="col-xl-2 col-md-4 col-lg-3 p-2 text-center border bg-secondary">M4</div>'+
                        '<div class="col-xl-2 col-md-4 col-lg-3 p-2 text-center border bg-secondary">M5</div>'+
                        '<div class="col-xl-2 col-md-4 col-lg-3 p-2 text-center border bg-secondary">M6</div>'+
                        '</div>'+

                        '</div>' +
                        '</div>' +
                        '</div>')
    
                })
        
        }
        else $('#THSMD').append('<div class="fw-bold d-flex justify-content-around align-items-center fs-1 text-uppercase" style="width: 100%; height: calc(100vh - 6rem)">Hãy chọn ít nhất 1 line</div>')
    }

    $('#btn-Xac-nhan').on('click',function(){
        swap_horizontal = $('input[name="kt-ngang"]').val();
        timereload = $('input[name="time_st_reload"]').val() * 60 * 1000;
        loadhtml();
        clearInterval(setreload);
        setreload = setInterval(function(){load_lineselected()}, timereload );
        load_lineselected()
    });
    $(document).ready(async function () {
        await load_line;
        swap_horizontal = $('input[name="kt-ngang"]').val();
        timereload = $('input[name="time_st_reload"]').val() * 60 * 1000;
        loadhtml();
        setreload = setInterval(function(){load_lineselected()}, timereload );
        load_lineselected()
    });