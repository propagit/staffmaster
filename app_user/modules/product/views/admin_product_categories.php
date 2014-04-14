<div class="pull-right btn-breadcrumb">
	<a href="#exportModel" data-toggle="modal" class="btn btn-success" id="export_file"><i class="icon-download-alt icon-white"></i> Export</a>
</div>
<div class="pull-right btn-breadcrumb">
	<form method="post" enctype="multipart/form-data" action="<?=base_url();?>admin/product/category/import" id="importForm">
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
	<li class="active">Categories</li>
</ul>
<table class="table table-bordered table-hover">
	<tr>
		<td width="80">Category ID</td>
		<td>Title</td>
		<td>Priority</td>
		<td>Intro</td>
		<td>Visible</td>
	</tr>
	<? foreach($categories as $category) { ?>
	<tr>
		<td><?=$category['category_id'];?></td>
		<td><?=$category['title'];?></td>
		<td><?=$category['priority'];?></td>
		<td><?=$category['intro'];?></td>
		<td><?=($category['visible']) ? 'Yes' : 'No';?></td>
	</tr>
	<? } ?>
</table>

<!-- Export Modal -->
<div id="exportModel" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-header">
		<h3 id="myModalLabel">Exporting Categories...</h3>
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
			url: "<?=base_url();?>admin/product/category/export",
			success: function(html)
			{				
				window.location = '<?=base_url();?>exports/' + html;
				$('#exportModel').modal('hide');
			}			
		})
	});
})
</script>