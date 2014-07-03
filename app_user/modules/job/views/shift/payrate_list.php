<div id="update-shift-payrate" style="min-width: 240px;">
	<span id="staff_payrates"><?=modules::run('attribute/payrate/field_select', 'payrate_id', $shift['payrate_id']);?></span>
	
	<div class="clearfix" style="margin-bottom:10px;"></div>
	<button id="btn-update-payrate" class="btn btn-sm btn-success"><i class="fa fa-check"></i> Update</button>
	<? if ($shift['staff_id']) { ?>
	<button id="btn-filter-staff" class="btn btn-sm btn-core"><i class="fa fa-user"></i> Filter By Staff</button>
	
	<script>
	$(function(){
		$('#btn-filter-staff').click(function(){
			$.ajax({
				type: "POST",
				url: "<?=base_url();?>job/ajax_shift/filter_payrate",
				data: {user_id: <?=$shift['staff_id'];?>, payrate_id: <?=$shift['payrate_id'];?>},
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
		$.ajax({
			type: "POST",
			url: "<?=base_url();?>job/ajax/update_shift_payrate",
			data: {pk: <?=$shift['shift_id'];?>, value: payrate_id},
			success: function(html) {
				$('#shift_<?=$shift['shift_id'];?>').replaceWith(html);
				init_inline_edit();
				$('#wrapper_js').find('.popover-break').hide();
			}
		})
	})
})
</script>