<?php
	$label = json_decode($field['label']);
?>
<div class="row" id="field_<?=$field['field_id'];?>">
    <div class="form-group">
        <label class="col-md-2 control-label"><?=$label->file_label;?></label>
       <div class="col-md-10">
            <label class="radio custom-inline">
                <input type="radio" name="search_file_<?=$field['field_id'];?>" value="yes" >
                Yes
            </label>
            <label class="radio custom-inline">
                <input type="radio" name="search_file_<?=$field['field_id'];?>" value="no" >
                No
            </label>
        </div>
    </div>
    
    <div class="form-group">
        <label class="col-md-2 control-label"><?=$label->date_label;?></label>
       <div class="col-md-4">
            <div class="input-group date" id="search_file_date_<?=$field['field_id'];?>">
                <input type="text" class="form-control" name="search_file_date_<?=$field['field_id'];?>" readonly />
                <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
                <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
            </div>
        </div>
    </div>
</div>

<script>
$(function(){
	$('#search_file_date_<?=$field['field_id'];?>').datetimepicker({
        weekStart: 1,
        todayBtn:  1,
		autoclose: 1,
		todayHighlight: 1,
		startView: 2,
        minView: 2,
		forceParse: 1,
        format: 'dd-mm-yyyy',
    });
	
});
</script>
