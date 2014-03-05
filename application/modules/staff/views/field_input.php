<?
	$data_source = array();
	foreach($staffs as $staff)
	{
		$data_source[] = '\'' . $staff['first_name'] . ' ' . $staff['last_name'] . '\'';
	}
	$data_source = implode(",", $data_source);
?>

<input type="text" name="<?=$field_name;?>" class="typeahead-devs-<?=$field_name;?> form-control" placeholder="enter staff name..." value="<?=$field_value;?>" />

<script>
$(function(){
	$('input.typeahead-devs-<?=$field_name;?>').typeahead({
		name: '<?=$field_name;?>',
		local: [<?=$data_source;?>]
	});
})
</script>