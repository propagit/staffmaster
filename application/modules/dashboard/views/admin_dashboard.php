<ul class="breadcrumb">
	<li class="active">Dashboard</li>
</ul>


<div class="row-fluid">
	<div class="span6 box">
		<table class="table">
			<thead>
				<td>Products</td>
				<td></td>
			</thead>
			<tr>
				<td>Current Exchange Products</td>
				<td><span class="badge badge-inverse pull-right"><?=$total_stocks;?></span></td>
			</tr>
			<tr>
				<td>Current Repair - Return Products</td>
				<td><span class="badge badge-inverse pull-right"><?=$total_products;?></span></td>
			</tr>
		</table>
		<a class="btn" href="<?=base_url();?>admin/product"><i class="icon-wrench"></i> Manage Products</a>
	</div>
	<div class="span6 box">
		<table class="table">
			<thead>
				<td>System Users</td>
				<td></td>
			</thead>
			<tr>
				<td>Distributor Accounts</td>
				<td><span class="badge badge-inverse pull-right"><?=$total_accounts;?></span></td>
			</tr>
			<tr>
				<td>Total Users</td>
				<td><span class="badge badge-inverse pull-right"><?=$total_users;?></span></td>
			</tr>
		</table>
		<a class="btn" href="<?=base_url();?>admin/user"><i class="icon-user"></i> Manage Users</a>
	</div>
</div>

<ul class="breadcrumb">
	<li class="active">Orders Overview</li>
</ul>
<div class="box">
	<table class="table">
		<thead>
			<td>Clients</td>
			<td>Customer</td>
			<td>Product Name</td>
			<!-- <td class="options">Details</td> -->
			<td class="center">Order Date</td>
		</thead>
		<? foreach($orders as $order) { ?>
		<tr>
			<td class="darkred"><?=$order['distributor_company_name'];?></td>
			<td><?=$order['customer_name'];?></td>
			<td class="darkred"><?=$order['product_name'];?></td>
			<!-- <td><a class="btn btn-mini pull-right btn-info" href="<?=base_url();?>admin/order/details/<?=$order['order_id'];?>">View Order</a></td> -->
			<td class="center"><?=date('d/m/Y', $order['sale_date']);?></td>
		</tr>
		<? } ?>
	</table>
	<a class="btn" href="<?=base_url();?>admin/order"><i class="icon-list-alt"></i> Manage Orders</a>
</div>