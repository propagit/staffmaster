<div class="staff-profile-detail-box">
	<h2> Your Availability </h2>
	<p> Please let us know the times that you are available for work</p>
</div>
<div id="list_availability"></div>



<script>
$(function(){
	load_availability(<?=$staff['user_id']?>);
});
function load_availability(user_id)
{
	preloading($('#list_availability'));
	$.ajax({
		type: "POST",
		url: "<?=base_url();?>staff/ajax/load_availability",
		data: {user_id: user_id},
		success: function(html) {			
			loaded($('#list_availability'), html);
		}
	})
}
</script>