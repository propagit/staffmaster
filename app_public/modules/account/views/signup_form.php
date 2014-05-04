<form class="row form-inline" role="form" id="signup-form">
	<div class="col-md-3 form-group" id="f_company_name">
		<label class="sr-only" for="company_name">Company Name</label>
		<input type="email" class="form-control input-lg" id="company_name" name="company_name" placeholder="Enter company name">
	</div>
	<div class="col-md-3 form-group" id="f_email_address">
		<label class="sr-only" for="email_address">Email Address</label>
		<input type="email" class="form-control input-lg" id="email_address" name="email_address" placeholder="Enter email">
	</div>
	<div class="col-md-3 form-group" id="f_password">
		<label class="sr-only" for="password">Password</label>
		<input type="password" class="form-control input-lg" id="password" name="password" placeholder="Password">
	</div>
	<div class="col-md-3">
		<button type="button" id="btn-signup" class="btn btn-core btn-lg btn-block">Try it now for free</button>
	</div>
</form>
<!-- Modal -->
<div class="modal fade" id="signupModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content" id="signup-message">
			<h2 class="text-success"><i class="fa fa-smile-o"></i> Great Decision!</h2>
			<p>You are nearly ready to start using StaffBooks<br />
			Check your email to finish the authentication process and login to your account.</p>
		</div>
	</div>
</div>
<script>
$(function(){
	$('#btn-signup').click(function(){
		
		$('#signup-form').find('.form-group').removeClass('has-error');
		$('#signup-form').find('input').tooltip('destroy')

		$.ajax({
			type: "POST",
			url: "<?=base_url();?>account/ajax/validate",
			cache: false,
			async: false,
			data: $('#signup-form').serialize(),
			success: function(html) {
				var data = $.parseJSON(html);
				if (!data.valid) {
					$('#f_' + data.error_id).addClass('has-error');
					$('#' + data.error_id).tooltip({
						title: data.msg,
						placement: 'bottom'
					});
					$('#' + data.error_id).focus();
				} else {					
					$('#signupModal').modal('show');
					$.ajax({
						type: "POST",
						url: "<?=base_url();?>account/ajax/signup",
						cache: false,
						data: $('#signup-form').serialize(),
						success: function(html) {
							setTimeout(function(){
								$('#signupModal').modal('hide');
							}, 2000);							
						}
					})								
				}
			}
		})
	});
});
</script>