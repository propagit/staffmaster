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
                    	<form id="add-brief-to-shift-form">
						<?=modules::run('brief/brief_select_field','existing_brief');?>
                        <input type="hidden" name="shift_id" value="<?=$shift_id;?>" />
                        </form>
                        <button type="button" class="btn btn-core" id="add-brief-to-shift"><i class="fa fa-plus"></i> Add</button>
					</div>
				</div>
                <h4 class="modal-body-title">Briefs Attached To This Shift</h4>
                <div id="ajax-existing-brief"></div>
                
                <div class="form-group add-top-margin-20 hide"  id="msg-duplicate">
                      <div class="col-sm-12 remove-gutters">
                           <div class="alert alert-danger"><i class="fa fa-times"></i> &nbsp; This Brief is already attached to this shift.</div>
                      </div>
                 </div>
            </div>
        </div>
    </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->


<script>
$(function(){
	load_existing_shift_briefs(<?=$shift_id;?>);
	
	$('#add-brief-to-shift').on('click',function(){
		add_brief_to_shift();
	});
});//ready

function load_existing_shift_briefs(shift_id){
	$.ajax({
		type: "POST",
		url: "<?=base_url();?>job/ajax_shift/load_shift_briefs",
		data: {shift_id:shift_id},
		success: function(html) {
			$('#ajax-existing-brief').html(html);
		}
	});
}

function add_brief_to_shift()
{
	$.ajax({
		type: "POST",
		url: "<?=base_url();?>job/ajax_shift/add_brief",
		data: $('#add-brief-to-shift-form').serialize(),
		success: function(html) {
			if(html == 'duplicate'){
				$('#msg-duplicate').removeClass('hide');
				setTimeout(function(){
					$('#msg-duplicate').addClass('hide');
				}, 3000);
			}else{
				load_existing_shift_briefs(<?=$shift_id;?>);
			}
		}
	});	
}

function delete_shift_brief(shift_brief_id)
{
	$.ajax({
		type: "POST",
		url: "<?=base_url();?>job/ajax_shift/delete_shift_brief",
		data: {shift_brief_id:shift_brief_id},
		success: function(html) {
			load_existing_shift_briefs(<?=$shift_id;?>);
		}
	});	
}

</script>