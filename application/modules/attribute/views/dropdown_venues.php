<?
	$data_source = array();
	foreach($venues as $venue)
	{
		$data_source[] = '"' . $venue['name'] . '"';
	}
	$data_source = implode(",", $data_source);
?>
<input type="text" name="<?=$field_name;?>" class="form-control" data-provide="typeahead" data-source='[<?=$data_source;?>]' autocomplete="off" >

<!--
<select name="<?=$field_name;?>" class="form-control" id="<?=$field_name;?>">
	<option value="">Select Venue</option>
	<? foreach($venues as $venue) { ?>
	<option value="<?=$venue['venue_id'];?>"<?=($field_value == $venue['venue_id']) ? ' selected' : '';?>><?=$venue['name'];?></option>
	<? } ?>
</select>
-->

<script>
$(function(){
	$('.typeahead').typeahead();
})
</script>