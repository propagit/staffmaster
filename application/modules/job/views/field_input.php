<?
	$data_source = array();
	foreach($jobs as $job)
	{
		$data_source[] = '\'' . $job['name'] . '\'';
	}
	$data_source = implode(",", $data_source);
?>

<input type="text" name="<?=$field_name;?>" class="typeahead-devs-<?=$field_name;?> form-control" placeholder="keywords..." />

<script>
$(function(){
	$('input.typeahead-devs-<?=$field_name;?>').typeahead({
		name: '<?=$field_name;?>',
		local: [<?=$data_source;?>]
	});
})
</script>