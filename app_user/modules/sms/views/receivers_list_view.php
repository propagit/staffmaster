<div class="table-responsive">
<table class="table table-bordered table-hover table-middle table-expanded">
    <thead>
    <tr class="heading">
        <th class="left">Receiver</th>
        <th class="left">Mobile Phone</th>
    </tr>
    </thead>
    <tbody>
	<? foreach($users as $user) { ?>
	<tr>
		<td class="left"><?=$user['first_name'] . ' ' . $user['last_name'];?></td>
		<td class="left"><?=($user['mobile'] != '') ? $user['mobile'] : 'Not provided';?></td>
	</tr>
	<? } ?>
    </tbody>
</table>
</div>

