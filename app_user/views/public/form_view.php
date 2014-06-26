<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title><?=$form['name'];?></title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<!-- Bootstrap -->
	<link href="<?=base_url();?>assets/css/bootstrap.min.css" rel="stylesheet" media="screen">
	<link rel="stylesheet" href="<?=base_url();?>assets/font-awesome/css/font-awesome.min.css">
	
	<!--[if IE 7]>
	<link rel="stylesheet" href="<?=base_url();?>assets/font-awesome/css/font-awesome-ie7.min.css">
	<![endif]-->
	
	<link href="<?=base_url();?>assets/css/bootstrap-fileupload.min.css" rel="stylesheet">
	
	<script src="<?=base_url();?>assets/js/hogan.js"></script>
	<script src="<?=base_url();?>assets/js/jquery.min.js"></script>
	<script src="<?=base_url();?>assets/js/jquery.scrollTo.min.js"></script>
	<script src="<?=base_url();?>assets/js/jquery.json-2.4.min.js"></script>
	<script src="<?=base_url();?>assets/js/bootstrap.min.js"></script>
	<script src="<?=base_url();?>assets/js/bootstrap.confirm.js"></script>
	<script src="<?=base_url();?>assets/jasny-bootstrap/js/jasny-bootstrap.min.js"></script>
	<!-- select2 -->
	<link href="<?=base_url();?>assets/css/select2/select2.css" rel="stylesheet">
	<script src="<?=base_url();?>assets/js/select2.min.js"></script>
	<script src="<?=base_url();?>assets/js/plupload/plupload.full.min.js"></script>
    
	<script> var base_url = '<?=base_url();?>'; </script>
	<script src="<?=base_url();?>assets/js/core.js" type="text/javascript" charset="utf-8"></script>
    <link href="<?=base_url();?>custom_styles" rel="stylesheet" type="text/css" />
    <link href="<?=base_url();?>assets/css/core.css" rel="stylesheet" media="screen">
	<link href="<?=base_url();?>assets/css/public/form.css" rel="stylesheet" media="screen">
	<link href="<?=base_url();?>assets/jasny-bootstrap/css/public/jasny-bootstrap.min.css" rel="stylesheet" media="screen">
	<link type="text/css" rel="stylesheet" href="<?=base_url();?>custom_styles" />
</head>
<body>


