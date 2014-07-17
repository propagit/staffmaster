<div class="alert alert-danger" id="alert-message">
	<h2 class="text-danger">Oh Noooo! <i class="fa fa-frown-o"></i></h2>
	
	<p><b>We have detected you are using a very old version of Internet Explorer! </b><br />
	Updating your browser is free and only takes a few minutes to do. Doing this will provide you with a better more secure online experience.<br />
	You can continue into the site although you may find that the system may not be 100% operational.</p>
	<p><b>We would recommend you update your browser.</b></p>	
	<br />
	<a class="btn btn-core" href="http://windows.microsoft.com/en-AU/internet-explorer/download-ie">Update Browser</a> &nbsp; &nbsp;
	<a class="btn btn-warning" onclick="continue_anyway()">Continue Without Update</a>
</div>
<script>
function continue_anyway() {
	document.getElementById('alert-message').remove();
	document.getElementById('check_browser').style.removeProperty('display');
}
</script>