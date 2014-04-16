<div class="box">
  <h2>Initialising Your Account</h2>
  <p>Please wait a short moment while we set up your system...</p>
</div>
<div id="wp_database">
	<div class="box loading">	
		<div class="pull-right">
			<div class="wp_loading"><img src="<?=base_url();?>assets/img/loading3.gif" /></div>
		</div>
		<h2>Creating Database</h2>
		<p class="result">Please wait a short moment while we set up your account database...</p>
	</div>
</div>
<script>
$(function(){
	setTimeout(function() {
		setup_database();
	}, 500);

})
function setup_database() {
	$.ajax({
		type: "POST",
		url: "<?=base_url();?>account/ajax_setup/create_database",
		data: {subdomain: '<?=$subdomain;?>'},
		success: function(html) {
			$('#wp_database').html(html);
		}
	})
}
</script>