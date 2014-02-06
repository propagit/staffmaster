<div class="form-group" id="f_availability<?=$num?>">
    <div class="col-lg-1">
        <select class="form-control" name="from_day<?=$num?>" id="from_day<?=$num?>">
        	<option value="1" <? if($from_day==1){echo "selected=selected";}?>>Monday</option>
            <option value="2" <? if($from_day==2){echo "selected=selected";}?>>Tuesday</option>
            <option value="3" <? if($from_day==3){echo "selected=selected";}?>>Wednesday</option>
            <option value="4" <? if($from_day==4){echo "selected=selected";}?>>Thursday</option>
            <option value="5" <? if($from_day==5){echo "selected=selected";}?>>Friday</option>
            <option value="6" <? if($from_day==6){echo "selected=selected";}?>>Saturday</option>
            <option value="7" <? if($from_day==7){echo "selected=selected";}?>>Sunday</option>
        </select>
    </div>
    <label class="col-lg-1 control-label">Available From:</label>
    <div class="col-lg-2">
        <div class="input-group date" id="start_time<?=$num?>">
            <input type="text" class="form-control" name="start_at<?=$num?>" data-format="HH:MM" value="<?=$start_time?>" />
            <span class="input-group-addon"><span class="glyphicon glyphicon-time"></span></span>
        </div>
    </div>
    <div class="col-lg-1">
        <select class="form-control" name="to_day<?=$num?>" id="to_day<?=$num?>">
        	<option value="1" <? if($to_day==1){echo "selected=selected";}?>>Monday</option>
            <option value="2" <? if($to_day==2){echo "selected=selected";}?>>Tuesday</option>
            <option value="3" <? if($to_day==3){echo "selected=selected";}?>>Wednesday</option>
            <option value="4" <? if($to_day==4){echo "selected=selected";}?>>Thursday</option>
            <option value="5" <? if($to_day==5){echo "selected=selected";}?>>Friday</option>
            <option value="6" <? if($to_day==6){echo "selected=selected";}?>>Saturday</option>
            <option value="7" <? if($to_day==7){echo "selected=selected";}?>>Sunday</option>
        </select>
    </div>
    <label class="col-lg-1 control-label">Available To:</label>
    <div class="col-lg-2">
        <div class="input-group date" id="finish_time<?=$num?>">
            <input type="text" class="form-control" name="finish_at<?=$num?>" data-format="HH:MM" value="<?=$finish_time?>" />
            <span class="input-group-addon"><span class="glyphicon glyphicon-time"></span></span>
        </div>
    </div>
    <div class="col-lg-1">
    	<button type="button" class="btn btn-info" onclick="remove_availability(<?=$num?>)"><i class="fa fa-trash-o"></i> Remove</button>
    </div>
</div>
<script>
$(function(){	
	$('#start_time<?=$num?>').datetimepicker({
        pickDate: false,
        minute: 59,
		minuteStepping: 60,
		
    });
	$('#finish_time<?=$num?>').datetimepicker({
        pickDate: false,
		minute: 59,
        minuteStepping: 60,
    });
	
	
});
function remove_availability(num)
{
	$('#f_availability'+num).fadeOut();
}
</script>