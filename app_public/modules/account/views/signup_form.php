<div class="alert alert-info">
	http://<b id="subdomain">subdomain</b>.sm.com
</div>
<form class="form-inline" role="form" id="signup-form">
	<div class="form-group">
		<label class="sr-only" for="company_name">Company Name</label>
		<input type="email" class="form-control" id="company_name" name="company_name" placeholder="Enter company name">
	</div>
	<div class="form-group">
		<label class="sr-only" for="email_address">Email Address</label>
		<input type="email" class="form-control" id="email_address" name="email_address" placeholder="Enter email">
	</div>
	<div class="form-group">
		<label class="sr-only" for="password">Password</label>
		<input type="password" class="form-control" id="password" name="password" placeholder="Password">
	</div>
	<button type="button" id="btn-signup" class="btn btn-success" data-loading-text="Please wait..." >Try it now for free</button>
</form>
<br />
<div class="alert alert-danger hide" id="signup-msg">
</div>
<script>
$(function(){
	$('#company_name').keyup(function(){
		var subdomain = $(this).val().toLowerCase();
		subdomain = subdomain.replace(/\s+/g, '');
		$('#subdomain').html(subdomain);
	});
	$('#btn-signup').click(function(){
		var btn = $(this);
		btn.button('loading');
		$.ajax({
			type: "POST",
			url: "<?=base_url();?>account/ajax/signup",
			data: $('#signup-form').serialize(),
			success: function(html) {
				btn.button('reset');
				var data = $.parseJSON(html);
				if (data.valid) {
					$('#signup-msg').removeClass('hide alert-danger');
					$('#signup-msg').addClass('alert-success');
					$('#signup-msg').html(data.msg);
				} else {
					$('#signup-msg').removeClass('hide alert-success');
					$('#signup-msg').addClass('alert-danger');
					$('#signup-msg').html(data.msg);
				}
			}
		})
	});
});
</script>