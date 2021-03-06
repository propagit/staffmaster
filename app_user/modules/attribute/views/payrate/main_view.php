<?=modules::run('wizard/main_view', 'payrate');?>

<!--begin top box--->
<div class="col-md-12">
	<div class="box top-box">
   		 <h2><i class="icon-attributesPayrate"></i> &nbsp; Manage Pay Rates</h2>
		 <p>Add pay rates to assign your staff working on jobs. An hourly client charge out rate and a staff pay rate can be set. Penalty rates can be applied based on the time and the day.</p>
		 <button class="btn btn-core" type="button" data-toggle="modal" data-target="#add-payrate-modal"><i class="fa fa-plus"></i> Add Pay Rate</button>
    </div>
</div>
<!--end top box-->
<? if (count($payrates) > 0) { ?>
<link href="//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css" rel="stylesheet" media="screen" type="text/css" />
<script src="//code.jquery.com/ui/1.10.4/jquery-ui.js"></script>

<!--begin bottom box -->
<div class="col-md-12">
	<div class="box bottom-box">
    	<div class="inner-box">
            <h2>Your Pay Rates</h2>
            <?=modules::run('payrate/field_select', 'payrate_id', $payrate_id);?>
            <br /><br />
            <div id="menu_payrates">
            	
            </div>
            <div id="nav_payrates">
            	
            </div>
            <div id="list_payrates"></div>
    	</div>
	</div>
</div>
<? } ?>
<!-- Add payrate modal -->
<div class="modal fade" id="add-payrate-modal" tabindex="-1" role="dialog" aria-labelledby="addPayrateLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>
				<h4 class="modal-title">Add New Pay Rate</h4>
			</div>
	        <div class="col-md-12">
				<div class="modal-body">          
                	<h4 class="modal-body-title">Enter Pay Rate Name</h4>
                    <p>
                    The "Pay Rate Name" should be a name that is easily identifiable. The pay rate name is used when assigning a pay rate to jobs you create. 
                    </p>
		            <form class="form-horizontal" role="form" id="form_add_payrate">
					<div class="form-group" id="f_name">
						<label for="inputEmail3" class="col-sm-3 control-label">Name</label>
						<div class="col-sm-9">
							<input type="text" class="form-control" name="name" placeholder="Enter pay rate name">
						</div>
					</div>
					<div class="form-group" id="f_staff_rate">
						<label for="inputPassword3" class="col-sm-3 control-label">Staff Rate</label>
						<div class="col-sm-4">
							<div class="input-group">
								<span class="input-group-addon">$</span>
								<input type="text" class="form-control input_number_only" name="staff_rate">
							</div>
						</div>
					</div>
					<div class="form-group" id="f_client_rate">
						<label for="inputPassword3" class="col-sm-3 control-label">Client Rate</label>
						<div class="col-sm-4">
							<div class="input-group">
								<span class="input-group-addon">$</span>
								<input type="text" class="form-control input_number_only" name="client_rate">
							</div>
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-offset-3 col-sm-3">
							<button type="button" class="btn btn-core" id="btn_add_payrate" data-loading-text="Adding pay rate..."><i class="fa fa-plus"></i> Add Pay Rate</button>
						</div>
					</div>
					</form>
				</div>
	        </div>
			<div class="modal-footer">
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<script>
$(function(){
	$('#btn_add_payrate').click(function(){
		preloading($('#add-payrate-modal .modal-content'));
		$('.form-group').removeClass('has-error');
		$.ajax({
			type: "POST",
			url: "<?=base_url();?>attribute/ajax/add_payrate",
			data: $('#form_add_payrate').serialize(),
			success: function(data) {
				data = $.parseJSON(data);
				$('#wrapper_loading').remove();
				if (!data.ok) {
					$('#f_' + data.error_id).addClass('has-error');
					$('#' + data.error_id).focus();
				} else {
					window.location = '<?=base_url();?>attribute/payrate/' + data.payrate_id;
				}				
			}
		}) 
	});
	
	$('#payrate_id').change(function(){
		load_pay_rates();
	})
	load_pay_rates();
});
function load_pay_rates()
{
	var payrate_id = $('#payrate_id').val();
	preloading($('#list_payrates'));
	$.ajax({
		type: "POST",
		url: "<?=base_url();?>attribute/ajax/load_payrates",
		data: {payrate_id: payrate_id},
		success: function(html) {
			loaded($('#list_payrates'), html);
		}
	})
}
</script>