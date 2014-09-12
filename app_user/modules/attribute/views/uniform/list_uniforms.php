<?=modules::run('wizard/main_view', 'uniform');?>

<!--begin top box--->
<div class="col-md-12">
	<div class="box top-box">
   		 <h2><i class="icon-attributesUniforms"></i> &nbsp; Manage Uniforms</h2>
		 <p>
         	Uniforms can be added to job details when you create jobs. 
            Add common dress attire your staff will be required to wear when working on jobs.
         </p>         
        <button class="btn btn-info" data-toggle="modal" href="#addUniform" ><i class="fa fa-plus"></i> Add New Uniform</button>
    </div>
</div>
<!--end top box-->

<!--begin bottom box -->
<div class="col-md-12" id="load-uniforms">
	
</div>
<!--end bottom box -->

<!-- Modal -->
<div class="modal fade" id="addUniform" tabindex="-1" role="dialog" aria-labelledby="addUniformLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>
				<h4 class="modal-title">Add Uniform</h4>
			</div>
            <div class="col-md-12">
                <form id="add-uniform-form" data-url="<?=base_url();?>attribute/ajax/add_uniform">
                <div class="modal-body">
                    <h4 class="modal-body-title">Enter Uniform Name</h4>
                    <div class="form-group">
                        <label for="name" class="col-sm-2 control-label">Name</label>
                        <div class="col-sm-10">
                             <input type="text" class="form-control" name="name" id="name" placeholder="Enter uniform name">
                        </div>
                    </div>
                    <div class="form-group">
                        	 <label for="add-button" class="col-sm-2 control-label">&nbsp;</label>
                        <div class="col-sm-10">
                          	<button id="add-new-uniform-btn" type="button" class="btn btn-info"><i class="fa fa-plus"></i> Add New Uniform</button>
                        </div>
                    </div>
                </div>
                
                </form>
            </div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- Modal -->
<div class="modal fade" id="editUniform" tabindex="-1" role="dialog" aria-labelledby="editUniformLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>
				<h4 class="modal-title">Edit Uniform</h4>
			</div>
            <div class="col-md-12">
                <form id="edit-uniform-form" data-url="<?=base_url();?>attribute/ajax/edit_uniform">
                <input type="hidden" name="uniform_id" id="uniform_id" />
                <div class="modal-body">
                    <div class="form-group">
                        <label for="name_edit" class="col-sm-2 control-label">Name</label>
                        <div class="col-sm-10">
                        	<input type="text" class="form-control" name="name" id="name_edit" placeholder="Enter uniform name">
                        </div>
                    </div>
                    <div class="form-group">
                        	 <label for="update-button" class="col-sm-2 control-label">&nbsp;</label>
                        <div class="col-sm-10">
                          	<button id="edit-uniform-btn" type="button" class="btn btn-info">Update Uniform</button>
                        </div>
                    </div>
                </div>
                </form>
            </div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<script>


var sort_data = {
	'sort_by':'name',
	'sort_order':'asc'
};

var params = {
	'url': '<?=base_url();?>attribute/ajax/get_uniforms',
	'output_container':'#load-uniforms',
	'type':'POST',
	'data':JSON.stringify(sort_data)
};

var delete_uniform_params = {
	'url': '<?=base_url();?>attribute/ajax/delete_uniform',
	'delete_id':''
}

$(function(){
	//load params
	help.load_content(params);
	
	//sort data
	help.sort_list('.sort-table',params);
	
	//add new uniform
	$('#add-new-uniform-btn').on('click',function(){
		 help.submit_form_data('add-uniform-form',function(success){
			if(success){
				$('#addUniform').modal('hide');
				help.load_content(params);
				reload_wizard('uniform');
			}
		 });
	});
	
	//edit uniform
	$('#edit-uniform-btn').on('click',function(){
		 help.submit_form_data('edit-uniform-form',function(success){
			if(success){
				$('#editUniform').modal('hide');
				help.load_content(params);
			}
		 });
	});
});

function open_edit_modal(uniform_id, name){
	$('#uniform_id').val(uniform_id);
	$('#name_edit').val(name);
	$('#editUniform').modal('show');
}
</script>