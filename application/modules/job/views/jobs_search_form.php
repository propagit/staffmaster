<div class="col-md-12">
	<!--begin top box--->
	<div class="box top-box">
		<h2>Your Campaigns - Shifts</h2>
		<p>Find campaigns you have created be searching for a client or a campaign name. Search shifts by clicking the find shift tab and entering the shift details.</p>
    </div><!--end top box-->
</div>

<div class="col-md-12">
	<!--begin bottom box -->
	<div class="box bottom-box">
		<!-- begin inner box -->
    	<div class="inner-box">    		
            <ul class="nav nav-tabs tab-respond" id="tab-search">
				<li class="<?=$search_shift_filters['shift_status'] == 'job_campaign' ? 'active' : '';?>"><a href="#search-campaigns" data-toggle="tab">Search Campaigns</a></li>
				<li class="<?=$search_shift_filters['shift_status'] != 'job_campaign' ? 'active' : '';?>"><a href="#find-shifts" data-toggle="tab">Find Shifts</a></li>
			</ul>
			
			
			<div class="tab-content">
				<!-- begin tab search campaigns -->
				<div class="tab-pane <?=$search_shift_filters['shift_status'] == 'job_campaign' ? 'active' : '';?>" id="search-campaigns">
					<h2 class="lg">Search Campaigns</h2>
					<form class="form-horizontal" role="form" id="form_search_jobs">
					<div class="row">
						<div class="form-group">
							<label for="keyword" class="col-md-2 control-label">Campaign Name</label>
							<div class="col-md-10">
								<input type="text" class="form-control" id="keyword" name="keywords" placeholder="keywords..." />
							</div>
						</div>
					</div>
					<? if (!modules::run('auth/is_client')) { ?>
					<div class="row">
						<div class="form-group">
							<label for="client_id" class="col-md-2 control-label">Client</label>
							<div class="col-md-4">
								<?=modules::run('client/field_select', 'client_id',$search_shift_filters['client_user_id']);?>
							</div>
							
						</div>
					</div>
					<? } ?>
					<div class="row">
						<div class="form-group">
							<label for="date_from" class="col-md-2 control-label">Date From</label>
							<div class="col-md-4">
								<div class="input-group date" id="date_from">
									<input type="text" class="form-control" name="date_from" readonly value="<?=$search_shift_filters['shift_date'];?>"/>
									<span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
									<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
								</div>
							</div>
							<label for="date_to" class="col-md-2 control-label">Date To</label>
							<div class="col-md-4">
								<div class="input-group date" id="date_to">
									<input type="text" class="form-control" name="date_to" readonly value="<?=$search_shift_filters['search_shift_date_to'];?>"/>
									<span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
									<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="form-group">
							<div class="col-md-offset-2 col-md-8">
								<button type="button" class="btn btn-core" id="btn_search_jobs"><i class="fa fa-search"></i> Search</button> &nbsp; 
								<button type="reset" class="btn btn-default"><i class="fa fa-refresh"></i> Reset</button>
							</div>
						</div>
					</div>	
					</form>
					
					<div id="jobs_search_list">
					</div>
				</div><!-- end tab search campaigns -->
				
				<!-- begin tab search shifts -->
				<div class="tab-pane <?=$search_shift_filters['shift_status'] != 'job_campaign' ? 'active' : '';?>" id="find-shifts">
					<h2 class="lg">Find Shifts</h2>
					<form class="form-horizontal" role="form" id="form_search_shifts">
					<div class="row">
						<div class="form-group">
							<label class="col-md-2 control-label">Campaign Name</label>
							<div class="col-md-4">
								<input type="text" class="form-control" name="keywords" placeholder="enter campaign name..." />
							</div>
							<label class="col-md-2 control-label">Venue</label>
							<div class="col-md-4">
								<?=modules::run('attribute/venue/field_input', 'venue');?>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="form-group">
							<label class="col-md-2 control-label">Staff Name</label>
							<div class="col-md-4">
								<input type="text" class="form-control" name="staff_name" placeholder="enter staff name..." value="<?=$search_shift_filters['staff_name'];?>" />
							</div>
							<label for="position" class="col-md-2 control-label">Role</label>
							<div class="col-md-4">
								<?=modules::run('attribute/role/field_select', 'role_id');?>
							</div>
						</div>
					</div>
					<? if (!modules::run('auth/is_client')) { ?>
					<div class="row">
						<div class="form-group">							
							<label class="col-md-2 control-label">Client</label>
							<div class="col-md-4">
								<?=modules::run('client/dropdown', 'client_id',$search_shift_filters['client_user_id']);?>
							</div>
							<label for="payrate" class="col-md-2 control-label">Payrate</label>
							<div class="col-md-4">
								<?=modules::run('attribute/payrate/field_select', 'payrate_id');?>
							</div>
						</div>
					</div>
					<? } ?>
					<div class="row">
						<div class="form-group">
							<label class="col-md-2 control-label">Date From</label>
							<div class="col-md-4">
								<div class="input-group date" id="shift_date_from">
									<input type="text" class="form-control" name="date_from" value="<?=$search_shift_filters['shift_date'];?>" readonly />
									<span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
									<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
								</div>
							</div>
							<label class="col-md-2 control-label">Date To</label>
							<div class="col-md-4">
								<div class="input-group date" id="shift_date_to">
									<input type="text" class="form-control" name="date_to" readonly value="<?=$search_shift_filters['search_shift_date_to'];?>"/>
									<span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
									<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
								</div>
							</div>
						</div>
					</div>
                    <div class="row">
						<div class="form-group">
							<label class="col-md-2 control-label">Status</label>
							<div class="col-md-4">
									<?=modules::run('job/field_select_shift_status', 'search_shift_shift_status',$search_shift_filters['shift_status']);?>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="form-group">
							<div class="col-md-offset-2 col-md-8">
								<button type="button" class="btn btn-core" id="btn_search_shifts"><i class="fa fa-search"></i> Search</button> &nbsp; 
								<button type="reset" class="btn btn-default"><i class="fa fa-refresh"></i> Reset</button>
							</div>
						</div>
					</div>
					</form>
					
					<div id="shifts_search_list"></div>
				
				</div><!-- end tab search shifts -->
			</div><!-- end tab content -->
        </div><!-- end inner box -->
    </div><!--end bottom box -->
