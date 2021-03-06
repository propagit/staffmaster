<form class="form-horizontal" id="form_add_expense" role="form">
<input type="hidden" name="timesheet_id" value="<?=$timesheet_id;?>" />
	<div class="row">
		<div class="form-group" id="f_description">
			<label for="expense_description" class="col-lg-3 control-label">Description:</label>
			<div class="col-lg-9">
				<input type="text" class="form-control" id="expense_description" name="description" placeholder="Enter expense description" />
			</div>
		</div>
	</div>
	<div class="row">
		<div class="form-group" id="f_staff_cost">
			<label class="col-lg-3 control-label">Cost</label>
			<div class="col-lg-4">
				<div class="input-group">
					<span class="input-group-addon">$</span>
					<input type="text" class="form-control" name="staff_cost">
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="form-group">
			<label class="col-lg-3 control-label">Tax</label>
			<div class="col-lg-4">
				<?=modules::run('common/field_select_gst', 'tax');?>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="form-group">
			<div class="col-lg-3 col-lg-offset-3">
				<button type="button" class="btn btn-core" id="btn-ts-add-expense"><i class="fa fa-plus"></i> Add Expense</button>
			</div>
		</div>
	</div>
</form>
<script>
$(function(){
	$('#btn-ts-add-expense').click(function(){
		$('.form-group').removeClass('has-error');
		$.ajax({
			type: "POST",
			url: "<?=base_url();?>pts/add_expense",
			data: $('#form_add_expense').serialize(),
			success: function(data) {
				data = $.parseJSON(data);
				if (!data.ok) {
					$('#f_' + data.error_id).addClass('has-error');
				}
				else {
					list_expenses(<?=$timesheet_id;?>);
					$('#form_add_expense').trigger("reset");
				}				
			}
		})
	})
});
</script>