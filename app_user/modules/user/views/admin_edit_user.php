<ul class="breadcrumb">
	<li><a href="<?=base_url();?>admin/user">Users Management</a> <span class="divider">/</span></li>
	<li class="active">Update User Profile</li>
</ul>

<? if (isset($updated)) { ?>
<div class="alert alert-success">
	User profile has been updated successfully!
</div>
<? } ?>
<div class="box">
<form method="post" action="<?=base_url();?>admin/user/edit/<?=$user['user_id'];?>">
	<div class="form-horizontal">
		<div class="control-group">
			<label class="control-label" for="company_name">Company Name</label>
			<div class="controls">
				<input type="text" id="company_name" name="company_name" value="<?=$user['company_name'];?>" />
			</div>
		</div>
		<div class="control-group">
			<label class="control-label" for="company_abn">Company ABN</label>
			<div class="controls">
				<input type="text" id="company_abn" name="company_abn" value="<?=$user['company_abn'];?>" />
			</div>
		</div>
		<div class="control-group">
			<label class="control-label" for="company_email">Company Email</label>
			<div class="controls">
				<input type="text" id="company_email" name="company_email" value="<?=$user['company_email'];?>" />
			</div>
		</div>
		<div class="control-group">
			<label class="control-label" for="company_phone">Company Phone</label>
			<div class="controls">
				<input type="text" id="company_phone" name="company_phone" value="<?=$user['company_phone'];?>" />
			</div>
		</div>
		<div class="control-group">
			<label class="control-label" for="address">Address</label>
			<div class="controls">
				<input type="text" id="address" name="address" value="<?=$user['address'];?>" />
			</div>
		</div>
		<div class="control-group">
			<label class="control-label" for="suburb">Suburb</label>
			<div class="controls">
				<input type="text" id="suburb" name="suburb" value="<?=$user['suburb'];?>" />
			</div>
		</div>
		<div class="control-group">
			<label class="control-label">State</label>
			<div class="controls">
				<select name="state">
					<? foreach($states as $state) { ?>
					<option value="<?=$state['code'];?>"<?=($state['code'] == $user['state']) ? ' selected' : '';?>><?=$state['name'];?></option>
					<? } ?>
				</select>
			</div>
		</div>
		<div class="control-group">
			<label class="control-label" for="postcode">Postcode</label>
			<div class="controls">
				<input type="text" id="postcode" name="postcode" value="<?=$user['postcode'];?>" />
			</div>
		</div>
		<div class="control-group">
			<label class="control-label" for="first_name">First Name</label>
			<div class="controls">
				<input type="text" id="first_name" name="first_name" value="<?=$user['first_name'];?>" />
			</div>
		</div>
		<div class="control-group">
			<label class="control-label" for="last_name">Family Name</label>
			<div class="controls">
				<input type="text" id="last_name" name="last_name" value="<?=$user['last_name'];?>" />
			</div>
		</div>
		<div class="control-group">
			<label class="control-label" for="service">Service</label>
			<div class="controls">
				<input type="text" id="service" name="service" value="<?=$user['service'];?>" />
			</div>
		</div>
		<div class="control-group">
			<label class="control-label" for="username">Username</label>
			<div class="controls">
				<input type="text" class="uneditable-input" disabled id="username" name="username" value="<?=$user['username'];?>" />
			</div>
		</div>
		<div class="control-group">
			<label class="control-label" for="password">Password</label>
			<div class="controls">
				<input type="password" id="password" name="password" />
			</div>
		</div>
		<div class="control-group">
			<label class="control-label" for="margin"></label>
			<div class="controls">
				<button class="btn" type="submit">Update Profile</button>
			</div>
		</div>
	</div>
</div>
<ul class="breadcrumb">
	<li class="active">User Discount</li>
</ul>
<div class="box">
	<div class="form-horizontal">
		<div class="control-group">
			<label class="control-label" for="discount">User Discount</label>
			<div class="controls">
				<div class="input-append">
					<input class="span1" id="discount" name="discount" type="text" value="<?=$user['discount'];?>">
					<span class="add-on">%</span>
				</div>
				<span class="help-inline">The customer % discount from the product list price</span>
			</div>
		</div>
		<div class="control-group">
			<label class="control-label" for="margin">User Controlled Margin</label>
			<div class="controls">
				<div class="input-append">
					<input class="span1" id="margin" name="margin" type="text" value="<?=$user['margin'];?>">
					<span class="add-on">%</span>
				</div>
				<span class="help-inline">User controlled figure for adding their own margin to products</span>
			</div>
		</div>
		<div class="control-group">
			<label class="control-label" for="margin"></label>
			<div class="controls">
				<button class="btn" type="submit">Update Discount</button>
			</div>
		</div>
	</div>
</div>
</form>

<a href="#createSubUserForm" class="btn btn-breadcrumb" data-toggle="modal">Create Sub User</a>
<ul class="breadcrumb">
	<li class="active">Sub Users</li>
</ul>
<? if (count($sub_users) > 0) { ?>
<table class="table table-bordered table-hover">
	<thead>
	<tr>
		<td>Username</td>
		<td>Email</td>		
		<td>Full name</td>
		<td class="center" width="30">Edit</td>
		<td class="center" width="30">Delete</td>
	</tr>
	</thead>
	<? foreach($sub_users as $sub_user) { ?>
	<tr>
		<td><?=$sub_user['username'];?></td>
		<td><?=$sub_user['company_email'];?></td>
		<td><?=$sub_user['first_name'] . ' ' . $sub_user['last_name']; ?></td>
		<td><a onclick="load_edit_form('<?=$sub_user['user_id'];?>','<?=$sub_user['first_name'];?>','<?=$sub_user['last_name'];?>','<?=$sub_user['username'];?>','<?=$sub_user['company_email'];?>')" class="btn btn-mini btn-info"><i class="icon-pencil icon-white"></i></a></td>
		<td class="center">
			<button class="btn btn-mini btn-danger" type="button" onclick="delete_sub_user(<?=$sub_user['user_id'];?>)"><i class="icon-trash icon-white"></i> </button>
		</td>
	</tr>
	<? } ?>
</table>
<? } ?>

