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
               		<input id="filebutton" name="<?=$elem->name?>" class="input-file" type="file">
                </div>
            </div>
<?php	
			break;					
		}		
	}//foreach
	}

?>
