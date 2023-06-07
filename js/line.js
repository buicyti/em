
let data1 = [{ "id": "Khu 1", "text": "Khu 1", "children":
[{ "id": "HS_SMD001", "text": "HS_SMD001" },
{ "id": "HS_SMD002", "text": "HS_SMD002" },
{ "id": "HS_SMD003", "text": "HS_SMD003" },
{ "id": "HS_SMD004", "text": "HS_SMD004" },
{ "id": "HS_SMD005", "text": "HS_SMD005" },
{ "id": "HS_SMD006", "text": "HS_SMD006" },
{ "id": "HS_SMD007", "text": "HS_SMD007" },
{ "id": "HS_SMD008", "text": "HS_SMD008" },
{ "id": "HS_SMD009", "text": "HS_SMD009" }]
},
{ "id": "Khu 2", "text": "Khu 2", "children":
[{ "id": "HS_SMD010", "text": "HS_SMD010" },
{ "id": "HS_SMD011", "text": "HS_SMD011" },
{ "id": "HS_SMD012", "text": "HS_SMD012" },
{ "id": "HS_SMD013", "text": "HS_SMD013" },
{ "id": "HS_SMD014", "text": "HS_SMD014" },
{ "id": "HS_SMD015", "text": "HS_SMD015" },
{ "id": "HS_SMD016", "text": "HS_SMD016" },
{ "id": "HS_SMD017", "text": "HS_SMD017" },
{ "id": "HS_SMD018", "text": "HS_SMD018" }]
},
{ "id": "Khu 3", "text": "Khu 3", "children":
[{ "id": "HS_SMD019", "text": "HS_SMD019" },
{ "id": "HS_SMD020", "text": "HS_SMD020" },
{ "id": "HS_SMD021", "text": "HS_SMD021" },
{ "id": "HS_SMD022", "text": "HS_SMD022" },
{ "id": "HS_SMD023", "text": "HS_SMD023" },
{ "id": "HS_SMD024", "text": "HS_SMD024" },
{ "id": "HS_SMD025", "text": "HS_SMD025" },
{ "id": "HS_SMD026", "text": "HS_SMD026" },
{ "id": "HS_SMD027", "text": "HS_SMD027" }]
},
{ "id": "Khu 4", "text": "Khu 4", "children":
[{ "id": "HS_SMDSVC", "text": "HS_SMDSVC" },
{ "id": "HS_SMD028", "text": "HS_SMD028" },
{ "id": "HS_SMD029", "text": "HS_SMD029" },
{ "id": "HS_SMD030", "text": "HS_SMD030" },
{ "id": "HS_SMD031", "text": "HS_SMD031" },
{ "id": "HS_SMD032", "text": "HS_SMD032" },
{ "id": "HS_SMD033", "text": "HS_SMD033" }]
},
{ "id": "Khu 5 (Interpose)", "text": "Khu 5 (Interpose)", "children":
[{ "id": "Interposer01", "text": "Interposer 01" },
{ "id": "Interposer02", "text": "Interposer 02" },
{ "id": "Interposer03", "text": "Interposer 03" },
{ "id": "Interposer04", "text": "Interposer 04" },
{ "id": "Interposer05", "text": "Interposer 05" },
{ "id": "Interposer06", "text": "Interposer 06" },
{ "id": "Interposer07", "text": "Interposer 07" },
{ "id": "Interposer08", "text": "Interposer 08" }]
}]

let dataMachine = ['Loader', 'Printer', 'Attach Carrier', 'P-AOI', 'NG P-AOI', 'Chip Mounter', 'M-AOI', 'NG M-AOI', 'Shieldcan', 'Reflow', 'Cooling', 'S-AOI', 'NG S-AOI', 'Detach Carrier', 'Magazine Buffer', 'Function', 'Bonding', 'Multi mounter', 'Chamber', 'Unloader' , 'Router', 'Shuttle', 'Khác']
let dataShift = ['A', 'C']
let dataGroup = ['MK', 'EGN']
let dataTinhtrang = ['OK', 'NG', 'Pending']

let dataLineEGN = ['All', 'SMD1', 'SMD2', 'Khác']
let dataMachineEGN = ['Nhiệt Độ Độ ẩm xưởng', 'Tủ LKĐT', 'Điều hoà Printer', 'GMES', 'Khác']