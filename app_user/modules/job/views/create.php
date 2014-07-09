<?=modules::run('wizard/main_view', 'job');?>

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
            <p>Choose a client and enter a campaign name to start creating jobs. Client departments can be set up when you create clients, 
a client will be able to filter jobs associated to them by the client department when they login to their client account.</p>
        	<br />
            <form class="form-horizontal" role="form" id="form_create_job">
                <div class="row">
                    <p class="col-lg-offset-2 help-block">&nbsp; Enter a unique campaign name that you will be able to search for later.</p>
                    <div class="form-group" id="f_name">
                        <label for="name" class="col-lg-2 control-label">Campaign Name</label>
                        <div class="col-lg-5">
                            <input type="text" class="form-control" name="name" id="name" placeholder="" />
                        </div>
                        <div class="col-lg-5"><span class="help-block" id="msg-error"></span></div>
                    </div>
                    <div class="form-group" id="f_client_id">
                        <label for="client_id" class="col-lg-2 control-label">Client</label>
                        <div class="col-lg-5">
                            <?=modules::run('client/field_select', 'client_id', set_value('client_id'));?>
                        </div>
                        <div class="col-lg-5">
                        	<span class="help-block"><a><i class="fa fa-plus"></i></a> &nbsp; <a target="_blank" href="<?=base_url();?>client/add">Create New Client</a></span>
                        </div>
                    </div>
                    <div class="form-group hide" id="wp_client_departments">
                    	<label class="col-lg-2 control-label">Department</label>
                    	<div class="col-lg-5" id="client_departments">
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
	load_client_departments();
	$('#client_id').change(function(){
		load_client_departments();
	});
	$('#btn-create-job').click(function(){
		$('#form_create_job').find('div[id^=f_]').removeClass('has-error');
		$.ajax({
			type: "POST",
			url: "<?=base_url();?>job/ajax/create_job",
			data: $('#form_create_job').serialize(),
			success: function(data) {
				data = $.parseJSON(data);
				if (!data.ok) {
					$('#f_' + data.error_id).addClass('has-error');
					$('#' + data.error_id).focus();
					if (data.error_id = 'name') {
						$('#msg-error').html(data.msg);
					}
				} else {
					window.location = '<?=base_url();?>job/details/' + data.job_id;
				}
			}
		})
	})
})
function load_client_departments() {
	var user_id = $('#client_id').val();
	$.ajax({
		type: "POST",
		url: "<?=base_url();?>job/ajax/load_client_departments",
		data: {user_id: user_id},
		success: function(html) {
			if (html) {
				$('#wp_client_departments').removeClass('hide');
				$('#client_departments').html(html);
			} else {
				$('#wp_client_departments').addClass('hide');
				$('#client_departments').html('');
			}
		}
	})
}
</script>