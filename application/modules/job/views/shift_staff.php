<form role="form" id="form_update_shift_staff">
	<div class="pull-left">
		<input type="hidden" name="shift_id" value="<?=$shift_id;?>" />
		<input type="text" class="shift_staff form-control" name="shift_staff" placeholder="Type staff name..." />	
	</div>
	<label class="control-label pull-left">Status</label>
	<div class="pull-left">
		<?=modules::run('job/dropdown_status','');?>
	</div>
	<div class="pull-left">
	<button type="button" class="btn btn-primary btn-sm staff-submit">
		<i class="glyphicon glyphicon-ok"></i>
		</button>
	<button type="button" class="btn btn-default btn-sm staff-cancel">
		<i class="glyphicon glyphicon-remove"></i>
	</button>
	</div>
</form>

<script>
$(function(){
	$('.shift_staff').typeahead({
		name: 'shift_staff',
		remote: '<?=base_url();?>staff/ajax/list_staffs'
	});
	$('.staff-cancel').click(function(){
		$('.shift_staff').popover('hide');
	});
})
</script>