<!-- Modal -->
<div id="createSubUserForm" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
		<h3 id="myModalLabel">Create Sub User</h3>
	</div>	
	<div class="modal-body">
		<input type="hidden" name="parent_id" value="<?=$user['user_id'];?>" />
		<div class="control-group" id="error_c_username">
			<label for="sub_username">Username</label>
			<input type="text" name="sub_username" id="sub_username" /><span class="help-inline" id="error_username"></span>
		</div>
		
		<div class="control-group" id="error_c_password">
			<label for="sub_password">Password</label>
			<input type="password" name="sub_password" id="sub_password" /><span class="help-inline" id="error_password"></span>
		</div>
		
		<div class="control-group" id="error_c_email">
			<label for="sub_email">Email address</label>
			<input type="text" name="sub_email" id="sub_email" /><span class="help-inline" id="error_email"></span>
		</div>
		<div class="control-group" id="error_c_firstname">
			<label for="sub_first_name">First Name</label>
			<input type="text" name="sub_first_name" id="sub_first_name" /><span class="help-inline" id="error_firstname"></span>
		</div>
		<div class="control-group" id="error_c_lastname">
			<label for="sub_last_name">Family Name</label>
			<input type="text" name="sub_last_name" id="sub_last_name" /><span class="help-inline" id="error_lastname"></span>
		</div>
	</div>
	
	<div class="modal-footer">
		<button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
		<button class="btn btn-primary" type="button" onclick="create_sub_user()">Create Sub User</button>
	</div>
</div>

<!-- Modal -->
<div id="editSubUserForm" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<form method="post" action="<?=base_url();?>admin/user/edit_sub_user/<?=$user['user_id'];?>">
<input type="hidden" name="sub_user_id" id="sub_user_id_edit" />
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
		<h3 id="myModalLabel">Edit Sub User</h3>
	</div>
	<div class="modal-body">
			<label for="sub_username_edit">Username</label>
			<input type="text" name="sub_username" id="sub_username_edit" disabled />
			<label for="sub_password_edit">Password</label>
			<input type="password" name="sub_password" id="sub_password_edit" />
			<label for="sub_email_edit">Email address</label>
			<input type="text" name="sub_email" id="sub_email_edit" />
			<label for="sub_first_name_edit">First Name</label>
			<input type="text" name="sub_first_name" id="sub_first_name_edit" />
			<label for="sub_last_name_edit">Family Name</label>
			<input type="text" name="sub_last_name" id="sub_last_name_edit" />
	</div>
	<div class="modal-footer">
		<button class="btn" data-dismiss="modal" aria-hidden="true">Cancel</button>
		<button class="btn btn-primary" type="submit">Update</button>
	</div>
</form>
</div>


<script>
function load_edit_form(user_id, first_name, last_name, username, email)
{
	$('#sub_user_id_edit').val(user_id);
	$('#sub_username_edit').val(username);
	$('#sub_email_edit').val(email);
	$('#sub_first_name_edit').val(first_name);
	$('#sub_last_name_edit').val(last_name);
	$('#editSubUserForm').modal('toggle');
}
function delete_sub_user(user_id)
{
	if(confirm('Are you sure you want to delete this sub account?'))
	{
		window.location = '<?=base_url();?>admin/user/delete/' + user_id;
	}
}
function create_sub_user()
{
	var username = $('#sub_username').val();
	var password = $('#sub_password').val();
	var email = $('#sub_email').val();
	var first_name = $('#sub_first_name').val();
	var last_name = $('#sub_last_name').val();
	$.ajax({
		url: "<?=base_url();?>user/ajax/create_sub_user",
		type: "POST",
		data: {user_id:<?=$user['user_id'];?>,username:username,password:password,email:email,first_name:first_name,last_name:last_name},
		dataType: "html",
		success: function(html) {
			var data = $.parseJSON(html);
			if (data.result == false)
			{
				if (data.username)
				{
					$('#error_username').html(data.username);
					$('#error_c_username').addClass('error');
				}
				else
				{
					$('#error_username').html('');
					$('#error_c_username').removeClass('error');
				}
				
				if (data.password)
				{
					$('#error_password').html(data.password);
					$('#error_c_password').addClass('error');
				}
				else
				{
					$('#error_password').html('');
					$('#error_c_password').removeClass('error');
				}

				if (data.email)
				{
					$('#error_email').html(data.email);
					$('#error_c_email').addClass('error');
				}
				else
				{
					$('#error_email').html('');
					$('#error_c_email').removeClass('error');
				}

				if (data.first_name)
				{
					$('#error_firstname').html(data.first_name);
					$('#error_c_firstname').addClass('error');
				}
				else
				{
					$('#error_firstname').html('');
					$('#error_c_firstname').removeClass('error');
				}

				if (data.last_name)
				{
					$('#error_lastname').html(data.last_name);
					$('#error_c_lastname').addClass('error');
				}
				else
				{
					$('#error_lastname').html('');
					$('#error_c_lastname').removeClass('error');
				}
				
			}
			else
			{
				window.location = '<?=base_url();?>admin/user/edit/<?=$user['user_id'];?>';
			}
		}
	})
}
</script>