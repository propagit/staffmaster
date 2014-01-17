<div class="bar-search">
	<div class="pull-right">
		<h4 class="c6">Or search product by product type and brand</h4>
		<?=modules::run('common/dropdown_categories');?>
		<span id="wrapper_brands"><?=modules::run('common/dropdown_brands');?></span> &nbsp; 
		<a class="btn btn-primary" href="<?=base_url();?>product">Search <i class="icon-search icon-white"></i></a>
	</div>
	
	<div class="pull-left">
		<h4 class="c6">Search products by keyword</h4>
		<form method="post" action="<?=base_url();?>product">
		<div class="input-append">
			<input class="input-xlarge" type="text" placeholder="Enter a product name, brand or item code" name="search_keywords" value="<?=$this->session->userdata('search_keywords');?>" />
			<button class="btn btn-primary" type="submit"><i class="icon-search icon-white"></i> Search</button>
		</div>
		</form>
	</div>
	<div class="clear"></div>
	<div class="shadow"></div>
</div>
<br />
<div class="bar-search">
	<div class="pull-right">
		<div class="well well-small">
			<button class="btn btn-mini btn-primary pull-right" type="button"><i class="icon-wrench icon-white"></i></button>
			<span class="c3">REPAIR / RETURN</span>
			Click the Return/Repair icon to order this product for repair
		</div>
		<div class="well well-small">
			<button class="btn btn-mini btn-primary pull-right" type="button"><i class="icon-refresh icon-white"></i></button>
			<span class="c3">EXCHANGE PRODUCT</span>
			Click the Exchange icon to order an exchange for this product
		</div>
	</div>
	<div class="pull-left">
		<h4>Search Result: <a><?=$search_results_count;?></a></h4>
		    <!--
<ul class="breadcrumb c3">
				<li><a>Products</a> <span class="divider">&raquo;</span></li>
				<li><a><?=$this->session->userdata('selected_category_label') ? $this->session->userdata('selected_category_label') : 'Any category'; ?></a> <span class="divider">&raquo;</span></li>
				<li><a><?=$this->session->userdata('selected_brand_label') ? $this->session->userdata('selected_brand_label') : 'Any brand'; ?></a></li>
			</ul>
-->
		Category <a><?=$this->session->userdata('selected_category_label') ? $this->session->userdata('selected_category_label') : 'Any category'; ?></a> / Brand name <a><a><?=$this->session->userdata('selected_brand_label') ? $this->session->userdata('selected_brand_label') : 'Any brand'; ?></a></a>
		<div class="pagination">
			<ul>
				<?=$pagination;?>
			</ul>
		</div>
	</div>
	<div class="clear"></div>
</div>
<div class="products_list">
	<? for($i=0; $i<count($products); $i++) { 
		$stock = modules::run('product/stock', $products[$i]['part_no']);
		
	?>
	<div class="product_wrapper<?=($i%4 == 3 )? ' last-child' : '';?>">
		<div class="photo"><a href="<?=base_url();?>product/p-<?=$products[$i]['product_id'];?>"><?=modules::run('product/photo', $products[$i]['pic_url']);?></a></div>
		<div class="info">
			<span class="c4"><?=character_limiter($products[$i]['title'],13);?></span>
			Part Number: <?=$products[$i]['part_no'];?>
		</div>
		<? if ($stock > 0) { ?>
		<a href="<?=base_url();?>product/e-<?=$products[$i]['product_id'];?>" class="btn btn-block btn-primary"><i class="icon-refresh icon-white"></i>  Exchange Available (<?=$stock;?>)</a>
		<? } else { ?>
		<button class="btn btn-block disabled" type="button"><i class="icon-refresh icon"></i>  Exchange Not Available</button>
		<? } ?>
		
		<a href="<?=base_url();?>product/r-<?=$products[$i]['product_id'];?>" class="btn btn-block btn-primary"><i class="icon-wrench icon-white"></i> Repair / Return Part</a>
	</div>
	<? } ?>
</div>

<div class="clear"></div>
<div class="pagination">
	<ul>
		<?=$pagination;?>
	</ul>
</div>