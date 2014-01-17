<h2>Job Shifts Calendar View</h2>

<div class="pull-right"><a href="<?=base_url();?>job/details/<?=$job['job_id'];?>" type="button" class="btn btn-info"><i class="icon-list-alt"></i>  List View</a></div>

<p><b>Step 2</b> - Create shift by clicking on the calendar date.</p>

<a href="<?=base_url();?>job/calendar"><i class="icon-calendar"></i> Jobs Calendar</a>
&nbsp; &nbsp; &nbsp;
<a href="<?=base_url();?>job/search"><i class="icon-search"></i> Search Jobs</a>
<br /><br />
<hr />
<br />
<h4>Client: <?=$client['company_name'];?></h4>
<h4><?=$job['name'];?></h4>
<?=$calendar;?>

<!-- Add Job Card Modal -->
<div class="modal fade" id="addJobCard" role="dialog" aria-labelledby="addJobCardLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close btn-close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title"><?=$job['name'];?> / Client: <?=$client['company_name'];?> / Job Date: <span id="day"></span>/<?=$month;?>/<?=$year;?></h4>
			</div>
			<form class="form-horizontal" role="form" method="post" action="<?=base_url();?>job/add_shift">
			<input type="hidden" name="job_id" value="<?=$job['job_id'];?>" />
			<input type="hidden" name="job_date" id="job_date" />
			<div class="modal-body">
				
				<div class="row">
					<div class="col-md-12">
						<div class="form-group">
							<label for="venue_id" class="col-lg-3 control-label">Venue</label>
							<div class="col-lg-5">
								<?=modules::run('attribute/venue/dropdown', 'venue_id');?>
							</div>
							<div class="col-lg-4">
								<span class="help-block">Or <a href="<?=base_url();?>attribute/venue" target="_blank">Enter New Venue</a></span>
							</div>
						</div>
						
						<div class="form-group">
							<label for="role_id" class="col-lg-3 control-label">Role</label>
							<div class="col-lg-9">
								<?=modules::run('attribute/role/dropdown', 'role_id');?>
							</div>
						</div>
						<div class="form-group">
							<label for="unisex" class="col-lg-3 control-label">Staff Required</label>
							<div class="col-lg-3">
								<div class="input-group">
									<span class="input-group-addon"><i class="icon-group"></i></span>
									<input type="text" class="form-control" name="unisex" id="unisex" />
								</div>
							</div>
							<div class="col-lg-3">
								<div class="input-group">
									<span class="input-group-addon"><i class="icon-male"></i></span>
									<input type="text" class="form-control" name="male" />
								</div>
							</div>
							<div class="col-lg-3">
								<div class="input-group">
									<span class="input-group-addon"><i class="icon-female"></i></span>
									<input type="text" class="form-control" name="female" />
								</div>
							</div>
						</div>
						<div class="form-group">
							<label for="uniform_id" class="col-lg-3 control-label">Uniform</label>
							<div class="col-lg-9">
								<?=modules::run('attribute/uniform/dropdown', 'uniform_id');?>
							</div>
						</div>
						<div class="form-group">
							<label for="venue_id" class="col-lg-3 control-label">Shift Duration</label>
							<div class="col-lg-9">
								<div id="slider-range"></div>
								<span id="time"></span>
								<input type="hidden" name="start_time" id="start_time" />
								<input type="hidden" name="finish_time" id="finish_time" />
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-info btn-close" data-dismiss="modal">Close</button>
				<button type="submit" class="btn btn-info">Add Shift</button>
			</div>
			</form>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<script>
$(function(){
	$('.highlight').parent().css('background','#b3dbf4');
	$('.addjob').parent().css('cursor','pointer');
	$('.addjob').parent().click(function(){
		var day = $(this).find('.addjob').attr('day');
		if (day < 10) { day = "0" + day; }
		$('#day').html(day);
		$('#job_date').val('<?=$year . '-' . $month;?>' + '-' + day);
		$('#addJobCard').modal('show');
	});
	$('.btn-close').click(function(){
		$('#addJobCard').modal('hide');
	});
	$("#slider-range").slider({
        range: true,
        min: 0,
        max: 1800,
        values: [540, 1020],
        step: 15,
        slide: slideTime
    });
    slideTime();
})
function slideTime(event, ui){
    var val0 = $("#slider-range").slider("values", 0),
        val1 = $("#slider-range").slider("values", 1),
        minutes0 = parseInt(val0 % 60, 10),
        hours0 = parseInt(val0 / 60 % 24, 10),
        minutes1 = parseInt(val1 % 60, 10),
        hours1 = parseInt(val1 / 60 % 24, 10);
    startTime = getTime(hours0, minutes0);
    endTime = getTime(hours1, minutes1);
    $('#start_time').val(startTime);
    $('#finish_time').val(endTime);
    $("#time").text(startTime + ' - ' + endTime);
}
function getTime(hours, minutes) {
    var time = null;
    minutes = minutes + "";
    if (hours < 12) {
        time = "AM";
    }
    else {
        time = "PM";
    }
    if (hours == 0) {
        hours = 12;
    }
    if (hours > 12) {
        hours = hours - 12;
    }
    if (minutes.length == 1) {
        minutes = "0" + minutes;
    }
    return hours + ":" + minutes + " " + time;
}
</script>