<!--begin top box--->
<div class="col-md-12">
	<div class="box top-box">
   		 <h2>Roles</h2>
		 <p>Manage your role attribute.</p>
    </div>
</div>
<!--end top box-->

<!--begin bottom box -->
<div class="col-md-12">
	<div class="box bottom-box">
    	<div class="inner-box">
            <h2>Roles</h2>
			<p>Manage your role attribute.</p>
            
            
            <a data-toggle="modal" href="#addRole" ><i class="icon-plus-sign"></i> Add Role</a>
            <br /><br />
            <table class="table table-hover">
                <thead>
                <tr class="heading">
                    <td class="left">Name <a href="<?=base_url();?>attribute/role/sort"><i class="icon-sort-by-alphabet"></i></a></td>
                    <td class="center"><i class="icon-eye-open"></i> View</td>
                    <td class="center"><i class="icon-trash"></i> Delete</td>
                    <!-- <td class="center"><i class="icon-check"></i> Check</td> -->
                </tr>
                </thead>
                <? foreach($roles as $role) { ?>
                <tr>
                    <td class="left"><?=$role['name'];?></td>
                    <td class="center"><a href="javascript:edit_role(<?=$role['role_id'];?>,'<?=$role['name'];?>')"><i class="icon-eye-open icon-large"></i></a></td>
                    <td class="center"><a href="javascript:delete_role(<?=$role['role_id'];?>)"><i class="icon-trash icon-large"></i></a></td>
                    <!-- <td class="center"><input type="checkbox" /></td> -->
                </tr>
                <? } ?>
            </table>
           
        </div>
    </div>
</div>
<!--end bottom box -->




<!-- Add Role Modal -->
<div class="modal fade" id="addRole" tabindex="-1" role="dialog" aria-labelledby="addRoleLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">Add Role</h4>
			</div>
			<form role="form" method="post" action="<?=base_url();?>attribute/role/add">
			<div class="modal-body">
				<div class="form-group">
					<label for="name">Name</label>
					<input type="text" class="form-control" name="name" id="name" placeholder="Enter role name">
				</div>
			</div>
			<div class="modal-footer">
			<button type="button" class="btn btn-info" data-dismiss="modal">Close</button>
			<button type="submit" class="btn btn-info">Submit</button>
			</div>
			</form>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->



<!-- Edit Role Modal -->
<div class="modal fade" id="editRole" tabindex="-1" role="dialog" aria-labelledby="editRoleLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">Edit Role</h4>
			</div>
			<form role="form" method="post" action="<?=base_url();?>attribute/role/edit">
			<input type="hidden" name="role_id" id="role_id" />
			<div class="modal-body">
				<div class="form-group">
					<label for="name_edit">Name</label>
					<input type="text" class="form-control" name="name" id="name_edit" placeholder="Enter role name">
				</div>
			</div>
			<div class="modal-footer">
			<button type="button" class="btn btn-info" data-dismiss="modal">Close</button>
			<button type="submit" class="btn btn-info">Submit</button>
			</div>
			</form>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<script>
function delete_role(role_id)
{
	if(confirm('Are you sure you want to delete this role?'))
	{
		window.location = '<?=base_url();?>attribute/role/delete/' + role_id;
	}
}
function edit_role(role_id, name)
{
	$('#role_id').val(role_id);
	$('#name_edit').val(name);
	$('#editRole').modal('show');
}
</script>