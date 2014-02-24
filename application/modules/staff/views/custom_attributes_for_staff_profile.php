<?php
	if($existing_elements){
	foreach($existing_elements as $elem){
		$staff_custom_attribute = modules::run('staff/get_staff_custom_attribute',$user_id,$elem->name);
		switch($elem->type){
			case 'textinput':
?>
			<div class="form-group">
                <label class="col-md-3 control-label"><?=$elem->label;?></label>
                <div class="col-md-4">
                    <input id="textinput" name="<?=$elem->name;?>" placeholder="<?=$elem->placeholder;?>" class="form-control" value="<?=$staff_custom_attribute['attributes'];?>" >
                </div>
            </div>
<?php
			break;
			
			case 'textarea':
?>
		   <div class="form-group">
                <label class="col-md-3 control-label"><?=$elem->label;?></label>
                <div class="col-md-4">
               		<textarea id="textarea" name="<?=$elem->name;?>" class="form-control"><?=$staff_custom_attribute['attributes'];?></textarea>
                </div>
            </div>
<?php
			break;
			
			case 'radio':
?>
			<div class="form-group">
                <label class="col-md-3 control-label"><?=$elem->label;?></label>
                <div class="col-md-4">
               		<?php
				   		$attrs = json_decode($elem->attributes);
						if($attrs){
							foreach($attrs as $attr){
								$checked = '';
								if($staff_custom_attribute['has_multi']){
									if(in_array($attr->value,$staff_custom_attribute['attributes'])){
                                    	$checked = 'checked="checked"';
                                    }	
								}else{
									if($attr->value == $staff_custom_attribute['attributes']){
										$checked = 'checked="checked"';	
									}
								}
				   ?>
						<label class="radio <?=($elem->inline_element == 'yes' ? 'custom-inline' : '' );?>">
                          <input type="radio" name="<?=$elem->name;?>" value="<?=$attr->value;?>" <?=$checked;?> >
                          <?=$attr->value;?>
                        </label>
                   <?php
				   			}
							
						}
				   ?>
                </div>
            </div>
<?php
			break;	
						
			case 'checkbox':
?>
			<div class="form-group">
                <label class="col-md-3 control-label"><?=$elem->label;?></label>
                <div class="col-md-4">
               		<?php
				   		$attrs = json_decode($elem->attributes);
						if($attrs){
							foreach($attrs as $attr){
								$checked = '';
								if($staff_custom_attribute['has_multi']){
									if(in_array($attr->value,$staff_custom_attribute['attributes'])){
                                    	$checked = 'checked="checked"';
                                    }	
								}else{
									if($attr->value == $staff_custom_attribute['attributes']){
										$checked = 'checked="checked"';	
									}
								}
				   ?>
						<label class="checkbox <?=($elem->inline_element == 'yes' ? 'custom-inline' : '' );?>">
                          <input type="checkbox" name="<?=$elem->name;?>[]" value="<?=$attr->value;?>" <?=$checked;?>>
                          <?=$attr->value;?>
                        </label>
                   <?php
				   			}
							
						}
				   ?>
                </div>
            </div>
<?php			
			break;
			
			case 'select':
?>
			<div class="form-group">
                <label class="col-md-3 control-label"><?=$elem->label;?></label>
                <div class="col-md-4">
               		<select id="select-basic" name="<?=$elem->name;?><?=($elem->multi_select == 'yes' ? '[]' : '');?>" class="form-control" <?=($elem->multi_select == 'yes' ? 'multiple="multiple"' : '');?>>
                      <?php
					  	$attrs = json_decode($elem->attributes);
						if($attrs){
							foreach($attrs as $attr){
								$selected = '';
								if($staff_custom_attribute['has_multi']){
									if(in_array($attr->value,$staff_custom_attribute['attributes'])){
                                    	$selected = 'selected="selected"';
                                    }	
								}else{
									if($attr->value == $staff_custom_attribute['attributes']){
										$selected = 'selected="selected"';	
									}
								}
					  ?>
                      <option value="<?=$attr->value;?>" <?=$selected;?>><?=$attr->option;?></option>
                      <?php
							}
							
						}
					  ?>
                      </select>
                </div>
            </div>

<?php			
			break;				
		}		
	}//foreach
?>
		<div class="form-group">
            <div class="col-md-12">
                <div class="alert alert-success hide" id="msg-update-custom-attributes"><i class="fa fa-check"></i> &nbsp; Custom attributes successfully updated</div>
                <button type="button" class="btn btn-core" id="update-custom-attributes"><i class="fa fa-save"></i> Update Custom Attributes</button>
            </div>
		</div>
<?php
	}else{
		if(modules::run('auth/is_admin')){
			echo 'You have not created any custom attributes yet. To create custom attributes go to "Edit Attributes" and then "Custom Attributes"';
		}
	}

?>
