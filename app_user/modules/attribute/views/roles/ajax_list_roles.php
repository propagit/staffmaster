<?php
	if(count($roles)){
	$role_params = json_decode($params);
	$total_active_staffs = $role_params->total_active_staffs;	
?>
<div class="box bottom-box">
	<div class="inner-box">
        <h2>Your Roles</h2>
		<p>Add new roles by clicking the "Add New Roles" button or manage your existing roles via the below table.</p>         
       
       	<div class="attr-list-wrap">
	       	<table class="table table-bordered table-hover table-middle table-expanded">
			    <thead>
			        <tr>
			            <th class="left">Role <i class="fa fa-sort sort-table" sort-by="name"></i></th>
			            <th class="center col-md-2">Staff Assigned To Role <i class="fa fa-sort sort-table" sort-by="frequency"></i></th>
			            <th class="center col-md-1">Edit Role</th>
			            <th class="center col-md-1">Delete Role</th>
			        </tr>
			    </thead>
			    <tbody>
			    <? foreach($roles as $role) { ?>
			    <tr>
			        <td class="left"><?=$role['name'];?></td>
			        <td class="center"><?=$role['frequency'];?>/<?=$total_active_staffs;?></td>
			        <td class="center"><a class="edit-role" edit-data-id="<?=$role['role_id'];?>" edit-data-name="<?=$role['name'];?>"><i class="fa fa-pencil"></i></a></td>
			        <td class="center"><a class="delete-role" delete-data-id="<?=$role['role_id'];?>"><i class="fa fa-times"></i></a></td>
			        
			    </tr>
			    <? } ?>
			    </tbody>
			</table>
       	</div>
       
    </div>
</div>

<script>
$(function(){
	//sort data
	help.sort_list('.sort-table',params);
	
	$('.edit-role').on('click',function(){
		var role_id = $(this).attr('edit-data-id');
		var role_name = $(this).attr('edit-data-name');
		open_edit_modal(role_id,role_name);
	});
	
	$('.delete-role').on('click',function(){
		var title = 'Delete Role';
		var message ='Are you sure you would like to delete this "Role"';
		var role_id = $(this).attr('delete-data-id');
		help.confirm_delete(title,message,function(confirmed){
			 if(confirmed){
				 delete_role(role_id);
				 help.load_content(params);
			 }
		});
	});
});
</script>
<? } // if count roles ?>