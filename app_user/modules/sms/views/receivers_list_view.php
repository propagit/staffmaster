<div class="table-responsive">
<table class="table table-bordered table-hover table-middle table-expanded">
    <thead>
    <tr class="heading">
        <th class="left">Receiver</th>
        <th class="center col-md-3">Mobile Phone</th>
    </tr>
    </thead>
    <tbody>
	<? foreach($users as $user) { ?>
	<tr>
		<td><?=$user['first_name'] . ' ' . $user['last_name'];?></td>
		<td><?=($user['mobile'] != '') ? $user['mobile'] : 'Not provided';?></td>
	</tr>
	<? } ?>
    </tbody>
</table>
</div>

