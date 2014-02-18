<table class="table table-topless">
	<tr>
		<th width="100">Type</th>
		<th width="100" class="center">Staff</th>
		<th>Amount</th>
		<th></th>
	</tr>
	<tr>
		<td>TFN</td>
		<td class="center"><?=($c = modules::run('payrun/count_staff', STAFF_TFN));?></td>
		<td class="right">$<?=money_format('%i',($a = modules::run('payrun/get_total_amount', STAFF_TFN)));?></td>
		<td><a class="btn btn-core btn-xs">Export</a></td>
	</tr>
	<tr>
		<td>ABN</td>
		<td class="center"><?=($d = modules::run('payrun/count_staff', STAFF_ABN));?></td>
		<td class="right">$<?=money_format('%i',($b = modules::run('payrun/get_total_amount', STAFF_ABN)));?></td>
		<td><a class="btn btn-core btn-xs">Export</a></td>
	</tr>
	<tr>
		<td>Total</td>
		<td class="center"><?=$c + $d;?></td>
		<td class="right">
			$<?=money_format('%i', $a+$b);?>
		</td>
		<td></td>
	</tr>
</table>