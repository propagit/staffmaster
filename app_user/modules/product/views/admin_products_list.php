<div class="pull-right btn-breadcrumb">
	<a href="#exportModel" class="btn btn-success" id="export_file" data-toggle="modal"><i class="icon-download-alt icon-white"></i> Export</a>
</div>
<div class="pull-right btn-breadcrumb">
	<form method="post" enctype="multipart/form-data" action="<?=base_url();?>admin/product/import" id="importForm">
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
	<li class="active">Manage Products</li>
</ul>


<form method="post" action="<?=base_url();?>admin/product">
<div class="box-search">
    <div class="input-append">
    <input class="span3" type="text" name="keywords" placeholder="name, brand, category ..." id="keywords" value="<?=$this->session->userdata('keywords');?>" />
    <button class="btn" type="submit" id="btn-search">Search <i class="icon-search"></i></button>
    </div>
</div>
</form>

<div class="pagination">
<ul>
	<?=$pagination;?>
</ul>
</div>

<table class="table table-bordered table-hover">
	<thead>
	<tr>
		<td width="40">Photo</td>
		<td>Product Name</td>
		<td>Part No</td>
		<td>Category</td>
		<td>Brand</td>
		<td>Stock</td>
	</tr>
	</thead>
	<? foreach($products as $product) { 
		$pic_url = base_url(). 'assets/img/no_image.gif';
		if (file_exists(UPLOADS_URL . './products/'. $product['pic_url'])) { $pic_url = base_url() . UPLOADS_URL . '/products/' . $product['pic_url']; }
	?>
	<tr>
		<td><img src="<?=$pic_url;?>" class="img-rounded photo_thumbnail" /></td>
		<td><a href="<?=base_url();?>admin/product/details/<?=$product['product_id'];?>"><?=$product['title'];?></a></td>
		<td><?=$product['part_no'];?></td>
		<td><?=$product['category_title'];?></td>
		<td><?=$product['brand_name'];?></td>
		<td class="center"><?=modules::run('product/stock', $product['part_no']);?>
	</tr>
	<? } ?>
</table>

<!-- Export Modal -->
<div id="exportModel" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-header">
		<h3 id="myModalLabel">Exporting Products...</h3>
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
			url: "<?=base_url();?>admin/product/export",
			success: function(html)
			{
				window.location = '<?=base_url().EXPORTS_URL;?>/' + html;
				$('#exportModel').modal('hide');
			}			
		})
	});
})
</script>