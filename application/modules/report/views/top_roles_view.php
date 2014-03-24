<? if (count($roles) == 0) { ?>
<div class="alert alert-warning">No data</div>
<? } else { ?>
<div id="chart-top-roles" style="height: 300px;"></div>
<script>
var chart = new Highcharts.Chart({
	chart: {
		renderTo: 'chart-top-roles',
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
            <? foreach($roles as $r) { echo $r . ','; } ?>
        ]
    }]
});
</script>
<? } ?>