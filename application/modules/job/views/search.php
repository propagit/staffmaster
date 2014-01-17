<h2>Search Jobs</h2>

<p>Find jobs you have created to view and edit them.</p>
<a href="<?=base_url();?>job/calendar"><i class="icon-calendar"></i> Jobs Calendar</a>
&nbsp; &nbsp; &nbsp;
<a href="<?=base_url();?>job/create"><i class="icon-plus-sign"></i> Create Job</a>
<br /><br />
<div class="panel">
	<div class="panel-heading">Search Job</div>
	<div class="panel-body">
		<form class="form-horizontal" role="form" method="post" action="<?=base_url();?>job/search">
			<div class="row">
				<div class="col-md-12">
					<div class="form-group">
						<label for="keyword" class="col-lg-2 control-label">Job Group Name</label>
						<div class="col-lg-10">
							<input type="text" class="form-control" id="keyword" name="keyword" />
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<label for="staff_name" class="col-lg-4 control-label">Client</label>
						<div class="col-lg-8">
							<?=modules::run('client/dropdown', 'client_id');?>
						</div>
					</div>
					<div class="form-group">
						<label for="department_id" class="col-lg-4 control-label">Status</label>
						<div class="col-lg-8">
							<?=modules::run('common/dropdown_status','status');?>
						</div>
					</div>
					<div class="form-group">
						<label for="availability" class="col-lg-4 control-label">Date From</label>
						<div class="col-lg-8">
							<div class="input-group">
								<input type="text" class="form-control" id="date_from" />
								<span class="input-group-addon"><i class="icon-calendar"></i></span>
							</div>
						</div>
					</div>			
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label for="venue" class="col-lg-4 control-label">Venue</label>
						<div class="col-lg-8">
							<?=modules::run('attribute/venue/dropdown', 'venue');?>
						</div>
					</div>
					<div class="form-group">
						<label for="job_id" class="col-lg-4 control-label">Job ID</label>
						<div class="col-lg-8">
							<input type="text" class="form-control" name="job_id" id="job_id" />
						</div>
					</div>
					<div class="form-group">
						<label for="gender" class="col-lg-4 control-label">Date To</label>
						<div class="col-lg-8">
							<div class="input-group">
								<input type="text" class="form-control" id="date_to" />
								<span class="input-group-addon"><i class="icon-calendar"></i></span>
							</div>
						</div>
					</div>
				</div>
				
			</div>
			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<div class="col-lg-offset-4 col-lg-8">
							<button type="submit" class="btn btn-info"><i class="icon-search"></i> Search</button>
						</div>
					</div>
				</div>
			</div>
			
			
		
		</form>
	</div>
</div>

<? if (isset($jobs)) { ?>

<table class="table table-bordered">
	<thead>
	<tr class="heading">
		<td class="left" width="20%"><i class="icon-folder-open"></i> Job Group Name <a href="#"><i class="icon-sort-by-alphabet"></i></a></td>
		<td class="center"><i class="icon-book"></i> Client <a href="#"><i class="icon-sort-by-alphabet"></i></a></td>
		<td class="center"><i class="icon-map-marker"></i> Venue</td>
		<td class="center" width="10%"><i class="icon-user"></i> Date <a href="#"><i class="icon-sort-by-alphabet"></i></a></td>
		<td class="center" width="10%"><i class="icon-thumb-up"></i> Status</td>
		<td class="center" width="10%">View Job</td>
		<td class="center" width="10%">View Group</td>
	</tr>
	</thead>
	<? foreach($jobs as $job) { $client = modules::run('client/get_client', $job['client_id']); ?>
	<tr>
		<td class="left">
			<?=$job['name'];?>
			<br />
			
		</td>
		<td class="center"><?=$client['company_name'];?></td>
		<td></td>
		<td class="center"></td>
		<td class="center"></td>
		<td class="center"><a href="<?=base_url();?>job/details/<?=$job['job_id'];?>"><i class="fa fa-eye"></i></a></td>
		<td class="center"><a href="<?=base_url();?>job/details/<?=$job['job_id'];?>"><i class="icon-list icon-large"></i></a></td>
	</tr>
	<? } ?>
</table>

<? } ?>

 <script>
$(function() {
	$( "#date_from" ).datepicker({
		defaultDate: "+1w",
		onClose: function( selectedDate ) {
			$( "#date_to" ).datepicker( "option", "minDate", selectedDate );
		}
	});
	$( "#date_to" ).datepicker({
		defaultDate: "+1w",
		onClose: function( selectedDate ) {
			$( "#date_from" ).datepicker( "option", "maxDate", selectedDate );
		}
	});
});
</script>