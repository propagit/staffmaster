<div class="modal-dialog">
	<div class="modal-content">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			
			<h4 class="modal-title">
				<? if($mode != '') { ?>
					Push to <?=ucwords($mode);?>
				<? } else { ?>
					Generate Pay Run
				<? } ?>
			</h4>
		</div>
		<div class="col-md-12">
			<form id="create-payrun-form">
			<input type="hidden" name="type" value="<?=$type;?>" />
			<div class="modal-body">
				<? if($mode != '') { ?>
				<input type="hidden" name="platform" value="<?=strtolower($mode);?>" />		

				<? } else { ?>
				<div class="form-group alert alert-info clearfix">
					<div class="checkbox no-margin">
						<label><input type="checkbox" id="check_to_export" name="export_csv" checked /> &nbsp; Export to CSV</label>
					</div>
					
					<div id="f_export_id" class="hide"><br />
						<?=modules::run('payrun/field_select_export_templates', $type, 'export_id');?>
					</div>
				</div>
				<? } ?>
				
				<div class="panel panel-default">
					<!-- Default panel contents -->
					<div class="panel-heading">Pay Run Period</div>
					<div class="panel-body">
						<div class="form-group" id="f_date_from">
							<label class="label-control col-md-3 remove-left-gutter">From Date</label>
							<div class="input-group date col-md-9" id="start_date">
								<input type="text" class="form-control" name="date_from" readonly />
								<span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
								<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
							</div>
						</div>
						<div class="form-group" id="f_date_to">
							<label class="label-control col-md-3 remove-left-gutter">To Date</label>
							<div class="input-group date col-md-9" id="finish_time">
								<input type="text" class="form-control" name="date_to" readonly />
								<span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
								<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
							</div>
						</div>
						<div class="form-group" id="f_payable_date">
							<label class="label-control col-md-3 remove-left-gutter">Payable Date</label>
							<div class="input-group date col-md-9" id="payable_date">
								<input type="text" class="form-control" name="payable_date" readonly />
								<span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
								<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
							</div>
						</div>
					</div>
				</div>

				<div class="form-group">
					<button id="add-save-payrun" type="button" class="btn btn-core">Generate Pay Run</button>
				</div>
			</div>
			</form>
		</div>
	</div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
<script>
$(function(){
	$('#waitingModal').modal({
		backdrop: 'static',
		keyboard: true,
		show: false
	})

	$('#add-save-payrun').click(function(){
		save_payrun();
	});
	$('#check_to_export').click(function(){
		include_export();
	});
	include_export();
	$('#start_date').datetimepicker({
        weekStart: 1,
        todayBtn:  1,
		autoclose: 1,
		todayHighlight: 1,
		startView: 2,
		minView: 2,
		forceParse: 1,
        minuteStep: 15,
        pickerPosition: 'bottom-left',
        format: 'dd-mm-yyyy'
    }).on('changeDate', function(e) {
    	var start_date = moment(e.date.valueOf() - 10*60*60*1000);
    	//var finish_date = $('input[name="date_to"]').val();
    	//if (start_date > moment(finish_date, "DD-MM-YYYY"))
    	//{
	    	//alert(moment(start_date).add('d', 7));
	    	$('input[name="date_to"]').val(moment(start_date).add('d', 7).format("DD-MM-YYYY"));
    	//}
    	$('#finish_time').datetimepicker('setStartDate', start_date.format("DD-MM-YYYY"));
    });
    $('#finish_time').datetimepicker({
        weekStart: 1,
        todayBtn:  1,
		autoclose: 1,
		todayHighlight: 1,
		startView: 2,
		minView: 2,
		forceParse: 1,
        minuteStep: 15,
        pickerPosition: 'bottom-left',
        format: 'dd-mm-yyyy'
    });
    $('#payable_date').datetimepicker({
        weekStart: 1,
        todayBtn:  1,
		autoclose: 1,
		todayHighlight: 1,
		startView: 2,
		minView: 2,
		forceParse: 1,
        minuteStep: 15,
        pickerPosition: 'bottom-left',
        format: 'dd-mm-yyyy'
    });
})

function include_export() {
	if ($('#check_to_export').is(':checked')) {
		$('#add-save-payrun').html('Generate and Export Pay Run');
		$('#f_export_id').removeClass('hide');
	} else {
		<? if($mode != '') { ?>
			$('#add-save-payrun').html('Push to <?=ucwords($mode);?>');
		<? } else { ?>
			$('#add-save-payrun').html('Generate Pay Run');
		<? } ?>
		
		$('#f_export_id').addClass('hide');
	}
}
function save_payrun() {
	$('.bs-modal-lg').modal('hide');
	$('#waitingModal').modal('show');
	$('#create-payrun-form').find('.has-error').removeClass('has-error');
	$.ajax({
		type: "POST",
		url: "<?=base_url();?>payrun/ajax/create_payrun",
		data: $('#create-payrun-form').serialize(),
		success: function(data) {			
			data = $.parseJSON(data);
			if (!data.ok) {
				//$('.bs-modal-lg').modal('show');
				$('#f_' + data.error_id).addClass('has-error');
				$('input[name="' + data.error_id + '"]').focus();
			}
			else {
				if (data.export) {
					window.location = '<?=base_url().EXPORTS_URL;?>/payrun/' + data.file_name;
					$('.bs-modal-lg').modal('hide');
					$('#waitingModal').modal('hide');
					list_staffs();
					get_payrun_stats();
				}
				else
				{
					if (data.pushed_msg) 
					{
						$('#order-message').html('<h2>Push Results</h2>' + data.pushed_msg + '<br /><p><a href="<?=base_url();?>payrun/search-payslip/' + data.payrun_id + '" class="btn btn-core">View Pay Run</a> &nbsp; <a class="btn btn-default" onclick="close_modal()">Run Another Pay Run</a></p>');
						$('#waitingModal').modal('show');
					}
					else
					{
						close_modal();
					}
					//$('.bs-modal-lg').modal('hide');
					//list_staffs();
					//get_payrun_stats();
				}
				
			}
		}
	})
}
function close_modal()
{
	$('#waitingModal').modal('hide');
	list_staffs();
	get_payrun_stats();
}
</script>