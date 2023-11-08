
$(document).ready(function() {
    var dom = document.getElementById("transactions");
    var myChart = echarts.init(dom);
    var app = {};
    option = null;
    app.title = 'VENUS';

    option = {
       
        tooltip: {
            trigger: 'item',
            formatter: "{a} <br/>{b}: {c} ({d}%)"
        },
        color: ["#57BE65", "#ff1a1a", "#3EA4F1"],
        series: [
            {
                name:'Transactions',
                type:'pie',
                radius: ['50%', '70%'],
                avoidLabelOverlap: false,
                label: {
                    normal: {
                        show: false,
                        position: 'center'
                    },
                    emphasis: {
                        show: true,
                        textStyle: {
                            fontSize: '14',
                            fontWeight: 'bold'
                        }
                    }
                },
                labelLine: {
                    normal: {
                        show: false
                    }
                },
                data:[
                    {value:totalIncome, name:'Khoản thu'},
                    {value:totalExpenses, name:'Khoản chi'},
                    {value:totalSavings, name:'Tiết kiệm'}
                ]
            }
        ]
    };
    ;
    if (option && typeof option === "object") {
        myChart.setOption(option, true);
    }


    initMonthlyGraph();

});

function initMonthlyGraph(){
    var dom = document.getElementById("monthly");
    var myChart = echarts.init(dom);
    window.addEventListener('resize', function() {
        myChart.resize();
    });
    const monthsShort = {
        January: 'Jan',
        February: 'Feb',
        March: 'Mar',
        April: 'Apr',
        May: 'May',
        June: 'Jun',
        July: 'Jul',
        August: 'Aug',
        September: 'Sep',
        October: 'Oct',
        November: 'Nov',
        December: 'Dec'
      };
    
    var app = {};
    option = null;
    var xAxisData = [];
    var data1 = [];
    var data2 = [];
    for (var i = 1; i < 31; i++) {
        xAxisData.push(i + ' Jan');
        data2.push(Math.random());
        data1.push(Math.random() * -1);
    }
    labels = $.map(labels, function (val, key) {
        var split_month_label   = val.split(' ');
        var full_month    = split_month_label[1];
        var shortMonth = monthsShort[full_month];
        return split_month_label[0] + ' ' + shortMonth;
        
    });
    option = {
        responsive: true,
        maintainAspectRatio: false,
        height: '70%',
        width: '85%' ,
        legend: {
            data: [expense_title, income_title],
            align: 'left'
        },
        tooltip: {},
        xAxis: {
            axisLabel: {
                fontSize: 12
            },
            data: labels,
            silent: false,
            splitLine: {
                show: false
            },
        },
        yAxis: {
            axisLabel: {
                fontSize: 10
              },
        },
        series: [{
            name: expense_title,
            type: 'bar',
            stack: 'transactions',
            itemStyle: {
                normal: {
                    barBorderRadius: 50,
                    color: "#ff1a1a"
                }
            },
            data: expenses,
            animationDelay: function (idx) {
                return idx * 10;
            }
        }, {
            name: income_title,
            type: 'bar',
            stack: 'transactions',
            barMaxWidth: 10,
            itemStyle: {
                normal: {
                    barBorderRadius: 50,
                    color: "#13A54E"
                }
            },
            data: income,
            animationDelay: function (idx) {
                return idx * 10 + 100;
            }
        }],
        animationEasing: 'elasticOut',
        animationDelayUpdate: function (idx) {
            return idx * 5;
        }
    };
    if (option && typeof option === "object") {
        myChart.setOption(option, true);
    }
}

