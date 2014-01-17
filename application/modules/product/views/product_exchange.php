<h4 class="c6">Enter Exchange Details</h4>
<p>* Denotes required field</p>
<? if (validation_errors()) { ?>
<div class="alert alert-error">
	<?php echo validation_errors('<div>','</div>'); ?>
</div>
<? } ?>
<? if (isset($success)) { ?>
<div class="alert alert-success">
	Your order of exchange part has been placed successfully! The Warranty has been activated!
</div>
<? } ?>
<form method="post" action="<?=current_url();?>" class="form-horizontal">
<div class="box order pull-right">
	<div class="photo"><?=modules::run('product/photo', $product['pic_url']);?></div>
	<div>
		<h3 class="c2"><?=$product['title'];?></h3>
		<h4 class="c4">Part No: <?=$product['part_no'];?> - Price: $<?=money_format('%i', modules::run('product/retail_price', $product['price']));?></h4>
	</div>
	<div class="clear"></div>
	<br />
	<h4 class="c4">Fault Description</h4>
	<textarea rows="3" name="fault"><?=set_value('fault');?></textarea>
</div>
<div class="pull-left">
		<div class="control-group">
			<label class="control-label c4" for="customer_name">Customer Name *</label>
			<div class="controls">
				<input type="text" class="input-xlarge upcase" id="customer_name" name="customer_name" value="<?=set_value('customer_name');?>" />
			</div>
		</div>
		<div class="control-group">
			<label class="control-label c4" for="customer_phone">Contact Number *</label>
			<div class="controls">
				<input type="text" class="input-xlarge" id="customer_phone" name="customer_phone" value="<?=set_value('customer_phone');?>" />
			</div>
		</div>
		<div class="control-group">
			<label class="control-label c4" for="customer_email">Email</label>
			<div class="controls">
				<input type="text" class="input-xlarge" id="customer_email" name="customer_email" value="<?=set_value('customer_email');?>" />
			</div>
		</div>
		<div class="control-group">
			<label class="control-label c4" for="customer_address">Address</label>
			<div class="controls">
				<input type="text" class="input-xlarge" id="customer_address" name="customer_address" value="<?=set_value('customer_address');?>" />
			</div>
		</div>
		<div class="control-group">
			<label class="control-label c4" for="customer_suburb">Suburb</label>
			<div class="controls">
				<input type="text" class="input-xlarge" id="customer_suburb" name="customer_suburb" value="<?=set_value('customer_suburb');?>" />
			</div>
		</div>
		<div class="control-group">
			<label class="control-label c4">State</label>
			<div class="controls">
				<select name="customer_state">
					<option value="">Select</option>
					<? foreach($states as $state) { ?>
					<option value="<?=$state['code'];?>"<?=($state['code'] == set_value('customer_state')) ? ' selected' : '';?>><?=$state['name'];?></option>
					<? } ?>
				</select>
			</div>
		</div>
		<div class="control-group">
			<label class="control-label c4" for="customer_postcode">Postcode</label>
			<div class="controls">
				<input type="text" id="customer_postcode" name="customer_postcode" value="<?=set_value('customer_postcode');?>" />
			</div>
		</div>
</div>

<div class="clear"></div>
<div class="shadow"></div>
<br />
<h2 class="c6">Activate Warranty</h2>
<p>To activate a warranty, enter the registration code found in the packaging of the exchanged item</p>
<? if (isset($error)) { ?>
<div class="alert alert-error">
	The registration code is invalid. Please check again!
</div>
<? } ?>
<div class="input-append">
	<input class="input-xlarge pull-left" type="text" placeholder="Enter a product registration code" name="req_no" />
	<input class="btn btn-success" type="submit" value="Activate Warranty" />
</div>

</form>