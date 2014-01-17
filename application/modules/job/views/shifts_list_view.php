<h2>Job Shifts List View</h2>

<div class="pull-right"><a href="<?=base_url();?>job/details/<?=$job['job_id'];?>/calendar" type="button" class="btn btn-info"><i class="icon-calendar"></i>  Calendar View</a></div>

<p><b>Step 3</b> - Review your job shifts list and attach briefs, surveys and other tasks you would like your<br />staff to complete on the jobs they work on. Click view for the full details of shift.</p>


<a href="<?=base_url();?>job/calendar"><i class="icon-calendar"></i> Jobs Calendar</a>
&nbsp; &nbsp; &nbsp;
<a href="<?=base_url();?>job/search"><i class="icon-search"></i> Search Jobs</a>
<br /><br />
<hr />
<br />

<div class="pull-right">
	<form class="form-inline" role="form">
	<div class="form-group">
		<input type="email" class="form-control" placeholder="Enter keyword">
	</div> &nbsp; 
	<button type="submit" class="btn btn-info"><i class="icon-search"></i> Search</button>
	</form>
</div>
<h4>Client: <?=$client['company_name'];?></h4>
<h4><?=$job['name'];?></h4>
<br />
<p>
<select class="selectpicker" data-style="btn-info">
	<option data-icon="icon-picture">Request Image</option>
	<option>Ketchup</option>
	<option>Relish</option>
</select>
</p>

<? if (isset($shifts)) { ?>
<table class="table table-hover">
	<thead>
	<tr class="heading">
		<td class="center" width="12%"><i class="icon-calendar"></i> Date <a href="#"><i class="icon-sort-by-alphabet"></i></a></td>
		<td class="left"><i class="icon-map-marker"></i> Venue <a href="#"><i class="icon-sort-by-alphabet"></i></a></td>
		<!-- <td class="center" width="10%"><i class="icon-location-arrow"></i> State</td> -->
		<td class="center" width="16%"><i class="icon-time"></i> Duration</td>
		<td class="center" width="10%"><i class="icon-user"></i> Staff</td>
		<td class="center" width="10%"><i class="icon-eye-open"></i> View</td>
		<td class="center" width="10%"><i class="icon-trash"></i> Delete</td>
		<td class="center" width="12%"><i class="icon-time"></i>Status  <a href="#"><i class="icon-sort-by-alphabet"></i></a></td>
		<td class="center" width="10%"><i class="icon-check"></i>Check</td>
	</tr>
	</thead>
	<? foreach($shifts as $shift) { 
		$venue = modules::run('attribute/venue/get_venue', $shift['venue_id']);
	?>
	<tr>
		<td class="left"><?=$shift['job_date'];?></td>
		<td class="left"><?=$venue['name'];?></td>
		<td class="center"><?=$shift['start_time'] . '-'. $shift['finish_time'];?></td>
		<td class="center"></td>
		<td class="center"><a href="<?=base_url();?>job/shift/<?=$shift['shift_id'];?>"><i class="icon-eye-open icon-large"></i></a></td>
		<td class="center"><a href="#"><i class="icon-trash icon-large"></i></a></td>
		<td class="center"><span class="label label-danger"><i class="icon-remove"></i></span></td>
		<td class="center"><input type="checkbox" /></td>
	</tr>
	<? } ?>	
</table>

<? } ?>