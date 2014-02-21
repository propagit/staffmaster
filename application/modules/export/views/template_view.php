<div class="table-responsive">
<form id="sort-fields-form">
<input type="hidden" id="order_values" name="order" />
<table class="table table-bordered table-hover table-middle sorted_table">
	<thead>
	<tr class="exclude">
		<th class="center" width="40">Sort</th>
		<th>Head Title</th>
		<th>Value</th>
		<th class="center" width="40"></th>
	</tr>
	</thead>
	<tbody>
	<? foreach($fields as $field) { ?>	
	<tr class="field-sortable">
		<td>
			<i class="fa fa-arrows-alt"></i>
			<input type="hidden" name="order_<?=$field['field_id'];?>" value="<?=$field['field_id'];?>" />
		</td>
		<td><?=$field['title'];?></td>
		<td><?=$field['value'];?></td>
		<td>
			<a onclick="remove_field(<?=$field['field_id'];?>)"><i class="fa fa-times"></i></a>
		</td>
	</tr>
	<? } ?>	
	</tbody>
</table>
</form>
</div>
<div id="serialize_output"></div>

<script>
$(function () {
	var group = $('.sorted_table').sortable({
		group: 'sorted_table',
		containerSelector: 'table',
		itemPath: '> tbody',
		itemSelector: 'tr.field-sortable',
		placeholder: '<tr class="placeholder"/>',
		onDrop: function (item, container, _super) {
			$('#order_values').val(group.sortable("serialize").get().join("\n"));
			$.ajax({
				type: "POST",
				url: "<?=base_url();?>export/ajax/update_fields_order",
				data: $('#sort-fields-form').serialize(),
				success: function(html) {					
				}
			})
			_super(item, container)
		},
		serialize: function (parent, children, isContainer) {
			return isContainer ? children.join() : parent.find('input').val()
		},
	})
})
function remove_field(field_id) {
	$.ajax({
		type: "POST",
		url: "<?=base_url();?>export/ajax/remove_field",
		data: {field_id: field_id},
		success: function(html) {
			load_template();
		}
	})
}
</script>