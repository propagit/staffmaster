<div class="alert alert-success clearfix wp-export-templates">
	<?=modules::run('common/field_select', $templates, 'export_id', '','', false);?>
</div>

<div class="col-md-7" id="template-preset">
	<div class="clearfix wp-fields">
	<?=modules::run('common/field_select', $fields, 'field_id');?>
	</div>
	<div class="table-responsive">
	<table class="table table-bordered table-hover table-middle">
		<thead>
		<tr>
			<th class="center">Head Title</th>
			<th class="center">Value</th>
			<th class="center">Format</th>
			<th class="center" width="60"></th>
		</tr>
		</thead>
		<tbody>
		<tr>
			<td><input type="text" class="form-control" size="10" name="field_title" /></td>
			<td><input type="text" class="form-control" size="10" name="field_value" /></td>
			<td>
				
			</td>
			<td>
				<button class="btn btn-core btn-add-field"><i class="fa fa-plus"></i> Add</button>
			</td>
		</tr>
		</tbody>
	</table>
	</div>
	
</div>
<div class="col-md-5 template-export">
	
</div>


<script>
$(function(){
	load_template();
	$('#<?=$object;?>').find('select[name="export_id"]').change(function(){
		load_template();
	})
	$('#<?=$object;?>').find('select[name="field_id"]').change(function(){
		var label = $('#<?=$object;?>').find('select[name="field_id"] option:selected').text();
		var value = $(this).val();
		$('#<?=$object;?>').find('input[name="field_title"]').val(label);
		$('#<?=$object;?>').find('input[name="field_value"]').val('{' + value + '}');
	});
	$('#<?=$object;?>').find('.btn-add-field').click(function(){
		var title = $('#<?=$object;?>').find('input[name="field_title"]').val();
		var value = $('#<?=$object;?>').find('input[name="field_value"]').val();
		add_field(title, value);
	});
})
function add_field(title, value) {
	var export_id = $('#<?=$object;?>').find('select[name="export_id"]').val();
	$.ajax({
		type: "POST",
		url: "<?=base_url();?>export/ajax/add_field",
		data: {export_id: export_id, title: title, value: value},
		success: function(html) {
			load_template();
		}
	})
}
function load_template() {
	var export_id = $('#<?=$object;?>').find('select[name="export_id"]').val();
	preloading($('#<?=$object;?>').find('.template-export'));
	$.ajax({
		type: "POST",
		url: "<?=base_url();?>export/ajax/load_template",
		data: {export_id: export_id},
		success: function(html) {
			loaded($('#<?=$object;?>').find('.template-export'), html);
		}
	})
	
}
</script>