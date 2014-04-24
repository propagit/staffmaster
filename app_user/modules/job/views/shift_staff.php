<form role="form" id="form_update_shift_staff">
<div class="row">
	<div class="col-md-6 remove-left-padding remove-gutters ">
		<div class="form-group pull-left" id="f_shift_staff">
			<input type="hidden" name="shift_staff_id" value="<?=$shift['staff_id'];?>" />
			<input type="hidden" name="shift_id" value="<?=$shift['shift_id'];?>" />
			<input type="text" class="shift_staff form-control" name="shift_staff" placeholder="Type staff name..." value="<?=($staff) ? $staff['first_name'] . ' ' . $staff['last_name'] : '';?>" />
		</div>
	</div>
	<div class="col-md-6">
		<div class="form-group col-md-12 remove-gutters pull-right">
			<?=modules::run('job/dropdown_status','status', $shift['status']);?>
		</div>
	</div>
</div>
</form>
<div class="text-danger" id="error-msg"></div>
<div id="staff_quick_search_result">
	
</div>

<button type="button" class="btn btn-primary btn-sm staff-submit">
	<i class="glyphicon glyphicon-ok"></i>
	</button>
<button type="button" class="btn btn-default btn-sm staff-cancel">
	<i class="glyphicon glyphicon-remove"></i>
</button>

<script>
$(function(){
	$('.shift_staff').on('input', function(){
		$('#error-msg').html('');
		$('#f_shift_staff').removeClass('has-error');
		var query = $(this).val();
		$.ajax({
			type: "POST",
			url: "<?=base_url();?>job/ajax/search_staff_for_shift",
			data: {query: query},
			success: function(html)
			{
				$('#staff_quick_search_result').html(html);
			}
		})
	});
    	
	$('.staff-cancel').click(function(){
		$('.shift_staff').popover('hide');
	});
	$('.staff-submit').click(function(){
		$.ajax({
			type: "POST",
			url: "<?=base_url();?>job/ajax_shift/update_shift_staff",
			data: $('#form_update_shift_staff').serialize(),
			success: function(data) {
				data = $.parseJSON(data);
				if (!data.ok)
				{	
					$('#f_shift_staff').addClass('has-error');
					$('#error-msg').html(data.msg);
				}
				else
				{
					$('#shift_<?=$shift['shift_id'];?>').replaceWith(data.html);
					init_inline_edit();
				}
			}
		})
	})
})
</script>