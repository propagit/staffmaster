<div class="box">	
	<div class="pull-right">
		<div class="wp_loading"><i class="fa fa-done fa-check-circle fa-3x"></i></div>
	</div>
	<h2>Creating Directories</h2>
	<p class="result">Please wait a short moment while we set up your account directories... <b class="text-success">Completed</b></p>
</div>
<div id="wp_account">
	<div class="box loading">	
		<div class="pull-right">
			<div class="wp_loading"><img src="<?=base_url();?>assets/img/loading3.gif" /></div>
		</div>
		<h2>Creating User Account</h2>
		<p class="result">Please wait a short moment while we set up your user account...</p>
	</div>
</div>
<script>
$(function(){
	setTimeout(function() {
		setup_account();
	}, 500);
})
function setup_account() {	
	$.ajax({
		type: "POST",
		url: "<?=base_url();?>account/ajax_setup/create_account",
		data: {subdomain: '<?=$subdomain;?>'},
		success: function(html) {
			$('#wp_account').html(html);
		}
	})
}
</script>