</div>


<script>
$(function() {	

	//if search filters are already present initiate search
	<?php if($search_shift_filters['shift_status'] != 'job_campaign'){ ?>
		search_shifts();
	<?php } ?>
	<?php if($search_shift_filters['shift_status'] == 'job_campaign'){ ?>
		search_jobs();
	<?php } ?>

	$('#btn_search_jobs').click(function(){
		search_jobs();
		$('body').scrollTo('#form_search_jobs', 500 );
	});
	$('#btn_search_shifts').click(function(){
		search_shifts();
		$('body').scrollTo('#form_search_shifts', 500 );
	})
	$('#date_from').datetimepicker({
        weekStart: 1,
        todayBtn:  1,
		autoclose: 1,
		todayHighlight: 1,
		startView: 2,
        minView: 2,
		forceParse: 1,
        format: 'dd-mm-yyyy',
    }).on('changeDate', function(e) {
    	var date_from = moment(e.date.valueOf() - 11*60*60*1000);
    	$('#date_to').datetimepicker('setStartDate', date_from.format("DD-MM-YYYY"));
    });
    $('#date_to').datetimepicker({
        weekStart: 1,
        todayBtn:  1,
		autoclose: 1,
		todayHighlight: 1,
		startView: 2,
        minView: 2,
		forceParse: 1,
        format: 'dd-mm-yyyy',
        pickerPosition: 'bottom-left'
    }).on('changeDate', function(e) {
    	var date_to = moment(e.date.valueOf() - 11*60*60*1000);
    	$('#date_from').datetimepicker('setEndDate', date_to.format("DD-MM-YYYY"));
    });
    $('#shift_date_from').datetimepicker({
        weekStart: 1,
        todayBtn:  1,
		autoclose: 1,
		todayHighlight: 1,
		startView: 2,
        minView: 2,
		forceParse: 1,
        format: 'dd-mm-yyyy',
    }).on('changeDate', function(e) {
    	var date_from = moment(e.date.valueOf() - 11*60*60*1000);
    	$('#shift_date_to').datetimepicker('setStartDate', date_from.format("DD-MM-YYYY"));
    });
    $('#shift_date_to').datetimepicker({
        weekStart: 1,
        todayBtn:  1,
		autoclose: 1,
		todayHighlight: 1,
		startView: 2,
        minView: 2,
		forceParse: 1,
        format: 'dd-mm-yyyy',
        pickerPosition: 'bottom-left'
    }).on('changeDate', function(e) {
    	var date_to = moment(e.date.valueOf() - 11*60*60*1000);
    	$('#shift_date_from').datetimepicker('setEndDate', date_to.format("DD-MM-YYYY"));
    });
});
function search_jobs(){
	preloading($('#jobs_search_list'));
	$.ajax({
		type: "POST",
		url: "<?=base_url();?>job/ajax/search_jobs",
		data: $('#form_search_jobs').serialize(),
		success: function(html) {
			loaded($('#jobs_search_list'), html);
		}
	})
}
function search_shifts(){
	preloading($('#shifts_search_list'));
	$.ajax({
		type: "POST",
		url: "<?=base_url();?>job/ajax/search_shifts",
		data: $('#form_search_shifts').serialize(),
		success: function(html) {
			loaded($('#shifts_search_list'), html);
		}
	})
}
function sort_search_shifts(key) {
	$.ajax({
		type: "POST",
		url: "<?=base_url();?>job/ajax/sort_shifts",
		data: {key: key},
		success: function(html) {
			search_shifts();
		}
	})
}
</script>