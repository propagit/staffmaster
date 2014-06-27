<div class="modal-dialog">
	<div class="modal-content">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			<h4 class="modal-title">Generate Pay Run</h4>
		</div>
		<div class="col-md-12">
			<form id="create-payrun-form">
			<input type="hidden" name="type" value="<?=$type;?>" />
			<div class="modal-body">
				<div class="form-group alert alert-info clearfix">
					<input type="checkbox" id="check_to_export" name="export_csv" checked /> &nbsp; Export to CSV
					<h2 id="f_export_id" class="hide">
						<?=modules::run('payrun/field_select_export_templates', $type, 'export_id');?>
					</h2>
				</div>
				<? if ($type == STAFF_TFN) { ?>
				<div class="panel panel-default">
					<!-- Default panel contents -->
					<div class="panel-heading">Pay Run Period</div>
					<div class="panel-body">
						<div class="form-group" id="f_date_from">
							<div class="input-group date" id="start_date">
								<span class="input-group-addon">From Date</span>
								<input type="text" class="form-control" name="date_from" readonly />
								<span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
								<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
							</div>
						</div>
						<div class="form-group" id="f_date_to">
							<div class="input-group date" id="finish_time">
								<span class="input-group-addon">To Date</span>
								<input type="text" class="form-control" name="date_to" readonly />
								<span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
								<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
							</div>
						</div>		
					</div>
				</div>
				<? } ?>

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
        format: 'dd-mm-yyyy',
        //startDate: "<?=date('Y-m-d');?>"
    }).on('changeDate', function(e) {
    	var start_date = moment(e.date.valueOf() - 11*60*60*1000);
    	var finish_date = $('input[name="date_to"]').val();
    	if (start_date > moment(finish_date, "DD-MM-YYYY"))
    	{
	    	$('input[name="date_to"]').val(start_date.format("DD-MM-YYYY"));
    	}
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
        format: 'dd-mm-yyyy',
        //startDate: "<?=date('Y-m-d');?>"
    });
})

function include_export() {
	if ($('#check_to_export').is(':checked')) {
		$('#add-save-payrun').html('Generate and Export Pay Run');
		$('#f_export_id').removeClass('hide');
	} else {
		$('#add-save-payrun').html('Generate Pay Run');
		$('#f_export_id').addClass('hide');
	}
}
function save_payrun() {
	$('#create-payrun-form').find('.has-error').removeClass('has-error');
	$.ajax({
		type: "POST",
		url: "<?=base_url();?>payrun/ajax/create_payrun",
		data: $('#create-payrun-form').serialize(),
		success: function(data) {
			data = $.parseJSON(data);
			if (!data.ok) {
				$('#f_' + data.error_id).addClass('has-error');
				$('input[name="' + data.error_id + '"]').focus();
			}
			else {
				if (data.export) {
					window.location = '<?=base_url().EXPORTS_URL;?>/payrun/' + data.file_name;
				}
				$('.bs-modal-lg').modal('hide');
				list_staffs();
				get_payrun_stats();
			}
		}
	})
}
</script>