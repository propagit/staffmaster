<div class="col-md-12">
	<div class="box top-box">
   		 <h2>Add Client</h2>
    	 <p>Add clients using below form or import multiple clients.</p>
    </div>
</div>

<div class="col-md-12">
	<div class="box bottom-box">
    	<div class="inner-box">
            <h2>Add New Client</h2>
            <p>Add clients using below form or import multiple clients</p>
            
            <form class="form-horizontal" role="form" method="post" action="<?=base_url();?>client/add">
			<div class="form-group<?=form_error('company_name')? ' has-error' : '';?>">
				<label for="company_name" class="col-lg-2 control-label">Company Name <span class="required">**</span></label>
				<div class="col-lg-10">
					<input type="text" class="form-control" id="company_name" name="company_name" value="<?=set_value('company_name');?>" />
				</div>
			</div>
			<div class="form-group<?=form_error('address')? ' has-error' : '';?>">
				<label for="address" class="col-lg-2 control-label">Address</label>
				<div class="col-lg-10">
					<input type="text" class="form-control" id="address" name="address" value="<?=set_value('address');?>" />
				</div>
			</div>
			<div class="form-group<?=form_error('suburb')? ' has-error' : '';?>">
				<label for="suburb" class="col-lg-2 control-label">Suburb</label>
				<div class="col-lg-10">
					<input type="text" class="form-control" id="suburb" name="suburb" value="<?=set_value('suburb');?>" />
				</div>
			</div>
			<div class="form-group<?=form_error('city')? ' has-error' : '';?>">
				<label for="city" class="col-lg-2 control-label">City</label>
				<div class="col-lg-10">
					<input type="text" class="form-control" id="city" name="city" value="<?=set_value('city');?>" />
				</div>
			</div>
			<div class="form-group">
				<label for="state" class="col-lg-2 control-label">State</label>
				<div class="col-lg-10">
					<?=modules::run('common/dropdown_states', 'state', set_value('state'));?>
				</div>
			</div>
			<div class="form-group">
				<label for="country" class="col-lg-2 control-label">Country</label>
				<div class="col-lg-10">
					<?=modules::run('common/dropdown_countries', 'country', set_value('country'));?>
				</div>
			</div>
			<div class="form-group<?=form_error('postcode')? ' has-error' : '';?>">
				<label for="postcode" class="col-lg-2 control-label">Postcode</label>
				<div class="col-lg-10">
					<input type="text" class="form-control auto-width" id="postcode" name="postcode" value="<?=set_value('postcode');?>" />
				</div>
			</div>
			<div class="form-group<?=form_error('abn')? ' has-error' : '';?>">
				<label for="abn" class="col-lg-2 control-label">ABN</label>
				<div class="col-lg-10">
					<input type="text" class="form-control" id="abn" name="abn" value="<?=set_value('abn');?>" />
				</div>
			</div>
			<div class="form-group">
				<label for="full_name" class="col-lg-2 control-label">Contact name</label>
				<div class="col-lg-10">
					<input type="text" class="form-control" id="full_name" name="full_name" value="<?=set_value('full_name');?>" />
				</div>
			</div>
			<div class="form-group<?=form_error('phone')? ' has-error' : '';?>">
				<label for="phone" class="col-lg-2 control-label">Phone Number</label>
				<div class="col-lg-10">
					<input type="text" class="form-control" id="phone" name="phone" value="<?=set_value('phone');?>" />
				</div>
			</div>
			<div class="form-group<?=form_error('email_address')? ' has-error' : '';?>">
				<label for="email_address" class="col-lg-2 control-label">Email Address</label>
				<div class="col-lg-10">
					<input type="text" class="form-control" id="email_address" name="email_address" value="<?=set_value('email_address');?>" />
				</div>
			</div>
			<div class="form-group<?=form_error('username')? ' has-error' : '';?>">
				<label for="username" class="col-lg-2 control-label">Username</label>
				<div class="col-lg-10">
					<input type="text" class="form-control" id="username" name="username" value="<?=set_value('username');?>" />
				</div>
			</div>
			<div class="form-group<?=form_error('password')? ' has-error' : '';?>">
				<label for="password" class="col-lg-2 control-label">Password</label>
				<div class="col-lg-10">
					<input type="password" class="form-control" id="password" name="password" value="<?=set_value('password');?>" />
				</div>
			</div>
			<div class="form-group">
				<label for="external_client_id" class="col-lg-2 control-label">External Client ID</label>
				<div class="col-lg-10">
					<input type="text" class="form-control" id="external_client_id" name="external_client_id" value="<?=set_value('external_client_id');?>" />
				</div>
			</div>
			<div class="form-group">
				<label for="address" class="col-lg-2 control-label">Auto Send Invoices</label>
				<div class="col-lg-10">
					<select name="invoice_auto_send" class="form-control auto-width">
						<option value="0">No</option>
						<option value="1"<?=(set_value('invoice_auto_send') == 1) ? ' selected' : '';?>>Yes</option>
					</select>
				</div>
			</div>
			<div class="form-group">
				<label for="address" class="col-lg-2 control-label">Account Status</label>
				<div class="col-lg-10">
					<select name="status" class="form-control auto-width">
						<option value="1">Active</option>
						<option value="0"<?=(set_value('status') === 0) ? ' selected' : '';?>>Inactive</option>
					</select>
				</div>
			</div>
			<div class="form-group">
				<div class="col-lg-offset-2 col-lg-10">
					<button type="submit" class="btn btn-info"><i class="fa fa-plus"></i> Add Client</button>
				</div>
			</div>
		</form>
		</div>
	</div>
</div>



