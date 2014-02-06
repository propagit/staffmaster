<table class="table">
	<tr>
    	<td>Day</td>
        <td>Unavailability Time</td>
        <td></td>
    </tr>
    <tr>
    	<td>Monday</td>
        <td>
        	<div id="monday">
            	<? 
					$monday_text ='';
				   if(isset($monday) && $monday !=''){
        			
					foreach($monday as $mon){
						$monday_text = $monday_text.$mon.'#';
					?>
                		<span id="mon<?=$num?>">[ <?=$mon?> ] <a class="removetime" onclick="remove_time(1,<?=$num?>);"><i class="fa fa-times-circle"></i></a></span>                
                	<? 
						$num++;
					} ?>
                <? } ?>
        	</div>
        </td>
        <td><button type="button" class="btn btn-info" onclick="add_availability(1)"><i class="fa fa-plus"></i> Add Unavailability</button></td>
    </tr>
    <tr>
    	<td>Tuesday</td>
        <td>
        	<div id="tuesday">
            	<?  $tuesday_text ='';
					if(isset($tuesday) && $tuesday !=''){
        			foreach($tuesday as $tue){ $tuesday_text = $tuesday_text.$tue.'#';?>
                		<span id="tue<?=$num?>">[ <?=$tue?> ] <a class="removetime" onclick="remove_time(2,<?=$num?>);"><i class="fa fa-times-circle"></i></a></span>                
                	<? 
						$num++;
					} ?>
                <? } ?>
            </div>
        </td>
        <td><button type="button" class="btn btn-info" onclick="add_availability(2)"><i class="fa fa-plus"></i> Add Unavailability</button></td>
    </tr>
    <tr>
    	<td>Wednesday</td>
		<td>
        	<div id="wednesday">
            	<? $wednesday_text ='';
				   if(isset($wednesday) && $wednesday !=''){
        			foreach($wednesday as $wed){ $wednesday_text = $wednesday_text.$wed.'#';?>
                		<span id="wed<?=$num?>">[ <?=$wed?> ] <a class="removetime" onclick="remove_time(3,<?=$num?>);"><i class="fa fa-times-circle"></i></a></span>                
                	<? 
						$num++;
					} ?>
                <? } ?>
            </div>
        </td>
        <td><button type="button" class="btn btn-info" onclick="add_availability(3)"><i class="fa fa-plus"></i> Add Unavailability</button></td>
    </tr>
    <tr>
    	<td>Thursday</td>
        <td>
        	<div id="thursday">
            	<? 
				   $thursday_text ='';
				   if(isset($thursday)&& $thursday !=''){
        			foreach($thursday as $thu){ $thursday_text = $thursday_text.$thu.'#';?>
                		<span id="thu<?=$num?>">[ <?=$thu?> ] <a class="removetime" onclick="remove_time(4,<?=$num?>);"><i class="fa fa-times-circle"></i></a></span>                
                	<? 
						$num++;
					} ?>
                <? } ?>
            </div>
        </td>
        <td><button type="button" class="btn btn-info" onclick="add_availability(4)"><i class="fa fa-plus"></i> Add Unavailability</button></td>
    </tr>
    <tr>
    	<td>Friday</td>
        <td>
        	<div id="friday">
            	<? 
				  $friday_text ='';
				  if(isset($friday)&& $friday !=''){
        			foreach($friday as $fri){ $friday_text = $friday_text.$fri.'#';?>
                		<span id="fri<?=$num?>">[ <?=$fri?> ] <a class="removetime" onclick="remove_time(5,<?=$num?>);"><i class="fa fa-times-circle"></i></a></span>                
                	<? 
						$num++;
					} ?>
                <? } ?>
            </div>
        </td>
        <td><button type="button" class="btn btn-info" onclick="add_availability(5)"><i class="fa fa-plus"></i> Add Unavailability</button></td>
    </tr>
    <tr>
    	<td>Saturday</td>
        <td>
        	<div id="saturday">
            	<? 
				  $saturday_text ='';
				  if(isset($saturday)&& $saturday !=''){
        			foreach($saturday as $sat){ $saturday_text = $saturday_text.$sat.'#';?>
                		<span id="sat<?=$num?>">[ <?=$sat?> ] <a class="removetime" onclick="remove_time(6,<?=$num?>);"><i class="fa fa-times-circle"></i></a></span>                
                	<? 
						$num++;
					} ?>
                <? } ?>
            </div>
        </td>
        <td><button type="button" class="btn btn-info" onclick="add_availability(6)"><i class="fa fa-plus"></i> Add Unavailability</button></td>
    </tr>
    <tr>
    	<td>Sunday</td>
        <td>
        	<div id="sunday">
            	<? 
				  $sunday_text ='';
				  if(isset($sunday)&& $sunday !=''){
        			foreach($sunday as $sun){ $sunday_text = $sunday_text.$sun.'#';?>
                		<span id="sun<?=$num?>">[ <?=$sun?> ] <a class="removetime" onclick="remove_time(7,<?=$num?>);"><i class="fa fa-times-circle"></i></a></span>                
                	<? 
						$num++;
					} ?>
                <? } ?>
            </div>
        </td>
        <td><button type="button" class="btn btn-info" onclick="add_availability(7)"><i class="fa fa-plus"></i> Add Unavailability</button></td>
    </tr>
