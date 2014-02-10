<!--begin top box--->
<div class="col-md-12">
	<div class="box top-box">
   		 <h2>Roles</h2>
		 <p>A role is the skill required for a staff member to perform on a shift. When you create a job you will be asked for the role the staff member is required to perform on the job. You can set roles that staff can work on via their personal profiles. The roles you set staff to work will effect what jobs they can apply for and what staff will appear when you search for staff by the role.</p>
    </div>
</div>
<!--end top box-->

<!--begin bottom box -->
<div class="col-md-12">
	<div class="box bottom-box">
    	<div class="inner-box">
            <h2>Add - Edit Roles</h2>
			<p>Add new roles by clicking the "Add New Roles" button or manage your existing roles via the below table.</p>
            <button class="btn btn-info" data-toggle="modal" href="#addRole" ><i class="fa fa-plus"></i> Add Role</button>
            <br /><br />
           
           
           	<div id="load-roles"></div>
           
        </div>
    </div>
</div>
<!--end bottom box -->




<!-- Add Role Modal -->
<div class="modal fade" id="addRole" tabindex="-1" role="dialog" aria-labelledby="addRoleLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>
				<h4 class="modal-title">Add New Role</h4>
			</div>
            <div class="col-md-12">
				<div class="modal-body">
            	<h4 class="modal-body-title">Enter Role Name</h4>
                <p>
                The Role name should represent the job the staff will perform whilst performing this role such as "Junior Bar Staff" as example.
                </p>
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="name">Name</label>
                    </div>
                </div>
                <div class="col-md-10">
                	<div class="form-group">
                        <input type="text" class="form-control" name="name" id="name" placeholder="Enter role name">
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="name">&nbsp;</label>
                    </div>
                </div>
                <div class="col-md-10">
                	<div class="form-group">
                        <button type="button" class="btn btn-info" onclick="add_role();"><i class="fa fa-plus"></i> Add Role</button>
                    </div>
                </div>
			</div>
            </div>
			<div class="modal-footer">
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->



<!-- Edit Role Modal -->
<div class="modal fade" id="editRole" tabindex="-1" role="dialog" aria-labelledby="editRoleLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>
				<h4 class="modal-title">Edit Role</h4>
			</div>
			<input type="hidden" name="role_id" id="role_id" />
            <div class="col-md-12">
                <div class="modal-body">           
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="name">Name</label>
                        </div>
                    </div>
                    <div class="col-md-10">
                        <div class="form-group">
                            <input type="text" class="form-control" name="name" id="name_edit" placeholder="Enter role name">
                        </div>
                    </div>
                    
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="name">&nbsp;</label>
                        </div>
                    </div>
                    <div class="col-md-10">
                        <div class="form-group">
                            <button type="button" class="btn btn-info" onclick="edit_role();"><i class="fa fa-plus"></i> Edit Role</button>
                        </div>
                    </div>
                </div>
            </div>
			<div class="modal-footer">
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<script>

var params = {
	'url': '<?=base_url();?>attribute/ajax/get_roles',
	'output_container':'#load-roles',
	'type':'POST',
	'data':'name_asc'
};

var sort_type = {
	'name_sort':'name_asc',
	'frequency_sort':'frequency_asc'	
};


$(function(){
	help.load_content(params);
});

 
function sort_list(sort_data){
	switch(sort_data){
		case 'name':
			if(sort_type.name_sort == 'name_asc'){
				sort_type.name_sort = 'name_desc';	
			}else{
				sort_type.name_sort = 'name_asc';	
			}
			params.data = sort_type.name_sort; 	
		break;
	}
	help.load_content(params);
} 

function add_role(){
	$.ajax({
		type: 'POST',
		url: '<?=base_url();?>attribute/ajax/add_role',
		data:{name:$('#name').val()},
		success: function(html) {
			help.load_content(params);
			$('#addRole').modal('hide');
		}
	});	 
}


function confirm_delete(role_id){
	
	var call_back_function = 'onclick="delete_role('+role_id+')"';
	var delete_message = 'You are about to delete this Role. Confirm Delete?';
	help.confirm_delete(call_back_function,delete_message);
}

function delete_role(role_id){
	$.ajax({
		type: 'POST',
		url: '<?=base_url();?>attribute/ajax/delete_role',
		data:{role_id:role_id},
		success: function(html) {
			help.load_content(params);
			$('#confirm_delete_modal').modal('hide');
		}
	});	 
}

function open_edit_modal(role_id, name){
	$('#role_id').val(role_id);
	$('#name_edit').val(name);
	$('#editRole').modal('show');
}

function edit_role(){
	$.ajax({
		type: 'POST',
		url: '<?=base_url();?>attribute/ajax/edit_role',
		data:{new_name:$('#name_edit').val(),role_id:$('#role_id').val()},
		success: function(html) {
			help.load_content(params);
			$('#editRole').modal('hide');
		}
	});	 
}

</script>