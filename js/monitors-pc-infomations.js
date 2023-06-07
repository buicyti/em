var header_title = 'EM - Thông tin máy tính';
var list_line = ["HS_SMD001","HS_SMD002","HS_SMD003","HS_SMD004","HS_SMD005","HS_SMD006","HS_SMD007","HS_SMD008","HS_SMD009",
				"HS_SMD010","HS_SMD011","HS_SMD012","HS_SMD013","HS_SMD014","HS_SMD015","HS_SMD016","HS_SMD017","HS_SMD018",
				"HS_SMD019","HS_SMD020","HS_SMD021","HS_SMD022","HS_SMD023","HS_SMD024","HS_SMD025","HS_SMD026","HS_SMD027",
				"HS_SMD028","HS_SMD029","HS_SMD030","HS_SMD031","HS_SMD032",
				"HS_SMD033","HS_SMD034","HS_SMD035","HS_SMD036","HS_SMD037","HS_SMD038"];

var list_machine = ["DAT", "Printer 1", "Printer 2", "SPI", "MAOI", "NG MAOI", "Shield can", "Reflow", "SAOI","NG SAOI",
            	"Function Main", "Function 1", "Function 2", "Function 3", "Function 4", "Function 5", "Function 6", "Function DL", 
            	"Bonding","Multi mouter", "Chamber", "Router", "Laptop"];

$.each(list_line, function(key, line_name) {
	$('#list-line').append("<option value=" + line_name + ">" + line_name + "</option>");
});
$.each(list_machine, function(key, machine_name) {
	$('#list-machine').append("<option value=" + machine_name + ">" + machine_name + "</option>");
});



	$('#btn-Xac-nhan').on('click', function(){
		display_type = $('input[name=display_type]:checked').val();
		kt_ngang = $('input[name=kt-ngang]').val();
		kt_doc = $('input[name=kt-doc]').val();
		time_st_reload = $('input[name=time_st_reload]').val();
		line_selected = $('#list-line').val();
		machine_selected = $('#list-machine').val();
		var data;
		if (display_type == "line_type") data = list_machine;
		else if (display_type == "machine_type") data = list_line;
		//console.log(display_type);
		$.ajax({
            url: 'php/monitors-pc-infomations.php',
            type: 'post',
            data: {
            	data: data,
            	display_type : display_type,
            	kt_ngang: kt_ngang,
            	kt_doc: kt_doc,
            	time_st_reload: time_st_reload,
            	line_selected: line_selected,
            	machine_selected: machine_selected
            },
            success: function (data) {
                $('#PC-SMD').html(data)
            },
            error: function(xhr, status, error) {
                console.error(xhr);
            }
        });
	});
