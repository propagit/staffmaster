<?
	$data_source = array();
	foreach($supers as $super)
	{
		$data_source[] = '\'' . $super['name'] . '\'';
	}
	$data_source = implode(",", $data_source);
?>

<input type="text" name="<?=$field_name;?>" class="typeahead-devs form-control"  value="<?=$field_value?>"/>

<script>
$(function(){
	$('input.typeahead-devs').typeahead({
		name: '<?=$field_name;?>',
		local: [<?=$data_source;?>]
	});
})
</script>