$(function () {
    var start = moment().subtract(29, 'days');
    var end = moment();

    function cb(start, end) {
        var months = {
            January: 'Tháng 1',
            February: 'Tháng 2',
            March: 'Tháng 3',
            April: 'Tháng 4',
            May: 'Tháng 5',
            June: 'Tháng 6',
            July: 'Tháng 7',
            August: 'Tháng 8',
            September: 'Tháng 9',
            October: 'Tháng 10',
            November: 'Tháng 11',
            December: 'Tháng 12'
          
        };
        // var start_month = start.format('MMMM');
        // var end_month   = end.format('MMMM');
        var start_month = months[start.format('MMMM')] + start.format(' D, YYYY');
        var end_month = months[end.format('MMMM')] + end.format(' D, YYYY');
        $('#reportrange span').html(start_month + ' - ' + end_month);
    }

    $('#reportrange').daterangepicker({
        startDate: start,
        endDate: end,
        locale: {
            "format": "DD/DD/YYYY",
             "separator": " - ",
            "applyLabel": "Apply",
            "cancelLabel": "Cancel",
            "fromLabel": "From",
            "toLabel": "To",
            "daysOfWeek": [
                "Su",
                "Mo",
                "Tu",
                "We",
                "Th",
                "Fr",
                "Sa"
            ],
            "monthNames": [
                "January",
                "February",
                "March",
                "April",
                "May",
                "June",
                "July",
                "August",
                "September",
                "October",
                "November",
                "December"
            ],
        },
        ranges: {
            'Today': [moment(), moment()],
            'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            'Last 7 Days': [moment().subtract(6, 'days'), moment()],
            'Last 30 Days': [moment().subtract(29, 'days'), moment()],
            'This Month': [moment().startOf('month'), moment().endOf('month')],
            'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        }
    }, cb);

    cb(start, end);
    $('*[data-range-key="Today"]').html(today);
    $('*[data-range-key="Yesterday"]').html(yesterday);
    $('*[data-range-key="Last 7 Days"]').html(last_7_days);
    $('*[data-range-key="Last 30 Days"]').html(last_30_days);
    $('*[data-range-key="This Month"]').html(this_month);
    $('*[data-range-key="Last Month"]').html(last_month);
    $('*[data-range-key="Custom Range"]').html(custom_range);

});



$('#reportrange').on('apply.daterangepicker', function(ev, picker) {
    $(".reports-title").text(eval(picker.chosenLabel.toLowerCase().split(' ').join('_')));
 
    $.ajax({
        url: reportsUrl,
        type: 'GET',
        data: {
            start_date: picker.startDate.format('YYYY-MM-DD'),
            end_date: picker.endDate.format('YYYY-MM-DD'),
        
        },
        success: function(response) {

            const dataObject = response.data;
            function formatCurrency(number) {
                return new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(number);
            }
            $(".reports-income").text(formatCurrency(response.data.income.total));
            $(".income-count").text(response.data.income.count+" Trns.");
            $(".reports-expenses").text(formatCurrency(response.data.expenses.total));
            $(".expenses-count").text(response.data.expenses.count+" Trns.");
        
            $(".top-expenses").hide();
            // if (response.data.expenses.top && Object.keys(response.data.expenses.top).length) {
            //     for (let expenseData of response.data.expenses.top) {
            //         $(".top-expenses").append('<tr><td>'+expenseData.expense.title+'</td><td class="text-right">'+expenseData.expense.amount+'</td></tr>');
            //     }
            // } else {
            //     $(".top-expenses").html("<tr><td class='text-center'>It's empty here!</td> </tr>");
            // }
            labels = response.data.chart.label;
            income = response.data.chart.income;
            expenses = response.data.chart.expenses;
            initMonthlyGraph(labels, income, expenses);
        },
        error: function(error) {
            console.error(error);
        }
    });
});




function reports(reports) {
    const dataObject = JSON.parse(reports.data.slice(8));
 
    $(".reports-income").text(dataObject.income.total);
    $(".income-count").text(dataObject.income.count+" Trns.");
    $(".reports-expenses").text(dataObject.expenses.total);
    $(".expenses-count").text(dataObject.expenses.count+" Trns.");

    $(".top-expenses").empty();
    if (Object.keys(dataObject.expenses.top).length) {
        for (let dataObject of dataObject.expenses.top) {
            $(".top-expenses").append('<tr><td>'+expense.title+'</td><td class="text-right">'+expense.amount+'</td></tr>');
        }
    }else{
        $(".top-expenses").html("<tr><td class='text-center'>It's empty here!</td> </tr>");
    }
    labels = dataObject.chart.label;
    income = dataObject.chart.income;
    expenses = dataObject.chart.expenses;
    initMonthlyGraph(labels, income, expenses);

}


// function reports(reports) {
//     const dataObject = JSON.parse(reports.data.slice(8));

//     const incomeTotal = dataObject.income.total;
//     const incomeCount = dataObject.income.count;
//     const expensesTotal = dataObject.expenses.total;
//     const expensesCount = dataObject.expenses.count;
//     const topExpenses = dataObject.expenses.top;

//     $(".reports-income").text(incomeTotal);
//     $(".income-count").text(`${incomeCount} Trns.`);
//     $(".reports-expenses").text(expensesTotal);
//     $(".expenses-count").text(`${expensesCount} Trns.`);

//     const topExpensesContainer = $(".top-expenses");
//     topExpensesContainer.empty();

//     if (topExpenses && topExpenses.length) {
//         for (let expense of topExpenses) {
//             topExpensesContainer.append(`<tr><td>${expense.title}</td><td class="text-right">${expense.amount}</td></tr>`);
//         }
//     } else {
//         topExpensesContainer.html("<tr><td class='text-center'>It's empty here!</td></tr>");
//     }

//     const labels = dataObject.chart.label;
//     const income = dataObject.chart.income;
//     const expenses = dataObject.chart.expenses;
//     initMonthlyGraph(labels, income, expenses);
// }

