<!--begin top box--->
<div class="col-md-12">
	<div class="box top-box">
   		 <h2>Manage Forms</h2>
		 <p>You can feed a recruitment form directly to your website that will allow applicants to apply to work for you. Create and configure the form and then get your web developer to use the "Embedded Code" to integrate the form into your website.</p>
            <button class="btn btn-info" data-toggle="modal" href="#addForm" ><i class="fa fa-plus"></i> Create New Form</button>  
    </div>
</div>
<!--end top box-->
<? if (count($forms) > 0) { ?>
<!--begin bottom box -->
<div class="col-md-12">
	<div class="box bottom-box">
		<div class="inner-box table-responsive">
			<table class="table table-bordered table-hover table-middle">
			<thead>
		        <tr class="heading">
		            <th class="left">Name</th>
		            <th class="center col-md-1">Configure</th>
		            <th class="center col-md-1">View</th>
		        	<th class="center col-md-1">Delete</th>
		        </tr>
		    </thead>
		    <tbody>
			<? foreach($forms as $form) { ?>
				<tr id="form_<?=$form['form_id'];?>">
					<td class="left"><?=$form['name'];?></td>
					<td class="center"><a href="<?=base_url();?>form/edit/<?=$form['form_id'];?>"><i class="fa fa-gear"></i></a></td>
					<td class="center"><a href="<?=base_url();?>public/form/<?=$form['form_id'];?>" target="_blank"><i class="fa fa-eye"></i></a></td>
					<td class="center"><a onclick="delete_form(<?=$form['form_id'];?>)"><i class="fa fa-trash-o"></i></a></td>
				</tr>
			<? } ?>
		    </tbody>
			</table>
		</div>
	</div>
</div>
<!--end bottom box -->

<!-- Add Role Modal -->
<div class="modal fade" id="addForm" tabindex="-1" role="dialog" aria-labelledby="addRoleLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>
				<h4 class="modal-title">Create New Form</h4>
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
	                      <button id="btn-add-form" type="button" class="btn btn-info"><i class="fa fa-plus"></i> Create Form</button>
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
		$('#form-add-form').find('.form-group').removeClass('has-error');
		$.ajax({
			type: "POST",
			url: "<?=base_url();?>form/ajax/add_form",
			data: $('#form-add-form').serialize(),
			success: function(data) {
				data = $.parseJSON(data);
				if (!data.ok) {
					$('#form-add-form').find('.form-group').addClass('has-error');
				} else {
					window.location = '<?=base_url();?>form/edit/' + data.form_id;
				}				
			}
		})
	})
});
function delete_form(form_id) {
	help.confirm_delete('Delete form','Are you sure you want to delete this form?',function(confirmed){
		if(confirmed){
			$.ajax({
				type: "POST",
				url: "<?=base_url();?>form/ajax/delete_form",
				data: {form_id: form_id},
				success: function(html) {
					$('#form_' + form_id).remove();
				}
			})
		}
	});
}
</script>
<? } ?>