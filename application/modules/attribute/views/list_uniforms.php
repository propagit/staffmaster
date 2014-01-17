<h2>Uniforms</h2>

<p>Manage your uniform attribute.</p>

<a data-toggle="modal" href="#addUniform" ><i class="icon-plus-sign"></i> Add Uniform</a>
<br /><br />
<table class="table table-hover">
	<thead>
	<tr class="heading">
		<td class="left">Name <a href="<?=base_url();?>attribute/uniform/sort"><i class="icon-sort-by-alphabet"></i></a></td>
		<td class="center"><i class="icon-eye-open"></i> View</td>
		<td class="center"><i class="icon-trash"></i> Delete</td>
		<!-- <td class="center"><i class="icon-check"></i> Check</td> -->
	</tr>
	</thead>
	<? foreach($uniforms as $uniform) { ?>
	<tr>
		<td class="left"><?=$uniform['name'];?></td>
		<td class="center"><a href="javascript:edit_uniform(<?=$uniform['uniform_id'];?>, '<?=$uniform['name'];?>')"><i class="icon-eye-open icon-large"></i></a></td>
		<td class="center"><a href="javascript:delete_uniform(<?=$uniform['uniform_id'];?>)"><i class="icon-trash icon-large"></i></a></td>
		<!-- <td class="center"><input type="checkbox" /></td> -->
	</tr>
	<? } ?>
</table>


<!-- Modal -->
<div class="modal fade" id="addUniform" tabindex="-1" role="dialog" aria-labelledby="addUniformLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">Add Uniform</h4>
			</div>
			<form role="form" method="post" action="<?=base_url();?>attribute/uniform/add">
			<div class="modal-body">
				<div class="form-group">
					<label for="name">Name</label>
					<input type="text" class="form-control" name="name" id="name" placeholder="Enter uniform name">
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

<!-- Modal -->
<div class="modal fade" id="editUniform" tabindex="-1" role="dialog" aria-labelledby="editUniformLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">Edit Uniform</h4>
			</div>
			<form role="form" method="post" action="<?=base_url();?>attribute/uniform/edit">
			<input type="hidden" name="uniform_id" id="uniform_id" />
			<div class="modal-body">
				<div class="form-group">
					<label for="name_edit">Name</label>
					<input type="text" class="form-control" name="name" id="name_edit" placeholder="Enter uniform name">
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
function delete_uniform(uniform_id)
{
	if(confirm('Are you sure you want to delete this uniform?'))
	{
		window.location = '<?=base_url();?>attribute/uniform/delete/' + uniform_id;
	}
}
function edit_uniform(uniform_id, name)
{
	$('#uniform_id').val(uniform_id);
	$('#name_edit').val(name);
	$('#editUniform').modal('show');
}
</script>