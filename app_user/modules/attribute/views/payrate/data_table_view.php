<link rel="stylesheet" media="screen" type="text/css" href="<?=base_url();?>assets/colorpicker/css/colorpicker.css" />
<link rel="stylesheet" media="screen" type="text/css" href="<?=base_url();?>assets/colorpicker/css/layout.css" />
<script type="text/javascript" src="<?=base_url();?>assets/colorpicker/js/colorpicker.js"></script>
<br />
<h2><?=$payrate['name'];?></h2>
<p>Drag and select to change charge out rates for this pay rate based on the time of the day.<br />
Set pay rate groups or client charge out groups to control how data for this pay rate should be exported the other systems</p>
<br />

<? if(count($groups) > 0) { ?>
<h4>Pay Rate Groups</h4>
<div class="table-responsive">
<table class="table table-condensed table-no-margin">

	<tr>
		<td><b>Colour</b></td>
		<td><b>Name<b></td>
		<td><b>Type<b></td>
	</tr>
	<? $i=0; foreach($groups as $group) { ?>
	<tr>
		<td>
			<div style="background-color:<?=$group['color'];?>; width:15px; height:15px;"></div>
		</td>
		<td><?=$group['group'];?></td>
		<td><?=($group['type']) ? 'Client' : 'Staff';?></td>
	</tr>
	<? $i++; } ?>
</table>
</div>
<? } ?>

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
		<? foreach($days as $key_day => $label_day) { 
			$staff_data = modules::run('attribute/payrate/get_payrate_full_data', $payrate_id, 0, $key_day, $key_hour);
			$client_data = modules::run('attribute/payrate/get_payrate_full_data', $payrate_id, 1, $key_day, $key_hour);
		?>
		<td<?=($staff_data['color']) ? ' style="background:' . $staff_data['color'] . '"' : '';?>>
			<input type="text" class="form-control input-sm input-staff" name="pr-0-<?=$key_day;?>-<?=$key_hour;?>" value="<?=$staff_data['value'];?>" />
			<input type="hidden" class="input-staff-group" name="group-0-<?=$key_day;?>-<?=$key_hour;?>" value="<?=$staff_data['group'];?>" />
			<input type="hidden" class="input-staff-color" name="color-0-<?=$key_day;?>-<?=$key_hour;?>" value="<?=$staff_data['color'];?>" />
		</td>
		<td<?=($client_data['color']) ? ' style="background:' . $client_data['color'] . '"' : '';?>>	
			<input type="text" class="form-control input-sm input-client" name="pr-1-<?=$key_day;?>-<?=$key_hour;?>" value="<?=$client_data['value'];?>" />
			<input type="hidden" class="input-client-group" name="group-1-<?=$key_day;?>-<?=$key_hour;?>" value="<?=$client_data['group'];?>" />
			<input type="hidden" class="input-client-color" name="color-1-<?=$key_day;?>-<?=$key_hour;?>" value="<?=$client_data['color'];?>" />
		</td>
		<? } ?>
	</tr>
	<? } ?>
</tbody>
</table>
</div>
</form>

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
					<div class="form-group">
						<label class="col-sm-4 control-label">Staff Rate</label>
						<div class="col-sm-6">
							<div class="input-group">
								<span class="input-group-addon">$</span>
								<input type="text" class="form-control input_number_only" id="staff_rate">
							</div>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-4 control-label">Staff Rate Group</label>
						<div class="col-sm-5">
							<input type="text" class="form-control" id="staff_group" />
						</div>
						<div class="colorSelector col-md-6" id="staff_color">
					      <div style="background-color:#00b1eb"></div>
					      <input type="hidden" id="staff_color_input" /> 
					   </div>
					</div>
					<div class="form-group">
						<label class="col-sm-4 control-label">Client Rate</label>
						<div class="col-sm-6">
							<div class="input-group">
								<span class="input-group-addon">$</span>
								<input type="text" class="form-control input_number_only" id="client_rate">
							</div>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-4 control-label">Client Rate Group</label>
						<div class="col-sm-5">
							<input type="text" class="form-control" id="client_group" />
						</div>
						<div class="colorSelector col-md-6" id="client_color">
					      <div style="background-color:#00b1eb"></div>
					      <input type="hidden" id="client_color_input" /> 
					   </div>
					</div>
					<div class="form-group">
						<div class="col-sm-offset-4 col-sm-6">
							<button type="button" class="btn btn-core" id="btn_update_payrate"><i class="fa fa-save"></i> Update Pay Rate</button>
						</div>
					</div>
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
		var staff_group = $('#staff_group').val();
		var staff_color = $('#staff_color_input').val();
		var client_group = $('#client_group').val();
		var client_color = $('#client_color_input').val();
		if (staff_rate)
		{
			$('.ui-selected.input-staff').val(staff_rate);
		}
		if (staff_group)
		{
			$('.ui-selected.input-staff').each(function(){
				$(this).parent().find('.input-staff-group').val(staff_group);
			})
		}
		if (staff_color)
		{
			$('.ui-selected.input-staff').each(function(){
				$(this).parent().find('.input-staff-color').val(staff_color);
			})
		}
		if (client_rate)
		{
			$('.ui-selected.input-client').val(client_rate);
		}
		if (client_group)
		{
			$('.ui-selected.input-client').each(function(){
				$(this).parent().find('.input-client-group').val(client_group);
			})
		}
		if (client_color)
		{
			$('.ui-selected.input-client').each(function(){
				$(this).parent().find('.input-client-color').val(client_color);
			})
		}
		$('#update-payrate-modal').modal('hide');
		$.ajax({
			type: "POST",
			url: "<?=base_url();?>attribute/ajax/update_payrates",
			data: $('#form_update_payrates').serialize(),
			success: function(html) {
				load_pay_rates();
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
	init_colour_picker('#staff_color','#00b1eb');
	init_colour_picker('#client_color','#00b1eb');
})
function init_colour_picker(colour_id,current_colour)
{
  $(colour_id).ColorPicker({
      color: current_colour,
      onShow: function (colpkr) {
          $(colpkr).fadeIn(500);
          return false;
      },
      onHide: function (colpkr) {
          $(colpkr).fadeOut(500);
          return false;
      },
      onChange: function (hsb, hex, rgb) {
          $(colour_id+' div').css('backgroundColor', '#' + hex);
          $(colour_id+'_input').val('#' + hex);
      }
  });	
}
</script>