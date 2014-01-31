<div class="table-responsive">
	<table class="table table-bordered table-hover" width="100%">
	<thead>
		<tr>
			<th>Date</th>
			<th>Client</th>
			<th>Venue</th>
			<th class="center">Start</th>
			<th class="center">Finish</th>
			<th class="center">Break</th>
			<th class="center">Brief</th>
			<th class="center">Status</th>
		</tr>
	</thead>
	<tbody>
	<? foreach($rosters as $roster) { ?>
		<tr>
			<td><?=date('d', $roster['start_time']);?></td>
			<td><? $client = modules::run('client/get_client', $roster['client_id']); echo $client['company_name']; ?></td>
			<td><?=modules::run('attribute/venue/display_venue', $roster['venue_id']);?></td>
			<td class="center"><?=date('H:i', $roster['start_time']);?></td>
			<td class="center"><?=date('H:i', $roster['finish_time']);?></td>
			<td class="center"><?=modules::run('common/break_time', $roster['break_time']);?></td>
			<td class="center"><a href="#"><i class="fa fa-eye"></i></a></td>
			<td class="center">
				<? if($roster['status'] == 1) { ?>
				<div class="btn-group">
					<button type="button" class="btn btn-xs btn-danger">Unconfirmed</button>
					<button type="button" class="btn btn-xs btn-danger dropdown-toggle" data-toggle="dropdown">
						<span class="caret"></span>
						<span class="sr-only">Toggle Dropdown</span>
					</button>
					<ul class="dropdown-menu pull-right" role="menu">
						<li><a href="#">Confirm</a></li>
						<li><a href="#">Reject</a></li>
					</ul>
				</div>
				<? } else if ($roster['status'] == 2) { ?>
				<span class="btn btn-xs btn-success"><i class="fa fa-thumbs-o-up"></i> Confirmed</span>
				<? } ?>
			</td>
		</tr>
	<? } ?>
	</tbody>
	</table>
</div>