</table>
<input type="hidden" name="monday_time" id="monday_time" value="<?=$monday_text?>"/>

<input type="hidden" name="tuesday_time" id="tuesday_time" value="<?=$tuesday_text?>" />
<input type="hidden" name="wednesday_time" id="wednesday_time" value="<?=$wednesday_text?>" />
<input type="hidden" name="thursday_time" id="thursday_time" value="<?=$thursday_text?>" />
<input type="hidden" name="friday_time" id="friday_time" value="<?=$friday_text?>" />
<input type="hidden" name="saturday_time" id="saturday_time" value="<?=$saturday_text?>" />
<input type="hidden" name="sunday_time" id="sunday_time" value="<?=$sunday_text?>" />


<!-- Add Image Modal -->
<div class="modal fade" id="addUnavailable" tabindex="-1" role="dialog" aria-labelledby="editVenueLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">Add Unavailable Time</h4>
			</div>
			
			<div class="modal-body">
				<div class="form-group" id="f_availability">
                    
                    <label class="col-lg-1 control-label">From:</label>
                    <div class="col-lg-4">
                   
                        <div class="input-group date" id="monday_start_time">
                            <input type="text" class="form-control" name="start_at" id="start_at" data-date-format="HH:MM" />
                            <span class="input-group-addon"><span class="glyphicon glyphicon-time"></span></span>
                        </div>
                    </div>
                    
                    <label class="col-lg-1 control-label">To:</label>
                        
                    <div class="col-lg-4">
                        <div class="input-group date" id="monday_finish_time">
                            <input type="text" class="form-control" name="finish_at" id="finish_at" data-format="HH:MM" />
                            <span class="input-group-addon"><span class="glyphicon glyphicon-time"></span></span>
                        </div>
                    </div>                                        
                </div>
			</div>
			<div class="modal-footer">
            	<button type="button" class="btn btn-info" data-dismiss="modal" onclick="add_time();">Add</button>
				<button type="button" class="btn btn-info" data-dismiss="modal">Close</button>
			
			</div>
			
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<script>
var day=0;
var count=<?=$num?>;
$(function(){	

	
	$('#monday_start_time').datetimepicker({
       format: "hh:ii",
		autoclose: true,
		viewSelect:'hour',
		showMeridian: true,
		startView:0,
		minuteStep:30,
		pickerPosition: "bottom-left"
	       
		
    });
	$('#monday_finish_time').datetimepicker({
       format: "hh:ii",
		autoclose: true,
		viewSelect:'hour',
		showMeridian: true,
		startView:0,
		minuteStep:30,
		pickerPosition: "bottom-left"
    });
	
	
});

