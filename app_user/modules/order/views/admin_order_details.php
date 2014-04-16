<ul class="breadcrumb">
	<li><a href="<?=base_url();?>admin/order">Manage Orders</a> <span class="divider">/</span></li>
	<li class="active">Order Details</li>
</ul>
<div class="box">
	<div class="product_photo pull-left">
		<?
			if (file_exists(UPLOADS_PATH . '/products/' . $product['pic_url']))
			{
				$pic_url = base_url() . UPLOADS_PATH . '/products/' . $product['pic_url'];
			}
			else
			{
				$pic_url = base_url() . 'assets/img/no_image.gif';
				$pic_url = base_url() . UPLOADS_URL . '/products/product.jpg';
			}
			
		?>
		<img src="<?=$pic_url;?>" />	
	</div>
	<div class="product_brief">
		<b>Part Name</b>
		<h3><?=$product['title'];?></h3>
		<b>Part No: <?=$product['part_no'];?></b><br /><br />
		<h3>Order Type: <?=$order['type'];?></h3>
	</div>
</div>

<form>
<div class="box">
	<div class="form-horizontal">
		<div class="control-group">
			<label class="control-label">Distributor Company</label>
			<div class="controls">
				<input type="text" value="<?=$order['distributor_company_name'];?>" disabled />
			</div>
		</div>
		<div class="control-group">
			<label class="control-label" for="product_serial_no">Serial No</label>
			<div class="controls">
				<input type="text" name="product_serial_no" id="product_serial_no" value="<?=$order['product_serial_no'];?>" disabled />
			</div>
		</div>
		<div class="control-group">
			<label class="control-label" for="req_no">Registration No</label>
			<div class="controls">
				<input type="text" name="req_no" id="req_no" value="<?=$order['req_no'];?>" disabled />
			</div>
		</div>
		<div class="control-group">
			<label class="control-label">Ship Direction</label>
			<div class="controls">
				<label class="radio">
					<input type="radio" name="ship_direction" value="DIRECT"<?=($order['ship_direction'] == 'DIRECT') ? ' checked' : '';?>> Direct to customer
				</label>
				<label class="radio">
					<input type="radio" name="ship_direction" value="DISTRIBUTOR"<?=($order['ship_direction'] != 'DIRECT') ? ' checked' : '';?>> Back to distributor
				</label>
			</div>
		</div><br />
		<div class="control-group">
			<label class="control-label" for="sys_rma">System RMA</label>
			<div class="controls">
				<input type="text" name="sys_rma" id="sys_rma" value="<?=$order['sys_rma'];?>" disabled />
			</div>
		</div>
		<div class="control-group">
			<label class="control-label">Type</label>
			<div class="controls">
				<select disabled>
					<option value="REP/RTN"<?=($order['type'] == "REP/RTN") ? ' selected' : ''; ?>>Repair / Return</option>
					<option value="EXCHANGE"<?=($order['type'] == "EXCHANGE") ? ' selected' : ''; ?>>Exchange</option>
				</select>
			</div>
		</div>
		<div class="control-group">
			<label class="control-label" for="sale_date">Sale Date</label>
			<div class="controls">
				<input type="text" class="date" id="sale_date" name="sale_date" value="<?=($order['sale_date']) ? date('d/m/Y', $order['sale_date']) : '';?>" disabled />
			</div>
		</div>
		<div class="control-group">
			<label class="control-label" for="received_date">Received Date</label>
			<div class="controls">
				<input type="text" class="date" name="received_date" id="received_date" value="<?=($order['received_date']) ? date('d/m/Y', $order['received_date']) : '';?>" disabled />
			</div>
		</div>
		<div class="control-group">
			<label class="control-label" for="repair_date">Repair Date</label>
			<div class="controls">
				<input type="text" class="date" name="repair_date" id="repair_date" value="<?=($order['repair_date']) ? date('d/m/Y', $order['repair_date']) : '';?>" disabled />
			</div>
		</div>
		<div class="control-group">
			<label class="control-label" for="ship_date">Ship Date</label>
			<div class="controls">
				<input type="text" class="date" name="ship_date" id="ship_date" value="<?=($order['ship_date']) ? date('d/m/Y', $order['ship_date']) : '';?>" disabled />
			</div>
		</div>
		<div class="control-group">
			<label class="control-label" for="consignment">Consignment Link</label>
			<div class="controls">
				<input class="input-xxlarge" type="text" name="consignment" id="consignment" value="<?=$order['consignment'];?>" disabled />
			</div>
		</div>
		
	</div>	
</div>
<div class="box">
	<div class="form-horizontal">
		<div class="control-group">
			<label class="control-label" for="customer_name">Customer Name</label>
			<div class="controls">
				<input type="text" value="<?=$order['customer_name'];?>" name="customer_name" id="customer_name" disabled />
			</div>
		</div>
		<div class="control-group">
			<label class="control-label" for="customer_email">Email</label>
			<div class="controls">
				<input type="text" value="<?=$order['customer_email'];?>" name="customer_email" id="customer_email" disabled />
			</div>
		</div>
		<div class="control-group">
			<label class="control-label" for="customer_address">Address</label>
			<div class="controls">
				<input type="text" value="<?=$order['customer_address'];?>" name="customer_address" id="customer_address" disabled />
			</div>
		</div>
		<div class="control-group">
			<label class="control-label" for="customer_suburb">Suburb</label>
			<div class="controls">
				<input type="text" value="<?=$order['customer_suburb'];?>" name="customer_suburb" id="customer_suburb" disabled />
			</div>
		</div>
		<div class="control-group">
			<label class="control-label">State</label>
			<div class="controls">
				<select name="customer_state" disabled>
					<? foreach($states as $state) { ?>
					<option value="<?=$state['code'];?>"<?=($state['code'] == $order['customer_state']) ? ' selected' : '';?>><?=$state['name'];?></option>
					<? } ?>
				</select>
			</div>
		</div>
		<div class="control-group">
			<label class="control-label" for="customer_postcode">Postcode</label>
			<div class="controls">
				<input type="text" value="<?=$order['customer_postcode'];?>" id="customer_postcode" name="customer_postcode" disabled />
			</div>
		</div>
		<div class="control-group">
			<label class="control-label" for="customer_phone">Contact Number</label>
			<div class="controls">
				<input type="text" value="<?=$order['customer_phone'];?>" id="customer_phone" name="customer_phone" disabled />
			</div>
		</div>
		<div class="control-group textarea">
			<label class="control-label" for="fault">Fault</label>
			<div class="controls">
				<textarea name="fault" id="fault" disabled><?=$order['fault'];?></textarea>
			</div>
		</div>
	</div>
</div>
</form>

<script>
$(function(){	
	$(".date").datepicker();
})
</script>