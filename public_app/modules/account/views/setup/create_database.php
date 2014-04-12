<div id="wp_tables">
	<div class="box loading">	
		<div class="pull-right">
			<div class="wp_loading"><img src="<?=base_url();?>assets/img/loading3.gif" /></div>
		</div>
		<h2>Creating Directories</h2>
		<p class="result">Please wait a short moment while we set up your account directories...</p>
	</div>
</div>
<!--
<div class="box">
	<div class="pull-right">
		<div class="wp_loading"><i class="fa fa-done fa-check-circle fa-3x"></i></div>
	</div>
	<h2>Creating Database</h2>
	<p class="result">Please wait a short moment while we set up your account database... <b class="text-success">Completed</b></p>
</div>
<div id="wp_tables">
	<div class="box loading">	
		<div class="pull-right">
			<div class="wp_loading"><img src="<?=base_url();?>assets/img/loading3.gif" /></div>
		</div>
		<h2>Creating Tables</h2>
		<p class="result">Please wait a short moment while we set up your account database...</p>
	</div>
</div>
-->
<script>
$(function(){
	setTimeout(function() {
		create_tables();
	}, 500);
})
function create_tables() {
	$.ajax({
		type: "POST",
		url: "<?=base_url();?>account/ajax_setup/create_tables",
		data: {username:'<?=$username;?>'},
		success: function(html) {
			$('#wp_tables').html(html);
		}
	})
}
</script>