<h2>Forecast</h2>
<p>This graph shows an estimated 3 month forecast for client invoicing, staff wages and expenses and a predicted profit.</p>
<div id="chart-forecast" style="height:300px;"></div>

<script>
var chart_forecast = new Highcharts.Chart({
	chart: {
		renderTo: 'chart-forecast',
		type: 'area'
	},
    title: {
        text: ' '
    },
    subtitle: {
        text: ' '
    },
    xAxis: {
        categories: [<?=$categories;?>],
        tickmarkPlacement: 'on',
        title: {
            enabled: false
        }
    },
    yAxis: {
        title: {
            text: ' '
        },
        labels: {
            formatter: function() {
                return '$' + this.value;
            }
        }
    },
    tooltip: {
        shared: true,
        valuePrefix: '$'
    },
    plotOptions: {
        area: {
            stacking: 'normal',
            lineColor: '#666666',
            lineWidth: 1,
            marker: {
                lineWidth: 1,
                lineColor: '#666666'
            }
        }
    },
    credits: {
    	enabled: false  
    },
    series: [{
        name: 'Profit',
        data: [502, 635, 809, 947]
    }, {
        name: 'Client Invoice',
        data: [106, 107, 111, 133]
    }, {
        name: 'Staff Pay',
        data: [163, 203, 276, 408]
    }, {
        name: 'Expenses',
        data: [18, 31, 54, 156]
    }]
});
</script>