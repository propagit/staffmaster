<div class="col-md-12">
	<div class="box top-box">
        <h2>Create Jobs</h2>
        <p>To start creating jobs select a client and a campaign name. A campaign name is used for you to find the shifts you create later. A job campaign can contain many shifts across many days, weeks or months.</p>
    </div>
</div>

<div class="col-md-12">
	<div class="box bottom-box">
    	<div class="inner-box">
            <h2>Create Job - Step 1</h2>
            <p>Enter a campaign name to start creating jobs. Client departments can be set up in your profile, jobs can be filtered by department on your Job Calendar.</p>
            <br />
            <form class="form-horizontal" role="form" id="form_create_job">
                <div class="row">
                    <div class="form-group" id="f_name">
                        <label for="name" class="col-lg-2 control-label">Campaign Name</label>
                        <div class="col-lg-4">
                            <input type="text" class="form-control" name="name" id="name" placeholder="" />
                        </div>
                        <div class="col-lg-6"><span class="help-block">Enter a unique campaign name that you will be able to search for later</span></div>
                    </div>      
                </div>
                <div class="row">
                	<div class="form-group">
                		<label class="col-lg-2 control-label">Department</label>
                		<div class="col-lg-4">
                			<?=modules::run('client/field_select_departments', $user_id, 'department_id');?>
                		</div>
                	</div>
                </div>
                <div class="row">
                    <div class="form-group">
                        <div class="col-lg-offset-2 col-lg-8">
                            <button type="button" class="btn btn-core" id="btn-create-job"><i class="fa fa-plus"></i> Create Job</button>
                        </div>
                    </div>
                </div>
            </form>
        </div><!--inner box-->
	</div><!--box-->
</div>
<script>
$(function(){
	$('#btn-create-job').click(function(){
		$('#form_create_job').find('div[id^=f_]').removeClass('has-error');
		$.ajax({
			type: "POST",
			url: "<?=base_url();?>job/ajax_client/create_job",
			data: $('#form_create_job').serialize(),
			success: function(data) {
				data = $.parseJSON(data);
				if (!data.ok) {
					$('#f_' + data.error_id).addClass('has-error');
					$('#' + data.error_id).focus();
				} else {
					window.location = '<?=base_url();?>job/details/' + data.job_id;
				}
			}
		})
	})
})
</script>