<form role="form" id="form_update_shift_supervisor">
	<div class="form-group pull-left" id="f_shift_supervisor">
		<input type="hidden" name="shift_staff_id" value="<?=$shift['supervisor_id'];?>" />
		<input type="hidden" name="shift_id" value="<?=$shift['shift_id'];?>" />
		<input type="text" class="shift_supervisor form-control" name="shift_staff" placeholder="Type staff name..." value="<?=($supervisor) ? $supervisor['first_name'] . ' ' . $supervisor['last_name'] : '';?>" />
	</div>
</form>

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
	$('.shift_supervisor').on('input', function(){
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
		$('.shift_supervisor').popover('hide');
	});
	$('.staff-submit').click(function(){
		$.ajax({
			type: "POST",
			url: "<?=base_url();?>job/ajax/update_shift_supervisor",
			data: $('#form_update_shift_supervisor').serialize(),
			success: function(data) {
				data = $.parseJSON(data);
				if (!data.ok)
				{	
					$('#f_shift_supervisor').addClass('has-error');
				}
				else
				{
					
					load_job_shifts(<?=$shift['job_id'];?>);
					/* $('.shift_staff').popover('hide');
					$('#shift_staff_' + data.shift_id).html(data.value);
					$('#shift_staff_' + data.shift_id).removeClass(function (index, css) {
					    return (css.match (/\bbtn-\S+/g) || []).join(' ');
					});
					$('#shift_staff_' + data.shift_id).parent().parent().removeClass();
					$('#shift_staff_' + data.shift_id).parent().parent().addClass(data.class_name); */
				}
			}
		})
	})
})
</script>