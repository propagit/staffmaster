<div class="row" id="field_<?=$field['field_id'];?>">
    <div class="form-group">
        <label class="col-md-2 control-label"><?=$field['label'];?></label>
       <div class="col-md-4">
            <label class="radio custom-inline">
                <input type="radio" name="search_file_<?=$field['field_id'];?>" value="yes" >
                Yes 
            </label>
            <label class="radio custom-inline">
                <input type="radio" name="search_file_<?=$field['field_id'];?>" value="no" >
                No
            </label>
        </div>
    </div>
</div>
