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
</head>
<body>


<br />
<!-- Begin page content -->
<div class="container-fluid">
    <div class="row">
    	<span class="text-red">**</span> Required Field
    	<h2>Personal Details</h2>
    	<p class="text-muted">Please fill in your personal details</p>
    	<form class="form-horizontal" role="form" method="post">
    	<? foreach($personal_fields as $name => $field) { if(isset($field['active'])) { ?>
			<div class="form-group">
				<label for="<?=$name;?>" class="col-sm-2 control-label">
					<?=$field['label'];?>
					<? if(isset($field['required'])) { ?>
						<span class="text-red">**</span>
					<? } ?>
				</label>
				<div class="col-sm-10">
					<? if($name == 'title') { ?>
					<?=modules::run('common/field_select_title', $name);?>
					<? } else if ($name == 'gender') { ?>
					<?=modules::run('common/field_select_genders', $name);?>
					<? } else if ($name == 'dob') { ?>
					<?=modules::run('common/dropdown_dob');?>
					<? } else if ($name == 'state') { ?>
					<?=modules::run('common/field_select_states', $name);?>
					<? } else if ($name == 'country') { ?>
					<?=modules::run('common/field_select_countries', $name);?>
					<? } else { ?>
					<input type="text" class="form-control" id="<?=$name;?>" name="<?=$name;?>" />
					<? } ?>
				</div>
			</div>
    	<? } } ?>
    	
    	<? foreach($extra_fields as $name => $field) { if (isset($field['active'])) { ?>
    	<hr />
	    <h2><?=$field['label'];?></h2>
	    	<? if($name == 'role' && count($roles) > 0) { ?>
    			<p class="text-muted">Please let us know what roles you could perform for us</p>
    			<? foreach($roles as $role) { ?>
    			<div class="checkbox checkbox_role">
					<label>
						<input type="checkbox"> <?=$role['name'];?>
					</label>
				</div>
    			<? }
    		} else if ($name == 'availability') { ?>
    			<p class="text-muted">Let us know what days you can work on</p>
    			<? $days = modules::run('common/array_day'); 
    				foreach($days as $day_no => $day_label) { ?>
    			<div class="checkbox checkbox_day">
					<label>
						<input type="checkbox"> <?=$day_label;?>
					</label>
				</div>	
    			<? }
    		} else if ($name == 'location') { ?>
    			<p class="text-muted">Let us know where you can work</p>
    			<?=modules::run('attribute/location/field_select', 'location_parent_id');?>
    			<div class="clear"></div>
    		<? } else if ($name == 'group' && count($groups) > 0) { ?>
    			<p class="text-muted">Please let us know what group you want to join</p>
    			<? foreach($groups as $group) { ?>
    			<div class="checkbox">
					<label>
						<input type="checkbox"> <?=$group['name'];?>
					</label>
				</div>
    			<? }
    		} else if ($name == 'picture') { ?>
    		<p class="text-muted">Upload photos of yourself so we have a visual refereance of you</p>
			<div id="filelist"><!-- Your browser doesn't have Flash, Silverlight or HTML5 support. --></div>
		<div class="progress progress-striped active" style="visibility: hidden;">
			<div class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;" id="upload-progress">
				0%
			</div>
		</div>
		<div id="upload_container">
		    <button id="pickfiles" href="javascript:;" class="btn btn-core">Select files</button>
		    <button id="uploadfiles" href="javascript:;" class="btn btn-core">Upload files</button>
            <span id="console"></span>
		</div>
		

    		<? } ?>
    	<? } } ?>    		
    	<hr />
    	<h2>Additional Information</h2>
    	<p class="text-muted">Please provide us with the below information</p>
    	<? foreach($custom_fields as $field) { ?>
    		<div class="form-group">
				<label for="<?=$name;?>" class="col-sm-2 control-label">
					<?=$field['label'];?>
					<? if($field['required']) { ?>
						<span class="text-red">**</span>
					<? } ?>
				</label>
				<div class="col-sm-10">
					<? if($field['type'] == 'text') { ?>
					<input id="textinput" type="text" placeholder="<?=$field['placeholder'];?>" class="form-control" />
					<? } else if ($field['type'] == 'textarea') { ?>
					<textarea id="textarea" class="form-control"></textarea>
					<? } else if ($field['type'] == 'checkbox') { ?>
					<?php
				   		$attrs = json_decode($field['attributes']);
						$values = array();
				   		if ($attrs) {
							foreach($attrs as $attr){ ?>
							<label class="checkbox <?=($field['inline'] == 'true' ? 'custom-inline' : '' );?>">
								<input type="checkbox" name="fields[<?=$field['field_id'];?>][]" value="<?=$attr;?>" <?=(in_array($attr, $values)) ? 'checked="checked"' : '';?>	/> <?=$attr;?>
							</label>
					<?php 	}
						} ?>
					<? } else if ($field['type'] == 'select') { ?>
					<select name="fields[<?=$field['field_id'];?>]<?=($field['multiple'] == 'true' ? '[]' : '');?>" class="form-control" <?=($field['multiple'] == 'true' ? 'multiple="multiple"' : '');?>>
			   			<? $value = '';
			   			if ($field['multiple'] != "true") { ?>
			   			<option value="">Select One</option>
			   			<? } else { $value = json_decode($value);  } ?>
						<? $attrs = json_decode($field['attributes']);
						if($attrs) {
							foreach($attrs as $attr) { 
								$selected = '';
								if($field['multiple'] == "true") {
									if(in_array($attr, $value)){
			                        	$selected = 'selected="selected"';
			                        }
								} else { # Single value
									if($attr == $value) {
										$selected = 'selected="selected"';	
									}
								}
							?>
						<option value="<?=$attr;?>" <?=$selected;?>><?=$attr;?></option>
						<? }
						} ?>
					</select>
					<? } else if ($field['type'] == 'radio') { ?>
					<?php
					   	$attrs = json_decode($field['attributes']);
						if($attrs){
							foreach($attrs as $attr){ ?>
							<label class="radio <?=($field['inline'] == 'true' ? 'custom-inline' : '' );?>">
								<input type="radio" name="fields[<?=$field['field_id'];?>]" value="<?=$attr;?>" />	<?=$attr;?>
							</label>
					<?php 	}
						} ?>
					<? } else if ($field['type'] == 'file') { ?>
					
					<div class="fileinput fileinput-new" data-provides="fileinput">
					<span class="btn btn-default btn-file"><span class="fileinput-new">Select file</span><input type="file" name="..."></span>
					<span class="fileinput-filename"></span>
					<a href="#" class="close fileinput-exists" data-dismiss="fileinput" style="float: none">&times;</a>
					</div>

					<? } ?>
				</div>
    		</div>
    	<? } ?>
    		<div class="form-group">
    			<label class="col-sm-2 control-label">&nbsp;</label>
    			<div class="col-sm-10"><button type="submit" class="btn btn-core">Apply Now</button></div>
    		</div>
    	</form>
    </div>
</div>
<script>
$(function(){
	init_select();
})
var uploader = new plupload.Uploader({
	runtimes : 'html5,flash,silverlight,html4',
	browse_button : 'pickfiles', // you can pass in id...
	container: document.getElementById('upload_container'), // ... or DOM Element itself
	url : '<?=base_url();?>public/form/upload_pictures',
	chunk_size: '400kb',
    max_retries: 5,
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
				document.getElementById('filelist').innerHTML += '<div id="' + file.id + '">' + file.name + ' (' + plupload.formatSize(file.size) + ') <b></b></div>';
			});
		},

		UploadProgress: function(up, file) {
			document.getElementById(file.id).getElementsByTagName('b')[0].innerHTML = '<span>' + file.percent + "%</span>";
			$('#upload-progress').attr('aria-valuenow', 60);
			$('#upload-progress').css("width", file.percent + "%");
			$('#upload-progress').html(file.percent + '% completed');
		},
		UploadComplete: function() {
			// On complete
		},

		Error: function(up, err) {
			$('#console').html('\n&nbsp;<span class="text-danger">Error: ' + err.message + '</span>');
		}
	}
});

uploader.init();
</script>
</body>
</html>