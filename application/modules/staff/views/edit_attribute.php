<div class="staff-profile-detail-box">
	<h2> Attributes </h2>
	<p> Staff can choose the "Attributes" </p>
</div>
<form class="form-horizontal" role="form" id="staff-custom-attributes-form">
<input type="hidden" name="user_staff_id" value="<?=$staff['user_id'];?>" />
	<?=modules::run('formbuilder/custom_attributes_for_staff_profile',$staff['user_id']);?>
</form>
<script>
$(function(){
	
	//update data
	$('#update-custom-attributes').on('click',function(){
		$.ajax({
			type: "POST",
			url: "<?=base_url();?>staff/ajax/update_custom_attributes",
			data: $('#staff-custom-attributes-form').serialize(),
			success: function(html) {
				$('#msg-update-custom-attributes').removeClass('hide');
				setTimeout(function(){
					$('#msg-update-custom-attributes').addClass('hide');
				}, 2000);
			}
		})
	});
	
	
});
</script>