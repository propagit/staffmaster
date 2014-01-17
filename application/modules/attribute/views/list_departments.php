<h2>Departments</h2>

<p>Manage your departments attribute.</p>

<a data-toggle="modal" href="#addDepartment" ><i class="icon-plus-sign"></i> Add Department</a>
<br /><br />


<table class="table table-hover">
	<thead>
	<tr class="heading">
		<td class="left">Department <a href="<?=base_url();?>attribute/department/sort"><i class="icon-sort-by-alphabet"></i></a></td>
		<td class="center"><i class="icon-eye-open"></i> View</td>
		<td class="center"><i class="icon-trash"></i> Delete</td>
		<!-- <td class="center"><i class="icon-check"></i> Check</td> -->
	</tr>
	</thead>
	<? foreach($departments as $department) { ?>
	<tr>
		<td class="left"><?=$department['name'];?></td>
		<td class="center"><a href="javascript:edit_department(<?=$department['department_id'];?>,'<?=$department['name'];?>')"><i class="icon-eye-open icon-large"></i></a></td>
		<td class="center"><a href="javascript:delete_department(<?=$department['department_id'];?>)"><i class="icon-trash icon-large"></i></a></td>
		<!-- <td class="center"><input type="checkbox" /></td> -->
	</tr>
	<? } ?>
</table>

<!-- Add Role Modal -->
<div class="modal fade" id="addDepartment" tabindex="-1" role="dialog" aria-labelledby="addDepartmentLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">Add Department</h4>
			</div>
			<form role="form" method="post" action="<?=base_url();?>attribute/department/add">
			<div class="modal-body">
				<div class="form-group">
					<label for="name">Name</label>
					<input type="text" class="form-control" name="name" id="name" placeholder="Enter department name">
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
<div class="modal fade" id="editDepartment" tabindex="-1" role="dialog" aria-labelledby="editDepartmentLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">Edit Department</h4>
			</div>
			<form role="form" method="post" action="<?=base_url();?>attribute/department/edit">
			<input type="hidden" name="department_id" id="department_id" />
			<div class="modal-body">
				<div class="form-group">
					<label for="name_edit">Name</label>
					<input type="text" class="form-control" name="name" id="name_edit" placeholder="Enter department name">
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
function delete_department(department_id)
{
	if(confirm('Are you sure you want to delete this department?'))
	{
		window.location = '<?=base_url();?>attribute/department/delete/' + department_id;
	}
}
function edit_department(department_id, name)
{
	$('#department_id').val(department_id);
	$('#name_edit').val(name);
	$('#editDepartment').modal('show');
}
</script>