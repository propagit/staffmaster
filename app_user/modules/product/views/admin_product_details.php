<ul class="breadcrumb">
	<li><a href="<?=base_url();?>admin/product">Manage Products</a> <span class="divider">/</span></li>
	<li class="active">Product Details</li>
</ul>
<div class="box">
	<div class="product_photo pull-left">
		<?
			if (file_exists('./uploads/products/' . $product['pic_url']))
			{
				$pic_url = base_url() . 'uploads/products/' . $product['pic_url'];
			}
			else
			{
				$pic_url = base_url() . 'assets/img/no_image.gif';
				$pic_url = base_url() . 'uploads/products/product.jpg';
			}
			
		?>
		<img src="<?=$pic_url;?>" />
	</div>
	<div class="product_brief">
		<b>Part Name</b>
		<h3><?=$product['title'];?></h3>
		<b>Part No: <?=$product['part_no'];?></b><br /><br />
		<h2>Price: $<?=$product['price'];?></h2>
	</div>
</div>
<? if (isset($result)) { ?>
<div class="alert alert-success">
	The product has been updated successfully!
</div>
<? } ?>
<div class="box">
	<form method="post" action="<?=base_url();?>admin/product/details/<?=$product['product_id'];?>">
	<div class="form-horizontal">
		<div class="control-group">
			<label class="control-label" for="product_title">Product Name</label>
			<div class="controls">
				<input type="text" class="input-xlarge" id="product_title" name="title" value="<?=$product['title'];?>" />
			</div>
		</div>
		<div class="control-group">
			<label class="control-label" for="product_part_no">Part No</label>
			<div class="controls">
				<input type="text" id="product_part_no" name="part_no" value="<?=$product['part_no'];?>" />
			</div>
		</div>
		<div class="control-group">
			<label class="control-label" for="product_brand">Brand</label>
			<div class="controls">
				<input type="text" id="product_brand" class="uneditable-input" disabled value="<?=$brand['reference_id'];?> (<?=$brand['name'];?>)" />
			</div>
		</div>
		<div class="control-group">
			<label class="control-label" for="product_category">Category</label>
			<div class="controls">
				<input type="text" id="product_category" class="uneditable-input" disabled value="<?=$category['category_id'];?> (<?=$category['title'];?>)" />
			</div>
		</div>
		<div class="control-group textarea">
			<label class="control-label" for="product_description">Description</label>
			<div class="controls">
				<textarea name="description"><?=$product['description'];?></textarea>
			</div>
		</div>
		<div class="control-group textarea">
			<label class="control-label" for="product_alternate_part">Alternate Part No</label>
			<div class="controls">
				<textarea name="alternate_part"><?=$product['alternate_part'];?></textarea>
			</div>
		</div>
		
		<div class="control-group">
			<label class="control-label" for="product_pic_url">Image URL</label>
			<div class="controls">
				<div class="input-prepend">
					<span class="add-on">uploads/products/</span>
					<input type="text" name="pic_url" id="product_pic_url" value="<?=$product['pic_url'];?>" />
				</div>
				
			</div>
		</div>
		
		<div class="control-group">
			<label class="control-label" for="product_price">List Price</label>
			<div class="controls">
				<div class="input-prepend">
					<span class="add-on">$</span>
					<input class="span2" id="product_price" name="price" type="text" value="<?=$product['price'];?>" />
				</div>
			</div>
		</div>
		
		<div class="control-group">
			<label class="control-label" for="password">3 Day Exchange</label>
			<div class="controls">
				<input type="checkbox" <?=($product['day3'] == 1) ? 'checked="checked"' : '';?> />
			</div>
		</div>
		
		<div class="control-group">
			<label class="control-label" for="password">Resource Material</label>
			<div class="controls">
				<input type="text" value="<?=$product['doc_links'];?>" />
			</div>
		</div>
		<div class="control-group">
			<label class="control-label" for="password">Checklist Form</label>
			<div class="controls">
				<input type="text" value="<?=$product['check_items'];?>" />
			</div>
		</div>
		
		<!--
		<div class="control-group">
			<label class="control-label" for="margin"></label>
			<div class="controls">
				<button class="btn" type="submit">Update Product</button>
			</div>
		</div>
		-->
	</div>
	</form>
</div>
<div class=" btn-breadcrumb">
	<button class="btn" type="submit"><i class="icon-list-alt"></i> View Stock Report (<?=modules::run('product/stock', $product['part_no']);?>)</button>
</div>
<ul class="breadcrumb">
	<li class="active">Exchange Stock</li>
</ul>