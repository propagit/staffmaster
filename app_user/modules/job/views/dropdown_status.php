<select name="<?=$field_name;?>" id="<?=$field_name;?>" class="form-control auto-width">
	<option value="<?=SHIFT_UNCONFIRMED;?>"<?=($field_value==SHIFT_UNCONFIRMED) ? ' selected' : '';?>>Unconfirmed</option>
	<option value="<?=SHIFT_CONFIRMED;?>"<?=($field_value==SHIFT_CONFIRMED) ? ' selected' : '';?>>Confirmed</option>
</select>