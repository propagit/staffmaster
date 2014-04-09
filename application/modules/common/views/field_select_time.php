<div class="field-select-time">
	<div class="col-md-4 remove-left-padding">
    	<?=modules::run('common/field_select',$hours,$field_name.'_hour',$field_value,$size,$title);?>
    </div>
    <div class="col-md-4 remove-left-padding">
   	 <?=modules::run('common/field_select',$minutes,$field_name.'_minutes',$field_value,$size,$title);?>
    </div>
</div>