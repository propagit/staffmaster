<!--begin top box--->
<div class="col-md-12">
	<div class="box top-box">
		<h2>Accounts Reports</h2>
		<p>Welcome to your Staff Account dashboard. Your Dashboard will give you a quick overview of activity going on within [COMPANY PROFILE NAME]. Check back regularly to keep yourself up to date.</p>
	</div>
</div>
<!--end top box-->

<!-- begin bottom box with 2 separate boxes -->
<div class="col-md-12">
	<div class="box bottom-box">
    	
    	<div class="col-md-6 white-box">
            <div class="inner-box">
            	<div class="pull-right col-lg-4">
            		<?=modules::run('report/field_select_financial_year', 'financial_year');?>
            	</div>
                <h2>Year To Date</h2>
                <p>This graph shows your year to date, client invoicing shown in blue, wages and expenses shown in red and green showing the profit.</p>
                <div id="chart-cashflow" style="height: 300px;">
                </div>              

                
            </div>
        </div>
        
        <div class="col-md-6 white-box">
            <div class="inner-box">
                <h2>Forecast</h2>
                <p>This graph shows an estimated 3 month forecast for client invoicing, staff wages and expenses and a predicted profit.</p>
                <div id="chart-forecast" style="height:300px;"></div>
                
            </div>
        </div>
        
	</div>
	
	<div class="box bottom-box">
    	
    	<div class="col-md-6 white-box">
            <div class="inner-box">
                <h2>Top 10 Clients</h2>
                <p>This graph shows you the top 10 clients based on customer<br />spend from generated invoices for the time period chosen.</p>
                <div class="row">
                	<div class="col-md-4 white-box">
                		<?=modules::run('report/field_select_year', 'year');?><br /><br />
                		<?=modules::run('report/field_select_month', 'month');?>
                	</div>
                	<div class="col-md-8">
	                	<div id="top-clients" style="height: 300px;"></div>
                	</div>
                </div>
                

                
            </div>
        </div>
        
        <div class="col-md-6 white-box">
            <div class="inner-box">
                <h2>Top 10 Roles</h2>
                <p>This graph shows you the top 10 roles based on generated<br />time sheets for the time period chosen.</p>
                
                <div class="row">
                	<div class="col-md-4 white-box">
                		<?=modules::run('report/field_select_year', 'year');?><br /><br />
                		<?=modules::run('report/field_select_month', 'month');?>
                	</div>
                	<div class="col-md-8">
	                	<div id="top-roles" style="height: 300px;"></div>
                	</div>
                </div>
            </div>
        </div>        
	</div>
	
	<div class="box bottom-box">
    	
    	<div class="col-md-6 white-box">
            <div class="inner-box">
            	<div class="pull-right col-lg-4">
            		<?=modules::run('report/field_select_week_month', 'week_month');?>
            	</div>
                <h2>Who's Working</h2>
                <p>This graph shows you the staff who have worked the most this week or this month. Rollover the bar to get more details.</p>
                <div id="staff-working" style="height: 300px;"></div>
                

                
            </div>
        </div>
        
        <div class="col-md-6 white-box">
            <div class="inner-box">
                <h2>Profit Per Campaign</h2>
				<div class="form-group col-md-6 white-box">
					<input type="email" class="form-control" placeholder="Enter job name">
				</div>
				<div class="col-md-2">
					<button type="submit" class="btn btn-core">Get Data</button>
				</div>
                <div class="clearfix"></div>
                <div id="job-profit" style="height: 300px;"></div>
            </div>
        </div>        
	</div>
</div>
<!-- end bottom box with 2 separate boxes -->

<script>
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

	$('#staff-working').highcharts({
        chart: {
            type: 'column',
            margin: [ 50, 50, 100, 80]
        },
        title: {
            text: ''
        },
        xAxis: {
            categories: [
                'Pro Gate',
                'Thomas Edison',
                'Fiona Harris',
                'Brian Hudson',
                'Lily Clipton',
                'Luke Smith',
                'Rio Chris',
                'Susie Howie',
                'Richard Gerald',
                'William Tent'
            ],
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
            min: 0,
            title: {
                text: ''
            }
        },
        legend: {
            enabled: false
        },
        tooltip: {
            pointFormat: '<b>{point.y:.1f} hours</b>',
        },
        credits: {
	    	enabled: false  
        },
        series: [{
            name: '',
            data: [36.4, 35.8, 32.1, 30, 24.6, 22.5, 19.1, 18.4, 18, 17.3],
            dataLabels: {
                enabled: true,
                rotation: -90,
                color: '#FFFFFF',
                align: 'right',
                x: 4,
                y: 10,
                style: {
                    fontSize: '13px',
                    fontFamily: 'Verdana, sans-serif',
                    textShadow: '0 0 3px black'
                }
            }
        }]
    });
	$('#top-clients').highcharts({
        chart: {
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
                ['Propagate',   45.0],
                ['Samsung',       26.8],
                ['Apple', 12.8],
                ['Nike',    8.5],
                ['Adidas',     6.2]
            ]
        }]
    });
    $('#top-roles').highcharts({
        chart: {
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
                ['Developer',   25.0],
                ['Sale',       26.8],
                ['Marketer', 22.8],
                ['Chef',    8.5],
                ['Manager',     16.2]
            ]
        }]
    });   
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
            categories: ['1750', '1800', '1850', '1900', '1950', '1999', '2050'],
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
                    return this.value / 1000;
                }
            }
        },
        tooltip: {
            shared: true,
            valueSuffix: ''
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
            data: [502, 635, 809, 947, 1402, 3634, 5268]
        }, {
            name: 'Client Invoice',
            data: [106, 107, 111, 133, 221, 767, 1766]
        }, {
            name: 'Staff Pay',
            data: [163, 203, 276, 408, 547, 729, 628]
        }, {
            name: 'Expenses',
            data: [18, 31, 54, 156, 339, 818, 1201]
        }]
    });
	var chart = new Highcharts.Chart({
		chart: {
			renderTo: 'chart-cashflow'
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
            categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun',
                'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
        },
        yAxis: {
            title: {
                text: ''
            },
            plotLines: [{
                value: 0,
                width: 1,
                color: '#808080'
            }]
        },
        credits: {
	    	enabled: false  
        },
        tooltip: {
            valueSuffix: ''
        },
        series: [{
            name: 'Profit',
            data: [7.0, 6.9, 9.5, 14.5, 18.2, 21.5, 25.2, 26.5, 23.3, 18.3, 13.9, 9.6]
        }, {
            name: 'Client Invoice',
            data: [0, 0.8, 5.7, 11.3, 17.0, 22.0, 24.8, 24.1, 20.1, 14.1, 8.6, 2.5]
        }, {
            name: 'Staff Pay',
            data: [0.9, 0.6, 3.5, 8.4, 13.5, 17.0, 18.6, 17.9, 14.3, 9.0, 3.9, 1.0]
        }, {
            name: 'Expenses',
            data: [3.9, 4.2, 5.7, 8.5, 11.9, 15.2, 17.0, 16.6, 14.2, 10.3, 6.6, 4.8]
        }]
	});
});
</script>