<h2>Find Processed Pay Slips</h2>

<form class="form-horizontal" role="form" id="form_search_payslips">
<div class="row">
	<div class="form-group">
		<label for="type" class="col-md-2 control-label">Type: </label>
		<div class="col-md-4">
			<?=modules::run('payrun/field_select_type', 'type');?>
		</div>
	</div>
</div>
<div class="row">
	<div class="form-group">
		<label for="staff_name" class="col-md-2 control-label">Staff Name</label>
		<div class="col-md-4">
			<input type="text" class="form-control" name="staff_name" />
		</div>
		<label for="venue" class="col-md-2 control-label">Venue</label>
		<div class="col-md-4">
			<?=modules::run('attribute/venue/field_input', 'venue');?>
		</div>
	</div>
</div>
<div class="row">
	<div class="form-group">
		<label for="date_from" class="col-md-2 control-label">Job Date From</label>
		<div class="col-md-4">
			<div class="input-group date" id="date_from2">
				<input type="text" class="form-control" name="date_from" readonly />
				<span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
				<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
			</div>
		</div>
		<label for="date_to" class="col-md-2 control-label">Job Date To</label>
		<div class="col-md-4">
			<div class="input-group date" id="date_to2">
				<input type="text" class="form-control" name="date_to" readonly />
				<span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
				<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
			</div>
		</div>
	</div>
</div>

<div class="row">
	<div class="form-group">
		<div class="col-md-offset-2 col-md-8">
			<button type="button" class="btn btn-core" id="btn-search-payslips"><i class="fa fa-search"></i> Search</button> &nbsp; 
			<button type="reset" class="btn btn-default"><i class="fa fa-refresh"></i> Reset</button>
		</div>
	</div>
</div>	
</form>

<div id="payslip-search-results">
</div>


<script>
$(function(){
    $('#btn-search-payslips').click(function() {
	    search_payslips();
    });
	$('#date_from2').datetimepicker({
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
    	$('#date_to2').datetimepicker('setStartDate', date_from.format("DD-MM-YYYY"));
    });
    $('#date_to2').datetimepicker({
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
    	$('#date_from2').datetimepicker('setEndDate', date_to.format("DD-MM-YYYY"));
    });
})
function search_payslips() {
	preloading($('#payslip-search-results'));
	$.ajax({
		type: "POST",
		url: "<?=base_url();?>payrun/ajax/search_payslips",
		data: $('#form_search_payslips').serialize(),
		success: function(html) {
			loaded($('#payslip-search-results'), html);
		}
	})
}
</script>