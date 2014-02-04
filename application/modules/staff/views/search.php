<h2>Search Staff</h2>

<p>Find your staff to communicate with them or view and edit their profile.</p>

<a href="<?=base_url();?>job/search"><i class="fa fa-search"></i> Search Jobs</a>
&nbsp; &nbsp; &nbsp;
<a href="<?=base_url();?>staff/add"><i class="fa fa-plus"></i> Add Staff</a>
<br /><br />
<div class="panel panel-default">
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
						<? //=modules::run('attribute/location/dropdown', 'location');?>
                        <?=modules::run('common/dropdown_location_form', 'location');?>
					</div>
				</div>				
			</div>
			<div class="col-md-6">
				<div class="form-group">
					<label for="rating" class="col-lg-4 control-label">Rating</label>
					<div class="col-lg-8">						
                        <?=modules::run('common/select_rating', 'rating');?>
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
						<button type="submit" class="btn btn-info"><i class="fa fa-search"></i> Search Staff</button>
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
		<? foreach($staffs as $staff) {
			$photo = $this->staff_model->get_hero($staff['staff_id']);
			if(count($photo)>0)
			{
				$thumb_src = base_url().'uploads/staff/profile/'.md5($staff['staff_id']).'/thumbnail/'.$photo['name'];
				$class="resize";
			}
			else
			{
				$thumb_src = base_url().'assets/img/dummy/default-avatar.png';
				$photo['name'] = "Use Avatar";
				$class='normal';
			}
		 ?>
		<div class="staff_search_profile">
			<a href="<?=base_url();?>staff/edit/<?=$staff['user_id'];?>">
            <div class="profile_photo">
				<img class="<?=$class?>" src="<?=$thumb_src;?>" title="<?=$staff['first_name'].' '.$staff['last_name']?>" alt="<?=$photo['name']?>" />
			</div>
            </a>
			<b><?=$staff['first_name'] . '</b><br />' . $staff['last_name'];?></b>
            
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
