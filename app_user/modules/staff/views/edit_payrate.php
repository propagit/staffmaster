<div class="staff-profile-detail-box">
	<h2>Pay Rate</h2>
	<p>Please select the pay rates that are available for this staff.</p>
</div>
<div id="list-staff-payrates">
</div>

<script>
$(function(){
	list_staff_payrates();
	
})
function list_staff_payrates() {
	preloading($('#list-staff-payrates'));
	$.ajax({
		type: "POST",
		url: "<?=base_url();?>staff/ajax/get_payrates",
		data: {user_id: <?=$staff['user_id'];?>},
		success: function(html) {
			loaded($('#list-staff-payrates'), html);
		}
	})
}
</script>