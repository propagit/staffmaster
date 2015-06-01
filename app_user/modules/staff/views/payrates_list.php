<table class="table table-bordered table-hover table-middle table-expanded">
    <thead>
    <tr class="heading">
    	<th width="40" class="center"><input type="checkbox" name="check_all" /></th>
        <th class="left">Pay Rate Name</th>
        <th class="center col-md-1">Default Pay Rate</th>
        <th class="center col-md-1">View</th>
    </tr>
    </thead>
    <tbody>
    	<?php $default_payrate_id = modules::run('staff/get_default_payrate_id',$user_id); 
			#echo $default_payrate_id;
		?>
        <? foreach($payrates as $payrate) { $checked = ($payrate['is_restricted'] == NULL) ? 'checked' : ''; ?>
        <tr>
        	<td class="center"><input type="checkbox" name="payrate_id" value="<?=$payrate['payrate_id'];?>" <?=$checked;?> /> </td>
            <td class="left"><?=$payrate['name'];?></td>
            <td class="center"><input class="set-staff-default-payrate" type="radio" name="default_payrate_id" data-payrate-id="<?=$payrate['payrate_id'];?>" <?=$payrate['payrate_id'] == $default_payrate_id ? 'checked' : '';?>></td>
            <td class="center"><a href="<?=base_url();?>attribute/payrate"><i class="fa fa-eye"></i></a></td>
        </tr>
        <? } ?>
    </tbody>
</table>

<script>
$(function(){
	$('input[type="checkbox"][name="payrate_id"]').click(function(){
		var payrate_id = $(this).val();
		$.ajax({
			type: "POST",
			url: "<?=base_url();?>staff/ajax/restrict_payrate",
			data: {user_id: <?=$user_id;?>, payrate_id: payrate_id},
			success: function(html) { }
		})
	})
	$('input[type="checkbox"][name="check_all"]').click(function(){
		var check_all = $(this).is(':checked');
		preloading($('#list-staff-payrates'));
		$.ajax({
			type: "POST",
			url: "<?=base_url();?>staff/ajax/unrestrict_all",
			data: {user_id: <?=$user_id;?>, unrestrict_all: check_all},
			success: function(html) {
				$('input[type="checkbox"][name="payrate_id"]').prop('checked', check_all);
				loaded($('#list-staff-payrates'));
			}
		})
	})
	
	$('.set-staff-default-payrate').click(function(){
		var selected_payrate = $(this).attr('data-payrate-id');
		//console.log(selected_payrate);
		$.ajax({
			type: "POST",
			url: "<?=base_url();?>staff/ajax/set_default_payrate",
			data: {user_id: <?=$user_id;?>, default_payrate_id: selected_payrate},
			success: function(html) {
				//loaded($('#list-staff-payrates'));
			}
		})
	});
})
</script>