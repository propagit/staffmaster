<?php
	if($existing_elements){
	foreach($existing_elements as $elem){
		switch($elem->type){
			case 'textinput':
?>
			<div class="row">
                <div class="form-group">
                    <label class="col-md-2 control-label"><?=$elem->label;?></label>
                    <div class="col-md-4">
                        <input id="textinput" name="custom_attrs_<?=$elem->name;?>" placeholder="<?=$elem->placeholder;?>" class="form-control" value="" >
                    </div>
                </div>
            </div>
<?php
			break;
			
			case 'textarea':
?>
		   <div class="row">
               <div class="form-group">
                    <label class="col-md-2 control-label"><?=$elem->label;?></label>
                    <div class="col-md-4">
                        <textarea id="textarea" name="custom_attrs_<?=$elem->name;?>" class="form-control"></textarea>
                    </div>
                </div>
            </div>
<?php
			break;
			
			case 'radio':
?>
			<div class="row">
                <div class="form-group">
                    <label class="col-md-2 control-label"><?=$elem->label;?></label>
                    <div class="col-md-4">
                        <?php
                            $attrs = json_decode($elem->attributes);
                            if($attrs){
                                foreach($attrs as $attr){
                       ?>
                            <label class="radio <?=($elem->inline_element == 'yes' ? 'custom-inline' : '' );?>">
                              <input type="radio" name="custom_attrs_<?=$elem->name;?>" value="<?=$attr->value;?>" >
                              <?=$attr->value;?>
                            </label>
                       <?php
                                }
                                
                            }
                       ?>
                    </div>
                </div>
            </div>
<?php
			break;	
						
			case 'checkbox':
?>
			<div class="row">
                <div class="form-group">
                    <label class="col-md-2 control-label"><?=$elem->label;?></label>
                    <div class="col-md-4">
                        <?php
                            $attrs = json_decode($elem->attributes);
                            if($attrs){
                                foreach($attrs as $attr){
                       ?>
                            <label class="checkbox <?=($elem->inline_element == 'yes' ? 'custom-inline' : '' );?>">
                              <input type="checkbox" name="custom_attrs_<?=$elem->name;?>[]" value="<?=$attr->value;?>">
                              <?=$attr->value;?>
                            </label>
                       <?php
                                }
                                
                            }
                       ?>
                    </div>
                </div>
            </div>
<?php			
			break;
			
			case 'select':
?>
			<div class="row">
                <div class="form-group">
                    <label class="col-md-2 control-label"><?=$elem->label;?></label>
                    <div class="col-md-4">
                        <select id="select-basic" name="custom_attrs_<?=$elem->name;?><?=($elem->multi_select == 'yes' ? '[]' : '');?>" class="form-control" <?=($elem->multi_select == 'yes' ? 'multiple="multiple"' : '');?>>
                          <option value="0" selected="selected">Any</option>
						  <?php
                            $attrs = json_decode($elem->attributes);
                            if($attrs){
                                foreach($attrs as $attr){
                          ?>
                          <option value="<?=$attr->value;?>"><?=$attr->option;?></option>
                          <?php
                                }
                                
                            }
                          ?>
                          </select>
                    </div>
                </div>
            </div>

<?php
			break;
			
			case'filebutton':
?>
			<div class="row">
                <div class="form-group">
                    <label class="col-md-2 control-label"><?=$elem->label;?></label>
                   <div class="col-md-4">
                   		<label class="radio custom-inline">
                        	<input type="radio" name="custom_file_<?=$elem->name;?>" value="yes" >
                            Yes 
                        </label>
                        <label class="radio custom-inline">
                        	<input type="radio" name="custom_file_<?=$elem->name;?>" value="no" >
                            No
                        </label>
                    </div>
                </div>
            </div>
<?php			
			break;				
		}		
	}//foreach
?>
<?php
	}else{
		if(modules::run('auth/is_admin')){
			echo 'You have not created any custom attributes yet. To create custom attributes go to "Edit Attributes" and then "Custom Attributes"';
		}
	}

?>