<br />
<!-- Begin page content -->
<div class="container-fluid">
    <div class="row">
    	<span class="text-red">**</span> Required Field
    	<h2>Personal Details</h2>
    	<p class="text-muted">Please fill in your personal details</p>
    	<form enctype="multipart/form-data" id="form<?=$form['form_id'];?>" class="form-horizontal" role="form">
    	<? foreach($personal_fields as $name => $field) { if(isset($field['active'])) { ?>
			<div class="form-group" id="f_<?=$field['form_field_id'];?>">
				<label for="field_<?=$name;?>" class="col-sm-2 control-label">
					<?=$field['label'];?>
					<? if(isset($field['required'])) { ?>
						<span class="text-red">**</span>
					<? } ?>
				</label>
				<div class="col-sm-10">
					<? if($name == 'title') { ?>
					<?=modules::run('common/field_select_title', $field['form_field_id']);?>
					<? } else if ($name == 'gender') { ?>
					<?=modules::run('common/field_select_genders', $field['form_field_id']);?>
					<? } else if ($name == 'dob') { ?>
					<?=modules::run('common/field_dob', $field['form_field_id']);?>
					<? } else if ($name == 'state') { ?>
					<?=modules::run('common/field_select_states', $field['form_field_id']);?>
					<? } else if ($name == 'country') { ?>
					<?=modules::run('common/field_select_countries', $field['form_field_id']);?>
					<? } else if ($name == 'password') { ?>
					<input type="password" class="form-control" id="field_<?=$name;?>" name="<?=$field['form_field_id'];?>" />
					<? } else { ?>
					<input type="text" class="form-control" id="field_<?=$name;?>" name="<?=$field['form_field_id'];?>" />
					<? } ?>
				</div>
			</div>
    	<? } } ?>
    	
    	<? foreach($extra_fields as $name => $field) { if (isset($field['active'])) { ?>
    	<hr />
	    <h2><?=$field['label'];?>
	    </h2>
	    	<? if($name == 'role' && count($roles) > 0) { ?>
    			<p class="text-muted" id="f_<?=$field['form_field_id'];?>">
    				Please let us know what roles you could perform for us	    			
			    	<? if(isset($field['required'])) { ?>
						<span class="text-red">**</span>
					<? } ?>
    			</p>
    			<? foreach($roles as $role) { ?>
    			<div class="checkbox checkbox_role">
					<label>
						<input type="checkbox" name="<?=$field['form_field_id'];?>[]" value="<?=$role['role_id'];?>" /> <?=$role['name'];?>
					</label>
				</div>
    			<? }
    		} else if ($name == 'availability') { ?>
    			<p class="text-muted" id="f_<?=$field['form_field_id'];?>">Let us know what days you can work on
	    			<? if(isset($field['required'])) { ?>
						<span class="text-red">**</span>
					<? } ?>
    			</p>
    			<? $days = modules::run('common/array_day'); 
    				foreach($days as $day_no => $day_label) { ?>
    			<div class="checkbox checkbox_day">
					<label>
						<input type="checkbox" name="<?=$field['form_field_id'];?>[]" value="<?=$day_no;?>" /> <?=$day_label;?>
					</label>
				</div>	
    			<? }
    		} else if ($name == 'location') { ?>
    			<p class="text-muted" id="f_<?=$field['form_field_id'];?>">Let us know where you can work
	    			<? if(isset($field['required'])) { ?>
						<span class="text-red">**</span>
					<? } ?>
    			</p>
    			<?=modules::run('attribute/location/field_input', $field['form_field_id']);?>
    			<div class="clear"></div>
    		<? } else if ($name == 'group' && count($groups) > 0) { ?>
    			<p class="text-muted" id="f_<?=$field['form_field_id'];?>">Please let us know what group you want to join
	    			<? if(isset($field['required'])) { ?>
						<span class="text-red">**</span>
					<? } ?>
    			</p>
    			<? foreach($groups as $group) { ?>
    			<div class="checkbox">
					<label>
						<input type="checkbox" name="<?=$field['form_field_id'];?>[]" value="<?=$group['group_id'];?>" /> <?=$group['name'];?>
					</label>
				</div>
    			<? }
    		} else if ($name == 'picture') { ?>
    		<p class="text-muted">Upload photos of yourself so we have a visual reference of you</p>
			<div id="filelist"><!-- Your browser doesn't have Flash, Silverlight or HTML5 support. --></div>
			<div class="progress progress-striped active" style="visibility: hidden;">
				<div class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;" id="upload-progress">0%</div>
			</div>
			<div id="upload_container">
			    <button type="button" id="pickfiles" href="javascript:;" class="btn btn-core">Select files</button>
			    <button type="button" id="uploadfiles" href="javascript:;" class="btn btn-core">Upload files</button>
	            <span id="console"></span>
			</div>
			<input type="hidden" id="field_pictures" name="<?=$field['form_field_id'];?>" />
			<div id="uploaded_photos">
			</div>
    		<? } ?>
    	<? } } ?>    		
    	<hr />
    	<? if (count($custom_fields) > 0) { ?>
    	<h2>Additional Information</h2>
    	<p class="text-muted">Please provide us with the below information</p>
    	<? foreach($custom_fields as $field) { ?>
    		<div class="form-group" id="f_<?=$field['form_field_id'];?>">
				<label for="<?=$name;?>" class="col-sm-2 control-label">
					<?=$field['label'];?>
					<? if($field['required']) { ?>
						<span class="text-red">**</span>
					<? } ?>
				</label>
				<div class="col-sm-10">
					<? if($field['type'] == 'text') { ?>
					<input type="text" placeholder="<?=$field['placeholder'];?>" name="<?=$field['form_field_id'];?>" class="form-control" />
					<? } else if ($field['type'] == 'textarea') { ?>
					<textarea name="<?=$field['form_field_id'];?>" class="form-control"></textarea>
					<? } else if ($field['type'] == 'checkbox') { ?>
					<?php
				   		$attrs = json_decode($field['attributes']);
				   		if ($attrs) {
							foreach($attrs as $attr){ ?>
							<label class="checkbox <?=($field['inline'] == 'true' ? 'custom-inline' : '' );?>">
								<input type="checkbox" name="<?=$field['form_field_id'];?>[]" value="<?=$attr;?>" /> <?=$attr;?>
							</label>
					<?php 	}
						} ?>
					<? } else if ($field['type'] == 'select') { ?>
					<select name="<?=$field['form_field_id'];?><?=($field['multiple'] == 'true' ? '[]' : '');?>" class="form-control" <?=($field['multiple'] == 'true' ? 'multiple="multiple"' : '');?>>
			   			<? if ($field['multiple'] != "true") { ?>
			   			<option value="">Select One</option>
			   			<? } 
						$attrs = json_decode($field['attributes']);
						if($attrs) {
							foreach($attrs as $attr) { ?>
						<option value="<?=$attr;?>"><?=$attr;?></option>
						<? }
						} ?>
					</select>
					<? } else if ($field['type'] == 'radio') { ?>
					<?php
					   	$attrs = json_decode($field['attributes']);
						if($attrs){
							foreach($attrs as $attr){ ?>
							<label class="radio <?=($field['inline'] == 'true' ? 'custom-inline' : '' );?>">
								<input type="radio" name="<?=$field['form_field_id'];?>" value="<?=$attr;?>" />	<?=$attr;?>
							</label>
					<?php 	}
						} ?>
					<? } else if ($field['type'] == 'file') { ?>
					
					<div id="filelist_<?=$field['form_field_id'];?>"><!-- Your browser doesn't have Flash, Silverlight or HTML5 support. --></div>
					<div class="progress progress-striped active" style="visibility: hidden;">
						<div class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;" id="upload-progress_<?=$field['form_field_id'];?>">
							0%
						</div>
					</div>
					<div id="upload_container_<?=$field['form_field_id'];?>">
					    <button type="button" id="pickfiles_<?=$field['form_field_id'];?>" href="javascript:;" class="btn btn-core">Select files</button>
					    <button type="button" id="uploadfiles_<?=$field['form_field_id'];?>" href="javascript:;" class="btn btn-core">Upload files</button>
			            <span id="console_<?=$field['form_field_id'];?>"></span>
					</div>
					<input type="hidden" name="<?=$field['form_field_id'];?>" />
					<div class="up_file" id="uploaded_file_<?=$field['form_field_id'];?>"></div>
					
<script>
var uploader_<?=$field['form_field_id'];?> = new plupload.Uploader({
	runtimes : 'html5,flash,silverlight,html4',
	browse_button : 'pickfiles_<?=$field['form_field_id'];?>', // you can pass in id...
	multi_selection:false,  //disable multi-selection
	container: document.getElementById('upload_container_<?=$field['form_field_id'];?>'), // ... or DOM Element itself
	url : '<?=base_url();?>public/form/<?=$form['form_id'];?>/upload_files',
	chunk_size: '400kb',
    max_retries: 5,    
    unique_names: true,
	flash_swf_url : '<?=base_url();?>assets/js/plupload/Moxie.swf',
	silverlight_xap_url : '<?=base_url();?>assets/js/plupload/Moxie.xap',

	filters : {
		max_file_size : '20mb',
		mime_types: [
			{title : "Image files", extensions : "jpg,gif,png"},
			{title : "Zip files", extensions : "zip"},
			{title : "Movie files", extensions : "mov,mp4,avi"},
			{title : "Document files", extensions : "pdf,doc,docx,ppt"}
		]
	},

	init: {
		PostInit: function() {
			$('#console_<?=$field['form_field_id'];?>').html('');
			$('#filelist_<?=$field['form_field_id'];?>').html('');
			$('#uploadfiles_<?=$field['form_field_id'];?>').click(function() {
				uploader_<?=$field['form_field_id'];?>.start();
				return false;
			});
		},

		FilesAdded: function(up, files) {
			if(uploader_<?=$field['form_field_id'];?>.files.length > 1)
			{
			    uploader_<?=$field['form_field_id'];?>.removeFile(uploader_<?=$field['form_field_id'];?>.files[0]);
			    uploader_<?=$field['form_field_id'];?>.refresh();// must refresh for flash runtime
			}
			$('#upload-progress_<?=$field['form_field_id'];?>').parent().css("visibility", "visible");

			plupload.each(files, function(file) {
				document.getElementById('filelist_<?=$field['form_field_id'];?>').innerHTML = '<div id="' + file.id + '">' + file.name + ' (' + plupload.formatSize(file.size) + ') <b></b></div>';
			});
		},

		UploadProgress: function(up, file) {
			document.getElementById(file.id).getElementsByTagName('b')[0].innerHTML = '<span>' + file.percent + "%</span>";
			$('#upload-progress_<?=$field['form_field_id'];?>').attr('aria-valuenow', 60);
			$('#upload-progress_<?=$field['form_field_id'];?>').css("width", file.percent + "%");
			$('#upload-progress_<?=$field['form_field_id'];?>').html(file.percent + '% completed');
		},
		UploadComplete: function(up, files) {
			// On complete
			$('#upload-progress_<?=$field['form_field_id'];?>').parent().css("visibility", "hidden");
			$('#upload-progress_<?=$field['form_field_id'];?>').css("width", "0%");
			$('#upload-progress_<?=$field['form_field_id'];?>').html('0%');
			$('#console_<?=$field['form_field_id'];?>').html('');
			$('#filelist_<?=$field['form_field_id'];?>').html('');
			$('#uploaded_file_<?=$field['form_field_id'];?>').html('<span>' + files[0].name + ' <i class="fa fa-times" onClick="remove_custom_file(<?=$field['form_field_id'];?>)"></i></span>');
			$('input[name="<?=$field['form_field_id'];?>"]').val(files[0].target_name);
		},

		Error: function(up, err) {
			$('#console_<?=$field['form_field_id'];?>').html('\n&nbsp;<span class="text-danger">Error: ' + err.message + '</span>');
		}
	}
});

uploader_<?=$field['form_field_id'];?>.init();
uploader_<?=$field['form_field_id'];?>.bind('FilesAdded', function(up, files) {
    $.each(files, function(i, file) {
        if(i){up.removeFile(file); return;}
    });
});
</script>
					
					
					<? } ?>
				</div>
    		</div>
    	<? } ?>
    	<hr />
    	<? } ?>
    	<p><button type="button" id="btn-submit" class="btn btn-core">Apply Now</button></p>
    		
    	</form>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="successModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
    <div class="modal-body">
      <div class="modal-body">
        <p><i class="text-success fa fa-check fa-5x"></i></p>
        <p class="text-success">Thank you for submitting your application!<br />
        Your details have be processed successfully.</p>
      </div>
    </div>
    </div>
  </div>
