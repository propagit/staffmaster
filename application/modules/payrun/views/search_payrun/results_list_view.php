<hr />
<h2>Search Results</h2>
<p>Your search returned <b><?=count($payruns);?></b> results</p>

<? if (count($payruns) > 0) { ?>
<div class="table-responsive">
<table class="table table-bordered table-hover table-middle" width="100%">
<thead>
	<tr>
		<th class="center" width="80">Processed</th>
		<th>Type</th>
		<th class="center" width="100">Staff</th>
		<th class="center" width="100">Time Sheets</th>
		<th class="center" width="120">Amount</th>
		<th class="center" width="80">Export</th>
		<!-- <th class="center" width="40"></th> -->
	</tr>
</thead>
<tbody>
<? foreach($payruns as $payrun) { ?>
	<tr>
		<td class="wp-date" width="80">
			<span class="wk_day"><?=date('D', strtotime($payrun['created_on']));?></span>
			<span class="wk_date"><?=date('d', strtotime($payrun['created_on']));?></span>
			<span class="wk_month"><?=date('M', strtotime($payrun['created_on']));?></span>
		</td>
		<td>
			<?=($payrun['type'] == STAFF_TFN) ? 'TFN' : 'ABN';?> Pay Run
		</td>
		<td class="center"><?=$payrun['total_staffs'];?></td>
		<td class="center"><?=$payrun['total_timesheets'];?></td>
		<td class="center">$<?=$payrun['amount'];?></td>
		<td class="center"><a data-toggle="modal" data-target=".bs-modal-lg" href="<?=base_url();?>payrun/ajax/export_payrun/<?=$payrun['payrun_id'];?>"><i class="fa fa-download"></i></a></td>
		<!-- <td class="center"><a><i class="fa fa-plus-square-o"></i></a></td> -->
	</tr>
<? } ?>
</tbody>
</table>
<? } ?>
