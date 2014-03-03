<br />
<div class="clearfix">
<div class="col-md-7">
	<h2>Configure Export</h2>	
</div>
<div class="col-md-5">
	<? if($object != 'staff') { ?>
	<div class="alert alert-success clearfix">
		<div class="col-md-6">
			<label><input type="radio" name="format" checked value="single" /> &nbsp; Single Time Sheet</label>
		</div>
		<div class="col-md-6">
			<label><input type="radio" name="format" value="batched" /> &nbsp; Batched Time Sheets</label>
		</div>
	</div>
	<? } else { ?>
	<input type="radio" name="<?=$object;?>_format" checked value="single" class="hide" />
	<? } ?>
</div>
</div>
<div id="wp-export-template_<?=$object;?>">
</div>

<script>
$(function() {
	load_templates();
	$('#<?=$object;?>').find('input[name="format"]').click(function(){
		load_templates();
	})
})
function load_templates() {
	var format = $('#<?=$object;?>').find('input[name="format"]:checked').val();
	$.ajax({
		type: "POST",
		url: "<?=base_url();?>export/ajax/load_templates",
		data: {format: format, object: '<?=$object;?>'},
		success: function(html) {
			$('#wp-export-template_<?=$object;?>').html(html);
		}
	});
}
</script>