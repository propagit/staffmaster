<?php
	if($existing_elements){
	foreach($existing_elements as $elem){
		$staff_custom_attribute = modules::run('staff/get_staff_custom_attribute',$user_id,$elem->name);
		switch($elem->type){		
			case 'filebutton':
?>
		    <div class="form-group">
                <label class="col-md-3 control-label"><?=$elem->label;?></label>
                <div class="col-md-4">
                	<?php 
						if($staff_custom_attribute['attributes']!=''){
					?>
                    	<a href="<?=base_url();?>uploads/staff/custom_attributes/<?=md5('custom_files'.$user_id);?>/<?=$staff_custom_attribute['attributes'];?>"><?=$staff_custom_attribute['attributes'];?></a>
                        <i title="Delete Document" class="fa fa-times custom-file-delete" delete-data-id="<?=$staff_custom_attribute['staffs_custom_attributes_id'];?>"></i>
                    <?php			
						}else{ 
					?>
               		<input id="filebutton" name="<?=$elem->name?>" class="input-file" type="file">
                    <?php } ?>
                </div>
            </div>
<?php	
			break;					
		}		
	}//foreach
	}

?>
<script>
$('.custom-file-delete').on('click',function(){
		var title = 'Delete Document';
		var message ='Are you sure you would like to delete this "Document"';
		var custom_form_id = $(this).attr('delete-data-id');
		help.confirm_delete(title,message,function(confirmed){
			 if(confirmed){
				window.location.replace('<?=base_url();?>staff/delete_custom_document/'+custom_form_id);
			 }
		});
	});
</script>
