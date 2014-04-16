<div class="box">	
	<div class="pull-right">
		<div class="wp_loading"><i class="fa fa-done fa-check-circle fa-3x"></i></div>
	</div>
	<h2>Creating User Account</h2>
	<p class="result">Please wait a short moment while we set up your user account... <b class="text-success">Completed</b></p>
</div>

<!-- Modal -->
<div class="modal fade" id="redirectModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<h2 class="text-success">Awesome!</h2>
			<p>You are all set and ready to go.<br />
			Redirecting to your Admin Portal in a few second ...</p>
		</div>
	</div>
</div>

<script>
$(function(){
	$('#redirectModal').modal('show');
	setTimeout(function() {
		window.location = '<?=$url;?>';
	}, 2000);
})
</script>