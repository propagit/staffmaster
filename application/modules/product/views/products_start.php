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
