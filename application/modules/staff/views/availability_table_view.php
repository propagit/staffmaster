<?
	$days = array(
		'1' => 'Monday',
		'2' => 'Tuesday',
		'3' => 'Wednesday',
		'4' => 'Thursday',
		'5' => 'Friday',
		'6' => 'Saturday',
		'7' => 'Sunday'
	);
	$hours = array(
		'0' => 'Midnight',
		'1' => '1:00 AM',
		'2' => '2:00 AM',
		'3' => '3:00 AM',
		'4' => '4:00 AM',
		'5' => '5:00 AM',
		'6' => '6:00 AM',
		'7' => '7:00 AM',
		'8' => '8:00 AM',
		'9' => '9:00 AM',
		'10' => '10:00 AM',
		'11' => '11:00 AM',
		'12' => '12:00 PM',
		'13' => '1:00 PM',
		'14' => '2:00 PM',
		'15' => '3:00 PM',
		'16' => '4:00 PM',
		'17' => '5:00 PM',
		'18' => '6:00 PM',
		'19' => '7:00 PM',
		'20' => '8:00 PM',
		'21' => '9:00 PM',
		'22' => '10:00 PM',
		'23' => '11:00 PM',
	);
?>
<form id="form_update_availability">
<input type="hidden" name="user_id" value="<?=$user_id;?>" />
<div class="table-responsive">
<table class="table table-bordered table-middle table-condensed" width="100%" id="availablity_data">
<thead>
	<tr>
		<th class="center" width="100">Time</th>
		<? foreach($days as $key => $label) { ?>
		<th class="center"><input type="checkbox" class="checkbox-sm" name="check-day-all" value="day<?=$key?>"/> <?=$label;?></th>
		<? } ?>
	</tr>
</thead>
<tbody>
	<? foreach($hours as $key_hour => $label_hour) { ?>
	<tr>
		<td><input type="checkbox" class="checkbox-sm" name="check-time-all" value="hour<?=$key_hour;?>"/> <?=$label_hour;?></td>
		<? foreach($days as $key_day => $label_day) { ?>
		<td class="center <?=( modules::run('staff/get_availability_data', $user_id, $key_day, $key_hour) == 1) ? ' available-color ' : ' unavailable-color ';?>" >
			<input type="checkbox" class="input-checkbox-sm day<?=$key_day;?> hour<?=$key_hour;?>" name="av-<?=$key_day;?>-<?=$key_hour;?>" value="1" <?=( modules::run('staff/get_availability_data', $user_id, $key_day, $key_hour) == 1) ? ' checked=checked' : '';?> />            
		</td>
		
		<? } ?>
	</tr>
	<? } ?>
</tbody>
</table>
</div>
</form>

<script>
$(function(){
	$('#form_update_availability .input-checkbox-sm').change(function(){
		var $this = $(this);		
		var name = $(this).attr('name');
		if($(this).is(':checked')){var value = $(this).val();$(this).parent().addClass('available-color');$(this).parent().removeClass('unavailable-color');}
		else{var value =0;$(this).parent().removeClass('available-color');$(this).parent().addClass('unavailable-color');}		
		
		$.ajax({
			type: "POST",
			url: "<?=base_url();?>staff/ajax/update_availability",
			data: {value_avail: value, name: name, user_id: <?=$user_id;?>},
			success: function(html) {}
		})
	})	
	
	$('#form_update_availability .checkbox-sm').change(function(){
		var $this = $(this);
		if($(this).is(':checked')){var check=true; var num=1;}else{var check=false; var num=0;}
		var value = $(this).val();
		$('.'+value).each(function(index){
			this.checked = check;	
			var name = $(this).attr('name');		
			if($(this).is(':checked')){$(this).parent().addClass('available-color');$(this).parent().removeClass('unavailable-color');}
			else{$(this).parent().removeClass('available-color');$(this).parent().addClass('unavailable-color');}					
			$.ajax({
				type: "POST",
				url: "<?=base_url();?>staff/ajax/update_availability",
				data: {value_avail:num, name: name, user_id: <?=$user_id;?>},
				success: function(html) {}
			})
		});
	});
})
</script>
