<hr />
<h2>Search Results</h2>
<p>Your search returned <b><?=count($total_payruns);?></b> results</p>
<ul class="pagination custom-pagination no-action-menu pull">
<?=modules::run('common/create_pagination',count($total_payruns),PAYRUN_PER_PAGE,$current_page)?>
</ul>
<? if (count($payruns) > 0) { ?>
<div id="nav_payrun2">
<?
	# Action menu
	$data = array(
		array('value' => 'mark_deleted', 'label' => 'Mark Selected as Deleted')
	);
	#echo modules::run('common/menu_dropdown', $data, 'payrun2-action', 'Actions');
?>
</div>
<div class="table-responsive">
<table class="table table-bordered table-hover table-middle" width="100%">
<thead>
	<tr>
		<th class="center" width="20"><input type="checkbox" id="selected_all_payruns" /></th>
		<th class="center" width="120">Processed <i class="fa fa-sort sort-result" sort-by="created_on"></i></th>
		<th>Type</th>
		<th class="center" width="80">From</th>
		<th class="center" width="80">To</th>
		<th class="center" width="100">Staff</th>
		<th class="center" width="100">Time Sheets</th>
		<th class="center" width="120">Amount <i class="fa fa-sort sort-result" sort-by="amount"></i></th>'
		<th class="center" width="80">Details</th>
		<th class="center" width="80">Export</th>
		<!-- <th class="center" width="40"></th> -->
	</tr>
</thead>
<tbody>
<? foreach($payruns as $payrun) { ?>
	<tr>
		<td><input type="checkbox" class="selected_payrun" value="<?=$payrun['payrun_id'];?>" /></td>
		<td class="wp-date" width="80">
			<span class="wk_day"><?=date('D', strtotime($payrun['created_on']));?></span>
			<span class="wk_date"><?=date('d', strtotime($payrun['created_on']));?></span>
			<span class="wk_month"><?=date('M', strtotime($payrun['created_on']));?></span>
		</td>
		<td>
			<?=($payrun['type'] == STAFF_TFN) ? 'TFN' : 'ABN';?> Pay Run
		</td>
		<td class="wp-date" width="80">
			<? if ($payrun['type'] == STAFF_TFN) { ?>
			<span class="wk_day"><?=date('D', strtotime($payrun['date_from']));?></span>
			<span class="wk_date"><?=date('d', strtotime($payrun['date_from']));?></span>
			<span class="wk_month"><?=date('M', strtotime($payrun['date_from']));?></span>
			<? } ?>
		</td>
		<td class="wp-date" width="80">
			<? if ($payrun['type'] == STAFF_TFN) { ?>
			<span class="wk_day"><?=date('D', strtotime($payrun['date_to']));?></span>
			<span class="wk_date"><?=date('d', strtotime($payrun['date_to']));?></span>
			<span class="wk_month"><?=date('M', strtotime($payrun['date_to']));?></span>
			<? } ?>
		</td>
		<td class="center"><?=$payrun['total_staffs'];?></td>
		<td class="center"><?=$payrun['total_timesheets'];?></td>
		<td class="center">$<?=$payrun['amount'];?></td>
		<td class="center"><a href="<?=base_url();?>payrun/search-payslip/<?=$payrun['payrun_id'];?>"><i class="fa fa-search"></i></a></td>
		<td class="center"><a data-toggle="modal" data-target=".bs-modal-lg" href="<?=base_url();?>payrun/ajax/export_payrun/<?=$payrun['payrun_id'];?>"><i class="fa fa-download"></i></a></td>
		<!-- <td class="center"><a><i class="fa fa-plus-square-o"></i></a></td> -->
	</tr>
<? } ?>
</tbody>
</table>
<? } ?>


<!-- Modal -->
<div class="modal fade" id="waitingModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content" id="order-message">
			<img src="<?=base_url();?>assets/img/loading3.gif" />
			<h2>Please wait!</h2>
			<p>Please wait a moment while we are processing your request ...</p>
		</div>
	</div>
</div>
<script>
$(function(){
	var selected_payruns = new Array();
	$('#selected_all_payruns').click(function(){
		$('input.selected_payrun').prop('checked', this.checked);		
	});
	$('#menu-payrun2-action ul li a[data-value="mark_deleted"]').confirmModal({
		confirmTitle: 'Delete selected pay runs',
		confirmMessage: 'Are you sure you want to delete selected pay runs?',
		confirmCallback: function(e) {
			selected_payruns.length = 0;
			$('.selected_payrun:checked').each(function(){
				selected_payruns.push($(this).val());
			});
			$.ajax({
				type: "POST",
				url: base_url + 'payrun/ajax/delete_payruns',
				data: {payruns: selected_payruns},
				success: function(html) {
					reset_current_page();
					search_payruns();
				}
			})
		}
	});
	
	$('.sort-result').on('click',function(){
		var sort_order = $('#sort-order').val();
		$('#sort-order').val(sort_order == 'asc' ? 'desc' : 'asc');
		$('#sort-by').val($(this).attr('sort-by'));
		reset_current_page();
		search_payruns();
	});	
	
	//go to page
	$('.pagination li').on('click',function(e){
		e.preventDefault();
		var clicked_page = $(this).attr('data-page-no');
		$('#current_page').val(clicked_page);
		search_payruns();
	});
});//ready
</script>
