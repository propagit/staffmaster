<div class="modal-dialog">
	<div class="modal-content">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			<h4 class="modal-title" id="myModalLabel">Payment Status</h4>
		</div>
		<div class="col-md-12">
			<div class="modal-body">
				Staff Payment: <b>$<?=money_format('%i', $staff_paid);?></b>
				-
				Client Billed: <b>$<?=money_format('%i', $client_billed);?></b>
			</div>		
		</div>
	</div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->