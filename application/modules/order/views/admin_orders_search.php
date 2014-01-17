<ul class="breadcrumb">
	<li><a href="<?=base_url();?>admin/order">Manage Orders</a> <span class="divider">/</span></li>
	<li class="active">Search Results</li>
</ul>

<form method="post" action="<?=base_url();?>admin/order/search">
<div class="box-search">
    <div class="input-append">
    <input class="span3" type="text" placeholder="product, customer ..." name="keywords" value="<?=$keywords;?>" />
    <button class="btn" type="submit">Search <i class="icon-search"></i></button>
    </div>
</div>
</form>
<table class="table table-bordered table-hover">
	<thead>
	<tr>
		<td>Distributor</td>
		<td width="240">Product Name</td>
		<td>Customer</td>
		<td>Order Date</td>
		<td>Order Type</td>
		<td width="40">View</td>
	</tr>
	</thead>
	<? foreach($orders as $order) { ?>
	<tr>
		<td><?=$order['distributor_company_name'];?></td>
		<td><?=$order['product_name'];?></td>
		<td><?=$order['customer_name'];?></td>
		<td><?=($order['sale_date']) ? date('d-m-Y', $order['sale_date']) : '';?></td>
		<td><?=$order['type'];?></td>
		<td>
			<a href="<?=base_url();?>admin/order/details/<?=$order['order_id'];?>" class="btn btn-info btn-small"><i class="icon-eye-open icon-white"></i></a>
		</td>
	</tr>
	<? } ?>
</table>