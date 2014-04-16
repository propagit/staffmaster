<div class="pull-right btn-breadcrumb">
	<a class="btn btn-danger" id="empty_db" data-toggle="modal"><i class="icon-trash icon-white"></i> Empty</a>
</div>
<div class="pull-right btn-breadcrumb">
	<a href="#exportModel" class="btn btn-success" id="export_file" data-toggle="modal"><i class="icon-download-alt icon-white"></i> Export</a>
</div>
<div class="pull-right btn-breadcrumb">
	<form method="post" enctype="multipart/form-data" action="<?=base_url();?>admin/order/import" id="importForm">
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
	<li class="active">Manage Orders</li>
</ul>


<form method="post" action="<?=base_url();?>admin/order/search">
<div class="box-search">
    <div class="input-append">
    <input class="span3" type="text" placeholder="product, customer ..." name="keywords" />
    <button class="btn" type="submit">Search <i class="icon-search"></i></button>
    </div>
</div>
</form>
<div class="pagination">
<ul>
	<?=$pagination;?>
</ul>
</div>
<div class="box_filters">
	<select id="distributor_name">
		<?=$this->session->userdata('order_distributor');?>
		<option value="">All distributors</option>
		<? foreach($users as $user) { ?>
		<option value="<?=$user['company_name'];?>"<?=($user['company_name'] == $this->session->userdata('order_distributor')) ? ' selected' : '';?>><?=$user['company_name'];?></option>
		<? } ?>
	</select>
	<select id="order_type">
		<option value="">Any order type</option>
		<option value="REP/RTN"<?=($this->session->userdata('order_type') == 'REP/RTN') ? ' selected': '';?>>REP/RTN</option>
		<option value="3D_EXCHANGE"<?=($this->session->userdata('order_type') == '3D_EXCHANGE') ? ' selected': '';?>>3 DAY EXCHANGE</option>
		<option value="EXCHANGE"<?=($this->session->userdata('order_type') == 'EXCHANGE') ? ' selected': '';?>>EXCHANGE</option>
	</select>
</div>
   
<table class="table table-bordered table-hover">
	<thead>
	<tr>
		<td>RMA</td>
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
		<td><?=$order['sys_rma'];?></td>
		<td><?=$order['distributor_company_name'];?></td>
		<td><?=$order['product_name'];?>
			<br />Part no: <?=$order['product_part_no'];?>
		</td>
		<td><?=$order['customer_name'];?></td>
		<td><?=($order['sale_date']) ? date('d/m/Y', $order['sale_date']) : '';?></td>
		<td><?=$order['type'];?></td>
		<td>
			<a href="<?=base_url();?>admin/order/details/<?=$order['order_id'];?>" class="btn btn-info btn-small"><i class="icon-eye-open icon-white"></i></a>
		</td>
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
	$('#empty_db').click(function(){
		if (confirm('This will remove all orders database. Are you sure you want to do so?'))
		{
			window.location = '<?=base_url();?>admin/order/empty';
		}
	});
	$('#import_file').change(function(){
		$('#importForm').submit();
	});
	$('#export_file').click(function(){
		$.ajax({
			url: "<?=base_url();?>admin/order/export",
			success: function(html)
			{
				window.location = '<?=base_url();?>exports/' + html;
				$('#exportModel').modal('hide');
			}			
		})
	});
	$('#distributor_name').change(function(){
		var name = $(this).val();
		$.ajax({
			type: "POST",
			url: "<?=base_url();?>admin/order/ajax/select_distributor",
			data: {name: name},
			dataType: "html",
			success: function(html)	{
				window.location = "<?=base_url();?>admin/order";
			}
		})
	});
	$('#order_type').change(function(){
		var type = $(this).val();
		$.ajax({
			type: "POST",
			url: "<?=base_url();?>admin/order/ajax/select_order_type",
			data: {type: type},
			dataType: "html",
			success: function(html) {
				window.location = "<?=base_url();?>admin/order";
			}
		})
	});
})
</script>