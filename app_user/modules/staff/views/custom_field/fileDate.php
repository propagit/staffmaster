<?php
	$label = json_decode($field['label']);
?>

<div class="form-group" id="field_fileDate_file_<?=$user_id;?>_<?=$field['field_id'];?>">
	<label class="col-md-2 control-label"><?=$label->file_label;?></label>
	<div class="col-md-6">
		<? $field_value = json_decode($field['staff_value']);
			$files = $field_value->files;
			#print_r($files);
			#exit;
		if (count($files) > 0) {
			foreach($files as $file) { ?>
				<?=modules::run('common/mime_to_icon', UPLOADS_PATH . '/staff/ ' . $user_id . '/' . $file);?>  &nbsp; <a target="_blank" href="<?=base_url().UPLOADS_URL;?>/staff/<?=$user_id;?>/<?=$file;?>">Download</a>
				<i title="Delete File" class="fa fa-times custom-file-delete" onclick="delete_file_field(<?=$user_id;?>,<?=$field['field_id'];?>,'<?=$file;?>')"></i><br />
			<? }	
		} ?>
	
		<div id="filelist_<?=$field['field_id'];?>"><!-- Your browser doesn't have Flash, Silverlight or HTML5 support. --></div>
		<div class="progress progress-striped active" style="visibility: hidden;">
			<div class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;" id="upload-progress_<?=$field['field_id'];?>">
				0%
			</div>
		</div>
		<div id="upload_container_<?=$field['field_id'];?>">
		    <button id="pickfiles_<?=$field['field_id'];?>" href="javascript:;" class="btn btn-core">Select files</button>
		    <button id="uploadfiles_<?=$field['field_id'];?>" href="javascript:;" class="btn btn-core">Upload files</button>
            <span id="console_<?=$field['field_id'];?>"></span>
		</div>
	</div>
</div>

<div class="form-group" id="field_fileDate_file_<?=$user_id;?>_<?=$field['field_id'];?>">
    <label class="col-md-2 control-label"><?=$label->date_label;?></label>
   <div class="col-md-4">
        <div class="input-group date" id="file_date_<?=$field['field_id'];?>">
            <input type="text" class="form-control" name="fields[<?=$field['field_id'];?>]" readonly />
            <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
            <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
        </div>
    </div>
</div>

<script>
$(function(){
	$('#file_date_<?=$field['field_id'];?>').datetimepicker({
        weekStart: 1,
        todayBtn:  1,
		autoclose: 1,
		todayHighlight: 1,
		startView: 2,
        minView: 2,
		forceParse: 1,
        format: 'dd-mm-yyyy',
    });
	
});


var uploader_<?=$field['field_id'];?> = new plupload.Uploader({
	runtimes : 'html5,flash,silverlight,html4',
	browse_button : 'pickfiles_<?=$field['field_id'];?>', // you can pass in id...
	container: document.getElementById('upload_container_<?=$field['field_id'];?>'), // ... or DOM Element itself
	url : '<?=base_url();?>staff/ajax/upload_custom_files/<?=$user_id;?>/<?=$field['field_id'];?>',
	chunk_size: '400kb',
    max_retries: 5,
	flash_swf_url : '<?=base_url();?>assets/js/plupload/Moxie.swf',
	silverlight_xap_url : '<?=base_url();?>assets/js/plupload/Moxie.xap',

	filters : {
		max_file_size : '20mb',
		mime_types: [
			{title : "Image files", extensions : "jpg,gif,png"},
			{title : "Document files", extensions : "pdf,doc,docx,ppt,xls"}
		]
	},

	init: {
		PostInit: function() {
			$('#console_<?=$field['field_id'];?>').html('');
			$('#filelist_<?=$field['field_id'];?>').html('');
			$('#uploadfiles_<?=$field['field_id'];?>').click(function() {
				uploader_<?=$field['field_id'];?>.start();
				return false;
			});
		},

		FilesAdded: function(up, files) {
			$('#upload-progress_<?=$field['field_id'];?>').parent().css("visibility", "visible");

			plupload.each(files, function(file) {
				document.getElementById('filelist_<?=$field['field_id'];?>').innerHTML += '<div id="' + file.id + '">' + file.name + ' (' + plupload.formatSize(file.size) + ') <b></b></div>';
			});
		},

		UploadProgress: function(up, file) {
			document.getElementById(file.id).getElementsByTagName('b')[0].innerHTML = '<span>' + file.percent + "%</span>";
			$('#upload-progress_<?=$field['field_id'];?>').attr('aria-valuenow', 60);
			$('#upload-progress_<?=$field['field_id'];?>').css("width", file.percent + "%");
			$('#upload-progress_<?=$field['field_id'];?>').html(file.percent + '% completed');
		},
		UploadComplete: function() {
			load_file_field(<?=$user_id;?>,<?=$field['field_id'];?>);
		},

		Error: function(up, err) {
			$('#console_<?=$field['field_id'];?>').html("\nError: " + err.message);
		}
	}
});

uploader_<?=$field['field_id'];?>.init();
</script>