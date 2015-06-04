<?php
	$label = json_decode($field['label']);
?>
<div class="row" id="field_<?=$field['field_id'];?>">
    <div class="form-group">
        <label class="col-md-2 control-label"><?=$label->file_label;?></label>
       <div class="col-md-10">
            <label class="radio custom-inline">
                <input type="radio" name="search_dateFile_file_<?=$field['field_id'];?>" value="yes" >
                Yes
            </label>
            <label class="radio custom-inline">
                <input type="radio" name="search_dateFile_file_<?=$field['field_id'];?>" value="no" >
                No
            </label>
        </div>
    </div>
    
    <div class="form-group">
       <label class="col-md-2 control-label"><?=$label->date_label;?> From</label>
       <div class="col-md-4">
            <div class="input-group date" id="search_file_date_from_<?=$field['field_id'];?>">
                <input type="text" class="form-control" name="search_dateFile_date_from_<?=$field['field_id'];?>" readonly placeholder="<?=$field['placeholder'];?> From" />
                <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
                <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
            </div>
        </div>
        
       <label class="col-md-2 control-label"><?=$label->date_label;?> To</label>
       <div class="col-md-4">
            <div class="input-group date" id="search_file_date_to_<?=$field['field_id'];?>">
                <input type="text" class="form-control" name="search_dateFile_date_to_<?=$field['field_id'];?>" readonly placeholder="<?=$field['placeholder'];?> To"/>
                <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
                <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
            </div>
        </div>
    </div>
</div>

<script>
$(function(){
	
	$('#search_file_date_from_<?=$field['field_id'];?>').datetimepicker({
        weekStart: 1,
        todayBtn:  1,
		autoclose: 1,
		todayHighlight: 1,
		startView: 2,
        minView: 2,
		forceParse: 1,
        format: 'dd-mm-yyyy',
    }).on('changeDate', function(e) {
    	var date_from = moment(e.date.valueOf() - 11*60*60*1000);
    	$('#search_file_date_to_<?=$field['field_id'];?>').datetimepicker('setStartDate', date_from.format("DD-MM-YYYY"));
    });
    $('#search_file_date_to_<?=$field['field_id'];?>').datetimepicker({
        weekStart: 1,
        todayBtn:  1,
		autoclose: 1,
		todayHighlight: 1,
		startView: 2,
        minView: 2,
		forceParse: 1,
        format: 'dd-mm-yyyy',
        pickerPosition: 'bottom-left'
    }).on('changeDate', function(e) {
    	var date_to = moment(e.date.valueOf() - 11*60*60*1000);
    	$('#search_file_date_from_<?=$field['field_id'];?>').datetimepicker('setEndDate', date_to.format("DD-MM-YYYY"));
    });
	
});
</script>
