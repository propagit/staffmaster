<?
	$data_source = array();
	foreach($venues as $venue)
	{
		$data_source[] = '\'' . $venue['name'] . '\'';
	}
	$data_source = implode(",", $data_source);
?>

<input type="text" name="<?=$field_name;?>" class="typeahead-devs form-control" placeholder="enter venue name..." value="<?=$field_value;?>" />

<script>
$(function(){
	$('input.typeahead-devs').typeahead({
		name: '<?=$field_name;?>',
		local: [<?=$data_source;?>]
	});
})
</script>