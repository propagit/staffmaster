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
		success: function(output) {
			var json = $.parseJSON(output);
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
			        categories: json.categories.split(',')
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
			                return '$' + this.value;
			            }
			        }
			    },
			    credits: {
			    	enabled: false  
			    },
			    tooltip: {
			        valuePrefix: '$'
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
			loaded($('#chart-financial-year'));
		}
	})
	
}
</script>