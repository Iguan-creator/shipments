let options = {
    chart: {
        height: 200,
        type: 'pie',
    },
    colors:['#45E676', '#F44336'],
    series: [304, 17],
    labels: ['В срок', 'Не в срок'],
    legend: {
        show: true,
        position: 'left',
        horizontalAlign: 'center',
        verticalAlign: 'middle',
        floating: false,
        fontSize: '14px',
        offsetX: 0,
        offsetY: 0
    },
    responsive: [{
        breakpoint: 600,
        options: {
            chart: {
                height: 240
            },
            legend: {
                show: false
            },
        }
    }]

}

let chart = new ApexCharts(
    document.querySelector("#apex-pie-1"),
    options
);

chart.render();
