<div class="staff-profile-detail-box">
	<h2> Attributes </h2>
</div>
<? if (count($fields) == 0) { ?>
You have not created any custom attributes yet. To create custom attributes go to "Edit Attributes" and then "Custom Attributes"
<? } else { ?>
<form class="form-horizontal" role="form" id="staff-custom-fields-form">
<input type="hidden" name="user_id" value="<?=$staff['user_id'];?>" />
<?=modules::run('staff/custom_attributes_form', $staff['user_id']);?>
<div class="form-group">
    <div class="col-md-10 col-md-offset-2">
        <div class="alert alert-success hide" id="msg-update-custom-fields"><i class="fa fa-check"></i> &nbsp; Custom attributes successfully updated</div>
        <button type="button" class="btn btn-core" id="btn-update-custom-fields"><i class="fa fa-save"></i> Update Custom Attributes</button>
    </div>
</div>
</form>
<script>
$(function(){
	//update data
	$('#btn-update-custom-fields').click(function(){
		$.ajax({
			type: "POST",
			url: "<?=base_url();?>staff/ajax/update_custom_fields",
			data: $('#staff-custom-fields-form').serialize(),
			success: function(html) {
				$('#msg-update-custom-fields').removeClass('hide');
				setTimeout(function(){
					$('#msg-update-custom-fields').addClass('hide');
				}, 2000);
			}
		})
	});	
});
function delete_file_field(user_id, field_id, file) {
	help.confirm_delete('Delete file', 'Are you sure you want to delete this file?', function(confirmed){
		if(confirmed){
			$.ajax({
				type: "POST",
				url: "<?=base_url();?>staff/ajax/delete_file_field",
				data: {user_id: user_id, field_id: field_id, file: file},
				success: function(html) {
					load_file_field(user_id, field_id);
				}
			})
		}
	});
}
function load_file_field(user_id, field_id) {
	$.ajax({
		type: "POST",
		url: "<?=base_url();?>staff/ajax/load_file_field",
		data: {user_id: user_id, field_id: field_id},
		success: function(html) {
			$('#field_' + user_id + '_' + field_id).replaceWith(html);
		}
	})
}
</script>
<? } ?>