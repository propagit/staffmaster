<div class="bar-search">
	<div class="pull-right">
		<?=modules::run('common/dropdown_categories');?>
		<?=modules::run('common/dropdown_brands');?> &nbsp; 
		<a class="btn btn-primary" href="<?=base_url();?>product">Search <i class="icon-search icon-white"></i></a>
	</div>
	<div class="pull-left">
	    <ul class="breadcrumb c6">
			<li><a href="<?=base_url();?>product/all">Products</a> <span class="divider">&raquo;</span></li>
			<li><a href="<?=base_url();?>product/c-<?=$category['reference_id'];?>"><?=$category['title'];?></a> <span class="divider">&raquo;</span></li>
			<li><?=$brand['name'];?></li>
		</ul>
	</div>
	<div class="clear"></div>
	<div class="shadow"></div>
</div>
<br />
<div class="pull-right">
	<div class="photo_large">
		<?=modules::run('product/photo', $product['pic_url']);?>
	</div>
	<p align="center">This is not what you are looking for? Perhaps try one of these similar items</p>
	<? $i = 5; foreach($similar_products as $similar_product) { ?>
	<div class="photo_thumb<?=($i==5) ? ' first-child': ''; ?>">
		<a href="<?=base_url();?>product/p-<?=$similar_product['product_id'];?>"><?=modules::run('product/photo', $similar_product['pic_url']);?></a>
		<?=$similar_product['part_no'];?>
	</div>
	
	<? $i++; } ?>
</div>
<div class="product_details pull-left">
	<h4 class="c4">Part Name</h4>
	<h3><?=$product['title'];?></h3>
	<p class="c4">Part No: <?=$product['part_no'];?></p>
	<h4 class="c4">Description</h4>
	<p><?=$product['description'];?></p>
	<h4 class="c4">Alternate Parts</h4>
	<p><?=$product['alternate_part'];?></p>
	<!--
<ul>
		<li>4784172</li>
		<li>3860122</li>
		<li>G7762</li>
		<li>EFPW552</li>
	</ul>
-->
	<? if (trim($product['check_items']) != '') { ?>
	<h4 class="c4">Check Items</h4>
	<ul class="check_items">
	<?
		$items = explode(";", $product['check_items']);
		
		foreach($items as $item) {
			echo '<li>' . $item . '</li>';
		}
	?>
	</ul>
	<? } ?>
	
	<? if (trim($product['doc_links']) != '') { 
		$doc_ids = explode(',', $product['doc_links']);
		
	?>
	<h4 class="c4">Training and Reading</h4>
	<p>Click the link below for further information<br />
	<? foreach($doc_ids as $file_id) { 
		$file = $this->resource_model->get_resource_file($file_id);
		if ($file) { ?>
	<a href="<?=base_url().UPLOADS_URL;?>/resources/<?=$file['file_name'];?>" target="_blank"><?=$file['orig_name'];?></a><br />
	<? } } ?>	
	<? } ?>
	</p>
	
	<? 
		$user = $this->session->userdata('user_data'); 
		$trade_price = $product['price'];
		if ($user['discount'] > 0)
		{
			$trade_price = (100 - $user['discount']) * $trade_price / 100;
		}
		$retail_price = $trade_price;
		if ($user['margin'] > 0)
		{
			$retail_price = (100 + $user['margin']) * $retail_price / 100;
		}
		$stock = modules::run('product/stock', $product['part_no']);
	?>
	
	<h4 class="c4">Return Repair Retail Price: 
		<span class="price">$<?=money_format('%i', $retail_price);?></span>
		(GST Inclusive)
	</h4>
	<!-- <h4 class="c4">Return Repair Trade Price: <span class="price">$<?=money_format('%i', $trade_price);?></span></h4> -->
	
	
	<div class="buttons">
		<a href="<?=base_url();?>product/r-<?=$product['product_id'];?>" class="btn btn-block btn-primary" type="button">Repair - Return Part <i class="icon-wrench icon-white"></i></a>
		<? if ($stock > 0) { ?>
		<a href="<?=base_url();?>product/e-<?=$product['product_id'];?>" class="btn btn-block btn-primary" type="button">Exchange Part (<?=$stock;?>) <i class="icon-refresh icon-white"></i></a>
		<? } else { ?>
		<a class="btn btn-block btn-primary disabled">Exchange Not Available <i class="icon-refresh icon-white"></i></a>
		<? } ?>
		<? if ($product['day3']) { ?>
		<a href="<?=base_url();?>product/3d-<?=$product['product_id'];?>" class="btn btn-block btn-primary">3 Day Exchange <i class="icon-calendar icon-white"></i></a>
		<? } else { ?>
		<a class="btn btn-block btn-primary disabled">3 Day Exchange <i class="icon-calendar icon-white"></i></a>
		<? } ?>
		<a href="#myModal" role="button" data-toggle="modal" class="btn btn-block btn-primary" type="button">Tell A Friend <i class="icon-share icon-white"></i></a>
	</div>
</div>

<!-- Modal -->
<div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
		<h3 id="myModalLabel">Tell A Friend</h3>
	</div>
	<div class="modal-body">
		<label for="friend_email">Enter your friend's email address</label>
		<input type="text" class="input-xlarge" id="friend_email" />
		
		<div id="results"></div>
	</div>
	<div class="modal-footer">
		<button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
		<button class="btn btn-primary" id="btn_sendmail">Send</button>
	</div>
</div>
</form>
<script>
$(function(){
	$('#btn_sendmail').click(function(){
		var email = $('#friend_email').val();
		$('#results').html('<div class="alert alert-info">Sending email...</div>');
		$.ajax({
			type: "POST",
			url: "<?=base_url();?>product/ajax/sendmail",
			data: {product_id: <?=$product['product_id'];?>, email:email},
			dataType: "html",
			success: function(html){
				var data = $.parseJSON(html);
				if (data.result == false)
				{
					$('#results').html('<div class="alert alert-error">' + data.msg + '</div>');
				}
				else
				{
					$('#results').html('<div class="alert alert-success">An email has been sent to your friend successfully!</div>');
					$('#myModal').modal('hide')
				}				
			}
		})
	})
});
</script>