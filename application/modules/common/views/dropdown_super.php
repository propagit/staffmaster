<?
	$data_source = array();
	foreach($supers as $super)
	{
		$data_source[] = '\'' . $super['name'] . '\'';
	}
	$data_source = implode(",", $data_source);
?>

<input type="text" name="<?=$field_name;?>" class="typeahead-devs form-control"  value="<?=$field_value?>" onfocus="check_super(this)"/>

<script>
$(function(){
	$('input.typeahead-devs').typeahead({
		name: '<?=$field_name;?>',
		local: [<?=$data_source;?>]
	});
	
})
function check_super(e)
{
	var super_name = e.value;
	$.ajax({
		url: '<?=base_url()?>common/check_super/',
		type: 'POST',
		data: ({super_value:super_name}),
		dataType: "html",
		success: function(html) {
			if(html==1)
			{
				//alert('Sorry, we dont have your super name at our database. Please choose other and fill in your super');
			}
		}
	})		
}
</script>