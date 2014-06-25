<div class="staff-profile-detail-box">
	<h2>Client Venues</h2>
	<p>You can manage which venues are available for this client.</p>
</div>
<div id="list-client-venues">
</div>

<script>
$(function(){
	list_client_venues();
	
})
function list_client_venues() {
	preloading($('#list-client-venues'));
	$.ajax({
		type: "POST",
		url: "<?=base_url();?>client/ajax/get_venues",
		data: {user_id: <?=$client['user_id'];?>},
		success: function(html) {
			loaded($('#list-client-venues'), html);
		}
	})
}
</script>