</div>

<script>
$(function(){
	init_select();
	$('#btn-submit').click(function(){
		$('#form<?=$form['form_id'];?>').find('.has-error').removeClass('has-error');
		$.ajax({
			type: "POST",
			url: "<?=base_url();?>public/form/<?=$form['form_id'];?>/submit",
			data: $('#form<?=$form['form_id'];?>').serialize(),
			success: function(html) {
				alert(html);
				var data = $.parseJSON(html);
				if (!data.ok) {
					for(var i=0; i < data.errors.length; i++) {
						$('#f_' + data.errors[i]).addClass('has-error');
						$('input[name="' + data.errors[i] + '"]').tooltip({
							title: 'Required field',
							placement: 'bottom'
						});
					}
					$('body').scrollTo('#f_' + data.errors[0], 500 );
				} else {
					$('#successModal').modal('show');
					$('#form<?=$form['form_id'];?>')[0].reset();
					setTimeout(function(){
						location.reload();
					}, 2000);
				}
			}
		})
	});
})
var file_names = new Array();
var uploader = new plupload.Uploader({
	runtimes : 'html5,flash,silverlight,html4',
	browse_button : 'pickfiles', // you can pass in id...
	container: document.getElementById('upload_container'), // ... or DOM Element itself
	url : '<?=base_url();?>public/form/<?=$form['form_id'];?>/upload_files',
	chunk_size: '400kb',
    max_retries: 5,
    unique_names: true,
	flash_swf_url : '<?=base_url();?>assets/js/plupload/Moxie.swf',
	silverlight_xap_url : '<?=base_url();?>assets/js/plupload/Moxie.xap',

	filters : {
		max_file_size : '20mb',
		mime_types: [
			{title : "Image files", extensions : "jpg,gif,png"}
		]
	},

	init: {
		PostInit: function() {
			$('#console').html('');
			$('#filelist').html('');
			$('#uploadfiles').click(function() {
				uploader.start();
				return false;
			});
		},

		FilesAdded: function(up, files) {
			$('#upload-progress').parent().css("visibility", "visible");

			plupload.each(files, function(file) {
				$('#filelist').append('<div id="' + file.id + '">' + file.name + ' (' + plupload.formatSize(file.size) + ') <b></b></div>');
			});
		},

		UploadProgress: function(up, file) {
			document.getElementById(file.id).getElementsByTagName('b')[0].innerHTML = '<span>' + file.percent + "%</span>";
			$('#upload-progress').attr('aria-valuenow', 60);
			$('#upload-progress').css("width", file.percent + "%");
			$('#upload-progress').html(file.percent + '% completed');
		},
		UploadComplete: function(up, files) {
			// On complete
			file_names.length = 0;
			$('#uploaded_photos').html('');
			plupload.each(files, function(file) {
				$('#uploaded_photos').append('<span><img class="img-thumbnail" src="<?=base_url() . UPLOADS_URL;?>/tmp/' + file.target_name + '" /><i class="fa fa-times" onClick="remove_file(this,\'' + file.id + '\',\'' + file.target_name + '\')"></i></span>');
				file_names.push(file.target_name);
			});
			if (file_names.length > 0) {
				$('#field_pictures').val(JSON.stringify(file_names));
			} else {
				$('#field_pictures').val('');
			}
			$('#upload-progress').parent().css("visibility", "hidden");
			$('#upload-progress').css("width", "0%");
			$('#upload-progress').html('0%');
			$('#console').html('');
			$('#filelist').html('');
		},

		Error: function(up, err) {
			$('#console').html('\n&nbsp;<span class="text-danger">Error: ' + err.message + '</span>');
		}
	}
});

uploader.init();
function remove_file(e,id,name) {
	uploader.removeFile(id);
	$(e).parent().remove();
	$('#filelist').find('#' + id).remove();
	var index = file_names.indexOf(name);
	if (index > -1) {
	    file_names.splice(index, 1);
	}
	if (file_names.length > 0) {
		$('#field_pictures').val(JSON.stringify(file_names));
	} else {
		$('#field_pictures').val('');
	}
}
function remove_custom_file(id) {
	$('input[name="' + id + '"]').val('');
	$('#uploaded_file_' + id).html('');
}
</script>
</body>
</html>