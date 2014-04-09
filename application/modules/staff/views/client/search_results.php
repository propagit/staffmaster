<link rel="stylesheet" href="<?=base_url();?>assets/bootstrap-gallery/css/bootstrap-image-gallery.min.css">
<script src="<?=base_url();?>assets/bootstrap-gallery/js/bootstrap-image-gallery.min.js"></script>

<hr />
<h2>Search Results</h2>
<ul class="pagination custom-pagination pull">
<?=modules::run('common/create_pagination',count($total_staff),STAFF_PER_PAGE,$current_page)?>
</ul>
<p>Your search returned <b><?=count($total_staff);?></b> results</p>
<br />
<? if(isset($staffs)) { ?>
<div class="table-responsive">
	 <table class="table table-bordered table-hover table-middle staff-search-result-table">
        <thead>
        <tr class="heading">
            <th class="center" width="60">Photo</th>
            <th class="left" width="150">First Name <i class="fa fa-sort sort-result" sort-by="u.first_name"></i></th>
            <th class="left">Last Name <i class="fa fa-sort sort-result" sort-by="u.last_name"></i></th>
            <th class="center">State <i class="fa fa-sort sort-result" sort-by="u.state"></i></th>
            <th class="center">Country <i class="fa fa-sort sort-result" sort-by="u.country"></i></th>
           
        </tr>
        </thead>
        <tbody>        	
            <? 
				foreach($staffs as $staff) {
				$photo = $this->staff_model->get_hero($staff['user_id']);
				$last_worked = $staff['last_worked_date'] == '0000-00-00 00:00:00' ? 'NA' : date('d M Y',strtotime(($staff['last_worked_date'])));
			 ?>
            <tr id="search-result-tr-<?=$staff['user_id'];?>">
                <td class="center">
	        	    <a class="search-staff-avatar-img"  onclick="load_staff_photos(<?=$staff['user_id'];?>)">
	                	<?=modules::run('staff/profile_image',$staff['user_id']);?>
	                 </a>
            	</td>
                <td class="left"><?=$staff['first_name'];?></td>
                <td class="left"><?=$staff['last_name'];?></a></td>
                <td class="center"><?=$staff['state'];?></td>
                <td class="center"><?=$staff['country'];?></td>
            </tr>
            <? } }?>
        </tbody>
    </table>
</div>
<div id="staff_photos"></div>
<script>
$(function(){
	$('.sort-result').on('click',function(){
		var sort_order = $('#sort-order').val();
		$('#sort-order').val(sort_order == 'asc' ? 'desc' : 'asc');
		$('#sort-by').val($(this).attr('sort-by'));
		reset_page();
		search_staffs();
	});
	//go to page
	$('.pagination li').on('click',function(e){
		e.preventDefault();
		scroll_to_form = false;
		var clicked_page = $(this).attr('data-page-no');
		$('#current_page').val(clicked_page);
		search_staffs();
	});	
});
function load_staff_photos(user_id) {
	$.ajax({
		type: "POST",
		url: "<?=base_url();?>staff/ajax_photo/load_staff_photos",
		data: {user_id: user_id},
		success: function(html) {
			//$('#staff_photos').html(html);
		}
	})
}
</script>
