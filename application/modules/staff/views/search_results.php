<hr />
<h2>Search Results</h2>
<p>Your search returned <b><?=count($total_staff);?></b> results</p>
<ul class="pagination pull">
<?=modules::run('common/create_pagination',count($total_staff),30,$current_page)?>
</ul>
<?php
	$array = array(
				array('value' => 'contact-multi-staff','label' =>'<i class="fa fa-envelope-o"></i> Contact Staff'),
				array('value' => 'delete-multi-staff','label' =>'<i class="fa fa-times"></i> Delete Staff'),
				array('value' => 'update-multi-rating','label' =>'<i class="fa fa-star"></i> Update Selected Rating'),
				array('value' => 'change-multi-status','label' =>'<i class="fa fa-thumbs-o-up"></i> Change Selected Status'),
				array('value' => 'export-staff','label' =>'<i class="fa fa-download"></i> Export Selected')
				);

	$id = 'search-staff-result-action';
	$label = 'Actions';
	echo modules::run('common/menu_dropdown',$array,$id,$label);
	
?>
<? if(isset($staffs)) { ?>
<div class="table-responsive">
	 <table class="table table-bordered table-hover table-middle staff-search-result-table">
        <thead>
        <tr class="heading">
            <th class="center"><input type="checkbox" id="master-checkbox" /></th>
            <th class="center">Photo</th>
            <th class="left col-md-2">Name <i class="fa fa-sort sort-result" sort-by="u.first_name"></i></th>
            <th class="left col-md-2">Email <i class="fa fa-sort sort-result" sort-by="u.email_address"></i></th>
            <th class="center col-md-1">State <i class="fa fa-sort sort-result" sort-by="u.state"></i></th>
            <th class="center ">Rating <i class="fa fa-sort sort-result" sort-by="s.rating"></i></th>
            <th class="center col-md-2">Last Work Day <i class="fa fa-sort sort-result" sort-by="s.last_worked_date"></i></th>
			<th class="center col-md-2">Last Profile Update <i class="fa fa-sort sort-result" sort-by="u.modified_on"></i></th>
            <th class="center col-md-2">Time Sheets in Pay Run <i class="fa fa-sort sort-result" sort-by="s.time_sheets_in_payrun"></i></th>
            <th class="center col-md-1">Status <i class="fa fa-sort sort-result" sort-by="u.status"></i></th>
            <th class="center">View</th>
        	<th class="center">Delete</th>
        </tr>
        </thead>
        <tbody>
        	<form id="staff-search-results-form">
            <? 
				foreach($staffs as $staff) {
				$photo = $this->staff_model->get_hero($staff['user_id']);
				$last_worked = $staff['last_worked_date'] == '0000-00-00 00:00:00' ? 'NA' : date('d M Y',strtotime(($staff['last_worked_date'])));
			 ?>
            <tr id="search-result-tr-<?=$staff['user_id'];?>">
                <td class="center"><input type="checkbox" name="user_staff_selected_user_id[]" value="<?=$staff['user_id'];?>" class="checkbox-multi-action" /></td>
                <td class="center">
                <a href="<?=base_url();?>staff/edit/<?=$staff['user_id'];?>">
                <div class="search-staff-avatar-img">
                	<?=modules::run('common/profile_picture','',$staff['user_id']);?>
                 </div>    
                </a>
            	</td>
                <td class="left"><a href="<?=base_url();?>staff/edit/<?=$staff['user_id'];?>"><?=$staff['first_name'].' '.$staff['last_name'];?></a></td>
                <td class="left"><?=$staff['email_address'];?></td>
                <td class="center"><?=$staff['state'];?></td>
                <td class="center">
                <?php
					$rating_class = 'wp-rating-'.$staff['user_id'];
					$selector = 'basic-'.$staff['user_id'];
				?>
                <div class="<?=$rating_class;?>">
                <?=modules::run('common/field_rating', 'rating_'.$staff['user_id'], $staff['rating'],$selector,$rating_class,$staff['user_id'],true,false);?>
                </div>
                </td>
                <td class="center"><?=$last_worked;?></td>
                <td class="center"><?=date('d M Y',strtotime(($staff['modified_on'] == '0000-00-00 00:00:00' ? $staff['created_on'] : $staff['modified_on'])));?></td>
                <th class="center"><?=$staff['time_sheets_in_payrun'];?></th>
                <td class="center"><?=($staff['status'] != 0 ? ($staff['status'] == 1 ? 'Active' : 'Inactive') : 'Pending');?></td>
                <td class="center"><a  href="<?=base_url();?>staff/edit/<?=$staff['user_id'];?>"><i class="fa fa-eye"></i></a></td>
                <td class="center"><i class="fa fa-times delete-staff" delete-data-id="<?=$staff['user_id'];?>"></i></td>
            </tr>
            <? } }?>
        </tbody>
        </form>
    </table>
</div>
<script>
	$(function(){
		$('.sort-result').on('click',function(){
			var sort_order = $('#sort-order').val();
			$('#sort-order').val(sort_order == 'asc' ? 'desc' : 'asc');
			$('#sort-by').val($(this).attr('sort-by'));
			reset_page();
			search_staffs();
		});	
		
		//check uncheck all checkboes
		help.toggle_checkboxes('#master-checkbox','.checkbox-multi-action');
		
		//delete single staff
		$('.delete-staff').on('click',function(){
		var title = 'Delete Staff';
		var message ='Are you sure you would like to delete this "Staff"';
		var user_id = $(this).attr('delete-data-id');
		help.confirm_delete(title,message,function(confirmed){
			 if(confirmed){
				 delete_staff(user_id);
			 }
			});
		});
	
		$('#menu-search-staff-result-action ul li a').on('click',function(){
			var action = $(this).attr('data-value');
			perform_multi_update(action);
		})
		
		//go to page
		$('.pagination li').on('click',function(e){
			e.preventDefault();
			scroll_to_form = false;
			var clicked_page = $(this).attr('data-page-no');
			$('#current_page').val(clicked_page);
			search_staffs();
		});
	
		
	});//ready
</script>


	