<!--begin top box--->
<div class="col-md-12">
	<div class="box top-box">
		<h2>Staff Expenses</h2>
	</div>
</div>
<!--end top box-->

<!--begin bottom box -->
<div class="col-md-12">
	<div class="box bottom-box">
		<div class="inner-box">
			<ul class="nav nav-tabs tab-respond" id="tab-invoice">
				<li class="active"><a href="#create-expenses" data-toggle="tab">Search Expenses</a></li>
				
				<li class="pull-right"><a href="<?=base_url();?>invoice">Client Invoices</a></li>
				<li class="pull-right active"><a>Staff Expenses</a></li>
				<li class="pull-right"><a href="<?=base_url();?>payrun">Pay Run</a></li>
				<li class="pull-right"><a href="<?=base_url();?>timesheet">Time Sheets</a></li>
			</ul>
			<br />
			
			<?=modules::run('expense/search_form');?>
			
			<div id="list_expenses"></div>

			
		</div>
	</div>
</div>

<script>
$(function() {
	search_expenses();
});

function search_expenses() {
	preloading($('#list_expenses'));
	$.ajax({
		type: "POST",
		url: "<?=base_url();?>expense/ajax/search_expenses",
		data: $('#form_search_expenses').serialize(),
		success: function(html) {
			loaded($('#list_expenses'), html);
		}
	})
}
function update_expense_status(expense_id, status) {
	$.ajax({
		type: "POST",
		url: "<?=base_url();?>expense/ajax/update_expense_status",
		data: {expense_id: expense_id, status: status},
		success: function(html) {
			$('#expense-' + expense_id).replaceWith(html);
		}
	})
}
</script>