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
					<div class="col-md-6">
						<input type="text" class="form-control" id="keyword" name="keyword" placeholder="Enter keywords..." />
					</div>
					<div class="col-md-4">
						<button type="button" class="btn btn-core" id="btn_search_clients"><i class="fa fa-search"></i> Search Staff</button>
						&nbsp;
						<button type="reset" class="btn btn-default"><i class="fa fa-refresh"></i> Reset</button>
					</div>
				</div>
			</div>	
			</form>
			
			<div id="clients_search_results"></div>            
        </div>
    </div>
</div>    

<script>
$(function(){
	search_clients();
	$('#btn_search_clients').click(function(){
		search_clients();
	})
})
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
</script>