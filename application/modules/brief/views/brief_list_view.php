<!--begin top box--->
<div class="col-md-12">
	<div class="box top-box">
   		 <h2>Brief Builder</h2>
		 <p>
         	Use the brief builder to build briefs and attach them to shifts you create. Your staff will be able to access the briefs when they view their roster or apply to work on shifts you create.
        </p>
    </div>
</div>
<!--end top box-->

<!--begin bottom box -->
<div class="col-md-12">
	<div class="box bottom-box">
    	<div class="inner-box">
        	<button class="btn btn-core create-new-brief" data-toggle="modal" data-target=".bs-modal-sml" href="<?=base_url();?>brief/ajax/load_create_brief_modal"><i class="fa fa-plus"></i> Create New Brief</button>
            <h2>Existing Brief</h2>
            <p>Search for a brief you have created to edit or review it</p>
            <form class="form-horizontal" id="form_search_brief" role="form">
			<div class="row">
				<div class="form-group">
					<label for="staff_name" class="col-md-1 control-label">Search briefs</label>
					<div class="col-md-10">
						<input type="text" class="form-control inline-search" id="keyword" name="keyword" tabindex="2" />
                        <button type="button" class="btn btn-core" id="btn_search_brief"><i class="fa fa-search"></i> Search</button>
					</div>
				</div>
			</div>
            <input type="hidden" name="sort_by" id="sort-by" value="created" />
            <input type="hidden" name="sort_order" id="sort-order" value="asc" />
            <input type="hidden" name="current_page"  id="current_page" value="1"  />
            </form>
            <div id="ajax-brief-lists"></div>
           
        </div>
    </div>
</div>
<!--end bottom box -->

<script>
$(function(){
	search_brief();
	
	$('#btn_search_brief').on('click',function(){
		search_brief();	
	});
});

function search_brief()
{
	preloading($('#ajax-brief-lists'));
	$.ajax({
		type: "POST",
		url: "<?=base_url();?>brief/ajax/search_brief",
		data: $('#form_search_brief').serialize(),
		success: function(html) {
			$('#wrapper_loading').remove();
			$('#ajax-brief-lists').html(html);
		}
	});
}

function change_status(obj)
{
	preloading($('#ajax-brief-lists'));
	var brief_id = obj.attr('data-brief');
	var cur_status = obj.hasClass('btn-danger') ? 'inactive' : 'active';
	$.ajax({
		type: "POST",
		url: "<?=base_url();?>brief/ajax/change_brief_status",
		data: {brief_id:brief_id,cur_status:cur_status},
		success: function(html) {
			if(html == 'success'){
				if(cur_status == 'active'){
					obj.removeClass('btn-success').addClass('btn-danger').html('Inactive');
				}else{
					obj.removeClass('btn-danger').addClass('btn-success').html('Active');
				}
			}
			$('#wrapper_loading').remove();
		}
	});	
}

function delete_brief(brief_id)
{
	preloading($('#ajax-brief-lists'));
	$.ajax({
		type: "POST",
		url: "<?=base_url();?>brief/ajax/delete_brief",
		data: {brief_id:brief_id},
		success: function(html) {
			if(html == 'success'){
				$('#brief-row-'+brief_id).remove();
			}
			$('#wrapper_loading').remove();
		}
	});
}
</script>