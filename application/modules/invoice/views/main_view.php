<!--begin top box--->
<div class="col-md-12">
	<div class="box top-box">
		<h2>Client Invoices</h2>
		<p>Create invoices and issue them to your clients. As time sheets are approved and batched they will be available to add to client invoice.</p>
	</div>
</div>
<!--end top box-->

<!--begin bottom box -->
<div class="col-md-12">
	<div class="box bottom-box">
		<div class="inner-box">
			<ul class="nav nav-tabs tab-respond" id="tab-invoice">
				<li class="active"><a href="#create-invoice" data-toggle="tab">Create Invoice</a></li>
				<li><a href="#search-invoices" data-toggle="tab">Search Invoices</a></li>
			</ul>
			<br />
			
			<div class="tab-content">
				<!-- Begin tab create invoice -->
				<div class="tab-pane active" id="create-invoice">
					<?=modules::run('invoice/create_view');?>					
				</div><!-- End tab create invoice -->
				
				<!-- begin tab search invoices -->
				<div class="tab-pane" id="search-invoices">
					<?=modules::run('invoice/search_form');?>
				</div>
			</div>
			
		</div>
	</div>
</div>

<script>
$(function() {
	//$('#tab-invoice a[href="#search-invoices"]').tab('show');
})
</script>