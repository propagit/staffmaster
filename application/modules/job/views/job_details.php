<div class="col-md-12">
	<div class="box top-box">
		<div class="col-md-4">			
	        <h2><?= $job['name']; ?> </h2>
	        <h2><?= $client['company_name']; ?></h2>
		</div>
		<div class="col-md-8">
			<div class="pull-right">
				<form role="form">
						<div class="form-group">
							<label for="exampleInputEmail1">Search Job Campaigns</label>
							<div class="input-group">
								<input type="text" class="form-control" placeholder="keywords..." />
								<span class="input-group-addon"><i class="fa fa-search"></i></span>
							</div>
						</div>
						<button type="submit" class="btn btn-core"><i class="fa fa-plus"></i> Create New Campaign</button>
					</form>
			</div>
			<div class="span2 pie-chart">
				<div id="easy-pie-chart-1" data-percent="58">
					58%
				</div>
				<div class="caption">
					Shifts Completed
				</div>
			</div>
			<div class="span2 pie-chart">
				<div id="easy-pie-chart-2" data-percent="84">
					84%
				</div>
				<div class="caption">
					Shifts Confirmed
				</div>
			</div>
			<div class="span2 pie-chart">
				<div id="easy-pie-chart-3" data-percent="12">
					12%
				</div>
				<div class="caption">
					Shifts Unconfirmed
				</div>
			</div>
			<div class="span2 pie-chart">
				<div id="easy-pie-chart-4" data-percent="16">
					16%
				</div>
				<div class="caption">
					Shifts Not Filled
				</div>
			</div>
			
		</div>
				
    </div>       
</div>


<div class="col-md-12">
	<div class="box bottom-box">
    
    	<div class="col-md-6 white-box">
            <div class="inner-box">
                <?=modules::run('job/shift/form_create', $job['job_id']);?>
            </div>
        </div>
        
        <div class="col-md-6 white-box">
            <div class="inner-box">
            	<h2>Weeks - Months Shifts</h2>
            	<p>Below you can see a schedule of all the jobs you have on for the week - month for this job campaign. You can duplicate the weeks shifts to another week. Unconfirmed and confirmed shifts are indicated by red or green.</p>

                <div id="wrapper_calendar">
				</div>                
                
            </div>
        </div>
        
	</div>
	
	<div class="box bottom-box">
    	<div class="inner-box">
    		<h2>Days Shifts</h2>
			<p>All shifts for the day on this job campaign are displayed below. Click the columns to perform in-line editing. Using the checkbox to select shifts  will allow you to perform group functions such as deleting and duplicating.</p><br />
			
			<div id="wrapper_js">
			</div>           
        </div>
    </div>
</div>


<!-- Modal -->
<div class="modal fade" id="copy_shift" tabindex="-1" role="dialog" aria-hidden="true">
</div><!-- /.modal -->
<script>
$(function(){
	// Easy Pie Charts
	var easyPieChartDefaults = {
		animate: 2000,
		scaleColor: false,
		lineWidth: 10,
		lineCap: 'square',
		size: 80,
		trackColor: '#e5e5e5'
	}
	$('#easy-pie-chart-1').easyPieChart($.extend({}, easyPieChartDefaults, {
		barColor: '#0fb507'
	}));
	$('#easy-pie-chart-2').easyPieChart($.extend({}, easyPieChartDefaults, {
		barColor: '#2ae421'
	}));
	$('#easy-pie-chart-3').easyPieChart($.extend({}, easyPieChartDefaults, {
		barColor: '#e42146'
	}));
	$('#easy-pie-chart-4').easyPieChart($.extend({}, easyPieChartDefaults, {
		barColor: '#f2850f'
	}));
			
	load_job_shifts(<?=$job['job_id'];?>);
})
function sort_shifts(key) {
	$.ajax({
		type: "POST",
		url: "<?=base_url();?>job/ajax/sort_shifts",
		data: {key: key},
		success: function(html) {
			load_job_shifts(<?=$job['job_id'];?>);
		}
	})
}
</script>