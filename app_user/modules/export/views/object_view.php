<br />
<div class="clearfix">
<div class="col-md-7">
	<h2>Configure <? $a = explode('_', $object); echo ucwords($a[0]); 
		if (isset($a[1])) echo ' ' . strtoupper($a[1]); ?> Export</h2>	
</div>
<div class="col-md-5">
	<? if($object != 'staff' && $object != 'expense' ) { ?>
	<input type="radio" name="format" value="single" checked class="hide" />
	<? } else { ?>
	<input type="radio" name="<?=$object;?>_format" checked value="single" class="hide" />
	<? } ?>
	
	<? if(count($levels) > 0) { ?>
	<select class="form-control" id="<?=$object;?>_export_level">
		<? foreach($levels as $level) { ?>
		<option value="<?=$level['level'];?>">Line by: <?=ucwords(str_replace('_', ' ', $level['level']));?></option>
		<? } ?>
	</select>
	<? } else { ?>
	<input type="hidden" id="<?=$object;?>_export_level" />
	<? } ?>
</div>
</div>
<div id="wp-export-template_<?=$object;?>">
</div>

<script>
$(function() {
	load_templates();
	$('#<?=$object;?>_export_level').change(function(){
		load_templates();
	})
})
function load_templates() {
	//var format = $('#<?=$object;?>').find('input[name="format"]:checked').val();
	var level = $('#<?=$object;?>_export_level').val();
	$.ajax({
		type: "POST",
		url: "<?=base_url();?>export/ajax/load_templates",
		data: {object: '<?=$object;?>', level: level},
		success: function(html) {
			$('#wp-export-template_<?=$object;?>').html(html);
		}
	});
}
</script>