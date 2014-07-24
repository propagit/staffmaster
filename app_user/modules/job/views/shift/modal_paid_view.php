<div class="modal-dialog">
	<div class="modal-content">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			<h4 class="modal-title" id="myModalLabel">Payment Status</h4>
		</div>
		<div class="col-md-12">
			<div class="modal-body">
				<? if ($timesheet['status_payrun_staff'] == PAYRUN_PAID) { ?>
					<div class="alert alert-success">
						Staff Payment 
						$<?=money_format('%i', $timesheet['total_amount_staff']);?> <b><i class="fa fa-check"></i> Paid</b> - 
						<a href="<?=base_url();?>payrun/search-payrun/<?=$timesheet['payrun_id'];?>" target="_blank">Pay run #<?=$timesheet['payrun_id'];?></a>
					</div>
				<? } else { ?>
					<div class="alert alert-warning">
						Staff Payment 
						$<?=money_format('%i', $timesheet['total_amount_staff']);?> <b>Unpaid</b> - 
						<a href="<?=base_url();?>payrun/search-payrun/<?=$timesheet['payrun_id'];?>" target="_blank">Pay run #<?=$timesheet['payrun_id'];?></a>
					</div>
				<? } ?>
				
				<? if ($timesheet['status_invoice_client'] == INVOICE_PAID) { ?>
					<div class="alert alert-success">
						Client Billed 
						$<?=money_format('%i', $timesheet['total_amount_client']);?> <b><i class="fa fa-check"></i> Paid</b> - 
						<a href="<?=base_url();?>invoice/search-invoices/<?=$timesheet['invoice_id'];?>" target="_blank">Invoice #<?=$timesheet['invoice_id'];?></a>
					</div>
				<? } else { ?>
					<div class="alert alert-warning">
						Client Billed 
						$<?=money_format('%i', $timesheet['total_amount_client']);?> <b>Unpaid</b> - 
						<a href="<?=base_url();?>invoice/search-invoices/<?=$timesheet['invoice_id'];?>" target="_blank">Invoice #<?=$timesheet['invoice_id'];?></a>
					</div>
				<? } ?>
			</div>		
		</div>
	</div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->