<hr />
<h2>Search Results</h2>
<p>Your search returned <b><?=count($total_clients);?></b> results</p>
<ul class="pagination custom-pagination pull">
<?=modules::run('common/create_pagination',count($total_clients),CLIENTS_PER_PAGE,$current_page)?>
</ul>
<?php
	$array = array(
				array('value' => 'contact-multi-clients','label' =>'<i class="fa fa-envelope-o"></i> Contact Clients'),
				array('value' => 'delete-multi-clients','label' =>'<i class="fa fa-times"></i> Delete Clients'),
				array('value' => 'change-multi-status','label' =>'<i class="fa fa-thumbs-o-up"></i> Change Selected Status'),
				array('value' => 'export-clients','label' =>'<i class="fa fa-download"></i> Export Selected'),
				array('value' => 'update-job-counts', 'label' => '<i class="fa fa-refresh"></i> Update Job Count')
				);

	$id = 'search-client-result-action';
	$label = 'Actions';
	echo modules::run('common/menu_dropdown',$array,$id,$label);
	
?>
<? if (isset($clients)) { ?>
<div class="table-responsive">
<form id="client-search-results-form">
<table class="table table-bordered table-hover table-middle table-expanded">
    <thead>
    <tr>
    	<th class="center"><input type="checkbox" id="master-checkbox" /></th>
        <th class="left col-md-3">Company Name <i class="fa fa-sort sort-result" sort-by="c.company_name"></i></td>
        <th class="center">Jobs <i class="fa fa-sort sort-result" sort-by="c.total_jobs"></i></th>
        <th class="center">Jobs This Year <i class="fa fa-sort sort-result" sort-by="c.total_jobs_current_year"></i></th>
        <th class="center">Status <i class="fa fa-sort sort-result" sort-by="u.status"></i></th>
        <th class="center">View</th>
        <th class="center">Delete</th>
    </tr>
    </thead>
    <tbody>
    <? foreach($clients as $client) { ?>
    <tr id="search-result-tr-<?=$client['user_id'];?>">
    	<td class="center"><input type="checkbox" name="user_client_selected_user_id[]" value="<?=$client['user_id'];?>" class="checkbox-multi-action" /></td>
        <td class="left"><?=$client['company_name'];?></td>
        <td class="center"><?=$client['total_jobs'];?></td>
        <td class="center"><?=$client['total_jobs_current_year'];?></td>
        <td class="center"><?=($client['status'] != 0 ? ($client['status'] == 1 ? 'Active' : 'Inactive') : 'Pending');?></td>
        <td class="center"><a href="<?=base_url();?>client/edit/<?=$client['user_id'];?>"><i class="fa fa-eye"></i></a></td>
        <td class="center"><i class="fa fa-times delete-client" delete-data-id="<?=$client['user_id'];?>"></i></td>
        
    </tr>
    <? } ?>
    </tbody>
</table>
</form>
</div>
<? } ?>

<script>
$(function(){
	//check uncheck all checkboes
	help.toggle_checkboxes('#master-checkbox','.checkbox-multi-action');
	
	//sort result
	$('.sort-result').on('click',function(){
		var sort_order = $('#sort-order').val();
		$('#sort-order').val(sort_order == 'asc' ? 'desc' : 'asc');
		$('#sort-by').val($(this).attr('sort-by'));
		reset_current_page();
		search_clients();
	});	
	
	//delete single client
	$('.delete-client').on('click',function(){
	var title = 'Delete Client';
	var message ='Are you sure you would like to delete this "Client"';
	var user_id = $(this).attr('delete-data-id');
	help.confirm_delete(title,message,function(confirmed){
		 if(confirmed){
			 delete_client(user_id);
		 }
		});
	});

	$('#menu-search-client-result-action ul li a').on('click',function(){
		var action = $(this).attr('data-value');
		if (action == 'update-job-counts') {
			window.location = '<?=base_url();?>client/update_client_jobs_count';
		} else {
			perform_multi_update(action);
		}
		
	})
	
	//go to page
	$('.pagination li').on('click',function(e){
		e.preventDefault();
		var clicked_page = $(this).attr('data-page-no');
		$('#current_page').val(clicked_page);
		search_clients();
	});
});//ready
</script>