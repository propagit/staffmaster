
<div class="alert alert-info">
	http://<b id="username">username</b>.sm.com
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
	<button type="button" id="btn-signup" class="btn btn-success">Try it now for free</button>
</form>
<br />
<div class="alert alert-danger hide" id="signup-msg">
</div>

<script>
$(function(){
	$('#company_name').keyup(function(){
		var username = $(this).val().toLowerCase();
		username = username.replace(/\s+/g, '');
		$('#username').html(username);
	});
	$('#btn-signup').click(function(){
		signup();
	});
});
function signup() {
	$.ajax({
		type: "POST",
		url: "<?=base_url();?>account/ajax/signup",
		data: $('#signup-form').serialize(),
		success: function(html) {
			var data = $.parseJSON(html);
			if (data.valid) {
				window.location = '<?=base_url();?>account/setup/' + data.username + '/' + data.code;
			} else {
				$('#signup-msg').html(data.msg);
				$('#signup-msg').removeClass('hide');
			}
		}
	})
}
</script>