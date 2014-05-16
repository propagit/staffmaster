<? if (count($errors) == 0) { ?>
<div class="alert alert-success">
	<i class="fa fa-smile-o fa-2x pull-left"></i> 
	<h4>Yea! - We found no issues with your data.</h4>
</div>
<button class="btn btn-core" id="btn-commit-upload">Commit Upload</button>

<!-- Modal -->
<div class="modal fade" id="waitingModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content" id="order-message">
			<img src="<?=base_url();?>assets/img/loading3.gif" />
			<h2>Please wait!</h2>
			<p>Please wait a moment while we are importing your staff ...</p>
			<div id="commit-result"></div>
		</div>
	</div>
</div>

<script>
$(function(){
	$('#waitingModal').modal({
		backdrop: 'static',
		keyboard: true,
		show: false
	})
	$('#btn-commit-upload').click(function(){
		$('#waitingModal').modal('show');
		$.ajax({
			type: "POST",
			url: "<?=base_url();?>staff/ajax_import/commit_upload",
			data: {upload_id: <?=$upload_id;?>},
			success: function(html) {
				$('#commit-result').html(html);
				setTimeout(function(){
					window.location = '<?=base_url();?>staff/search';
				}, 2000);				
			}
		})
	})
})
</script>

<? } else { ?>
<div class="alert alert-danger">
	<i class="fa fa-frown-o fa-2x pull-left"></i> 
	<h4>Oh No! - We found <b><?=count($errors);?></b> issues with your imported data</h4>
</div>
<a class="btn btn-core" href="<?=base_url().EXPORTS_URL;?>/error/<?=$error_report_file;?>" target="_blank">Download Error Report</a>
<? } ?>