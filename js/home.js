
$.ajax({
    type: "POST",
    url: "php/home.php",
    dataType: "json",
    data: {get_data_TH : 'THxuong'},
    success: function (dulieu) {
        fchartbar("#THxuong", dulieu['line'], dulieu['temp'], dulieu['humi'], "BIỂU ĐỒ NHIỆT ĐỘ - ĐỘ ẨM LINE", 18, 28, 40, 60)
        fchartpie("#Txuong", dulieu['TOK'], dulieu['TNG'],"Tỉ lệ Nhiệt độ xưởng")
        fchartpie("#Hxuong", dulieu['HOK'], dulieu['HNG'], "Tỉ lệ Độ ẩm xưởng")
    },
    error: function(xhr, status, error) {
        console.error(xhr);
    }
});

$.ajax({
    type: "POST",
    url: "php/home.php",
    dataType: "json",
    data: {get_data_TH : 'THtuLKDT'},
    success: function (dulieu) {
        fchartbar("#THtuLKDT", dulieu['line'], dulieu['temp'], dulieu['humi'], "BIỂU ĐỒ NHIỆT ĐỘ - ĐỘ ẨM TỦ BẢO QUẢN LINH KIỆN ĐẮT TIỀN", 18, 28, 0, 10)
        fchartpie("#TtuLKDT", dulieu['TOK'], dulieu['TNG'],"Tỉ lệ Nhiệt độ tủ bảo quản linh kiện đắt tiền")
        fchartpie("#HtuLKDT", dulieu['HOK'], dulieu['HNG'], "Tỉ lệ Độ ẩm tủ bảo quản linh kiện đắt tiền")
    },
    error: function(xhr, status, error) {
        console.error(xhr);
    }
});

$.ajax({
    type: "POST",
    url: "php/home.php",
    dataType: "json",
    data: {get_data_TH : 'THreflow'},
    success: function (dulieu) {
        fchartbar("#THreflow", dulieu['line'], dulieu['temp'], dulieu['humi'], "BIỂU ĐỒ NHIỆT ĐỘ - ĐỘ ẨM ỐNG KHÍ THẢI REFLOW", 0, 70, 0, 20)
        fchartpie("#Treflow", dulieu['TOK'], dulieu['TNG'],"Tỉ lệ Nhiệt độ")
        fchartpie("#Hreflow", dulieu['HOK'], dulieu['HNG'], "Tỉ lệ Độ ẩm")
    },
    error: function(xhr, status, error) {
        console.error(xhr);
    }
});

$.ajax({
    type: "POST",
    url: "php/home.php",
    dataType: "json",
    data: {get_data_TH : 'VCprinter'},
    success: function (dulieu) {
        fchartVacuum(dulieu['line'], dulieu['M1'], dulieu['M2'])
        fchartpie("#VCprinter1", dulieu['OK'], dulieu['NG'],"Tỉ lệ Nhiệt độ")
    },
    error: function(xhr, status, error) {
        console.error(xhr);
    }
});



function fchartbar(barid, line, dataTemp, dataHumi, chartName, tMin, tMax, hMin, hMax){
    new Chart(
        $(barid),
        {
          type: "bar",
          data: {
          labels: line,
          datasets: [{
            label: "Nhiệt độ",
            yAxisID: "y",
            borderColor: "rgb(0, 99, 220)",
            backgroundColor: "rgb(0, 99, 220)",
            borderWidth: 2,
            radius: 10,
            data: dataTemp,
            tension: 0.4,
            datalabels: {
                align: function(context) {
                    var value = context.dataset.data[context.dataIndex];
                    return value > 0 ? "end" : "start";
                },
                anchor: function(context) {
                    var value = context.dataset.data[context.dataIndex];
                    return value > 0 ? "end" : "start";
                },
                color: function(ctx){
                    // use the same color as the border
                    if(ctx.dataset.data[ctx.dataIndex] > tMin && ctx.dataset.data[ctx.dataIndex] < tMax) return "#17a029";
                    else return "#e65252";
                },
                formatter: function(value){
                    return value + "°C";
                }
            }
          },{
            label: "Độ ẩm",
            yAxisID: "y1",
            borderColor: "rgb(255, 150, 132)",
            backgroundColor: "rgb(255, 150, 132)",
            borderWidth: 2,
            radius: 10,
            data: dataHumi,
            tension: 0.4,
            datalabels: {
                align: function(context) {
                    var value = context.dataset.data[context.dataIndex];
                    return value > 0 ? "end" : "start";
                },
                anchor: function(context) {
                    var value = context.dataset.data[context.dataIndex];
                    return value > 0 ? "end" : "start";
                },
                color: function(ctx){
                    // use the same color as the border
                    if(ctx.dataset.data[ctx.dataIndex] >= hMin && ctx.dataset.data[ctx.dataIndex] < hMax) return "#17a029";
                    else return "#e65252";
                },
                formatter: function(value){
                    return value + " %";
                }
            }
    
          }],
        },
        plugins: [ChartDataLabels],
        options: {
            scales: {
                x: {
                    ticks: { display: true, font: {family: "Times New Roman", size: 14,  weight: "italic", }, /* maxTicksLimit: 20 */ },
                    title: { display: true, font: {family: "Times New Roman", size: 18,  weight: "Bold", }, text: chartName },
                    //grid: { display: false}
                },
                y: {
                    type: "linear", display: true, position: "left", min: 0, max: 120,
                    ticks: { color: "rgb(0, 99, 220)", stepSize: 10 },
                    title: { display: true, text: "Nhiệt độ (°C)", font: { family: "Times New Roman", size: 11}, color: "rgb(0, 99, 220)" }
                },
                y1: {
                    type: "linear", display: true, position: "right", min: 0, max: 100,
                    ticks: { color: "rgb(255, 150, 132)", stepSize: 10 },
                    // grid line settings
                    grid: { drawOnChartArea: false},
                    title: { display: true, text: "Độ ẩm (%)", font: { family: "Times New Roman", size: 11 }, color: "rgb(255, 150, 132)" }
                },
            },
            interaction: {
              intersect: false,
              mode: "index",
            },
            
        }
    }
    );
    
}


