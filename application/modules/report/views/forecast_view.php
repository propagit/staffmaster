<div class="pull-right">
	<span id="last_updated_on"></span>
	&nbsp; 
	<button class="btn btn-core" id="run-forecase">Run Forecast</button>
</div>
<h2>Forecast</h2>
<p>This graph shows an estimated 3 month forecast for client invoicing, staff wages and expenses and a predicted profit.</p>
<div id="chart-forecast" style="height:300px;"></div>

<script>
$(function(){
	forecast_chart();
	$('#run-forecase').click(function(){
		preloading($('#chart-forecast'));
		$.ajax({
			type: "POST",
			url: "<?=base_url();?>report/ajax/run_forecast",
			success: function(html) {
				forecast_chart();
				loaded($('#run-forecase'));
			}
		})
	})
});
function forecast_chart() {
	$.ajax({
		type: "POST",
		url: "<?=base_url();?>report/ajax/load_forecast_data",
		data: {year: year},
		success: function(output) {
			var json = $.parseJSON(output);
			if (json.last_updated_on)
			{
				$('#last_updated_on').html('Last updated at ' + json.last_updated_on);
			}
			
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
			        categories: json.categories.split(','),
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
			        data: json.profits
			    }, {
			        name: 'Client Invoice',
			        data: json.invoices
			    }, {
			        name: 'Staff Pay',
			        data: json.pays
			    }, {
			        name: 'Expenses',
			        data: json.expenses
			    }]
			});
		}
	});
}
</script>