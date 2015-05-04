<form id="user-note-form">
    <div id="n_user_id" class="form-group">
        <label for="job_type" class="col-lg-2 remove-gutters control-label">Add Note To</label>
        <div class="col-lg-10">
            <?=modules::run('user/field_select', 'user_id');?>
        </div>
    </div>
    <div id="n_note" class="form-group">
        <label class="col-lg-2 control-label remove-gutters">Note</label>
        <div class="col-lg-10">
            <textarea id="user-note" class="form-control" name="note"></textarea>
        </div>
    </div>
    <div class="form-group" style="padding-top:20px;">
        <label class="col-lg-2 control-label remove-gutters">&nbsp;</label>
        <div class="col-lg-10">
            <button id="add-user-note" type="button" class="btn btn btn-core pull"><i class="fa fa-comment-o"></i>Add Note</button>
        </div>
    </div>
</form>

<?php
	/** 
		script to add note is in 
		
		modules/user_notes/views/main_view
	
	*/
?>


