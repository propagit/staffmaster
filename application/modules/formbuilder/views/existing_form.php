<? // echo '<pre>'.print_r($existing_elements,true).'</pre>'; ?>
<?php
	if($existing_elements){
	foreach($existing_elements as $elem){
		switch($elem->type){
			case 'textinput':
?>
			<div class="push dropped" data="popover-textinput">
                <div class="control-group" type="textinput">
                  <label class="control-label" id="textinput-label"><?=$elem->label;?></label>
                  <div class="controls">
                    <input id="textinput" name="<?=$elem->name;?>" type="text" placeholder="<?=$elem->placeholder;?>" class="form-control" >
                  </div>
                  	<input class="sort-index" type="hidden" value="<?=$elem->order;?>" data="<?=$elem->name;?>"  />
                </div>
             </div>
<?php
			break;
			
			case 'textarea':
?>
			<div class="push dropped" data="popover-textarea">
               <div class="control-group" type="textarea">
                  <label class="control-label" id="textarea-label"><?=$elem->label;?></label>
                  <div class="controls">                     
                    <textarea id="textarea" name="<?=$elem->name;?>" class="form-control"></textarea>
                  </div>
                  <input class="sort-index" type="hidden" value="<?=$elem->order;?>" data="<?=$elem->name;?>"  />
                </div>
            </div>
<?php
			break;
			
			case 'radio':
?>
			<div class="push dropped" data="popover-radio-checkbox">
                <div class="control-group" type="<?=($elem->inline_element == 'no' ? 'multi-radios' : 'inline-radios' );?>">
                  <label class="control-label" id="radio-checkbox-label" data="<?=($elem->inline_element == 'no' ? 'multi-radios' : 'inline-radios' );?>"><?=$elem->label;?></label>
                  <div class="controls">
                   <?php
				   		$attrs = json_decode($elem->attributes);
						if($attrs){
							foreach($attrs as $attr){
				   ?>
						<label class="radio <?=($elem->inline_element == 'yes' ? 'inline' : '' );?>">
                          <input type="radio" name="<?=$elem->name;?>" value="<?=$attr->value;?>">
                          <?=$attr->value;?>
                        </label>
                   <?php
				   			}
							
						}
				   ?>

                  </div>
                  <input class="sort-index" type="hidden" value="<?=$elem->order;?>" data="<?=$elem->name;?>"  />
                </div>
            </div>
<?php
			break;	
						
			case 'checkbox':
?>
			<div class="push dropped" data="popover-radio-checkbox">
                <div class="control-group" type="<?=($elem->inline_element == 'no' ? 'multi-checkbox' : 'inline-checkbox' );?>">
                  <label class="control-label" id="radio-checkbox-label" data="<?=($elem->inline_element == 'no' ? 'multi-checkbox' : 'inline-checkbox' );?>">Multiple Checkboxes</label>
                  <div class="controls">
                   <?php
				   		$attrs = json_decode($elem->attributes);
						if($attrs){
							foreach($attrs as $attr){
				   ?>
                    <label class="checkbox <?=($elem->inline_element == 'yes' ? 'inline' : '' );?>">
                      <input type="checkbox" name="<?=$elem->name;?>" value="<?=$attr->value;?>">
                      Option one
                    </label>
                    <?php
							}
						}
					?>
                  </div>
                  <input class="sort-index" type="hidden" value="<?=$elem->order;?>" data="<?=$elem->name;?>"  />
                </div>
            </div>
<?php			
			break;
			
			case 'select':
?>
			<div class="push dropped" data="popover-select">
                  <div class="control-group" type="<?=($elem->multi_select == 'no' ? 'select-basic' : 'select-multi' );?>">
                    <label class="control-label" id="select-label" data="<?=($elem->multi_select == 'no' ? 'select-basic' : 'select-multi' );?>"><?=$elem->label;?></label>
                    <div class="controls">
                      <select id="select-basic" name="<?=$elem->name;?>" class="form-control" <?=($elem->multi_select == 'yes' ? 'multiple="multiple"' : '');?>>
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
                    <input class="sort-index" type="hidden" value="<?=$elem->order;?>" data="<?=$elem->name;?>"  />
                  </div>
           </div>

<?php			
			break;
?>

<?php			
			case 'filebutton':
?>
			<div class="push dropped" data="popover-button">
                <div class="control-group" type="filebutton">
                  <label class="control-label" id="filebutton-label"><?=$elem->label;?></label>
                  <div class="controls">
                    <input id="filebutton" name="<?=$elem->name?>" class="input-file" type="file">
                  </div>
                  <input class="sort-index" type="hidden" value="<?=$elem->order;?>" data="<?=$elem->name;?>"  />
                </div>
            </div>
<?php	
			break;					
		}		
	}//foreach
	}//if 

?>
