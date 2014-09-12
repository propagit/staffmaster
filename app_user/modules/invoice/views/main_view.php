<script src="<?=base_url()?>assets/ckeditor/ckeditor.js"></script>
<script src="<?=base_url()?>assets/ckeditor/config.js"></script>
<script src="<?=base_url()?>assets/ckeditor/styles.js"></script>
<!--begin top box--->
<div class="col-md-12">
	<div class="box top-box">
		<? if (modules::run('auth/is_client')) { ?>
		<h2><i class="icon-accountsInvoices"></i> &nbsp; Your Invoices</h2>
		<p>A record of recent issued invoices can be found, viewed and downloaded using the below form.</p>
		<? } else { ?>
		<h2><i class="icon-accountsInvoices"></i> &nbsp; Client Invoices</h2>
		<p>Create invoices and issue them to your clients. As time sheets are approved and batched they will be available to add to client invoice.</p>
		<? } ?>
	</div>
</div>
<!--end top box-->

<!--begin bottom box -->
<div class="col-md-12">
	<div class="box bottom-box">
		<div class="inner-box">
			<? if (modules::run('auth/is_client')) { ?>
				<?=modules::run('invoice/search_form');?>
			<? } else { ?>
			<ul class="nav nav-tabs tab-respond" id="tab-invoice">
				<li class="active"><a href="#create-invoice" data-toggle="tab">Create Invoice</a></li>
				<li><a href="#search-invoices" data-toggle="tab">Search Invoices</a></li>
				
				<li class="pull-right active"><a href="<?=base_url();?>invoice">Client Invoices</a></li>
				<li class="pull-right"><a href="<?=base_url();?>expense">Staff Expenses</a></li>
				<li class="pull-right">
					<a href="<?=base_url();?>payrun">Pay Run</a>
				</li>
				<li class="pull-right">
					<a href="<?=base_url();?>timesheet">Time Sheets</a>
				</li>
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
			<? } ?>
		</div>
	</div>
</div>

<script>
$(function() {
	$('#tab-invoice a[href="#<?=$tab;?>"]').tab('show');
})
</script>