<!--begin top box--->
<div class="col-md-12">
	<div class="box top-box">
   		 <h2>Uniforms</h2>
		 <p>
         	Uniforms can be added to job details when you create jobs. 
            Add common dress attire your staff will be required to wear when working on jobs.
         </p>
    </div>
</div>
<!--end top box-->

<!--begin bottom box -->
<div class="col-md-12">
	<div class="box bottom-box">
    	<div class="inner-box">
            <h2>Add - Edit Uniforms</h2>
			<p>Add new uniforms by clicking the "Add New Uniforms" button or manage your existing uniforms via the below table.</p>
            
            <button class="btn btn-info" data-toggle="modal" href="#addUniform" ><i class="fa fa-plus"></i> Add New Uniform</button>

            <div class="attr-list-wrap">
            	<table class="table table-bordered table-hover table-middle table-expanded">
                    <thead>
                    <tr class="heading">
                        <th class="left">Uniform <i class="fa fa-sort sort-table" sort-by="name" sort-order="desc"></i></a></th>
                        <th class="center col-md-1">Edit Uniform</th>
                        <th class="center col-md-1">Delete Uniform</th>
                    </tr>
                    </thead>
                    <tbody id="load-uniforms">
                    
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<!--end bottom box -->




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


var sort_data = {
	'sort_by':'name',
	'sort_order':'asc'
};

var params = {
	'url': '<?=base_url();?>attribute/ajax/get_uniforms',
	'output_container':'#load-uniforms',
	'type':'POST',
	'data':JSON.stringify({"sort_by":"name","sort_order":"asc"})
};


$(function(){
	help.load_content(params);
	
	//sort data
	help.sort_list('.sort-table');
});


</script>
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