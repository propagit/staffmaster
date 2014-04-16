<div class="modal-dialog">
	<div class="modal-content">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			<h4 class="modal-title" id="myModalLabel">Expenses</h4>
		</div>
		<div class="col-md-12">			
			<div class="modal-body modal-form">
				
				<div id="shift-expenses"></div>
				
				<?=modules::run('job/shift/add_expense_form', $shift_id);?>
				
			</div>
		</div>
	</div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->

<script>
$(function(){
	list_expenses(<?=$shift_id;?>);
});
function list_expenses(shift_id) {
	preloading($('#shift-expenses'));
	$.ajax({
		type: "POST",
		url: "<?=base_url();?>job/ajax_shift/list_expenses",
		data: {shift_id: shift_id},
		success: function(html) {
			loaded($('#shift-expenses'), html);
		}
	})
}
function delete_expense(shift_id, i) {
	$.ajax({
		type: "POST",
		url: "<?=base_url();?>job/ajax_shift/delete_expense",
		data: {shift_id: shift_id, i:i},
		success: function(html) {
			list_expenses(shift_id);
		}
	})
}
</script>