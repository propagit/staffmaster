<div class="modal-dialog">
	<div class="modal-content">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			<h4 class="modal-title" id="myModalLabel">Time Sheet</h4>
		</div>
		<div class="col-md-12">
			<div class="modal-body" id="modal-timesheet">
				<table class="table table-middle table-condensed">
					<? if($timesheet['staff_id']) { 
						$staff = modules::run('staff/get_staff', $timesheet['staff_id']);
					?>
								
					<tr class="active">
						<th width="120"><?=modules::run('staff/profile_image', $staff['user_id']);?></th>
						<th>
							<h4><?=$staff['first_name'] . ' ' . $staff['last_name'];?></h4>
						</th>
						<td>&nbsp;</td>
					</tr>
					<? } ?>
					
					<tr>
						<td>Role</td>
						<td><?=modules::run('attribute/role/display_role', $timesheet['role_id']);?></td>
					</tr>
					<tr>
						<td>Uniform</td>
						<td><?=modules::run('attribute/uniform/display_uniform', $timesheet['uniform_id']);?></td>
					</tr>
					<tr>
						<td>Venue</td>
						<td><?=modules::run('attribute/venue/display_venue', $timesheet['venue_id']);?></td>
					</tr>
					<tr>
						<td>Start Time</td>
						<td><?=date('H:i \o\n jS F, Y', $timesheet['start_time']);?></td>
					</tr>
					<tr>
						<td>Finish Time</td>
						<td><?=date('H:i \o\n jS F, Y', $timesheet['finish_time']);?></td>
					</tr>
					<tr class="active">
						<th>Breaks</th>
						<td>&nbsp;</td>
					</tr>
					<? $breaks = json_decode($timesheet['break_time']);
					if ($breaks) foreach($breaks as $break) { ?>
					<tr>
						<td></td>
						<td> <?=$break->length/60;?> minutes <i>start at</i> <?=date('H:i', $break->start_at);?></td>
					</tr>
					<? } ?>
					<tr class="active">
						<th>Pay Rate</th>
						<td><?=modules::run('attribute/payrate/display_payrate', $timesheet['payrate_id']);?></td>
					</tr>
					<?
						$hours = modules::run('attribute/payrate/extract_payrate', $timesheet);
						foreach($hours as $rate=>$length) { ?>
					<tr>
						<td></td>
						<td><b><?=$length/60;?></b> hours at $<?=$rate;?></td>
					</tr>
					<? } ?>
					<tr>
						<td>Supervisor</td>
						<td>
							<? if($timesheet['supervisor_id']) { $supervisor = modules::run('staff/get_staff', $timesheet['supervisor_id']); 
								echo $supervisor['first_name'] . ' ' . $supervisor['last_name'];				
							?>
							<? } else { ?>
							No Supervisor Assigned
							<? } ?>
						</td>
					</tr>
					<? $expenses = unserialize($timesheet['expenses']); ?>
					<tr class="active">
						<th>Expenses</th>
						<td><? if (!$expenses) { echo 'No Expenses'; } ?></td>
					</tr>
					<? if ($expenses) { foreach($expenses as $expense) { ?>
					<tr>
						<td><?=$expense['description'];?></td>						
						<td>$<?=$expense['staff_cost'];?></td>
					</tr>
					<? } } ?>
				</table>				
				<button type="button" class="btn btn-core"><i class="fa fa-print"></i> Print</button>
				&nbsp;
				<button type="button" class="btn btn-core"><i class="fa fa-envelope-o"></i> Email</button>
			</div>	
		</div>
	</div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->