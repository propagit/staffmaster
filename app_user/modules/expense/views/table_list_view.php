<hr />

<? if (count($expenses) == 0) { ?>
<div class="alert alert-warning">No expenses found</div>
<? } else { ?>
<h2>Search Results</h2>
<p>Your search returned <b><?=count($expenses);?></b> results</p>
<div id="nav_expenses">
<?
	# Action menu
	$data = array(
		array('value' => 'export', 'label' => 'Export Selected'),
		array('value' => 'mark_unpaid', 'label' => 'Mark Selected as Unpaid'),
		array('value' => 'mark_paid', 'label' => 'Mark Selected as Paid'),
		#array('value' => 'mark_deleted', 'label' => 'Mark Selected as Deleted')
	);
	echo modules::run('common/menu_dropdown', $data, 'exp-action', 'Actions');
?>
</div>
<div class="table-responsive">
<table class="table table-bordered table-hover table-middle">
	<thead>
	<tr>
		<th class="center" width="20"><input type="checkbox" id="selected_all_expenses" /></th>
		<th class="center" width="80">Date</th>
		<th>Staff Name</th>
		<th>Client Name</th>
		<th>Job Name</th>
		<th>Description</th>
		<th class="center" width="100">Staff Cost</th>
		<th class="center" width="120">Status</th>
		<th class="center" width="80">Paid On</th>
	</tr>
	</thead>
	<tbody>
	<? foreach($expenses as $expense) { echo modules::run('expense/row_view', $expense['expense_id']); } ?>
	</tbody>
</table>
</div>
<script>
$(function(){
	var selected_expenses = new Array();
	$('#selected_all_expenses').click(function(){
		$('input.selected_expense').prop('checked', this.checked);		
	});
	$('#menu-exp-action ul li a[data-value="export"]').click(function(){
		selected_expenses.length = 0;
		$('.selected_expense:checked').each(function(){
			selected_expenses.push($(this).val());
		});
		var ids = selected_expenses.join(',');
		if (ids != '') {
			$('.bs-modal-lg').modal({
				remote: '<?=base_url();?>expense/ajax/load_export_modal/' + encodeURIComponent(ids),
				show: true
			});
		}		
	});
	$('#menu-exp-action ul li a[data-value="mark_unpaid"]').click(function(){
		selected_expenses.length = 0;
		$('.selected_expense:checked').each(function(){
			update_expense_status($(this).val(), <?=EXPENSE_UNPAID;?>);
		});	
	});
	$('#menu-exp-action ul li a[data-value="mark_paid"]').click(function(){
		selected_expenses.length = 0;
		$('.selected_expense:checked').each(function(){
			update_expense_status($(this).val(), <?=EXPENSE_PAID;?>);
		});	
	});
	$('#menu-exp-action ul li a[data-value="mark_deleted"]').click(function(){
		selected_expenses.length = 0;
		$('.selected_expense:checked').each(function(){
			update_expense_status($(this).val(), <?=EXPENSE_DELETED;?>);
		});	
	});
})
</script>
<? } ?>