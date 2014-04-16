<div class="pull-right btn-breadcrumb">
	<a href="#exportModel" data-toggle="modal" class="btn btn-success" id="export_file"><i class="icon-download-alt icon-white"></i> Export</a>
</div>
<div class="pull-right btn-breadcrumb">
	<form method="post" enctype="multipart/form-data" action="<?=base_url();?>admin/product/brand/import" id="importForm">
	<div class="fileupload fileupload-new" data-provides="fileupload">
		<div>
			<span class="btn btn-file btn-info">
				<span class="fileupload-new"><i class="icon-upload icon-white"></i>  Import</span>
				<input type="file" name="import_file" id="import_file" />
			</span>
		</div>
	</div>
	</form>
</div>


<ul class="breadcrumb">
	<li><a href="<?=base_url();?>admin/product">Manage Products</a> <span class="divider">/</span></li>
	<li class="active">Brands</li>
</ul>

<table class="table table-bordered table-hover">
	<tr>
		<td width="80">Brand ID</td>
		<td>Title</td>
	</tr>
	<? foreach($brands as $brand) { ?>
	<tr>
		<td><?=$brand['reference_id'];?></td>
		<td><?=$brand['name'];?></td>
	</tr>
	<? } ?>
</table>

<!-- Export Modal -->
<div id="exportModel" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-header">
		<h3 id="myModalLabel">Exporting Brands...</h3>
	</div>
	<div class="modal-body">
		<p><img src="<?=base_url();?>assets/img/ajaxloading.gif" /></p>
	</div>
</div>

<script>
$(function(){
	$('#import_file').change(function(){
		$('#importForm').submit();
	});
	$('#export_file').click(function(){
		$.ajax({
			url: "<?=base_url();?>admin/product/brand/export",
			success: function(html)
			{
				window.location = '<?=base_url().EXPORTS_URL;?>/' + html;				
				$('#exportModel').modal('hide');
			}			
		})
	});
})
</script>