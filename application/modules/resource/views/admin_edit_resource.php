<ul class="breadcrumb">
	<li><a href="<?=base_url();?>admin/resource">Resources Management</a> <span class="divider">/</span></li>
	<li class="active">Edit Resource</li>
</ul>
<? if (isset($updated)) { ?>
<div class="alert alert-success">
	You have updated resource successfully!
</div>
<? } ?>
<div class="box">
<form method="post" action="<?=base_url();?>admin/resource/edit/<?=$resource['resource_id'];?>">
	<div class="form-horizontal">
		<div class="control-group">
			<label class="control-label" for="resource_title">Resource Title</label>
			<div class="controls">
				<input type="text" id="resource_title" name="resource_title" value="<?=$resource['resource_title'];?>" />
			</div>
		</div>
		<div class="control-group textarea">
			<label class="control-label" for="resource_description">Resource Description</label>
			<div class="controls">
				<textarea rows="10" id="resource_description" name="resource_description"><?=$resource['resource_description'];?></textarea>
			</div>
		</div>
		<div class="control-group">
			<label class="control-label" for="survey_link">Survey Link</label>
			<div class="controls">
				<input type="text" class="input-xxlarge" id="survey_link" name="survey_link" placeholder="http://" value="<?=$resource['survey_link'];?>" />
			</div>
		</div>
		<div class="control-group">
			<label class="control-label" for="youtube_link">Embed Video</label>
			<div class="controls">
				<input type="text" class="input-xxlarge" id="youtube_link" name="youtube_link" placeholder="http://" value="<?=$resource['youtube_link'];?>" />
			</div>
		</div>
		<? if($resource['youtube_link']) { 
			$url = str_replace('/watch?v=', '/v/', $resource['youtube_link']);
			$url = str_replace('youtu.be/', 'www.youtube.com/v/', $url);
		?>
		<div class="control-group textarea">
			<label class="control-label">Video Preview</label>
			<div class="controls">
				<object width="412" height="232"><param name="movie" value="<?=$url;?>?hl=en_US&amp;version=3"></param><param name="allowFullScreen" value="true"></param><param name="allowscriptaccess" value="always"></param><embed src="<?=$url;?>?hl=en_US&amp;version=3" type="application/x-shockwave-flash" width="412" height="232" allowscriptaccess="always" allowfullscreen="true"></embed></object>
			</div>
		</div>
		<? } ?>
		
		<div class="control-group">
			<label class="control-label" for="margin"></label>
			<div class="controls">
				<button class="btn" type="submit">Update Resource</button>
			</div>
		</div>
	</div>
</form>
</div>
<div class="btn-breadcrumb pull-right">
	<form method="post" enctype="multipart/form-data" action="<?=base_url();?>admin/resource/upload/<?=$resource['resource_id'];?>">
	<div class="fileupload fileupload-new" data-provides="fileupload">
		<div class="input-append">
			<div class="uneditable-input span3">
				<i class="icon-file fileupload-exists"></i> 
				<span class="fileupload-preview"></span>
			</div>
			<span class="btn btn-file">
				<span class="fileupload-new">Select file</span>
				<span class="fileupload-exists">Change</span>
				<input type="file" name="userfile" />
			</span>
			<button type="submit" name="upload_file" class="btn fileupload-exists">Upload File</button>
		</div>
	</div>
</form>
</div>

<ul class="breadcrumb">
	<li class="active">Attachments</li>
</ul>
<? if(count($files) > 0) { ?>
<table class="table table-bordered">
	<thead>
	<tr>
		<td width="80">File Number</td>
		<td>File Name</td>
		<td>Title</td>
		<!-- <td>Uploaded on</td> -->
		<td class="center" width="40"></td>
		<td class="center" width="40"></td>
	</tr>
	</thead>
	<? foreach($files as $file) { ?>
	<tr>
		<td><?=$file['file_id'];?></td>
		<td><a href="<?=base_url();?>uploads/resources/<?=$file['file_name'];?>" target="_blank"><?=$file['file_name'];?></a></td>
		<td><?=$file['orig_name'];?></td>
		<!-- <td><?=time_since($file['createdon']);?></td> -->
		<td class="center">
			<a onclick="edit_file(<?=$file['file_id'];?>,'<?=$file['orig_name'];?>')" class="btn btn-mini btn-info"><i class="icon-pencil icon-white"></i></a>
		</td>
		<td class="center">
			<a onclick="remove_file(<?=$file['file_id'];?>)" class="btn btn-mini btn-danger"><i class="icon-trash icon-white"></i></a>
		</td>
	</tr>
	<? } ?>
</table>
<? } ?>
<div id="myModal" class="modal hide fade">
<form method="post" action="<?=base_url();?>admin/resource/update_file/<?=$resource['resource_id'];?>">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		<h3>Edit File</h3>
	</div>
	<div class="modal-body">
		<input type="hidden" name="file_id" id="file_id" />
		<label for="file_title">File title</label>
		<input type="text" name="file_title" class="input-xxlarge" id="file_title" />
	</div>
	<div class="modal-footer">
		<button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
		<button class="btn btn-primary" type="submit">Save Change</button>
	</div>
</form>
</div>


<script>
function edit_file(file_id, file_title)
{
	$('#file_id').val(file_id);
	$('#file_title').val(file_title);
	$('#myModal').modal('toggle');
}
function remove_file(file_id)
{
	if (confirm('Are you sure you want to delete this file?'))
	{
		window.location = '<?=base_url();?>admin/resource/remove_file/' + file_id;
	}
}
</script>