<hr />
<h2>Search Results</h2>
<p>Your search returned <b><?=count($staffs);?></b> results</p>
<? if(isset($staffs)) { ?>
	<div class="panel-heading panel-heading-mid"></div>
	<div class="panel-body">
		<div class="pull-right">
			<a href="#"><b><i class="icon-sort-by-alphabet"></i> Sort By Name</b></a>
		</div>
		<ul class="pagination">
			<li><a href="#">&laquo;</a></li>
			<li><a href="#">1</a></li>
			<li><a href="#">2</a></li>
			<li><a href="#">3</a></li>
			<li><a href="#">4</a></li>
			<li><a href="#">5</a></li>
			<li><a href="#">&raquo;</a></li>
		</ul>
		<div class="clearfix"></div>
		<? foreach($staffs as $staff) {
			$photo = $this->staff_model->get_hero($staff['staff_id']);
			if(count($photo)>0)
			{
				$thumb_src = base_url().'uploads/staff/profile/'.md5($staff['staff_id']).'/thumbnail/'.$photo['name'];
				$class="resize";
			}
			else
			{
				$thumb_src = base_url().'assets/img/dummy/default-avatar.png';
				$photo['name'] = "Use Avatar";
				$class='normal';
			}
		 ?>
		<div class="staff_search_profile">
			<a href="<?=base_url();?>staff/edit/<?=$staff['user_id'];?>">
            <div class="profile_photo">
				<img class="<?=$class?>" src="<?=$thumb_src;?>" title="<?=$staff['first_name'].' '.$staff['last_name']?>" alt="<?=$photo['name']?>" />
			</div>
            </a>
			<b><?=$staff['first_name'] . '</b><br />' . $staff['last_name'];?></b>
            
			<div class="rating">
				<span class="star"></span>
				<span class="star"></span>
				<span class="star"></span>
				<span class="star"></span>
				<span class="star"></span>
			</div>
		</div>
		<? } ?>
		<div class="clearfix"></div>
	</div>
	<? } ?>