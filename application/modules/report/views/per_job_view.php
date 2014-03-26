<h2>Profit Per Campaign</h2>
<form id="load_job_profit_form">
<div class="form-group col-md-6 white-box">
	<?=modules::run('job/field_input', 'job_name');?>
</div>
<div class="col-md-2">
	<button type="button" class="btn btn-core" id="btn-load-job-profit">Get Data</button>
</div>
</form>
<div class="clearfix"></div>
<div id="chart-job-profit" style="height: 300px;"></div>

<script>
$(function(){
	$('#btn-load-job-profit').click(function(){
		load_job_profit();
	})
})
function load_job_profit() {
	preloading($('#chart-job-profit'));
	$.ajax({
		type: "POST",
		url: "<?=base_url();?>report/ajax/load_job_profit_data",
		data: $('#load_job_profit_form').serialize(),
		success: function(output) {
			
		}
	})
}
$(function(){
	$('#job-profit').highcharts({
        chart: {
            type: 'column'
        },
        title: {
            text: ''
        },
        subtitle: {
            text: ''
        },
        xAxis: {
            categories: ['Invoiced', 'Staff Wages', 'Profit', 'Expenses'],
            title: {
                text: null
            }
        },
        yAxis: {
            min: 0,
            title: {
                text: '',
                align: 'high'
            },
            labels: {
                overflow: 'justify'
            }
        },
        tooltip: {
            pointFormat: '<b>${point.y:.1f}</b>',
        },
        plotOptions: {
            bar: {
                dataLabels: {
                    enabled: true
                }
            }
        },
        legend: {
            enabled: false
        },
        credits: {
            enabled: false
        },
        series: [{
            name: '',
            data: [5640, 3580, 4000, 1210],
            colorByPoint: true
        }]
    });  
	
	
});
</script>