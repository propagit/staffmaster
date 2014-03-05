<div class="col-md-12">
	<div class="box top-box">
		<h2>Search Clients</h2>
		<p>Search and manage your client list.</p>         
    </div>
</div>

<div class="col-md-12">
	<div class="box bottom-box">
    	<div class="inner-box">
            <h2>Search Client</h2>
            <p>Search and manage your client list.</p>
            <form class="form-horizontal" role="form" id="form_search_clients">
            
            <div class="row">
				<div class="form-group">
					<label for="keyword" class="col-md-2 control-label">Company name</label>
					<div class="col-md-4">
						<input type="text" class="form-control" id="keyword" name="keyword" placeholder="Enter keywords..." />
					</div>
				</div>
			</div>
            
            <div class="row">
				<div class="form-group">
					<div class="col-md-offset-2 col-md-4">
						<button type="button" class="btn btn-core" id="btn_search_clients"><i class="fa fa-search"></i> Search Staff</button>
						&nbsp;
						<button type="reset" class="btn btn-default"><i class="fa fa-refresh"></i> Reset</button>
					</div>
				</div>
			</div>
            <input type="hidden" name="sort_by" id="sort-by" value="company_name" />
            <input type="hidden" name="sort_order" id="sort-order" value="asc" />	
            <input type="hidden" name="current_page"  id="current_page" value="1"  />
			</form>
			
			<div id="clients_search_results"></div>            
        </div>
    </div>
</div> 

<!-- Multi Status Modal-->
<div class="modal fade" id="updateMultiStatus" tabindex="-1" role="dialog" aria-labelledby="updateStatusLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>
				<h4 class="modal-title">Update Selected Status</h4>
			</div>
			<form id="add-new-venue-form">
            <div class="col-md-12">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="name" class="col-sm-2 control-label">Status</label>
                        <div class="col-sm-10">
                           <?=modules::run('client/field_select_status', 'client_multi_status_update');?>
                        </div>
                    </div>
                    
                   
                     <div class="form-group">
                               <label for="add-button" class="col-sm-2 control-label">&nbsp;</label>
                          <div class="col-sm-10">
                              <button onclick="update_multiple_selected_status();"  type="button" class="btn btn-info"><i class="fa fa-save"></i> Update Status</button>
                          </div>
                      </div>
                </div>
            </div>
			</form>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->   

<script>
$(function(){
	search_clients();
	$('#btn_search_clients').click(function(){
		search_clients();
	})
	
	//prevent form sumbit on enter and instead do ajax search
	$('#form_search_clients').bind("keyup keypress", function(e) {
		  var code = e.keyCode || e.which; 
		  if (code  == 13) {               
			e.preventDefault();
			reset_page();
			search_clients();
		  }
	});
})
function reset_page()
{
	$('#current_page').val(1);
}
function search_clients() {
	preloading($('#clients_search_results'));
	$.ajax({
		type: "POST",
		url: "<?=base_url();?>client/ajax/search_clients",
		data: $('#form_search_clients').serialize(),
		success: function(html) {
			loaded($('#clients_search_results'), html);
			$('body').scrollTo('#form_search_clients', 500 );
		}
	})
}

function delete_client(user_id){
	$.ajax({
		type: "POST",
		url: "<?=base_url();?>client/ajax/delete_client",
		data: {user_id:user_id},
		success: function(html) {
			$('#search-result-tr-'+user_id).remove();
		}
	})
}
function perform_multi_update(action){
	switch(action){
		case 'contact-multi-clients':
			
		break;
		case 'delete-multi-clients':
			delete_multi_clients();
		break;
		case 'change-multi-status':
			$('#updateMultiStatus').modal('show');
		break;
		case 'export-clients':
		
		break;	
	}
}

function delete_multi_clients(){
		var title = 'Delete Clients';
		var message ='Are you sure you would like to delete these "Clients"';
		var user_id = $(this).attr('delete-data-id');
		help.confirm_delete(title,message,function(confirmed){
			 if(confirmed){
				$.ajax({
						type: "POST",
						url: "<?=base_url();?>client/ajax/delete_multi_clients",
						data: $('#client-search-results-form').serialize(),
						success: function(html) {
							reset_page();
							search_clients();
						}
					});
			 }
		});
}


function update_multiple_selected_status()
{
	var new_status = $('#client_multi_status_update').val();
	$('#client-search-results-form').append('<input type="hidden" name="new_multi_status" value="'+new_status+'" />');	
	$.ajax({
		  type: "POST",
		  url: "<?=base_url();?>client/ajax/update_status_multi_clients",
		  data: $('#client-search-results-form').serialize(),
		  success: function(html) {
			  $('#updateMultiStatus').modal('hide');
			  reset_page();
			  search_clients();
		  }
	  });
}
</script>