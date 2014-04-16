<? if (count($errors) == 0) { ?>
<div class="alert alert-success">
	<i class="fa fa-smile-o fa-2x pull-left"></i> 
	<h4>Yea! - We found no issues with your data.</h4>
</div>
<button class="btn btn-core" id="btn-commit-upload">Commit Upload</button>
<div id="commit-result"></div>
<script>
$(function(){
	$('#btn-commit-upload').click(function(){
		$.ajax({
			type: "POST",
			url: "<?=base_url();?>attribute/ajax_venue/commit_upload",
			data: {records: <?=$records;?>},
			success: function(html) {
				//$('#commit-result').html(html);
				window.location = '<?=base_url();?>attribute/venue';
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
<a class="btn btn-core" href="<?=base_url();?>exports/error/<?=$error_report_file;?>" target="_blank">Download Error Report</a>
<? } ?>