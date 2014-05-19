<!-- highcharts -->
<script src="<?=base_url();?>assets/highcharts/highcharts.js"></script>
<script src="<?=base_url();?>assets/highcharts/modules/data.js"></script>
<script src="<?=base_url()?>assets/ckeditor/ckeditor.js"></script>
<script src="<?=base_url()?>assets/ckeditor/config.js"></script>
<script src="<?=base_url()?>assets/ckeditor/styles.js"></script>
<div class="col-md-12">
	<div class="box top-box">
		<div class="col-md-5">
	        <h2><?= $client['company_name']; ?></h2>
	        <h2 class="s30"><?= $job['name']; ?> </h2>
		</div>
		<div class="col-md-7">
			<div class="pull-right">
				<div class="form-group label-search-job">
					<label for="exampleInputEmail1">Search Job Campaigns</label>
					<?=modules::run('job/field_select', 'job_name');?>
				</div>
				<a href="<?=base_url();?>job/create" class="btn btn-core top-create-btn"><i class="fa fa-plus"></i> Create New Campaign</a>
			</div>
			<? 
				$shifts_count = modules::run('job/count_job_shifts', $job['job_id']);
				$completed = modules::run('job/count_job_shifts', $job['job_id'], null, SHIFT_FINISHED); 
				$confirmed = modules::run('job/count_job_shifts', $job['job_id'], null, SHIFT_CONFIRMED); 
				$unconfirmed = modules::run('job/count_job_shifts', $job['job_id'], null, SHIFT_UNCONFIRMED);
				$unassigned = modules::run('job/count_job_shifts', $job['job_id'], null, '0'); 
				$rejected = modules::run('job/count_job_shifts', $job['job_id'], null, SHIFT_REJECTED); 
				$completed_percentage = 0;
				if ($shifts_count > 0) {
					$completed_percentage = number_format($completed / $shifts_count * 100, 2, '.', '');
				}
			?>
			<div class="span2 pie-chart pull-right">
				<div id="easy-pie-chart-1" data-percent="<?=$completed_percentage;?>">
					<small><?=$completed;?>/<?=$shifts_count;?></small>
				</div>
				<div class="caption">
					Shifts Completed
				</div>
			</div>
			
			<? if ($shifts_count != $completed) { ?>
			<div class="span2 pie-chart pull-right">
				<div id="chart-incompleted-shifts">
				</div>
				<div class="caption">
					<b><?=($shifts_count - $completed);?></b> Active Shifts
				</div>
			</div>
			<? } ?>
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

			<p>All shifts for the day on this job campaign are displayed below. Click the columns to perform in-line editing. <br />Using the checkbox to select shifts  will allow you to perform group functions such as deleting and duplicating.</p><br />
			
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
	$('#job_name').change(function(){
		window.location = '<?=base_url();?>job/details/' + $(this).val();
	});
	<? if ($shifts_count != $completed) { ?>
	$('#chart-incompleted-shifts').highcharts({
        chart: {
        	backgroundColor: '#f6f6f6',
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
        colors: ['#2ae421','#e42146','#f2850f','#ddd'],
        tooltip: {
            pointFormat: '<b>{point.percentage:.1f}%: {point.y}</b>'
        },
        plotOptions: {
            pie: {
            	dataLabels: {
	            	enabled: false	
            	},
                shadow: false,
                center: ['50%', '50%']
            }
        },
        credits: {
	    	enabled: false  
        },
        series: [{
            type: 'pie',
            name: 'a',
            innerSize: '95%',
            data: [
                ['Confirmed',       <?=$confirmed;?>],
                ['Rejected', <?=$rejected;?>],
                ['Unconfirmed',    <?=$unconfirmed;?>],
                ['Unassigned',     <?=$unassigned;?>]
            ]
        }]
    });
    <? } ?>
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
			
	load_job_shifts(<?=$job['job_id'];?>);
	
	//email apply for shift
	$(document).on('click','.send-email-from-modal',function(){
		email_apply_for_shift();
	});
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