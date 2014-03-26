<tr class="field-sortable" id="field-<?=$field['field_id'];?>">
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