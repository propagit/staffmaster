<!--begin top box--->
<div class="col-md-12">
	<div class="box top-box">
		<h2>Search Jobs</h2>
		<p>Find jobs you have created to view and edit them.</p>
    </div>
</div>
<!--end top box-->

<!--begin bottom box -->
<div class="col-md-12">
	<div class="box bottom-box">
    	<div class="inner-box">
            
			<div class="panel panel-default">
				<div class="panel-heading">Search Job</div>
				<div class="panel-body">
					<form class="form-horizontal" role="form" id="form_search_jobs">
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label for="keyword" class="col-lg-2 control-label">Job Group Name</label>
									<div class="col-lg-10">
										<input type="text" class="form-control" id="keyword" name="keywords" placeholder="keywords..." />
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label for="client_id" class="col-lg-4 control-label">Client</label>
									<div class="col-lg-8">
										<?=modules::run('client/dropdown', 'client_id');?>
									</div>
								</div>
								<div class="form-group">
									<label for="status" class="col-lg-4 control-label">Status</label>
									<div class="col-lg-8">
										<?=modules::run('common/dropdown_status','status');?>
									</div>
								</div>
								<div class="form-group">
									<label for="date_from" class="col-lg-4 control-label">Date From</label>
									<div class="col-lg-8">
										<div class="input-group date" id="date_from">
											<input type="text" class="form-control" name="date_from" readonly />
											<span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
											<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
										</div>
									</div>
								</div>		
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label for="venue" class="col-lg-4 control-label">Venue</label>
									<div class="col-lg-8">
										<?=modules::run('attribute/venue/dropdown', 'venue');?>
									</div>
								</div>
								<div class="form-group">
									<label for="job_id" class="col-lg-4 control-label">Job ID</label>
									<div class="col-lg-8">
										<input type="text" class="form-control" name="job_id" id="job_id" />
									</div>
								</div>
								
								<div class="form-group">
									<label for="date_to" class="col-lg-4 control-label">Date To</label>
									<div class="col-lg-8">
										<div class="input-group date" id="date_to">
											<input type="text" class="form-control" name="date_to" readonly />
											<span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
											<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
										</div>
									</div>
								</div>
							</div>
							
						</div>
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<div class="col-lg-offset-4 col-lg-8">
										<button type="button" class="btn btn-info" id="btn_search_jobs"><i class="fa fa-search"></i> Search</button> &nbsp; 
										<button type="reset" class="btn btn-default"><i class="fa fa-refresh"></i> Reset</button>
									</div>
								</div>
							</div>
						</div>
						
						
					
					</form>
				</div>
			</div>
			
			<div id="jobs_search_list">
			</div>

            
           
        </div>
    </div>
</div>
<!--end bottom box -->


 <script>
$(function() {
	search_jobs();
	$('#btn_search_jobs').click(function(){
		search_jobs();
		//$('body').scrollTo('#jobs_search_list', 500 );
	});
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
});
function search_jobs(){
	$.ajax({
		type: "POST",
		url: "<?=base_url();?>job/ajax/search_jobs",
		data: $('#form_search_jobs').serialize(),
		success: function(html) {
			$('#jobs_search_list').html(html);
		}
	})
}
</script>