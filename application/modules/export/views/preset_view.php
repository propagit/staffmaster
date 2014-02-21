<div class="clearfix" style="padding: 5px; background:#eee; border: 1px solid #ccc; border-bottom:0;">
<?=modules::run('common/field_select', $fields, 'field-id');?>
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
		<td><input type="text" class="form-control" size="10" id="field_title" /></td>
		<td><input type="text" class="form-control" size="10" id="field_value" /></td>
		<td>
			
		</td>
		<td>
			<button class="btn btn-core" id="btn-add-field"><i class="fa fa-plus"></i> Add</button>
		</td>
	</tr>
	</tbody>
</table>
</div>

<script>
$(function(){
	$('#field-id').change(function(){
		var label = $('#field-id option:selected').text();
		var value = $(this).val();
		$('#field_title').val(label);
		$('#field_value').val('{' + value + '}');
	})
	$('#btn-add-field').click(function(){
		var title = $('#field_title').val();
		var value = $('#field_value').val();
		add_field(title, value);
	})
})
function add_field(title, value) {
	var export_id = $('#export_id').val();
	$.ajax({
		type: "POST",
		url: "<?=base_url();?>export/ajax/add_field",
		data: {export_id: export_id, title: title, value: value},
		success: function(html) {
			load_template();
		}
	})
}
</script>