<div class="modal-dialog">
	<div class="modal-content">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			<h4 class="modal-title" id="myModalLabel">Expenses</h4>
		</div>
		<div class="col-md-12">			
			<div class="modal-body modal-form">
			
				<div id="ts-expenses"></div>
				
				<?=modules::run('timesheet/add_expense_form', $timesheet_id);?>
				
			</div>
		</div>
	</div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->

<script>
$(function(){
	list_expenses(<?=$timesheet_id;?>);
});
function list_expenses(timesheet_id) {
	preloading($('#ts-expenses'));
	$.ajax({
		type: "POST",
		url: "<?=base_url();?>timesheet/ajax/list_expenses",
		data: {timesheet_id: timesheet_id},
		success: function(html) {
			loaded($('#ts-expenses'), html);
			refrest_timesheet(timesheet_id);
		}
	})
}
function delete_expense(timesheet_id, i) {
	$.ajax({
		type: "POST",
		url: "<?=base_url();?>timesheet/ajax/delete_expense",
		data: {timesheet_id: timesheet_id, i:i},
		success: function(html) {
			list_expenses(timesheet_id);
			refrest_timesheet(timesheet_id);
		}
	})
}
</script>