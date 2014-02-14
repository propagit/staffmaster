<?php
	$group_params = json_decode($params);
	$total_active_staffs = $group_params->total_active_staffs;	
?>
<table class="table table-bordered table-hover table-middle table-expanded">
	<thead>
	<tr class="heading">
		<th class="left">Group Name <i class="fa fa-sort sort-table" sort-by="name"></i></td>
        <th class="center col-md-2">Staff Assigned To Gruop <i class="fa fa-sort sort-table" sort-by="name"></i></th>
		<th class="center col-md-1"><i class="icon-eye-open"></i> Edit Group</td>
		<th class="center col-md-1"><i class="icon-trash"></i> Delete Group</td>
	</tr>
	</thead>
    <tbody>
	<? foreach($groups as $group) { ?>
	<tr>
		<td class="left"><?=$group['name'];?></td>
        <td class="center"><?=$group['frequency'];?>/<?=$total_active_staffs;?></td>
		<td class="center"><a class="edit-group" edit-data-id="<?=$group['group_id'];?>" edit-data-name="<?=$group['name'];?>"><i class="fa fa-pencil"></i></a></td>
		<td class="center"><a class="delete-group" delete-data-id="<?=$group['group_id'];?>"><i class="fa fa-times"></i></a></td>
	</tr>
	<? } ?>
    </tbody>
</table>
<script>
$(function(){
	
	//sort data
	help.sort_list('.sort-table',params);
	
	//open edit modal
	$('.edit-group').on('click',function(){
		var group_id = $(this).attr('edit-data-id');
		var group_name = $(this).attr('edit-data-name');
		open_edit_modal(group_id,group_name);
	});
	
	//delete uniform
	$('.delete-group').on('click',function(){
		var title = 'Delete Group';
		var message ='Are you sure you would like to delete this "Group"';
		var group_id = $(this).attr('delete-data-id');
		help.confirm_delete(title,message,function(confirmed){
			 if(confirmed){
				 delete_group_params.delete_id = group_id;
				 help.delete_data(delete_group_params,params);
			 }
		});
	});

});
</script>