<h2>Search Staff</h2>

<p>Find your staff to communicate with them or view and edit their profile.</p>

<a href="#"><i class="icon-search"></i> Search Jobs</a>
&nbsp; &nbsp; &nbsp;
<a href="<?=base_url();?>staff/add"><i class="icon-plus-sign"></i> Add Staff</a>
<br /><br />
<div class="panel">
	<div class="panel-heading">Search Staff</div>
	<div class="panel-body">
		<form class="form-horizontal" role="form" method="post" action="<?=base_url();?>staff/search">
		<div class="row">
			<div class="col-md-6">
				<div class="form-group">
					<label for="staff_name" class="col-lg-4 control-label">Staff Name</label>
					<div class="col-lg-8">
						<input type="text" class="form-control" id="staff_name" name="staff_name" value="" tabindex="2" />
					</div>
				</div>
				<div class="form-group">
					<label for="department_id" class="col-lg-4 control-label">Department</label>
					<div class="col-lg-8">
						<?=modules::run('attribute/department/dropdown','department_id');?>
					</div>
				</div>
				<div class="form-group">
					<label for="availability" class="col-lg-4 control-label">Availability</label>
					<div class="col-lg-8">
						<?=modules::run('attribute/availability/dropdown','availability');?>
					</div>
				</div>
				<div class="form-group">
					<label for="state" class="col-lg-4 control-label">State</label>
					<div class="col-lg-8">
						<?=modules::run('common/dropdown_states', 'state');?>
					</div>
				</div>
				<div class="form-group">
					<label for="location" class="col-lg-4 control-label">Location</label>
					<div class="col-lg-8">
						<?=modules::run('attribute/location/dropdown', 'location');?>
					</div>
				</div>				
			</div>
			<div class="col-md-6">
				<div class="form-group">
					<label for="rating" class="col-lg-4 control-label">Rating</label>
					<div class="col-lg-8">
						<div class="rating pull-left">
							<span class="star"></span>
							<span class="star"></span>
							<span class="star"></span>
							<span class="star"></span>
							<span class="star"></span>
						</div>
					</div>
				</div>
				<div class="form-group">
					<label for="status" class="col-lg-4 control-label">Status</label>
					<div class="col-lg-8">
						<?=modules::run('common/dropdown_status', 'status');?>
					</div>
				</div>
				<div class="form-group">
					<label for="gender" class="col-lg-4 control-label">Gender</label>
					<div class="col-lg-8">
						<?=modules::run('common/dropdown_genders', 'gender');?>
					</div>
				</div>
				<div class="form-group">
					<label for="position" class="col-lg-4 control-label">Role</label>
					<div class="col-lg-8">
						<?=modules::run('attribute/role/dropdown', 'position');?>
					</div>
				</div>
				<div class="form-group">
					<label for="payrate" class="col-lg-4 control-label">Payrate</label>
					<div class="col-lg-8">
						<?=modules::run('attribute/payrate/dropdown', 'payrate');?>
					</div>
				</div>
			</div>
			
		</div>
		<div class="row">
			<div class="col-md-6">
				<div class="form-group">
					<div class="col-lg-offset-4 col-lg-8">
						<button type="submit" class="btn btn-info"><i class="icon-search"></i> Search Staff</button>
					</div>
				</div>
			</div>
		</div>
		
		
		</form>
	</div>
	<? if(isset($staffs)) { ?>
	<div class="panel-heading panel-heading-mid">Your Search Returned: <?=count($staffs);?> Results</div>
	<div class="panel-body">
		<div class="pull-right">
			<a href="#"><b><i class="icon-sort-by-alphabet"></i> Sort By Name</b></a>
		</div>
		<ul class="pagination">
			<li><a href="#">&laquo;</a></li>
			<li><a href="#">1</a></li>
			<li><a href="#">2</a></li>
			<li><a href="#">3</a></li>
			<li><a href="#">4</a></li>
			<li><a href="#">5</a></li>
			<li><a href="#">&raquo;</a></li>
		</ul>
		<div class="clearfix"></div>
		<? foreach($staffs as $staff) { ?>
		<div class="staff_search_profile">
			<a href="<?=base_url();?>staff/edit/<?=$staff['user_id'];?>"><div class="profile_photo">
				<i class="icon-user icon-4x"></i>
			</div></a>
			<b><?=$staff['first_name'] . '</b><br />' . $staff['last_name'];?>
			<div class="rating">
				<span class="star"></span>
				<span class="star"></span>
				<span class="star"></span>
				<span class="star"></span>
				<span class="star"></span>
			</div>
		</div>
		<? } ?>
		<div class="clearfix"></div>
	</div>
	<? } ?>
</div>
