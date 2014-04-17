<div class="col-md-6">
	
	<div class="table-responsive">
	<form id="verify-import-form">
	<input type="hidden" name="upload_id" value="<?=$upload_id;?>" />
	<table class="table table-bordered table-hover table-middle">
		<thead>
		<tr>
			<th>Import Column To</th>
			<th>Your Imported Data (First Record)</th>
		</tr>
		</thead>
		<tbody>
		<? for($i=0; $i < count($fields); $i++) { 
			if ($fields[$i]) {
		?>
		<tr>
			<td><?=modules::run('staff/field_select_fields', 'fields[]' , $fields[$i]);?></td>
			<td>
				<?=$fields[$i];?> (<?=$samples[$i];?>)
			</td>
		</tr>
		<? } } ?>
		</tbody>
	</table>
	</form>
	</div>
</div>
<div class="col-md-6">
	<h2>Configure Import</h2>
	<p>We found <b><?=$total_records;?></b> records in your import. The first line of data from your file is displayed. Please line up your columns to ensure your data will be imported in the correct columns. </p>
	<button type="button" class="btn btn-core" id="btn-verify-import">Verify Configuration</button>
	<div class="clearfix"></div>
	<br />
	<div id="wp-verify-import">
	</div>
</div>
<div class="clearfix"></div>
<script>
$(function(){
	$('#btn-verify-import').click(function(){
		preloading($('#wp-verify-import'));
		$.ajax({
			type: "POST",
			url: "<?=base_url();?>staff/ajax_import/verify_import",
			data: $('#verify-import-form').serialize(),
			success: function(html) {
				loaded($('#wp-verify-import'), html);
			}
		})
	})
});
</script>