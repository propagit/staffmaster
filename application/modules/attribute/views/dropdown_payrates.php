<select name="<?=$field_name;?>" class="form-control" id="<?=$field_name;?>">
	<option value="">Select Payrate</option>
	<? foreach($payrates as $payrate) { ?>
	<option value="<?=$payrate['payrate_id'];?>"<?=($field_value == $payrate['payrate_id']) ? ' selected' : '';?>><?=$payrate['name'];?></option>
	<? } ?>
</select>