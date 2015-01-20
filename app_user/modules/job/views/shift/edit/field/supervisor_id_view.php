<div class="row">
	<div class="form-group" id="f_update_field">
		<label class="col-lg-3 control-label">Supervisor</label>
		<div class="col-lg-9">
			<? #echo modules::run('staff/field_input', 'value');?>
            <?=modules::run('user/field_select', 'supervisor_id');?>
		</div>
	</div>
</div>
<script>
$('select').select2();
</script>
