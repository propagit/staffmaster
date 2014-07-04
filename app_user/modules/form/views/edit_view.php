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
            	<form role="form" id="form-settings-form">
            	<input type="hidden" name="form_id" value="<?=$form['form_id'];?>" />
					<div class="form-group">
						<label class="control-label">Email Forwarding</label>
						<input type="text" class="form-control" name="receive_email" placeholder="example@domain.com" value="<?=$form['receive_email'];?>" />
					</div>
					<div class="form-group">
						<label class="control-label">Embed Code</label>
						<textarea class="form-control" readonly><iframe frameborder="0" scrolling="auto" width="100%" align="top,center" height="900px" src="<?=$url;?>" ></iframe></textarea>
					</div>
					<div class="alert alert-success hide" id="msg-update">Updated successfully!</div>
					<button type="button" class="btn btn-core" id="btn-update-settings">Update</button>
            	</form>
            </div>
        </div>
        
        <div class="col-md-6 white-box">
            <div class="inner-box">
            	<a href="<?=$url;?>" class="btn btn-core pull-right" target="_blank"><i class="fa fa-eye"></i> Preview</a>
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
									<span class="label label-<?=(isset($field['active']) && $field['active']) ? 'success' : 'default'?>" onclick="active_field(this,'<?=$field['label'];?>','<?=$name;?>')">Active</span>
								</td>
								<td class="right" width="20"><span class="label label-<?=(isset($field['required'])) ? 'success' : 'default'?>" onclick="require_field(this,'<?=$name;?>')">Required</span></td>
							</tr>
							<? } ?>
						</table>
					</div>
					
					
					<div class="list-group-item">
						<a onclick="load_fields(this,'financial')" class="pull-right"><i class="fa fa-plus-square"></i></a>
						<b>Financial Details</b>
						<table class="table table-hover table-condensed table-fields hide" id="fields-financial">
							<? foreach($financial_fields as $name => $field) { ?>
							<tr>
								<td class="left"><?=$field['label'];?></td>
								<td class="right" width="20">
									<span class="label label-<?=(isset($field['active']) && $field['active']) ? 'success' : 'default'?>" onclick="active_field(this,'<?=$field['label'];?>','<?=$name;?>')">Active</span>
								</td>
								<td class="right" width="20"><span class="label label-<?=(isset($field['required'])) ? 'success' : 'default'?>" onclick="require_field(this,'<?=$name;?>')">Required</span></td>
							</tr>
							<? } ?>
						</table>
					</div>
					
					<div class="list-group-item">
						<a onclick="load_fields(this,'super')" class="pull-right"><i class="fa fa-plus-square"></i></a>
						<b>Super Details</b>
						<table class="table table-hover table-condensed table-fields hide" id="fields-super">
							<? foreach($super_fields as $name => $field) { ?>
							<tr>
								<td class="left"><?=$field['label'];?></td>
								<td class="right" width="20">
									<span class="label label-<?=(isset($field['active']) && $field['active']) ? 'success' : 'default'?>" onclick="active_field(this,'<?=$field['label'];?>','<?=$name;?>')">Active</span>
								</td>
								<td class="right" width="20"><span class="label label-<?=(isset($field['required'])) ? 'success' : 'default'?>" onclick="require_field(this,'<?=$name;?>')">Required</span></td>
							</tr>
							<? } ?>
						</table>
					</div>
					
					<? foreach($extra_fields as $name => $field) { ?>
					<div class="list-group-item">
						<b><?=$field['label'];?></b>
						<div class="pull-right">
							<span class="label label-<?=(isset($field['active'])) ? 'success' : 'default'?>" onclick="active_field(this,'<?=$field['label'];?>','<?=$name;?>')">Active</span>
							<span class="label label-required label-<?=(isset($field['required'])) ? 'success' : 'default'?>" onclick="require_field(this,'<?=$name;?>')">Required</span>
						</div>
					</div>
					<? } ?>
					
					<div href="#" class="list-group-item">
						<a onclick="load_fields(this,'custom')" class="pull-right"><i class="fa fa-plus-square"></i></a>
						<b>Custom Attributes</b>
						<table class="table table-hover table-condensed table-fields hide" id="fields-custom">
							<? foreach($custom_fields as $field) { ?>
							<tr>
								<td class="left"><?=$field['label'];?></td>
								<td class="right" width="20"><span class="label label-<?=($field['required'] != NULL) ? 'success' : 'default'?>" onclick="active_field(this,'<?=$field['label'];?>','<?=$field['field_id'];?>')">Active</span></td>
								<td class="right" width="20"><span class="label label-<?=($field['required']) ? 'success' : 'default'?>" onclick="require_field(this,'<?=$field['field_id'];?>')">Required</span></td>
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
$(function(){
	$('#btn-update-settings').click(function(){
		$.ajax({
			type: "POST",
			url: "<?=base_url();?>form/ajax/update_settings",
			data: $('#form-settings-form').serialize(),
			success: function(html) {
				$('#msg-update').removeClass('hide');
				setTimeout(function(){
					$('#msg-update').addClass('hide');
				}, 2000);
			}
		})
	})
})
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
			if (html == 'default') {
				$(e).parent().parent().find('.label').removeClass('label-success');
				$(e).parent().parent().find('.label').addClass('label-default');
			}
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