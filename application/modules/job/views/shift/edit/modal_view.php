<div class="modal-dialog">
	<div class="modal-content">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>
			<h4 class="modal-title" id="myModalLabel">Edit Selected Shifts</h4>
		</div>
		<div class="col-md-12">			
			<div class="modal-body modal-form">
				<form class="form-horizontal" id="form_edit_shifts" role="form">
				<input type="hidden" name="shift_ids" value="<?=$shift_ids;?>" />
					<div class="row">
						<div class="form-group">
							<label for="staff_name" class="col-md-3 control-label">Select Field:</label>
							<div class="col-md-9">
								<?=modules::run('job/shift/field_select_fields', 'field_id');?>
							</div>
						</div>
					</div>
					<div id="field_inputs"></div>
					<div id="msg-update-shifts" class="row hide">
						<div class="form-group">
							<div class="col-lg-9 col-lg-offset-3">
								<div class="alert alert-success"><i class="fa fa-check"></i> &nbsp; Selected Shifts have been updated</div>
							</div>
						</div>
					</div>
					
					<div id="field-submit" class="row hide">
						<div class="form-group">
							<div class="col-lg-3 col-lg-offset-3">
								<button type="button" class="btn btn-core" id="btn-update-shifts"><i class="fa fa-save"></i> Update All</button>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->

<script>
$(function(){
	$('#field_id').change(function(){
		if ($(this).val()) {
			load_field_inputs();
			$('#field-submit').removeClass('hide');
		} else {
			$('#field-submit').addClass('hide');
			$('#field_inputs').html('');
		}
	});
	$('#btn-update-shifts').click(function(){
		update_shifts();
	})
})
function load_field_inputs() {
	var field_id = $('#field_id').val();
	preloading($('#field_inputs'));
	$.ajax({
		type: "POST",
		url: "<?=base_url();?>job/ajax_shift/load_field_inputs",
		data: {field_id: field_id},
		success: function(html) {
			loaded($('#field_inputs'), html);
		}
	})
}
function update_shifts() {
	$.ajax({
		type: "POST",
		url: "<?=base_url();?>job/ajax_shift/update_shifts",
		data: $('#form_edit_shifts').serialize(),
		success: function(data) {
			data = $.parseJSON(data);
			if (!data.ok) {
				$('#f_update_field').addClass('has-error');
			}
			else
			{
				$('#msg-update-shifts').removeClass('hide');
				setTimeout(function(){
					$('#msg-update-shifts').addClass('hide');
				}, 2000);
				load_job_shifts(data.job_id);
			}
		}
	})
}
</script>