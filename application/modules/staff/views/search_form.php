<!--begin top box--->
<div class="col-md-12">
	<div class="box top-box">
   		 <h2>Search Staff</h2>
		 <p>Find your staff to communicate with them or view and edit their profile.</p>
    </div>
</div>
<!--end top box-->

<!--begin bottom box -->
<div class="col-md-12">
	<div class="box bottom-box">
    	<div class="inner-box">
            <h2>Search Staff</h2>
		 	<p>Find your staff to communicate with them or view and edit their profile.</p>
            
			<form class="form-horizontal" id="form_search_staffs" role="form">
			<div class="row">
				<div class="form-group">
					<label for="staff_name" class="col-md-2 control-label">Staff Name</label>
					<div class="col-md-4">
						<input type="text" class="form-control" id="staff_name" name="staff_name" tabindex="2" />
					</div>
					<label for="rating" class="col-md-2 control-label">Rating</label>
					<div class="col-md-4">
                        <?=modules::run('common/field_rating', 'rating');?>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="form-group">
					<label for="department_id" class="col-md-2 control-label">Group</label>
					<div class="col-md-4">
						<?=modules::run('attribute/group/field_select', 'group_id');?>
					</div>
					<label for="status" class="col-md-2 control-label">Status</label>
					<div class="col-md-4">
						<?=modules::run('staff/field_select_status', 'status');?>
					</div>
				</div>
			</div>	
			<div class="row">
				<div class="form-group">
					<label for="state" class="col-md-2 control-label">State</label>
					<div class="col-md-4">
						<?=modules::run('common/field_select_states', 'state');?>
					</div>
					<label for="gender" class="col-md-2 control-label">Gender</label>
					<div class="col-md-4">
						<?=modules::run('common/field_select_genders', 'gender');?>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="form-group">
					<label for="location" class="col-md-2 control-label">Location</label>
					<div class="col-md-4">
						<?=modules::run('attribute/location/field_select', 'location_parent_id');?>
					</div>
					<label for="position" class="col-md-2 control-label">Role</label>
					<div class="col-md-4">
						<?=modules::run('attribute/role/field_select', 'position');?>
					</div>
				</div>				
			</div>
			<div class="row">
				<div class="form-group">
					<div class="col-md-offset-2 col-lg-4">
						<button type="button" class="btn btn-core" id="btn_search_staffs"><i class="fa fa-search"></i> Search Staff</button>
					</div>
				</div>
			</div>			
		
			</form>
			
			<div id="staffs_search_results"></div>
		</div>
	</div>
</div>
<!--end bottom box -->

<script>
$(function(){
	$('#btn_search_staffs').click(function(){
		search_staffs();
	})
})
function search_staffs() {
	preloading($('#staffs_search_results'));
	$.ajax({
		type: "POST",
		url: "<?=base_url();?>staff/ajax/search_staffs",
		data: $('#form_search_staffs').serialize(),
		success: function(html) {
			loaded($('#staffs_search_results'), html);
		}
	})
}
</script>