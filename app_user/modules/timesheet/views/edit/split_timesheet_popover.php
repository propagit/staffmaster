<?php
	$start_hour = date('H',$timesheet['start_time']);
	$end_hour = date('H',$timesheet['finish_time']);
	$difference = ($timesheet['finish_time'] - $timesheet['start_time']) / 3600;
	
?>
<form id="split_timesheet_form">
<input type="hidden" name="timesheet_id" value="<?=$timesheet['timesheet_id'];?>">
<div id="split-timesheet" style="width:650px;">
	<div class="ts-split-time-wrap col-xs-6 remove-gutters">
    	<div class="col-xs-6 remove-left-gutter"><b>Hour </b>
    	<select name="hour" class="form-control">
        <?php 
			$hour = 0;
			$time = 0;
			for($i = 0; $i <= $difference ; $i++){ 
				$time = ($i * 3600) + $timesheet['start_time'];
				$hour = date('H',$time);
		?>
			<option value="<?=$time;?>"><?=$hour;?></option>
        <?php } ?>
        </select>
        </div>
        <div class="col-xs-6 remove-left-gutter"><b>Minute </b>
        <select name="minute" class="form-control col-xs-6">
            <option value="0">00</option>
            <option value="15">15</option>
            <option value="30">30</option>
            <option value="45">45</option>
        </select>
        </div>
    </div>
    
    <div class="ts-split-payrate-wrap col-xs-6 remove-gutters">
    	<div class="col-xs-8 remove-gutters" style="text-align:right;">
    	<span id="staff_payrates" class="col-xs-<?=$this->config_model->get('separate_client_payrate') ? '6' : '12';?> remove-left-gutter" style="text-align:left;">
       		 <b>Staff Payrate </b><?=modules::run('attribute/payrate/field_select', 'payrate_id', $timesheet['payrate_id']);?>
        </span>
	
		<? if($this->config_model->get('separate_client_payrate')) {
            $client_payrate_id = ($timesheet['client_payrate_id']) ? $timesheet['client_payrate_id'] : $timesheet['payrate_id'];
            echo '<span style="text-align:left;" class="col-xs-6 remove-left-gutter">
					<b>Client Payrate </b>' . modules::run('attribute/payrate/field_select', 'client_payrate_id', $client_payrate_id) . 
				 '</span>';
            
        } ?>
        </div>
        <div class="col-xs-4 remove-right-gutter" style="margin-top:17px;">&nbsp;
       		<button type="button" class="btn btn-default btn-sm ts-split-cancel pull" style="margin-right:5px;"><i class="glyphicon glyphicon-remove"></i></button>
        	<button type="button" id="btn-split-timesheet" class="btn btn-sm btn-core pull"><i class="glyphicon glyphicon-ok"></i></button>
            
        </div>
    </div>
    
    <div class="col-xs-12 bg-danger hide">
    	<span id="ts-split-error-msg" class="text-danger"></span>
    </div>
	
</div>
</form>
<div style="clear:both"></div>
<script>
$(function(){
	$('#btn-split-timesheet').click(function(){
		//console.log('tst');
		$('#ts-split-error-msg').parent().addClass('hide');
		$.ajax({
			type: "POST",
			url: '<?=base_url();?>timesheet/ajax/split_timesheet',
			data: $('#split_timesheet_form').serialize(),
			dataType:"JSON",
			success: function(data){
				if(data.ok){
					load_split_timesheet(data.timesheet_id);
					$('.ts-split-cancel').click(function(){
						$('.ts_split').popover('hide');
					});	
				}else{
					$('#ts-split-error-msg').html(data.msg);
					$('#ts-split-error-msg').parent().removeClass('hide');	
				}
			}
		});
	});
});

function load_split_timesheet(new_timesheet_id){
	$.ajax({
		type: "POST",
		url: '<?=base_url();?>timesheet/ajax/load_ts_row_view',
		data:{timesheet_id:<?=$timesheet['timesheet_id'];?>},
		success: function(html){
			$('#timesheet_<?=$timesheet['timesheet_id'];?>').replaceWith(html);
		}
	}).done(function(){
		load_new_split_timesheet(new_timesheet_id);
	});
}

function load_new_split_timesheet(new_timesheet_id){
	$.ajax({
		type: "POST",
		url: '<?=base_url();?>timesheet/ajax/load_ts_row_view',
		data:{timesheet_id:new_timesheet_id},
		success: function(html){
			$('#timesheet_<?=$timesheet['timesheet_id'];?>').after(html);
			init_edit();
		}
	});
}

</script>
