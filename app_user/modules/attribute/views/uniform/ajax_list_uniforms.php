<?php if(count($uniforms)){ ?>
<table class="table table-bordered table-hover table-middle table-expanded">
    <thead>
    <tr class="heading">
        <th class="left">Uniform <i class="fa fa-sort sort-table" sort-by="name"></i></a></th>
        <th class="center col-md-1">Edit Uniform</th>
        <th class="center col-md-1">Delete Uniform</th>
    </tr>
    </thead>
    <tbody>
        <? foreach($uniforms as $uniform) { ?>
        <tr>
            <td class="left"><?=$uniform['name'];?></td>
            <td class="center"><a class="edit-uniform" edit-data-id="<?=$uniform['uniform_id'];?>" edit-data-name="<?=$uniform['name'];?>"><i class="fa fa-pencil"></i></a></td>
            <td class="center"><a class="delete-uniform" delete-data-id="<?=$uniform['uniform_id'];?>"><i class="fa fa-times"></i></a></td>
        </tr>
        <? } ?>
    </tbody>
</table>

<script>
$(function(){
	
	//sort data
	help.sort_list('.sort-table',params);
	
	//open edit modal
	$('.edit-uniform').on('click',function(){
		var uniform_id = $(this).attr('edit-data-id');
		var uniform_name = $(this).attr('edit-data-name');
		open_edit_modal(uniform_id,uniform_name);
	});
	
	//delete uniform
	$('.delete-uniform').on('click',function(){
		var title = 'Delete Uniform';
		var message ='Are you sure you would like to delete this "Uniform"';
		var uniform_id = $(this).attr('delete-data-id');
		help.confirm_delete(title,message,function(confirmed){
			 if(confirmed){
				 delete_uniform_params.delete_id = uniform_id;
				 help.delete_data(delete_uniform_params,params);
			 }
		});
	});
});
</script>
<?php } //if count uniforms?>