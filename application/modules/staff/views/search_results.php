<hr />
<h2>Search Results</h2>
<p>Your search returned <b><?=count($staffs);?></b> results</p>
<? if(isset($staffs)) { ?>

	 <table class="table table-bordered table-hover table-middle">
        <thead>
        <tr class="heading">
            <th class="center"><input type="checkbox" /></th>
            <th class="center">Photo</th>
            <th class="left col-md-2">Name</th>
            <th class="left col-md-2">Group</th>
            <th class="center col-md-1">State</th>
            <th class="center col-md-1">Rating</th>
            <th class="center col-md-2">Hours Worked (week)</th>
			<th class="center col-md-2">Hours Worked (all)</th>
            <th class="center col-md-1">Status</th>
            <th class="center col-md-1">View</th>
        	<th class="center col-md-1">Delete</th>
        </tr>
        </thead>
        <tbody>
            <? 
				foreach($staffs as $staff) {
				$photo = $this->staff_model->get_hero($staff['user_id']);
			 ?>
            <tr>
                <td class="center"><input type="checkbox" /></td>
                <td class="center">
                <a href="<?=base_url();?>staff/edit/<?=$staff['user_id'];?>">
                <div class="search-staff-avatar-img">
                	<?=modules::run('common/profile_picture','',$staff['user_id']);?>
                 </div>    
                </a>
            	</td>
                <td class="left"><?=$staff['first_name'].' '.$staff['last_name'];?></td>
                <td class="left">Group</td>
                <td class="center">State</td>
                <td class="center">
                <?php
					$rating_class = 'wp-rating-'.$staff['user_id'];
					$selector = 'basic-'.$staff['user_id'];
				?>
                <div class="<?=$rating_class;?>">
                <?=modules::run('common/field_rating', 'rating_'.$staff['user_id'], $staff['rating'],false,$selector,$rating_class,true,$staff['user_id']);?>
                </div>
                </td>
                <td class="center">Hours Worked (week)</td>
                <td class="center">Hours Worked (all)</td>
                <td class="center">Status</td>
                <td class="center"><a  href="<?=base_url();?>staff/edit/<?=$staff['user_id'];?>"><i class="fa fa-eye"></i></a></td>
                <td class="center"><i class="fa fa-times"></i></td>
            </tr>
            <? } }?>
        </tbody>
    </table>




	