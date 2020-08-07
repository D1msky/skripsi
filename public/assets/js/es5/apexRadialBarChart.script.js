'use strict';

$(document).ready(function () {
    // Basic Radial Bar Chart
    var options = {
        chart: {
            height: 200,
            type: 'radialBar'
        },
        plotOptions: {
            radialBar: {
                hollow: {
                    size: '70%'
                },
                dataLabels: {
                    showOn: 'always'
                }

            }
        },
        series: [70],
        labels: ['Cricket']

    };

    var chart = new ApexCharts(document.querySelector("#simpleRadialBar"), options);

    chart.render();

});