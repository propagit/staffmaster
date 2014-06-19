<!--begin top box--->
<div class="col-md-12">
	<div class="box top-box">
   		 <h2>Configure: <?=$form['name'];?></h2>
		 <p>Applicant details entered into the form will send via email to the address you specify below, the email will contain an approve link that will create the staff profile in a pending status. Changing the status of a staff member from pending to approved will make these staff account accessible and allow the staff member to work on jobs you create in the system.</p>
            <a class="btn btn-info" href="<?=base_url();?>form" ><i class="fa fa-arrow-left"></i> Back to Forms List</a>  
    </div>
</div>
<!--end top box-->

<div class="col-md-12">
	<div class="box bottom-box">
    
    	<div class="col-md-6 white-box">
            <div class="inner-box">
            	<h2>Form Settings</h2>
            	<br />
            	<form role="form">
					<div class="form-group">
						<label class="control-label">Email Forwarding</label>
						<input type="text" class="form-control" name="email" />
					</div>
					<div class="form-group">
						<label class="control-label">Embed Code</label>
						<textarea class="form-control" readonly><iframe src="<?=base_url();?>form" frameborder="0" allowfullscreen></iframe>
						</textarea>
					</div>
            	</form>
            </div>
        </div>
        
        <div class="col-md-6 white-box">
            <div class="inner-box">
            	<h2>Available Fields</h2>
            	<br />
            	
				<div class="list-group" id="form-fields">
					<div class="list-group-item active">
						<a onclick="load_fields(this,'personal')" class="pull-right"><i class="fa fa-plus-square"></i></a>
						<b>Personal Details</b>
						<table class="table table-hover table-condensed table-fields hide" id="fields-personal">
							<? foreach($personal_fields as $name => $field) { ?>
							<tr>
								<td class="left"><?=$field['label'];?></td>
								<td class="right" width="20">
									<span class="label label-<?=(isset($field['active'])) ? 'success' : 'default'?>" onclick="active_field(this,'<?=$field['label'];?>','<?=$name;?>')">Active</span>

								</td>
								<td class="right" width="20"><span class="label label-<?=(isset($field['required'])) ? 'success' : 'default'?>" onclick="require_field(this,'<?=$name;?>')">Required</span></td>
							</tr>
							<? } ?>
						</table>
					</div>
					<div href="#" class="list-group-item">
						<b>Pictures</b>
						<div class="pull-right">
							<span class="label label-default">Active</span>
							<span class="label label-default label-required">Required</span>
						</div>
					</div>
					<!--
					<div href="#" class="list-group-item">
						<a onclick="load_fields(this,'financial')" class="pull-right"><i class="fa fa-plus-square"></i></a>
						<b>Financial Details</b>
						<table class="table table-hover table-condensed table-fields hide" id="fields-financial">
							<? foreach($financial_fields as $key => $label) { ?>
							<tr>
								<td class="left"><?=$label;?></td>
								<td class="right" width="20"><span class="label label-default">Active</span></td>
								<td class="right" width="20"><span class="label label-default">Required</span></td>
							</tr>
							<? } ?>
						</table>
					</div>
					<div href="#" class="list-group-item">
						<b>Super Details</b>
						<div class="pull-right">
							<span class="label label-success">Active</span>
							<span class="label label-default label-required">Required</span>
						</div>
					</div>
					-->
					<div href="#" class="list-group-item">
						<b>Roles</b>
						<div class="pull-right">
							<span class="label label-default">Active</span>
							<span class="label label-default label-required">Required</span>
						</div>
					</div>
					<div href="#" class="list-group-item">
						<b>Availability</b>
						<div class="pull-right">
							<span class="label label-default">Active</span>
							<span class="label label-default label-required">Required</span>
						</div>
					</div>
					<div href="#" class="list-group-item">
						<b>Locations</b>
						<div class="pull-right">
							<span class="label label-default">Active</span>
							<span class="label label-default label-required">Required</span>
						</div>
					</div>
					<div href="#" class="list-group-item">
						<b>Groups</b>
						<div class="pull-right">
							<span class="label label-default">Active</span>
							<span class="label label-default label-required">Required</span>
						</div>
					</div>
					<div href="#" class="list-group-item">
						<a onclick="load_fields(this,'custom')" class="pull-right"><i class="fa fa-plus-square"></i></a>
						<b>Custom Attributes</b>
						<table class="table table-hover table-condensed table-fields hide" id="fields-custom">
							<? foreach($custom_fields as $field) { ?>
							<tr>
								<td class="left"><?=$field['label'];?></td>
								<td class="right" width="20"><span class="label label-default" onclick="active_field(this,'<?=$field['label'];?>','<?=$field['field_id'];?>')">Active</span></td>
								<td class="right" width="20"><span class="label label-default">Required</span></td>
							</tr>
							<? } ?>
						</table>
					</div>
				</div>

                             
                
            </div>
        </div>
        
	</div>
</div>
<script>
function load_fields(e,section) {
	var f = $('#fields-' + section);
	if (f.hasClass('hide')) {
		f.removeClass('hide');
		$(e).html('<i class="fa fa-minus-square"></i></a>');
	} else {
		f.addClass('hide');
		$(e).html('<i class="fa fa-plus-square"></i></a>');
	}
}
function active_field(e, label, name) {
	$.ajax({
		type: "POST",
		url: "<?=base_url();?>form/ajax/active_field",
		data: {form_id: <?=$form['form_id'];?>, label: label, name: name},
		success: function(html) {
			$(e).removeClass('label-success');
			$(e).removeClass('label-default');
			$(e).addClass('label-' + html);
		}
	})
}
function require_field(e, name) {
	$.ajax({
		type: "POST",
		url: "<?=base_url();?>form/ajax/require_field",
		data: {form_id: <?=$form['form_id'];?>, name: name},
		success: function(html) {
			$(e).removeClass('label-success');
			$(e).removeClass('label-default');
			$(e).addClass('label-' + html);
		}
	})
}
</script>