function fchartpie(pieid, TOK, TNG, pieName){
     new Chart($(pieid), {
        type: "pie",
        data: {
        labels: ["OK", "NG"],
            datasets: [{ data: [TOK, TNG], backgroundColor: [ "#17a029", "#e65252" ], borderColor: "#fff" }]
        },
        plugins: [ChartDataLabels],
        options: {
            tooltips: { enabled: true },
            scales: { x: { ticks: { display: false, font: {family: "Times New Roman", size: 14,  weight: "italic"}}, title: { display: true, text: pieName },grid: { display: false} }},
            plugins: {
                legend:false,
                datalabels: {
                formatter: (value, ctx) => {
                    let datasets = ctx.chart.data.datasets;
            
                    if (datasets.indexOf(ctx.dataset) === datasets.length - 1) {
                    let sum = datasets[0].data.reduce((a, b) => a + b, 0);
                    let percentage = Math.round((value / sum) * 100) + "%";
                    return ctx.chart.data.labels[ctx.dataIndex] + ": " + percentage;
                    } else {
                    return ctx.chart.data.labels[ctx.dataIndex] + ": " + percentage;
                    }
                },
                color: "#fff"
                }
            }
        }
    });
}

function fchartVacuum(line, M1, M2){
   new Chart(
        $("#VCprinter"),
        {
          type: "bar",
          data: {
          labels: line,
          datasets: [{
            label: "Máy 1",
            //yAxisID: "y",
            borderColor: "rgb(0, 99, 220)",
            backgroundColor: "rgb(0, 99, 220)",
            borderWidth: 2,
            radius: 10,
            data: M1,
            tension: 0.4,
            datalabels: {
                align: function(context) {
                    var value = context.dataset.data[context.dataIndex];
                    return value > 0 ? "end" : "start";
                },
                anchor: function(context) {
                    var value = context.dataset.data[context.dataIndex];
                    return value > 0 ? "end" : "start";
                },
                color: function(ctx){
                    // use the same color as the border
                    if(ctx.dataset.data[ctx.dataIndex] > 14 && ctx.dataset.data[ctx.dataIndex] < 25) return "#17a029";
                    else return "#e65252";
                },
                formatter: function(value){
                    return value + " m/s";
                }
            }
          },{
            label: "Máy 2",
            //yAxisID: "y1",
            borderColor: "rgb(255, 255, 132)",
            backgroundColor: "rgb(255, 255, 132)",
            borderWidth: 2,
            radius: 10,
            data: M2,
            tension: 0.4,
            datalabels: {
                align: function(context) {
                    var value = context.dataset.data[context.dataIndex];
                    return value > 0 ? "end" : "start";
                },
                anchor: function(context) {
                    var value = context.dataset.data[context.dataIndex];
                    return value > 0 ? "end" : "start";
                },
                color: function(ctx){
                    // use the same color as the border
                    if(ctx.dataset.data[ctx.dataIndex] > 14 && ctx.dataset.data[ctx.dataIndex] < 25) return "#17a029";
                    else return "#e65252";
                },
                formatter: function(value){
                    return value + " m/s";
                }
            }

          }],
        },
        plugins: [ChartDataLabels],
        options: {
            scales: {
                x: {
                    ticks: {
                      display: true,
                      font: {family: "Times New Roman", size: 14,  weight: "italic", },
                      //maxTicksLimit: 20
                    },
                    title: {
                      display: true,
                      font: {family: "Times New Roman", size: 18,  weight: "Bold", },
                      text: "BIỂU ĐỒ LỰC HÚT VACUUM TABLE"
                    },
                    //grid: { display: false}
                },
                y: {
                    type: "linear",
                    display: true,
                    position: "left",
                    min: 0,
                    max: 50,
                    ticks: {
                      color: "rgb(0, 99, 220)",
                      stepSize: 5
                    },
                    title: {
                      display: true,
                      text: "Vacuum (m/s)",
                      font: { family: "Times New Roman", size: 11},
                      color: "rgb(0, 99, 220)"
                    }
                },
            },
            interaction: {
              intersect: false,
              mode: "index",
            },
            
        }
    }
  );
}

 

/* $(document).ready(function () {
    setInterval( function() {
        var tet = new Date("Jan 21,2023 24:00:00").getTime();
        var now = new Date().getTime();
        var timeRest = tet - now;
                //Số s còn lại để đến tết;
                var day = Math.floor(timeRest/(1000*60*60*24));
                //Số ngày còn lại
                var hours = Math.floor(timeRest%(1000*60*60*24)/(1000*60*60));
                // Số giờ còn lại
                var minute = Math.floor(timeRest%(1000*60*60)/(1000*60));
                // Số phút còn lại
                var sec = Math.floor(timeRest%(1000*60)/(1000));

                $('#days').html(day)
                $('#hours').html(hours)
                $('#mins').html(minute)
                $('#secs').html(sec)
    }, 1000)
});

new bootstrap.Modal(document.getElementById('exampleModal'), {
    keyboard: false
  }).show(); */
 