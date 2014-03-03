<h2>Search Pay Runs</h2>

<form class="form-horizontal" role="form" id="form_search_payruns">
<div class="row">
	<div class="form-group">
		<label for="client_id" class="col-md-2 control-label">Type: </label>
		<div class="col-md-4">
			<?=modules::run('payrun/field_select_type', 'type');?>
		</div>
	</div>
</div>

<div class="row">
	<div class="form-group">
		<label for="date_from" class="col-md-2 control-label">Date From</label>
		<div class="col-md-4">
			<div class="input-group date" id="date_from">
				<input type="text" class="form-control" name="date_from" readonly />
				<span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
				<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
			</div>
		</div>
		<label for="date_to" class="col-md-2 control-label">Date To</label>
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
		<div class="col-md-offset-2 col-md-8">
			<button type="button" class="btn btn-core" id="btn-search-payruns"><i class="fa fa-search"></i> Search</button> &nbsp; 
			<button type="reset" class="btn btn-default"><i class="fa fa-refresh"></i> Reset</button>
		</div>
	</div>
</div>	
</form>

<div id="payrun-search-results">
</div>

<script>
$(function(){
    $('#btn-search-payruns').click(function() {
	    search_payruns();
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
})
function search_payruns() {
	preloading($('#payrun-search-results'));
	$.ajax({
		type: "POST",
		url: "<?=base_url();?>payrun/ajax/search_payruns",
		data: $('#form_search_payruns').serialize(),
		success: function(html) {
			loaded($('#payrun-search-results'), html);
		}
	})
}
</script>