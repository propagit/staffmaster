<div id="update-shift-payrate" style="width: 240px;">
	<span id="staff_payrates"><?=modules::run('attribute/payrate/field_select', 'payrate_id', $timesheet['payrate_id']);?></span>
	
	
	<? if($this->config_model->get('separate_client_payrate')) {
		$client_payrate_id = ($timesheet['client_payrate_id']) ? $timesheet['client_payrate_id'] : $timesheet['payrate_id'];
		echo '<br /><br />' . modules::run('attribute/payrate/field_select', 'client_payrate_id', $client_payrate_id);
		
	} ?>
	
	<div class="clearfix" style="margin-bottom:5px;"></div>
	<button id="btn-update-payrate" class="btn btn-sm btn-core"><i class="fa fa-check"></i></button>
	<? if ($timesheet['staff_id']) { ?>
	<button id="btn-filter-staff" class="btn btn-sm btn-success"><i class="fa fa-user"></i> Filter By Staff</button>
	
	<script>
	$(function(){
		$('#btn-filter-staff').click(function(){
			$.ajax({
				type: "POST",
				url: "<?=base_url();?>job/ajax_shift/filter_payrate",
				data: {user_id: <?=$timesheet['staff_id'];?>, payrate_id: <?=$timesheet['payrate_id'];?>},
				success: function(html) {
					$('#staff_payrates').html(html);
				}
			})
		})
	})
	</script>
	<? } ?>
</div>
<script>
$(function(){
	$('#btn-update-payrate').click(function(){
		var payrate_id = $(this).parent().find('#payrate_id').val();
		var client_payrate_id = $(this).parent().find('#client_payrate_id').val();
		$.ajax({
			type: "POST",
			url: "<?=base_url();?>timesheet/ajax/update_timesheet_payrate",
			data: {pk: <?=$timesheet['timesheet_id'];?>, value: payrate_id, client_payrate_id: client_payrate_id},
			success: function(html) {
				$('#timesheet_<?=$timesheet['timesheet_id'];?>').replaceWith(html);
				init_edit();
				$('#wrapper_js').find('.popover-break').hide();
			}
		})
	})
	$('#separate_client_payrate').click(function(){
		var on = '';
		if ($(this).is(':checked')) {
			on = 1;
		}
		$.ajax({
			type: "POST",
			url: "<?=base_url();?>config/ajax/add",
			data: {separate_client_payrate: on},
			success: function(html) {
				load_client_payrates();
			}
		})
	})
	load_client_payrates();
})
function load_client_payrates()
{
	var on = $('#separate_client_payrate').is(':checked');
	if (on) {
		$.ajax({
			type: "POST",
			url: "<?=base_url();?>job/ajax_shift/load_client_payrates",
			data: {payrate_id: <?=($timesheet['client_payrate_id']) ? $timesheet['client_payrate_id'] : $timesheet['payrate_id'];?>},
			success: function(html) {
				$('#client_payrates').html(html);
			}
		})
	} else {
		$('#client_payrates').html('');
	}
}
</script>