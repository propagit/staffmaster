<div class="pull-right col-lg-4">
	<?=modules::run('report/field_select_financial_year', 'financial_year');?>
</div>
<h2>Year To Date</h2>
<p>This graph shows your year to date, client invoicing shown in blue, wages and expenses shown in red and green showing the profit.</p>
<div id="chart-financial-year" style="height: 300px;">
</div>

<script>
$(function() {
	financial_year_chart();
	$('#financial_year').change(function(){
		financial_year_chart();
	})
})
function financial_year_chart() {
	year = $('#financial_year').val();
	preloading($('#chart-financial-year'));
	$.ajax({
		type: "POST",
		url: "<?=base_url();?>report/ajax/load_financial_year_data",
		data: {year: year},
		success: function(data) {
			data = $.parseJSON(data);
			var categories = data.categories.split(',');
			var chart = new Highcharts.Chart({
				chart: {
					renderTo: 'chart-financial-year'
				},
				title: {
			        text: '',
			        x: -20 //center
			    },
			    subtitle: {
			        text: '',
			        x: -20
			    },
			    xAxis: {
			        categories: categories
			    },
			    yAxis: {
			        title: {
			            text: ''
			        },
			        plotLines: [{
			            value: 0,
			            width: 1,
			            color: '#808080'
			        }],
			        labels: {
			            formatter: function() {
			                return '$' + this.value * 100;
			            }
			        }
			    },
			    credits: {
			    	enabled: false  
			    },
			    tooltip: {
			        valueSuffix: ''
			    },
			    series: [{
			        name: 'Profit',
			        data: [-1.0, -3.9, 9.5, 14.5, 18.2, 21.5, 25.2, 26.5, 23.3, 18.3, 13.9, 9.6]
			    }, {
			        name: 'Client Invoice',
			        data: [2, 2.8, 5.7, 11.3, 17.0, 22.0, 24.8, 24.1, 20.1, 14.1, 8.6, 2.5]
			    }, {
			        name: 'Staff Pay',
			        data: [3.9, 4.6, 3.5, 8.4, 13.5, 17.0, 18.6, 17.9, 14.3, 9.0, 3.9, 1.0]
			    }, {
			        name: 'Expenses',
			        data: [3.9, 4.2, 5.7, 8.5, 11.9, 15.2, 17.0, 16.6, 14.2, 10.3, 6.6, 4.8]
			    }]
			});
			loaded($('#chart-financial-year'));
		}
	})
	
}
</script>