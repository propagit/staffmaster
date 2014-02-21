<br />

<div class="col-md-7">
	<h2>Configure Export</h2>	
</div>
<div class="col-md-5">
	<? if($object != 'staff') { ?>
	<div class="alert alert-success clearfix">
		<div class="col-md-6">
			<label><input type="radio" name="<?=$object;?>_format" checked value="single" /> &nbsp; Single Time Sheet</label>
		</div>
		<div class="col-md-6">
			<label><input type="radio" name="<?=$object;?>_format" value="batched" /> &nbsp; Batched Time Sheets</label>
		</div>
	</div>
	<? } else { ?>
	<input type="radio" name="<?=$object;?>_format" checked value="single" class="hide" />
	<? } ?>
	<div class="alert alert-success clearfix wp-export-templates">
		
	</div>
</div>

<div class="col-md-7" id="template-preset">
	
</div>
<div class="col-md-5" id="template-export">
	
</div>
<script>
$(function() {
	load_templates();
	$('input[name="<?=$object;?>_format"]').click(function(){
		load_templates();	
	})
	$('#export_id').change(function(){
		load_template();
	})
})
function load_templates() {
	var format = $('input[name="<?=$object;?>_format"]:checked').val();
	$.ajax({
		type: "POST",
		url: "<?=base_url();?>export/ajax/load_templates",
		data: {format: format, object: '<?=$object;?>'},
		success: function(html) {
			load_preset('<?=$object;?>', format);
			$('#<?=$object;?>').find('.wp-export-templates').html(html);
		}
	}).done(function(){
		load_template();
		$('#export_id').change(function(){
			load_template();
		})
	})
}
function load_template() {
	var export_id = $('#export_id').val();
	preloading($('#template-export'));
	$.ajax({
		type: "POST",
		url: "<?=base_url();?>export/ajax/load_template",
		data: {export_id: export_id},
		success: function(html) {
			loaded($('#template-export'), html);
		}
	})
	
}
function load_preset(object, format) {
	preloading($('#template-preset'));
	$.ajax({
		type: "POST",
		url: "<?=base_url();?>export/ajax/load_preset",
		data: {object: object, format: format},
		success: function(html) {
			loaded($('#template-preset'), html);
		}
	})
}
</script>