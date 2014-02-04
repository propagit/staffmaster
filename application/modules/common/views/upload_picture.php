<form name="addthumbForm" method="post" enctype="multipart/form-data" action="<?=base_url()?>common/upload_picture_file/<?=$field_name?>">
<input type="hidden" name="<?=$field_name?>" id="<?=$field_name?>" value="<?=$field_value?>">
<div class="fileupload fileupload-new" data-provides="fileupload" style="float:left; ">        
    <span class="btn btn-file">
        <i class="fa fa-cloud-upload"></i>
        <span class="fileupload-new">Select file</span>
        <span class="fileupload-exists">Change</span>         
        <input type="file" name="userfile"/>
    </span>
    <span class="fileupload-preview"></span>
    <a href="#" class="fileupload-exists" data-dismiss="fileupload" style="float: none"><i class="fa fa-trash-o"></i></a>
</div> 
<button class="btn btn-info" type="submit" style="float:left; margin-left:10px;">
        <i class="fa fa-plus-circle"></i> Add Image
    </button>       
</form>