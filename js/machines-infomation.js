var header_title = "EM - Thông tin thiết bị"

$(document).ready(function () {

});
$('#changeInfo').on('change', function(){
    var _thead = ""
    switch($('#changeInfo').val()){
        case '1':
            _thead = '<thead>'+
            '<tr>'+
                '<th rowspan="2">Line</th>'+
                '<th rowspan="2">Machine</th>'+
                '<th rowspan="2">Asset</th>'+
                '<th rowspan="2">Model</th>'+
                '<th rowspan="2">Serial No.</th>'+
                '<th rowspan="2">Version MMI</th>'+
                '<th rowspan="2">Stencil size</th>'+
                '<th rowspan="2">Pass lane</th>'+
                '<th rowspan="2">Base block Height</th>'+
                '<th rowspan="2">SQZ size</th>'+
                '<th rowspan="2">Auto solder</th>'+
                '<th rowspan="2">Fix lane</th>'+
                '<th rowspan="2">Mfg Date</th>'+
                '<th rowspan="2">Marker</th>'+
                '<th colspan="7">PC</th>'+
                '<th rowspan="2">PCB size</th>'+
                '<th rowspan="2">Machine Size</th>'+
                '<th rowspan="2">Power</th>'+
            '</tr>'+
            '<tr>'+
                '<th>CPU</th>'+
                '<th>RAM</th>'+
                '<th>Disk Type</th>'+
                '<th>Windows Version</th>'+
                '<th>Service pack</th>'+
                '<th>IP</th>'+
                '<th>MAC</th>'+
            '</tr>'+
            '<thead></thead>';
            
            load_tab(_thead)
            break
        case '2':
            _thead = ''
            load_tab(_thead)
            break
        default:
            _thead = ''
            load_tab(_thead)
            break
    }
})

$('label.input-group-text').on('click', function(){
    if ($('#inputGroupFile02').get(0).files.length === 0) return//kiểm tra nếu chưa chọn file thì dừng lại
    var form_data = new FormData();
        //thêm files vào trong form data
        form_data.append('file', $('#inputGroupFile02').prop('files')[0]);
        form_data.append('phpOffice', 'import-infomation')
        form_data.append('machine', $('#changeInfo').val())
    $.ajax({
        type: "POST",
        url: "php/machines-infomation.php",
        data: form_data,
        dataType: "json",
        cache: false,
        contentType: false,
        processData: false,
        success: function (response) {
            console.log(response)
        },
        error: function(xhr, status, error) {
            console.error(xhr)
        }
        
    });
    $('#inputGroupFile02').val('')
    return false
})

function load_tab(_thead){
    $('#tabInfo').empty()
    $('#tabInfo').append(_thead);

    $.ajax({
        type: "POST",
        url: "php/machines-infomation.php",
        data: {load_machine: $('#changeInfo').val()},
        dataType: "json",
        success: function (_data) {
            tabInfo = $('#tabInfo').DataTable({
                data: _data,
                columns: [
                    {data: 'Line'},
                    {data: 'Machine'},
                    {data: 'Asset'},
                    {data: 'Model'},
                    {data: 'Serial'},
                    {data: 'Version MMI'},
                    {data: 'Stencil Size'},
                    {data: 'Pass Lane'},
                    {data: 'Base Block Height'},
                    {data: 'SQZ Size'},
                    {data: 'Auto Solder'},
                    {data: 'Fix Lane'},
                    {data: 'Mfg Date'},
                    {data: 'Maker'},
                    {data: 'CPU'},
                    {data: 'RAM'},
                    {data: 'Hard Type'},
                    {data: 'Windows'},
                    {data: 'Service Pack'},
                    {data: 'IP'},
                    {data: 'MAC'},
                    {data: 'PCB Size'},
                    {data: 'Machine Size'},
                    {data: 'Power'}
                ],
                columnDefs: [
                    {targets: "_all", className: "dt-center", width: "250px"}
                ]
            })
        },
        error: function(xhr, status, error) {
            console.error(xhr)
        }
    });
    
}