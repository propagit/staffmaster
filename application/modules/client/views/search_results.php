<hr />
<h2>Search Results</h2>
<p>Your search returned <b><?=count($total_clients);?></b> results</p>
<ul class="pagination pull">
<?=modules::run('common/create_pagination',count($total_clients),5,$current_page)?>
</ul>
<?php
	$array = array(
				array('value' => 'contact-multi-clients','label' =>'<i class="fa fa-envelope-o"></i> Contact Clients'),
				array('value' => 'delete-multi-clients','label' =>'<i class="fa fa-times"></i> Delete Clients'),
				array('value' => 'change-multi-status','label' =>'<i class="fa fa-thumbs-o-up"></i> Change Selected Status'),
				array('value' => 'export-clients','label' =>'<i class="fa fa-download"></i> Export Selected')
				);

	$id = 'search-client-result-action';
	$label = 'Actions';
	echo modules::run('common/menu_dropdown',$array,$id,$label);
	
?>
<? if (isset($clients)) { ?>
<div class="table-responsive">
<table class="table table-bordered table-hover table-middle table-expanded">
    <thead>
    <tr>
    	<th class="center"><input type="checkbox" id="master-checkbox" /></th>
        <th class="left col-md-3">Company Name <i class="fa fa-sort sort-result" sort-by="c.company_name"></i></td>
        <th class="center">Jobs <!--<i class="fa fa-sort sort-result" sort-by=""></i>--></th>
        <th class="center">Jobs This Year <!--<i class="fa fa-sort sort-result" sort-by="total_jobs_this_year"></i>--></th>
        <th class="center">Status <i class="fa fa-sort sort-result" sort-by="u.status"></i></th>
        <th class="center">View</th>
        <th class="center">Delete</th>
    </tr>
    </thead>
    <? foreach($clients as $client) { ?>
    <tr>
    	<td class="center"><input type="checkbox" name="user_client_selected_user_id[]" value="<?=$client['user_id'];?>" class="checkbox-multi-action" /></td>
        <td class="left"><?=$client['company_name'];?></td>
        <td class="center"><?=modules::run('client/get_client_total_jobs',$client['user_id']);?></td>
        <td class="center"><?=modules::run('client/get_client_total_jobs',$client['user_id'],date('Y'));?></td>
        <td class="center"><?=($client['status'] != 0 ? ($client['status'] == 1 ? 'Active' : 'Inactive') : 'Pending');?></td>
        <td class="center"><a href="<?=base_url();?>client/edit/<?=$client['user_id'];?>"><i class="fa fa-eye"></i></a></td>
        <td class="center"><a><i class="fa fa-times"></i></a></td>
        
    </tr>
    <? } ?>
</table>
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
		reset_page();
		search_clients();
	});	
	
	//go to page
	$('.pagination li').on('click',function(e){
		e.preventDefault();
		scroll_to_form = false;
		var clicked_page = $(this).attr('data-page-no');
		$('#current_page').val(clicked_page);
		search_clients();
	});
});//ready
</script>