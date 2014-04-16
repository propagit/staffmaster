<? if (count($clients) == 0) { ?>
<div class="alert alert-warning">No data</div>
<? } else { ?>
<div id="chart-top-clients" style="height: 300px;"></div>
<script>
var chart = new Highcharts.Chart({
	chart: {
		renderTo: 'chart-top-clients',
        plotBackgroundColor: null,
        plotBorderWidth: 0,
        plotShadow: false
    },
    title: {
        text: '',
        align: 'center',
        verticalAlign: 'middle',
        y: 50
    },
    tooltip: {
        pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
    },
    plotOptions: {
        pie: {
            shadow: false,
            center: ['50%', '50%']
        }
    },
    credits: {
    	enabled: false  
    },
    series: [{
        type: 'pie',
        name: 'Browser share',
        innerSize: '50%',
        data: [
            <? foreach($clients as $c) { echo $c . ','; } ?>
        ]
    }]
});
</script>
<? } ?>