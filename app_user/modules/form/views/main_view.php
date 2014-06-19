<!--begin top box--->
<div class="col-md-12">
	<div class="box top-box">
   		 <h2>Manage Forms</h2>
		 <p>You can feed a recruitment form directly to your website that will allow applicants to apply to work for you. Create and configure the form and then get your web developer to use the "Embedded Code" to integrate the form into your website.</p>
            <button class="btn btn-info" data-toggle="modal" href="#addForm" ><i class="fa fa-plus"></i> Add New Form</button>  
    </div>
</div>
<!--end top box-->
<!--begin bottom box -->
<div class="col-md-12">
	<?=var_dump($forms);?>
</div>
<!--end bottom box -->

<!-- Add Role Modal -->
<div class="modal fade" id="addForm" tabindex="-1" role="dialog" aria-labelledby="addRoleLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>
				<h4 class="modal-title">Add New Form</h4>
			</div>
			<form id="form-add-form">
            <div class="col-md-12">
				<div class="modal-body">
	                <div class="form-group">
	                    <label for="name" class="col-sm-2 control-label">Name</label>
	                    <div class="col-sm-10">
	                      <input type="text" class="form-control" name="name" placeholder="Enter form name">
	                    </div>
	                </div>
	                <div class="form-group">
	                	 <label for="add-button" class="col-sm-2 control-label">&nbsp;</label>
	                    <div class="col-sm-10">
	                      <button id="btn-add-form" type="button" class="btn btn-info"><i class="fa fa-plus"></i> Add Form</button>
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
	$('#btn-add-form').click(function(){
		$.ajax({
			type: "POST",
			url: "<?=base_url();?>form/ajax/add_form",
			data: $('#form-add-form').serialize(),
			success: function(form_id) {
				window.location = '<?=base_url();?>form/edit/' + form_id;
			}
		})
	})
});
function list_forms() {
	
}
</script>