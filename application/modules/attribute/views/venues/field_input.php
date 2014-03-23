<?
	$data_source = array();
	foreach($venues as $venue)
	{
		$data_source[] = '\'' . $venue['name'] . '\'';
	}
	$data_source = implode(",", $data_source);
?>

<input type="text" name="<?=$field_name;?>" class="typeahead-devs-venue-<?=$field_name;?> form-control" placeholder="enter venue name..." value="<?=$field_value;?>" />

<script>
$(function(){
	$('input.typeahead-devs-venue-<?=$field_name;?>').typeahead({
		name: '<?=$field_name;?>',
		local: [<?=$data_source;?>]
	});
})
</script>