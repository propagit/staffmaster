<select name="dob_day" class="form-control custom-select col-dob dob-day">
	<? for($i=1;$i<=30;$i++) { ?>
	<option value="<?=sprintf('%02d',$i);?>"<?=($day==$i) ? ' selected' : '';?>><?=sprintf('%02d',$i);?></option>
	<? } ?>
</select>

<select name="dob_month" class="form-control custom-select col-dob dob-mth">
	<? for($i=1;$i<=12;$i++) { ?>
	<option value="<?=sprintf('%02d',$i);?>"<?=($month==$i) ? ' selected' : '';?>><?=sprintf('%02d',$i);?></option>
	<? } ?>
</select>

<select name="dob_year" class="form-control custom-select col-dob dob-year">
	<? for($i=2012;$i>=1900;$i--) { ?>
	<option value="<?=$i;?>"<?=($year==$i) ? ' selected' : '';?>><?=$i;?></option>
	<? } ?>
</select>
