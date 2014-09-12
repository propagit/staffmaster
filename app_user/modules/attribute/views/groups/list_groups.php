<!--begin top box--->
<div class="col-md-12">
	<div class="box top-box">
   		 <h2><i class="icon-attributesGroups"></i> &nbsp; Manage Groups</h2>
		 <p>
         	Groups are used to group staff together so you can communicate with a group of staff.
         	Staff can be assigned to the groups you create below. You can select group to communicate 
            with via the conversation module and the comm centre.
        </p>
        <button class="btn btn-info btn-rt-margin" data-toggle="modal" href="#addGroup" ><i class="fa fa-plus"></i> Add New Group</button>
    </div>
</div>
<!--end top box-->

<!--begin bottom box -->
<div class="col-md-12" id="load-groups" >
	
</div>
<!--end bottom box -->

<!-- Add Role Modal -->
<div class="modal fade" id="addGroup" tabindex="-1" role="dialog" aria-labelledby="addGroupLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>
				<h4 class="modal-title">Add Group</h4>
			</div>
            <div class="col-md-12">
                <form id="add-group-form" data-url="<?=base_url();?>attribute/ajax/add_group">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="name" class="col-sm-2 control-label">Name</label>
                        <div class="col-sm-10">
                        	<input type="text" class="form-control" name="name" id="name" placeholder="Enter group name">
                        </div>
                    </div>
                    <div class="form-group">
                        	 <label for="add-button" class="col-sm-2 control-label">&nbsp;</label>
                        <div class="col-sm-10">
                          	<button id="add-new-group-btn" type="button" class="btn btn-info"><i class="fa fa-plus"></i> Add New Group</button>
                        </div>
                    </div>
                </div>
                </form>
            </div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- Edit Role Modal -->
<div class="modal fade" id="editGroup" tabindex="-1" role="dialog" aria-labelledby="editGroupLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>
				<h4 class="modal-title">Edit Group</h4>
			</div>
            <div class="col-md-12">
                <form id="edit-group-form" data-url="<?=base_url();?>attribute/ajax/edit_group">
                <input type="hidden" name="group_id" id="group_id" />
                <div class="modal-body">
                    <div class="form-group">
                        <label for="name_edit" class="col-sm-2 control-label">Name</label>
                        <div class="col-sm-10">
                        	<input type="text" class="form-control" name="name" id="name_edit" placeholder="Enter group name">
                        </div>
                    </div>
                    <div class="form-group">
                        	 <label for="add-button" class="col-sm-2 control-label">&nbsp;</label>
                        <div class="col-sm-10">
                          	<button id="edit-group-btn" type="button" class="btn btn-info">Update Group</button>
                        </div>
                    </div>
                </div>
                </form>
            </div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<script>
var sort_data = {
	'sort_by':'name',
	'sort_order':'asc',
	'total_active_staffs':<?=modules::run('staff/get_total_staff');?>	
};

var params = {
	'url': '<?=base_url();?>attribute/ajax/get_groups',
	'output_container':'#load-groups',
	'type':'POST',
	'data':JSON.stringify(sort_data)
};

var delete_group_params = {
	'url': '<?=base_url();?>attribute/ajax/delete_group',
	'delete_id':''
}


$(function(){
	//load existing groups
	help.load_content(params);
	
	//add new uniform
	$('#add-new-group-btn').on('click',function(){
		 help.submit_form_data('add-group-form',function(success){
			if(success){
				$('#addGroup').modal('hide');
				help.load_content(params);
			}
		 });
	});
	
	//edit uniform
	$('#edit-group-btn').on('click',function(){
		 help.submit_form_data('edit-group-form',function(success){
			if(success){
				$('#editGroup').modal('hide');
				help.load_content(params);
			}
		 });
	});
});

function open_edit_modal(group_id, name){
	$('#group_id').val(group_id);
	$('#name_edit').val(name);
	$('#editGroup').modal('show');
}


</script>