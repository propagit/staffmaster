<h2>Search Invoices</h2>
<br />
<form class="form-horizontal" role="form" id="form_search_invoices">
<? if (!$is_client) { ?>
<div class="row">
	<div class="form-group">
		<label for="client_id" class="col-md-2 control-label">Client</label>
		<div class="col-md-4">
			<?=modules::run('client/field_select', 'client_id');?>
		</div>
		<label for="invoice_id" class="col-md-2 control-label">Invoice ID</label>
		<div class="col-md-4">
			<input type="text" class="form-control" name="invoice_id" />
		</div>
	</div>
</div>
<? } ?>
<div class="row">
	<div class="form-group">
		<label for="keyword" class="col-md-2 control-label">Campaign Name</label>
		<div class="col-md-10">
			<input type="text" class="form-control" id="keyword" name="keywords" placeholder="keywords..." />
		</div>
	</div>
</div>
<div class="row">
	<div class="form-group">
		<label class="col-md-2 control-label">Invoice Number</label>
		<div class="col-md-4">
			<input type="text" class="form-control" name="invoice_number" />
		</div>
		<label class="col-md-2 control-label">PO Number</label>
		<div class="col-md-4">
			<input type="text" class="form-control" name="po_number" />
		</div>
	</div>
</div>
<div class="row">
	<div class="form-group">
		<label for="date_from" class="col-md-2 control-label">Issue Date From</label>
		<div class="col-md-4">
			<div class="input-group date" id="date_from">
				<input type="text" class="form-control" name="date_from" readonly />
				<span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
				<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
			</div>
		</div>
		<label for="date_to" class="col-md-2 control-label">Issue Date To</label>
		<div class="col-md-4">
			<div class="input-group date" id="date_to">
				<input type="text" class="form-control" name="date_to" readonly />
				<span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
				<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
			</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="form-group">
		<label class="col-md-2 control-label">Issued By</label>
		<div class="col-md-4">
			<?=modules::run('user/field_select_admin', 'issued_by');?>
		</div>
		<label class="col-md-2 control-label">Invoice Status</label>
		<div class="col-md-4">
			<?=modules::run('invoice/field_select_status', 'status');?>
		</div>
	</div>
</div>
<div class="row">
	<div class="form-group">
		<div class="col-md-offset-2 col-md-8">
			<button type="button" class="btn btn-core" id="btn-search-invoices"><i class="fa fa-search"></i> Search</button> &nbsp; 
			<button type="reset" class="btn btn-default"><i class="fa fa-refresh"></i> Reset</button>
		</div>
	</div>
</div>
<input type="hidden" name="sort_by" id="sort-by" value="issued_date" />
<input type="hidden" name="sort_order" id="sort-order" value="asc" />
<input type="hidden" name="current_page"  id="current_page" value="1"  />
</form>

<div id="invoice-search-results">
</div>

<!-- Modal -->
<div class="modal fade" id="waitingModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content" id="order-message">
			<img src="<?=base_url();?>assets/img/loading3.gif" />
			<h2>Please wait!</h2>
			<p>Please wait a moment while we are processing your request ...</p>
		</div>
	</div>
</div>

<script>
$(function(){
    $('#btn-search-invoices').click(function() {
	    search_invoices();
    });
	$('#date_from').datetimepicker({
        weekStart: 1,
        todayBtn:  1,
		autoclose: 1,
		todayHighlight: 1,
		startView: 2,
        minView: 2,
		forceParse: 1,
        format: 'dd-mm-yyyy',
    }).on('changeDate', function(e) {
    	var date_from = moment(e.date.valueOf() - 11*60*60*1000);
    	$('#date_to').datetimepicker('setStartDate', date_from.format("DD-MM-YYYY"));
    });
    $('#date_to').datetimepicker({
        weekStart: 1,
        todayBtn:  1,
		autoclose: 1,
		todayHighlight: 1,
		startView: 2,
        minView: 2,
		forceParse: 1,
        format: 'dd-mm-yyyy',
        pickerPosition: 'bottom-left'
    }).on('changeDate', function(e) {
    	var date_to = moment(e.date.valueOf() - 11*60*60*1000);
    	$('#date_from').datetimepicker('setEndDate', date_to.format("DD-MM-YYYY"));
    });
	
		
	//email invoice
	$(document).on('click','.send-email-from-modal',function(){
		email_invoice();
	});
	
	//sample email
	$(document).on('click','#send-sample-email',function(){
		email_sample_invoice();
	});
})
function search_invoices() {
	preloading($('#invoice-search-results'));
	$.ajax({
		type: "POST",
		url: "<?=base_url();?>invoice/ajax/search_invoices",
		data: $('#form_search_invoices').serialize(),
		success: function(html) {
			loaded($('#invoice-search-results'), html);
		}
	})
}
<? if($this->uri->segment(3)) { ?>
	$('input[name="invoice_id"]').val(<?=$this->uri->segment(3);?>);
	search_invoices();
<? } ?>
</script>