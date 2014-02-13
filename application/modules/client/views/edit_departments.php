<div class="staff-profile-detail-box">
	<h2>Departments</h2>
	<p>Client departments can be set up for each client. A client department can be allocated when creating jobs. Clients are able to view all of their jobs when they login into their client account, adding departments allows a client to filter by department to only show jobs relevant to a single department.</p>
	<button type="button" class="btn btn-core" data-toggle="modal" href="#addDepartment"><i class="fa fa-plus"></i> Add Department</button>
</div>

<div id="list_departments"></div>

<!-- Add Department Modal -->
<div class="modal fade" id="addDepartment" tabindex="-1" role="dialog" aria-labelledby="addDepartmentLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>
				<h4 class="modal-title">Add New Department</h4>
			</div>
			<form class="form-horizontal" role="form" id="form_add_client_department">
				<div class="col-md-12">
					<div class="modal-body">
						<input type="hidden" name="user_id" value="<?=$client['user_id'];?>" />
						<h4 class="modal-body-title">Enter Department Name</h4>
						<div class="form-group">
							<label for="name" class="col-md-2 control-label">Name</label>
							<div class="col-sm-10">
								<input type="text" class="form-control" name="name" placeholder="Enter department name">
							</div>
						</div>
						<div class="form-group">
							<label for="add-button" class="col-sm-2 control-label">&nbsp;</label>
							<div class="col-sm-10">
								<button id="btn-add-department" type="button" class="btn btn-info"><i class="fa fa-plus"></i> Add Department</button>
							</div>
						</div>
					</div>
				</div>
			</form>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<script>
$(function(){
	list_departments();
	$('#btn-add-department').click(function(){
		$.ajax({
			type: "POST",
			url: "<?=base_url();?>client/ajax/add_department",
			data: $('#form_add_client_department').serialize(),
			success: function(html) {
				$('#addDepartment').modal('hide');
				list_departments();
			}
		})
	})
})
function list_departments() {
	preloading($('#list_departments'));
	$.ajax({
		type: "POST",
		url: "<?=base_url();?>client/ajax/list_departments",
		data: {user_id: <?=$client['user_id'];?>},
		success: function(html) {
			loaded($('#list_departments'), html);
		}
	})
}
</script>