<!-- Add Note Modal -->
<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>
            <h4 class="modal-title">Add Note</h4>
        </div>
        <div class="col-md-12">
            <div class="modal-body">
                <h4 class="modal-body-title">Add Note to a Shift</h4>
                <div class="form-group editor-wrap">
                    <label for="name" class="col-sm-2 control-label">Note</label>
                    <div class="col-sm-10">
                      <form id="add-note-form">
                        <textarea class="form-control" name="note" data="required"></textarea>
                        <input type="hidden" name="shift_id" value="<?=$shift_id?>" />
                      </form>
                    </div>
                </div>
                <div class="form-group push full-width">
                     <label for="add-button" class="col-sm-2 control-label">&nbsp;</label>
                    <div class="col-sm-10">
                      <button id="add-note" type="button" class="btn btn-info"><i class="fa fa-plus"></i> Add Note</button>
                    </div>
                </div>
                
                <div id="ajax-existing-notes" class="modal-vertical-scroll push full-width"></div>
                
       		 </div>
        </div>
    </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
<script>
$(function(){
	//add note
	$('#add-note').on('click',function(){
		if(help.validate_form('add-note-form')){
			add_note();
		}
	});
	
	//list existing notes
	load_existing_notes(<?=$shift_id?>);
	
});


function add_note(){
	$.ajax({
		type: 'POST',
		url: '<?=base_url();?>job/ajax_shift/add_note',
		data:$('#add-note-form').serialize(),
		success: function(html) {
			load_existing_notes(<?=$shift_id?>);
		}
	});	 
}

function load_existing_notes(shift_id){
	$.ajax({
		type: 'POST',
		url: '<?=base_url();?>job/ajax_shift/load_shift_notes',
		data:{shift_id:shift_id},
		success: function(html) {
			$('#ajax-existing-notes').html(html);
		}
	});	 
}

function delete_shift_note(job_shift_note_id)
{
	$.ajax({
		type: 'POST',
		url: '<?=base_url();?>job/ajax_shift/delete_shift_note',
		data:{job_shift_note_id:job_shift_note_id},
		success: function(html) {
			load_existing_notes(<?=$shift_id?>);
		}
	});		
}
</script>
