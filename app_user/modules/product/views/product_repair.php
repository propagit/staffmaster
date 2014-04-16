<h4 class="c6">Enter Customer Details</h4>
<p>* Denotes required field</p>
<? if (validation_errors()) { ?>
<div class="alert alert-error">
	<?php echo validation_errors('<div>','</div>'); ?>
</div>
<? } ?>
<? if (isset($success)) { ?>
<div class="alert alert-success">
	Your order of repair / return part has been placed successfully!
</div>
<? } ?>
<form class="form-horizontal" method="post" action="<?=current_url();?>">
<div class="box order pull-right">
	<div class="photo">
		<? echo modules::run('product/photo', $product['pic_url']); ?>
	</div>
	<div>
		<!-- <h4 class="c4">Part Name</h4> -->
		<h3 class="c2"><?=$product['title'];?></h3>
		<h4 class="c4">Part No: <?=$product['part_no'];?> - Price: $<?=money_format('%i', modules::run('product/retail_price', $product['price']));?></h4>
	</div>
	<div class="clear"></div>
	<br />
	<h4 class="c4">Fault Description *</h4>
	<textarea rows="3" name="fault"><?=set_value('fault');?></textarea>
</div>
<div class="pull-left">
		<div class="control-group">
			<label class="control-label c4">Ship Direction</label>
			<div class="controls">
				<label class="radio">
					<input type="radio" name="ship_direction" value="DIRECT"<?=(set_value('ship_direction') == 'DIRECT') ? ' checked' : '';?> onClick="switch_ship_direction()" /> Direct to customer ( $<?=money_format('%i', modules::run('config/shipping_cost'));?> freight charge )
				</label>
				<label class="radio">
					<input type="radio" name="ship_direction" value="DISTRIBUTOR"<?=(set_value('ship_direction') == 'DISTRIBUTOR') ? ' checked' : '';?> onClick="switch_ship_direction()" /> Back to distributor
				</label>
			</div>
		</div>
		
		
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
			<label class="control-label c4" for="customer_address">Address <span class="customer_required">*</span></label>
			<div class="controls">
				<input type="text" class="input-xlarge" id="customer_address" name="customer_address" value="<?=set_value('customer_address');?>" />
			</div>
		</div>
		<div class="control-group">
			<label class="control-label c4" for="customer_suburb">Suburb <span class="customer_required">*</span></label>
			<div class="controls">
				<input type="text" class="input-xlarge" id="customer_suburb" name="customer_suburb" value="<?=set_value('customer_suburb');?>" />
			</div>
		</div>
		<div class="control-group">
			<label class="control-label c4">State <span class="customer_required">*</span></label>
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
			<label class="control-label c4" for="customer_postcode">Postcode <span class="customer_required">*</span></label>
			<div class="controls">
				<input type="text" id="customer_postcode" name="customer_postcode" value="<?=set_value('customer_postcode');?>" />
			</div>
		</div>
		
		
</div>
<div class="clearfix"></div>
	<? $check_items = explode(';', $product['check_items']);
	if (count($check_items) > 0) { ?>
		<div class="control-group">
			<label class="control-label"></label>
			<div class="controls">
				<label class="checkbox">
					<input type="checkbox" name="agree" value="1"  <?php echo set_checkbox('agree', '1'); ?>/> Please check to confirm you have read and agreed to the checklist statement (if applicable) and the terms and conditions.
				</label>
				<ul>
				<? 
				foreach($check_items as $item)
				{
					if (trim($item) != "")
					{
						echo '<li>' . $item . '</li>';
					}
				}
				?>
				</ul>
			</div>
		</div>
	<? } ?>	
		<div class="control-group">
			<label class="control-label"></label>
			<div class="controls">
				<input type="submit" class="btn btn-primary" value="Place Order" />
			</div>
		</div>
</form>
<script>
function set_state(state)
{
	$('#customer_state').val(state);
	$('#state_label').html(state);
}
function switch_ship_direction()
{
	var ship_direction = $('input[name="ship_direction"]:checked').val();
	if (ship_direction == 'DIRECT')
	{
		$('.customer_required').show();
	}
	else
	{
		$('.customer_required').hide();
	}
}
$(function(){
	switch_ship_direction();	
})
</script>