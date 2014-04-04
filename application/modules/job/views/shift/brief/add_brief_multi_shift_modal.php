<!-- Add Brief Modal -->
<div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>
            <h4 class="modal-title">Add Brief</h4>
        </div>
        <div class="col-md-12">
            <div class="modal-body">
            	<h4 class="modal-body-title">Add Brief <a class="modal-link" target="_blank" href="<?=base_url();?>brief">&nbsp;&nbsp;<i class="fa fa-pencil"></i> Create New Brief</a></h4>
                <div class="form-group add-brief-to-shift-modal-form">
					<label for="staff_name" class="col-md-2 control-label remove-gutters">Existing Briefs</label>
					<div class="col-md-10 add-brief-to-shift-select-wrap">
                    	<form id="add-brief-to-multi-shift-form">
						<?=modules::run('brief/brief_select_field','existing_brief');?>
                        <input type="hidden" name="shift_ids" value="<?=$shift_ids;?>" />
                        </form>
                        <button type="button" class="btn btn-core" id="add-brief-to-multi-shift"><i class="fa fa-plus"></i> Add</button>
                        <button type="button" class="btn btn-core" id="remove-brief-to-multi-shift"><i class="fa fa-times"></i> Remove</button>
					</div>
				</div>
                
                <div class="form-group add-top-margin-20 hide"  id="msg-success">
                      <div class="col-sm-12 remove-gutters">
                           <div class="alert alert-success"><i class="fa fa-times"></i> &nbsp; Brief successfully attached to selected Shifts.</div>
                      </div>
                 </div>
                 <div class="form-group add-top-margin-20 hide"  id="msg-success-remove">
                      <div class="col-sm-12 remove-gutters">
                           <div class="alert alert-success"><i class="fa fa-times"></i> &nbsp; Brief successfully removed from selected Shifts.</div>
                      </div>
                 </div>
            </div>
        </div>
    </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->


<script>
$(function(){
	//add brief
	$('#add-brief-to-multi-shift').on('click',function(){
		add_brief_to_multi_shift();
	});
	
	//remove brief
	$('#remove-brief-to-multi-shift').on('click',function(){
		remove_brief_from_multi_shift();
	});
});//ready

//add multi brief
function add_brief_to_multi_shift()
{
	$.ajax({
		type: "POST",
		url: "<?=base_url();?>job/ajax_shift/add_brief_multi_shift",
		data: $('#add-brief-to-multi-shift-form').serialize(),
		success: function(html) {
			  $('#msg-success').removeClass('hide');
			  setTimeout(function(){
				  $('#msg-success').addClass('hide');
			  }, 3000);
		}
	});	
}
//remove multi brief
function remove_brief_from_multi_shift()
{
	$.ajax({
		type: "POST",
		url: "<?=base_url();?>job/ajax_shift/remove_brief_multi_shift",
		data: $('#add-brief-to-multi-shift-form').serialize(),
		success: function(html) {
			  $('#msg-success-remove').removeClass('hide');
			  setTimeout(function(){
				  $('#msg-success-remove').addClass('hide');
			  }, 3000);
		}
	});	
}

</script>