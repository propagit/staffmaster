<select name="<?=$field_name;?>" class="form-control" id="<?=$field_name;?>">
	<option value="">Select Client</option>
	<? foreach($clients as $client) { ?>
	<option value="<?=$client['user_id'];?>"<?=($field_value == $client['user_id']) ? ' selected' : '';?>><?=$client['company_name'];?></option>
	<? } ?>
</select>