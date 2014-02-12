<?
	$days = array(
		'1' => 'Monday',
		'2' => 'Tuesday',
		'3' => 'Wednesday',
		'4' => 'Thursday',
		'5' => 'Friday',
		'6' => 'Saturday',
		'7' => 'Sunday'
	);
	$hours = array(
		'0' => 'Midnight',
		'1' => '1:00 AM',
		'2' => '2:00 AM',
		'3' => '3:00 AM',
		'4' => '4:00 AM',
		'5' => '5:00 AM',
		'6' => '6:00 AM',
		'7' => '7:00 AM',
		'8' => '8:00 AM',
		'9' => '9:00 AM',
		'10' => '10:00 AM',
		'11' => '11:00 AM',
		'12' => '12:00 PM',
		'13' => '1:00 PM',
		'14' => '2:00 PM',
		'15' => '3:00 PM',
		'16' => '4:00 PM',
		'17' => '5:00 PM',
		'18' => '6:00 PM',
		'19' => '7:00 PM',
		'20' => '8:00 PM',
		'21' => '9:00 PM',
		'22' => '10:00 PM',
		'23' => '11:00 PM',
	);
?>
<form id="form_update_payrates">
<input type="hidden" name="payrate_id" value="<?=$payrate_id;?>" />
<div class="table-responsive">
<table class="table table-bordered table-middle table-condensed table-striped selectable" width="100%" id="payrate_data">
<thead>
	<tr>
		<th class="center" width="100">Time</th>
		<? foreach($days as $key => $label) { ?>
		<th class="center<?=($key%2==1) ? ' odd' : '';?>" colspan="2"><?=$label;?></th>
		<? } ?>
	</tr>
</thead>
<tbody>
	<? foreach($hours as $key_hour => $label_hour) { ?>
	<tr>
		<td class="center"><?=$label_hour;?></td>
		<? foreach($days as $key_day => $label_day) { ?>
		<td>
			<input type="text" class="form-control input-sm input-staff" name="pr-0-<?=$key_day;?>-<?=$key_hour;?>" value="<?=modules::run('attribute/payrate/get_payrate_data', $payrate_id, 0, $key_day, $key_hour);?>" />
		</td>
		<td>	
			<input type="text" class="form-control input-sm input-client" name="pr-1-<?=$key_day;?>-<?=$key_hour;?>" value="<?=modules::run('attribute/payrate/get_payrate_data', $payrate_id, 1, $key_day, $key_hour);?>" />
		</td>
		<? } ?>
	</tr>
	<? } ?>
</tbody>
</table>
</div>

<!-- update payrate modal -->
<div class="modal fade" id="update-payrate-modal" tabindex="-1" role="dialog" aria-labelledby="addPayrateLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>
				<h4 class="modal-title">Update Pay Rate</h4>
			</div>
	        <div class="col-md-12">
				<div class="modal-body">          
		            <form class="form-horizontal" role="form" id="form_update_payrate">
					<div class="form-group">
						<label for="inputPassword3" class="col-sm-3 control-label">Staff Rate</label>
						<div class="col-sm-4">
							<div class="input-group">
								<span class="input-group-addon">$</span>
								<input type="text" class="form-control input_number_only" id="staff_rate">
							</div>
						</div>
					</div>
					<div class="form-group">
						<label for="inputPassword3" class="col-sm-3 control-label">Client Rate</label>
						<div class="col-sm-4">
							<div class="input-group">
								<span class="input-group-addon">$</span>
								<input type="text" class="form-control input_number_only" id="client_rate">
							</div>
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-offset-3 col-sm-3">
							<button type="button" class="btn btn-core" id="btn_update_payrate"><i class="fa fa-save"></i> Update Pay Rate</button>
						</div>
					</div>
					</form>
				</div>
	        </div>
			<div class="modal-footer">
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<script>
$(function(){
	$('.selectable').selectable();
	$('.selectable').mouseup(function(){
		var count = $('.ui-selecting.input-sm').size();
		if(count > 0) {
			$('#update-payrate-modal').modal('show');
		}
	});
	$('#btn_update_payrate').click(function(){
		var staff_rate = $('#staff_rate').val();
		var client_rate = $('#client_rate').val();
		if (staff_rate)
		{
			$('.ui-selected.input-staff').val(staff_rate);
		}
		if (client_rate)
		{
			$('.ui-selected.input-client').val(client_rate);
		}
		$('#update-payrate-modal').modal('hide');
		$.ajax({
			type: "POST",
			url: "<?=base_url();?>attribute/ajax/update_payrates",
			data: $('#form_update_payrates').serialize(),
			success: function(html) {
				load_pay_rates(<?=$payrate_id;?>);
			}
		})
	});
	$('#form_update_payrates .input-sm').change(function(){
		var $this = $(this);
		var value = $(this).val();
		var name = $(this).attr('name');
		$.ajax({
			type: "POST",
			url: "<?=base_url();?>attribute/ajax/update_payrate",
			data: {value: value, name: name, payrate_id: <?=$payrate_id;?>},
			success: function(html) {
				$this.val(html);
			}
		})
	})
})
</script>