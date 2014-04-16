<ul class="breadcrumb">
	<li><a href="<?=base_url();?>admin/user">Users Management</a> <span class="divider">/</span></li>
	<li class="active">Create New User</li>
</ul>

<div class="box">
<form method="post" action="<?=base_url();?>admin/user/create">
	<div class="form-horizontal">
		<div class="control-group">
			<label class="control-label" for="company_name">Company Name</label>
			<div class="controls">
				<input type="text" id="company_name" name="company_name" value="<?=set_value('company_name');?>" />
			</div>
		</div>
		<div class="control-group">
			<label class="control-label" for="company_abn">Company ABN</label>
			<div class="controls">
				<input type="text" id="company_abn" name="company_abn" value="<?=set_value('company_abn');?>" />
			</div>
		</div>
		<div class="control-group<?=form_error('company_email')? ' error' : '';?>">
			<label class="control-label" for="company_email">Company Email</label>
			<div class="controls">
				<input type="text" id="company_email" name="company_email" value="<?=set_value('company_email');?>" />
				<span class="help-inline"><?=form_error('company_email');?></span>
			</div>
		</div>
		<div class="control-group">
			<label class="control-label" for="company_phone">Company Phone</label>
			<div class="controls">
				<input type="text" id="company_phone" name="company_phone" value="<?=set_value('company_phone');?>" />
			</div>
		</div>
		<div class="control-group">
			<label class="control-label" for="address">Address</label>
			<div class="controls">
				<input type="text" id="address" name="address" value="<?=set_value('address');?>" />
			</div>
		</div>
		<div class="control-group">
			<label class="control-label" for="suburb">Suburb</label>
			<div class="controls">
				<input type="text" id="suburb" name="suburb" value="<?=set_value('suburb');?>" />
			</div>
		</div>
		<div class="control-group">
			<label class="control-label">State <?=set_value('state');?></label>
			<div class="controls">
				<select name="state">
					<? foreach($states as $state) { ?>
					<option value="<?=$state['code'];?>"<?=(set_value('state') == $state['code']) ? ' selected' : '';?>><?=$state['name'];?></option>
					<? } ?>
				</select>
			</div>
		</div>
		<div class="control-group">
			<label class="control-label" for="postcode">Postcode</label>
			<div class="controls">
				<input type="text" id="postcode" name="postcode" value="<?=set_value('postcode');?>" />
			</div>
		</div>
		<div class="control-group<?=form_error('first_name')? ' error' : '';?>">
			<label class="control-label" for="first_name">First Name</label>
			<div class="controls">
				<input type="text" id="first_name" name="first_name" value="<?=set_value('first_name');?>" />
				<span class="help-inline"><?=form_error('first_name');?></span>
			</div>
		</div>
		<div class="control-group<?=form_error('last_name')? ' error' : '';?>">
			<label class="control-label" for="last_name">Family Name</label>
			<div class="controls">
				<input type="text" id="last_name" name="last_name" value="<?=set_value('last_name');?>" />
				<span class="help-inline"><?=form_error('last_name');?></span>
			</div>
		</div>
		<div class="control-group">
			<label class="control-label" for="service">Service</label>
			<div class="controls">
				<input type="text" id="service" name="service" value="<?=set_value('service');?>" />
			</div>
		</div>
		<div class="control-group<?=(form_error('username') || isset($username_exist)) ? ' error' : '';?>">
			<label class="control-label" for="username">Username</label>
			<div class="controls">
				<input type="text" id="username" name="username" value="<?=set_value('username');?>" />
				<span class="help-inline"><?=form_error('username');?><?=(isset($username_exist)) ? 'This username has already been used' : '';?></span>
			</div>
		</div>
		<div class="control-group<?=form_error('password')? ' error' : '';?>">
			<label class="control-label" for="password">Password</label>
			<div class="controls">
				<input type="password" id="password" name="password" value="<?=set_value('password');?>" />
				<span class="help-inline"><?=form_error('password');?></span>
			</div>
		</div>
		<div class="control-group">
			<label class="control-label" for="margin"></label>
			<div class="controls">
				<button class="btn" type="submit">Create User</button>
			</div>
		</div>
	</div>
</form>
</div>
<!--
<ul class="breadcrumb">
	<li class="active">User Discount</li>
</ul>
<div class="box">
	<div class="form-horizontal">
		<div class="control-group">
			<label class="control-label" for="discount">User Discount</label>
			<div class="controls">
				<div class="input-append">
					<input class="span1" id="discount" type="text">
					<span class="add-on">%</span>
				</div> &nbsp; The customer % discount from the product list price
			</div>
		</div>
		<div class="control-group">
			<label class="control-label" for="margin">User Controlled Margin</label>
			<div class="controls">
				<div class="input-append">
					<input class="span1" id="margin" type="text">
					<span class="add-on">%</span>
				</div> &nbsp; User controlled figure for adding their own margin to products
			</div>
		</div>
	</div>
</div>
-->