<? foreach($uniforms as $uniform) { ?>
<tr>
    <td class="left"><?=$uniform['name'];?></td>
    <td class="center"><a class="edit-uniform" edit-data-id="<?=$uniform['uniform_id'];?>" edit-data-name="<?=$uniform['name'];?>"><i class="fa fa-pencil"></i></a></td>
    <td class="center"><a class="delete-uniform" delete-data-id="<?=$uniform['uniform_id'];?>"><i class="fa fa-times"></i></a></td>
</tr>
<? } ?>
<script>
$(function(){
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
				 help.delete_data(delete_uniform_params,function(deleted){
					  if(deleted){
						  help.load_content(load_params);
					  }
				 });
			 }
		});
	});
});
</script>