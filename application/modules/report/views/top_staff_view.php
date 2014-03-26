<div class="pull-right col-lg-4">
	<?=modules::run('report/field_select_year', 'staff_year');?><br /><br />
	<?=modules::run('report/field_select_month', 'staff_month');?>
</div>
<h2>Who's Working</h2>
<p>This graph shows you the staff who have worked the most by month or year. Rollover the bar to get more details.</p>
<div id="chart-top-staff" style="height: 400px;"></div>

<script>
$(function(){
	$('#staff_year').change(function(){
		top_staff_chart();
	});
	$('#staff_month').change(function(){
		top_staff_chart();
	});
	top_staff_chart();
})
function top_staff_chart() {
	var year = $('#staff_year').val();
	var month = $('#staff_month').val();
	preloading($('#chart-top-staff'));
	$.ajax({
		type: "POST",
		url: "<?=base_url();?>report/ajax/load_top_staff_data",
		data: {year: year, month: month},
		success: function(output) {
			var json = $.parseJSON(output);
			var chart = new Highcharts.Chart({
				chart: {
		        	renderTo: 'chart-top-staff',
		            type: 'column',
		            margin: [ 50, 50, 100, 80]
		        },
		        title: {
		            text: ''
		        },
		        xAxis: {
		            categories: json.names.split(','),
		            labels: {
		                rotation: -45,
		                align: 'right',
		                style: {
		                    fontSize: '13px',
		                    fontFamily: 'Verdana, sans-serif'
		                }
		            }
		        },
		        yAxis: {
		            title: {
		                text: ''
		            }
		        },
		        legend: {
		            enabled: false
		        },
		        plotOptions: {
                    series: {
                        borderWidth: 0,
                        dataLabels: {
                            enabled: true,
                            format: '{point.y} hours'
                        }
                    }
                },
		        tooltip: {
		            pointFormat: '<b>{point.y:.1f} hours</b>',
		        },
		        credits: {
			    	enabled: false  
		        },
		        colors: [
			        '#8bbc21',
			    ],
		        series: [{
		            name: '',
		            data: json.minutes
		        }]				
			});
			loaded($('#chart-top-staff'));
		}
	})
}
</script>