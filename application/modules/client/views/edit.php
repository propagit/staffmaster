<h2>Edit Client</h2>
<p>Update clients using below form.</p>

<a href="<?=base_url();?>client/search"><i class="icon-plus-sign"></i> Search Clients</a>
<br /><br />
<div class="panel">
	<div class="panel-heading">Edit Client</div>
	<div class="panel-body">
		<form class="form-horizontal" role="form" method="post" action="<?=base_url();?>client/edit/<?=$client['user_id'];?>">
			<div class="form-group<?=form_error('company_name')? ' has-error' : '';?>">
				<label for="company_name" class="col-lg-2 control-label">Company Name <span class="required">**</span></label>
				<div class="col-lg-10">
					<input type="text" class="form-control" id="company_name" name="company_name" value="<?=$client['company_name'];?>" />
				</div>
			</div>
			<div class="form-group<?=form_error('address')? ' has-error' : '';?>">
				<label for="address" class="col-lg-2 control-label">Address</label>
				<div class="col-lg-10">
					<input type="text" class="form-control" id="address" name="address" value="<?=$client['address'];?>" />
				</div>
			</div>
			<div class="form-group<?=form_error('suburb')? ' has-error' : '';?>">
				<label for="suburb" class="col-lg-2 control-label">Suburb</label>
				<div class="col-lg-10">
					<input type="text" class="form-control" id="suburb" name="suburb" value="<?=$client['suburb'];?>" />
				</div>
			</div>
			<div class="form-group<?=form_error('city')? ' has-error' : '';?>">
				<label for="city" class="col-lg-2 control-label">City</label>
				<div class="col-lg-10">
					<input type="text" class="form-control" id="city" name="city" value="<?=$client['city'];?>" />
				</div>
			</div>
			<div class="form-group">
				<label for="state" class="col-lg-2 control-label">State</label>
				<div class="col-lg-10">
					<?=modules::run('common/dropdown_states', 'state', $client['state']);?>
				</div>
			</div>
			<div class="form-group">
				<label for="country" class="col-lg-2 control-label">Country</label>
				<div class="col-lg-10">
					<?=modules::run('common/dropdown_countries', 'country', $client['country']);?>
				</div>
			</div>
			<div class="form-group<?=form_error('postcode')? ' has-error' : '';?>">
				<label for="postcode" class="col-lg-2 control-label">Postcode</label>
				<div class="col-lg-10">
					<input type="text" class="form-control auto-width" id="postcode" name="postcode" value="<?=$client['postcode'];?>" />
				</div>
			</div>
			<div class="form-group<?=form_error('abn')? ' has-error' : '';?>">
				<label for="abn" class="col-lg-2 control-label">ABN</label>
				<div class="col-lg-10">
					<input type="text" class="form-control" id="abn" name="abn" value="<?=$client['abn'];?>" />
				</div>
			</div>
			<div class="form-group">
				<label for="full_name" class="col-lg-2 control-label">Contact name</label>
				<div class="col-lg-10">
					<input type="text" class="form-control" id="full_name" name="full_name" value="<?=$client['full_name'];?>" />
				</div>
			</div>
			<div class="form-group<?=form_error('phone')? ' has-error' : '';?>">
				<label for="phone" class="col-lg-2 control-label">Phone Number</label>
				<div class="col-lg-10">
					<input type="text" class="form-control" id="phone" name="phone" value="<?=$client['phone'];?>" />
				</div>
			</div>
			<div class="form-group<?=form_error('email_address')? ' has-error' : '';?>">
				<label for="email_address" class="col-lg-2 control-label">Email Address</label>
				<div class="col-lg-10">
					<input type="text" class="form-control" id="email_address" name="email_address" value="<?=$client['email_address'];?>" />
				</div>
			</div>
			<div class="form-group">
				<label for="username" class="col-lg-2 control-label">Username</label>
				<div class="col-lg-10">
					<input type="text" class="form-control" id="username" name="username" value="<?=$client['username'];?>" disabled />
				</div>
			</div>
			<div class="form-group">
				<label for="password" class="col-lg-2 control-label">Password</label>
				<div class="col-lg-10">
					<input type="password" class="form-control" id="password" name="password" />
				</div>
			</div>
			<div class="form-group">
				<label for="external_client_id" class="col-lg-2 control-label">External Client ID</label>
				<div class="col-lg-10">
					<input type="text" class="form-control" id="external_client_id" name="external_client_id" value="<?=$client['external_client_id'];?>" />
				</div>
			</div>
			<div class="form-group">
				<label for="address" class="col-lg-2 control-label">Auto Send Invoices</label>
				<div class="col-lg-10">
					<select name="invoice_auto_send" class="form-control auto-width">
						<option value="0">No</option>
						<option value="1"<?=($client['invoice_auto_send'] == 1) ? ' selected' : '';?>>Yes</option>
					</select>
				</div>
			</div>
			<div class="form-group">
				<label for="address" class="col-lg-2 control-label">Account Status</label>
				<div class="col-lg-10">
					<select name="status" class="form-control auto-width">
						<option value="1">Active</option>
						<option value="0"<?=($client['status'] == "0") ? ' selected' : '';?>>Inactive</option>
					</select>
				</div>
			</div>
			<div class="form-group">
				<div class="col-lg-offset-2 col-lg-10">
					<button type="submit" class="btn btn-info"><i class="icon-save"></i> Update Client</button>
				</div>
			</div>
		</form>


	</div>
</div>