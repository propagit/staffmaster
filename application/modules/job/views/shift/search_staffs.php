<div class="modal-dialog modal-lg">
	<div class="modal-content">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			<h4 class="modal-title" id="myModalLabel">Find Staff</h4>
		</div>
		<div class="col-md-12">			
			<div class="modal-body" id="shift-search-staffs">
				<div class="col-md-7">
					<h4>Search Staff</h4>
					<p>Find staff to fill this shift<br />&nbsp;</p>
					<form class="form-horizontal" id="form_search_staffs" role="form">
					<div class="row">
						<div class="form-group">
							<label for="staff_name" class="col-md-2 control-label">Name:</label>
							<div class="col-md-10">
								<input type="text" class="form-control" id="staff_name" name="keyword" placeholder="Enter staff name" />
							</div>
						</div>
					</div>
					<div class="row">
						<div class="form-group">
							<label class="col-lg-2 control-label">Role</label>
							<div class="col-lg-4">
								<?=modules::run('attribute/role/field_select', 'role_id');?>
							</div>
							<label class="col-lg-2 control-label">Gender</label>
							<div class="col-lg-4">
								<?=modules::run('common/field_select_genders', 'gender');?>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="form-group">
							<label class="col-lg-2 control-label">Location</label>
							<div class="col-lg-10">
								<?=modules::run('attribute/location/field_select', 'location_parent_id');?>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="form-group">
							<label class="col-lg-2 control-label">Rating</label>
							<div class="col-lg-4">
								<?=modules::run('common/field_rating', 'rating', 0,'basic-search-form','wp-rating-0','no-user',false,false);?>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="form-group">
							<label class="col-lg-2 control-label">Available</label>
							<div class="col-lg-3">
								<div class="radio"><input type="radio" name="availability" /> Only Show</div>
							</div>
							<div class="col-lg-4">
								<div class="radio"><input type="radio" name="availability" /> Show All Staff</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="form-group">
							<div class="col-lg-3 col-lg-offset-2">
								<button class="btn btn-core"><i class="fa fa-search"></i> Search</button>
							</div>
							<div class="col-lg-4 help-block">
								<a><i class="fa fa-plus"></i></a> &nbsp; <a href="#"><b>More Options</b></a>
							</div>
						</div>
					</div>
					</form>
				</div>
				<div class="col-md-5">
					<h4>Most Suitable Staff</h4>
					<p>Based on your staff profiles, below staffs are best suited to fill this shift.</p>
				</div>
			</div>
		</div>
	</div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->