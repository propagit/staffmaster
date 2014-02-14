<form name="addthumbForm" method="post" enctype="multipart/form-data" action="<?=base_url()?>common/upload_picture_file/<?=$field_name?>">
<input type="hidden" name="<?=$field_name?>" id="<?=$field_name?>" value="<?=$field_value?>">
<div class="form-group">
        <label for="name_edit" class="col-sm-2 control-label">Image</label>
        <div class="col-sm-10">
			<div class="fileupload fileupload-staff" data-provides="fileupload" >        
                <span class="btn btn-file">
                    <i class="fa fa-cloud-upload"></i>
                    <span class="fileupload-new">Select file</span>
                    <span class="fileupload-exists">Change</span>         
                    <input type="file" name="userfile"/>
                </span>
                <span class="fileupload-preview"></span>
                <a href="#" class="fileupload-exists" data-dismiss="fileupload" style="float: none"><i class="fa fa-trash-o"></i></a>
            </div> 
           
        </div>
</div>
<div class="form-group">
	<label class="col-sm-2 control-label" for="edit-button"> </label>
	<div class="col-sm-10">
		<button id="edit-role" class="btn btn-info" type="submit">Add Image</button>
	</div>
</div>
     
</form>