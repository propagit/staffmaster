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
            	<?=modules::run('report/financial_year_view');?>
            </div>
        </div>
        
        <div class="col-md-6 white-box">
            <div class="inner-box">
                <?=modules::run('report/fore_cast_view');?>
                
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
	
	
});
</script>