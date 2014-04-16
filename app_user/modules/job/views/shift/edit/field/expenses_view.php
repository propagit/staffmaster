<div class="row">
		<div class="form-group" id="f_description">
			<label for="expense_description" class="col-lg-3 control-label">Description:</label>
			<div class="col-lg-9">
				<input type="text" class="form-control" id="expense_description" name="description" placeholder="Enter expense description" />
			</div>
		</div>
	</div>
	<div class="row">
		<div class="form-group" id="f_staff_cost">
			<label class="col-lg-3 control-label">Staff Cost</label>
			<div class="col-lg-4">
				<div class="input-group">
					<span class="input-group-addon">$</span>
					<input type="text" class="form-control" name="staff_cost">
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="form-group" id="f_client_cost">
			<label class="col-lg-3 control-label">Client Cost</label>
			<div class="col-lg-4">
				<div class="input-group">
					<span class="input-group-addon">$</span>
					<input type="text" class="form-control" name="client_cost">
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="form-group">
			<label class="col-lg-3 control-label">Tax</label>
			<div class="col-lg-4">
				<?=modules::run('common/field_select_gst', 'tax');?>
			</div>
		</div>
	</div>