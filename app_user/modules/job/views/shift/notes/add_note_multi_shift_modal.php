<!-- Add Note Modal -->
<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>
            <h4 class="modal-title">Add Note</h4>
        </div>
        <div class="col-md-12">
            <div class="modal-body">
                <h4 class="modal-body-title">Add Note to Selected Shifts</h4>
                <div class="form-group editor-wrap">
                    <label for="name" class="col-sm-2 control-label">Note</label>
                    <div class="col-sm-10">
                      <form id="add-note-to-multi-shift-form">
                        <textarea class="form-control" name="note" data="required"></textarea>
                        <input type="hidden" name="shift_ids" value="<?=$shift_ids?>" />
                      </form>
                    </div>
                </div>
                <div class="form-group push full-width">
                     <label for="add-button" class="col-sm-2 control-label">&nbsp;</label>
                    <div class="col-sm-10">
                      <button id="add-note-to-multi-shift" type="button" class="btn btn-info"><i class="fa fa-plus"></i> Add Note</button>
                    </div>
                </div>
                
                <div class="form-group add-top-margin-20 hide"  id="msg-success">
                  <div class="col-sm-12 remove-gutters">
                       <div class="alert alert-success"><i class="fa fa-times"></i> &nbsp; Note successfully added to selected Shifts.</div>
                  </div>
             	</div>
                                
       		 </div>
        </div>
    </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
<script>
$(function(){
	//add brief
	$('#add-note-to-multi-shift').on('click',function(){
		if(help.validate_form('add-note-to-multi-shift-form')){
			add_note_to_multi_shift();
		}
	});
});//ready

//add note to multiple shifts
function add_note_to_multi_shift()
{
	$.ajax({
		type: "POST",
		url: "<?=base_url();?>job/ajax_shift/add_note_multi_shift",
		data: $('#add-note-to-multi-shift-form').serialize(),
		success: function(html) {
			  $('#msg-success').removeClass('hide');
			  setTimeout(function(){
				  $('#msg-success').addClass('hide');
			  }, 3000);
		}
	});	
}

</script>