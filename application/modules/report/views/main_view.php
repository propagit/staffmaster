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
						<?=modules::run('report/field_select_year', 'client_year');?><br /><br />
						<?=modules::run('report/field_select_month', 'client_month');?>
					</div>
					<div class="col-md-8" id="wp-char-top-clients">
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
                		<?=modules::run('report/field_select_year', 'role_year');?><br /><br />
                		<?=modules::run('report/field_select_month', 'role_month');?>
                	</div>
                	<div class="col-md-8" id="wp-char-top-roles">
	                	
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
	$('#client_year').change(function(){
		top_clients_chart();
	});
	$('#client_month').change(function(){
		top_clients_chart();
	});
	$('#role_year').change(function(){
		top_roles_chart();
	});
	$('#role_month').change(function(){
		top_roles_chart();
	});
	top_clients_chart();
	top_roles_chart();
})
function top_roles_chart() {
	var year = $('#role_year').val();
	var month = $('#role_month').val();
	preloading($('#wp-char-top-roles'));
	$.ajax({
		type: "POST",
		url: "<?=base_url();?>report/ajax/load_top_roles_data",
		data: {year: year, month: month},
		success: function(html) {
			loaded($('#wp-char-top-roles'), html);
		}
	})
}
function top_clients_chart() {
	var year = $('#client_year').val();
	var month = $('#client_month').val();
	preloading($('#wp-char-top-clients'));
	$.ajax({
		type: "POST",
		url: "<?=base_url();?>report/ajax/load_top_clients_data",
		data: {year: year, month: month},
		success: function(html) {
			loaded($('#wp-char-top-clients'), html);
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
	
	
});
</script>