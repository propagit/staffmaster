<br />
<form class="form-horizontal" role="form" id="form_add_staff_location">
<input type="hidden" name="user_id" value="<?=$staff['user_id'];?>" />
<div class="row">
	<div class="form-group" id="f_staff_location">
		<label for="location" class="col-md-2 control-label">Location</label>
		<div class="col-md-4">
			<?=modules::run('attribute/location/field_select', 'location_parent_id');?>
		</div>
	</div>				
</div>
<div class="row">
	<div class="form-group">
		<div class="col-md-offset-2 col-md-4">
			<button type="button" class="btn btn-core" id="btn_add_location"><i class="fa fa-plus"></i> Add Location</button>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-offset-2 col-md-10" id="staff_locations">
	</div>
</div>
</form>

<script>
$(function(){
	load_staff_locations();
	$('#btn_add_location').click(function(){
		$('#f_staff_location').removeClass('has-error');
		$.ajax({
			type: "POST",
			url: "<?=base_url();?>staff/ajax/add_location",
			data: $('#form_add_staff_location').serialize(),
			success: function(data) {
				data = $.parseJSON(data);
				if (!data.ok)
				{
					$('#f_staff_location').addClass('has-error');
				}
				load_staff_locations();				
			}
		})
	})
});
function load_staff_locations() {
	preloading($('#staff_locations'));
	$.ajax({
		type: "POST",
		url: "<?=base_url();?>staff/ajax/load_locations",
		data: {user_id: '<?=$staff['user_id'];?>' },
		success: function(html) {
			loaded($('#staff_locations'), html);
		}
	})
}
</script>


<? #=modules::run('common/dropdown_location', 's_loc', $staff['locations']);?>
