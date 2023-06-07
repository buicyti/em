
var header_title = 'EM - Checklist Strap';

$(document).ready(function(){
    load_data();
    
});

function getDaysInMonth(month, year) {
    var date = new Date(year, month - 1, 1);
    var days = [];
    while (date.getMonth() === month - 1) {
      days.push(new Date(date));
      date.setDate(date.getDate() + 1);
    }
    return days;
  }
function load_data(){
    
    select_checklist = $('#checklist-select').val();
    select_month = $('input[name="select-month"]').val();
    select_year = $('input[name="select-year"]').val();
    
    $.ajax({
        type: "post",
        url: "php/checklist-view.php",
        data: { 
            checklist_selected: select_checklist,
            month_selected: select_month,
            year_selected: select_year
        },
        dataType: "json",
        success: function (data) {
            //console.log(data)
            
            columns = [ {
                title: "STT",
                render: function (data, type, row, meta) {
                    return meta.row + 1; }// This contains the row index
                },
                {data: 'id_emp', title: 'Mã NV'},
                {data: 'name_emp', title: 'Tên nhân viên'},
                {data: 'nhom', title: 'Nhóm'},
                {data: 'ca_kip', title: 'Ca'}
            ]
            
            $('#example').append('<tfoot><tr><th>No</th><th>ID</th><th>Name</th><th>Group</th><th>Shift</th></tr></tfoot>')

            $.each(getDaysInMonth(select_month, select_year), function (indexInArray, valueOfElement) { 
                var clsTable = (valueOfElement.toLocaleString('en-US', {weekday: 'short'}) === 'Sun' || valueOfElement.toLocaleString('en-US', {weekday: 'short'}) === 'Sat' ? 'dt-center cuoituan' : 'dt-center') 
                var dayTable = (valueOfElement.getDate() < 10 ? '0' : '') + valueOfElement.getDate()
                
                columns.push({
                    data: 'd' + dayTable,
                    title: dayTable,
                    className: clsTable,
                    render: function ( data, type, row ){
                        if(data == "OK") data = '<span class="text-primary">'+ data +'</span>'
                        else if(data == "NG") data = '<span class="text-danger">'+ data +'</span>'
                        return data
                    }
                })
                $('#example tfoot tr').append('<th>'+ valueOfElement.toLocaleString('vi-VN', {weekday: 'short'}) +'</th>')
            });

            
            tablea = $('#example').DataTable({
                data: data,
                columns: columns,
                columnDefs: [
                    {
                        targets: "_all",
                        className: "dt-center",
                        defaultContent: "-"
                    },{
                        targets: 1,
                        width: "70px"
                    },{
                        targets: 2,
                        width: "150px"
                    },{
                        "targets": 3,
                        "visible": ($('#showGroup').is(':checked') ? true: false)
                    },{
                        "targets": 4,
                        "visible": ($('#showShift').is(':checked') ? true: false)
                    }
                ],
                fixedColumns: {
                    left: 3
                },
                dom: 'Bfrtip',//tìm kiếm
                initComplete: function () {
                    this.api()
                        .columns()
                        .every(function () {
                            var column = this;
                            var select = $('<select><option value=""></option></select>')
                                .appendTo($(column.footer()).empty())
                                .on('change', function () {
                                    var val = $.fn.dataTable.util.escapeRegex($(this).val());
         
                                    column.search(val ? '^' + val + '$' : '', true, false).draw();
                                });
         
                            column
                                .data()
                                .unique()
                                .sort()
                                .each(function (d, j) {
                                    select.append('<option value="' + d + '">' + d + '</option>');
                                });
                        });
                },
                language: {
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
                scrollX: true,
                processing: true, // tiền xử lý trước
                aLengthMenu: [[10, 20, 50, -1], [10, 20, 50, 'All']], // danh sách số trang trên 1 lần hiển thị bảng
                order: [[0, 'asc']] //sắp xếp giảm dần theo cột thứ 1
            })
            
        },
        error: function(xhr, status, error) {
            console.error(xhr);
        }
    });
}
$('input[name="select-month"], input[name="select-year"], #checklist-select').change(function(){
    tablea.destroy()
    $('#example').empty()
    load_data()
  });

$('#showGroup').change(function() {
    tablea.columns(3).visible($(this).is(':checked'))
});

$('#showShift').change(function() {
    tablea.columns(4).visible($(this).is(':checked'))
})
