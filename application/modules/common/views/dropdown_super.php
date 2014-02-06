<?
	$data_source = array();
	foreach($supers as $super)
	{
		$data_source[] = '\'' . $super['name'] . '\'';
	}
	$data_source = implode(",", $data_source);
?>

<input type="text" name="<?=$field_name;?>" class="typeahead-devs form-control"  value="<?=$field_value?>" />

<script>
var myData=[<?=$data_source;?>];
$(function(){
	
	
	$('input.typeahead-devs').typeahead({
		name: '<?=$field_name;?>',
		local: [<?=$data_source;?>],
		source: [<?=$data_source;?>]
	}).blur(validateSelection);
	
})
function validateSelection() {
    if ($.inArray($(this).val(), myData) === -1) {
        alert('Sorry, the super name is not available in our system');
		
	}
		
}
function check_super(e)
{
	var super_name = e.value;
	$.ajax({
		url: '<?=base_url()?>common/check_super/',
		type: 'POST',
		data: ({super_value:super_name}),
		dataType: "html",
		success: function(html) {
			alert(html);
		}
	})		
}
</script>