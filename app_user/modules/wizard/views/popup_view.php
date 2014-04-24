<!-- Modal -->
<div class="modal fade" id="welcomeModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content" id="credit-alert">
			<div class="modal-body">
				<h2>Welcome To Staff Master</h2>
				<p>We can see you are new to Staff Master, to help you get familiar with the system and guide you through the process of creating your first job we have created a set up wizard.</p>
			</div>
			<div class="modal-footer">
				<a type="button" class="btn btn-core btn-lg" href="<?=base_url();?>setting/company"><i class="fa fa-smile-o"></i> Yes! Help Me Set Up</a>
				<button type="button" class="btn btn-default btn-lg" id="btn-dismiss"><i class="fa fa-frown-o"></i> No! Thanks</button>
				
			</div>
			<p><input type="checkbox" id="turnoff"> &nbsp; Do not show this next time</p>
		</div>	
			
	</div>
</div>

<script>
$(function(){
	$('#welcomeModal').modal({
		backdrop: 'static',
		keyboard: true,
		show: true
	});
	$('#btn-dismiss').click(function(){
		var turnoff = $('#turnoff').is(':checked');
		$.ajax({
			type: "POST",
			url: "<?=base_url();?>wizard/ajax/turnoff",
			data: {turnoff: turnoff},
			success: function(html) {
				$('#welcomeModal').modal('hide');
			}
		})
	})
})
</script>