function add_availability(days)
{
	day=days;

	$('#addUnavailable').modal('show');
	
}
function remove_time(day,id)
{
	if(day==1){						
		
		var deleted_time = $('#mon'+id).html();
		var n = deleted_time.search("]");
		var time_text = deleted_time.slice(2,n-1);
		var time = $('#monday_time').val();		
		var new_time = time.replace(time_text,"#");
		
		$('#monday_time').val(new_time);
		$('#mon'+id).hide();
	}
	if(day==2){
		
		var deleted_time = $('#tue'+id).html();
		var n = deleted_time.search("]");
		var time_text = deleted_time.slice(2,n-1);
		var time = $('#tuesday_time').val();		
		var new_time = time.replace(time_text,"#");
		
		$('#tuesday_time').val(new_time);
		
		$('#tue'+id).hide();
	}
	if(day==3){
		var deleted_time = $('#wed'+id).html();
		var n = deleted_time.search("]");
		var time_text = deleted_time.slice(2,n-1);
		var time = $('#wednesday_time').val();		
		var new_time = time.replace(time_text,"#");
		
		$('#wednesday_time').val(new_time);
		$('#wed'+id).hide();
	}
	if(day==4){
		var deleted_time = $('#thu'+id).html();
		var n = deleted_time.search("]");
		var time_text = deleted_time.slice(2,n-1);
		var time = $('#thursday_time').val();		
		var new_time = time.replace(time_text,"#");
		
		$('#thursday_time').val(new_time);		
		$('#thu'+id).hide();
	}
	if(day==5){
		var deleted_time = $('#fri'+id).html();
		var n = deleted_time.search("]");
		var time_text = deleted_time.slice(2,n-1);
		var time = $('#friday_time').val();		
		var new_time = time.replace(time_text,"#");
		
		$('#friday_time').val(new_time);		
		$('#fri'+id).hide();
	}
	if(day==6){
		var deleted_time = $('#sat'+id).html();
		var n = deleted_time.search("]");
		var time_text = deleted_time.slice(2,n-1);
		var time = $('#saturday_time').val();		
		var new_time = time.replace(time_text,"#");
		
		$('#saturday_time').val(new_time);		
		$('#sat'+id).hide();
	}
	if(day==7){
		
		var deleted_time = $('#sun'+id).html();
		var n = deleted_time.search("]");
		var time_text = deleted_time.slice(2,n-1);
		var time = $('#sunday_time').val();		
		var new_time = time.replace(time_text,"#");
		
		$('#sunday_time').val(new_time);		
		$('#sun'+id).hide();
	}
}
function add_time()
{
	
	
	if(day==1){
		$('#monday').html($('#monday').html() + ' <span id="mon'+count+'">[ '+$('#start_at').val()+' - '+$('#finish_at').val()+' ]' + ' <a class="removetime" onclick="remove_time(1,'+count+');"><i class="fa fa-times-circle"></i></a></span>' );
		$('#monday_time').val($('#monday_time').val() + $('#start_at').val()+' - '+$('#finish_at').val()+'#');
	}
	if(day==2){$('#tuesday').html($('#tuesday').html() + ' <span id="tue'+count+'">[ '+$('#start_at').val()+' - '+$('#finish_at').val()+' ]' + ' <a class="removetime" onclick="remove_time(2,'+count+');"><i class="fa fa-times-circle"></i></a></span>');
		$('#tuesday_time').val($('#tuesday_time').val() + $('#start_at').val()+' - '+$('#finish_at').val()+'#');
	}
	if(day==3){$('#wednesday').html($('#wednesday').html() + ' <span id="wed'+count+'">[ '+$('#start_at').val()+' - '+$('#finish_at').val()+' ]' + ' <a class="removetime" onclick="remove_time(3,'+count+');"><i class="fa fa-times-circle"></i></a></span>');
		$('#wednesday_time').val($('#wednesday_time').val() + $('#start_at').val()+' - '+$('#finish_at').val()+'#');
	}
	if(day==4){$('#thursday').html($('#thursday').html() + ' <span id="thu'+count+'">[ '+$('#start_at').val()+' - '+$('#finish_at').val()+' ]' + ' <a class="removetime" onclick="remove_time(4,'+count+');"><i class="fa fa-times-circle"></i></a></span>');
		$('#thursday_time').val($('#thursday_time').val() + $('#start_at').val()+' - '+$('#finish_at').val()+'#');
	}
	if(day==5){$('#friday').html($('#friday').html() + ' <span id="fri'+count+'">[ '+$('#start_at').val()+' - '+$('#finish_at').val()+' ]' + ' <a class="removetime" onclick="remove_time(5,'+count+');"><i class="fa fa-times-circle"></i></a></span>');
		$('#friday_time').val($('#friday_time').val() + $('#start_at').val()+' - '+$('#finish_at').val()+'#');
	}
	if(day==6){$('#saturday').html($('#saturday').html() + '<span id="sat'+count+'">[ '+$('#start_at').val()+' - '+$('#finish_at').val()+' ]' + ' <a class="removetime" onclick="remove_time(6,'+count+');"><i class="fa fa-times-circle"></i></a></span>');
		$('#saturday_time').val($('#saturday_time').val() + $('#start_at').val()+' - '+$('#finish_at').val()+'#');
	}
	if(day==7){$('#sunday').html($('#sunday').html() + ' <span id="sun'+count+'">[ '+$('#start_at').val()+' - '+$('#finish_at').val()+' ]' + ' <a class="removetime" onclick="remove_time(7,'+count+');"><i class="fa fa-times-circle"></i></a></span>');
		$('#sunday_time').val($('#sunday_time').val() + $('#start_at').val()+' - '+$('#finish_at').val()+'#');
	}
	count=count+1;
}
</script>
<style>
.removetime{
	margin-right:20px;
}
</style>
