<?
if(count($photo)>0)
{
	$thumb_src = base_url().'uploads/staff/profile/'.md5($staff['user_id']).'/thumbnail2/'.$photo['name'];
	$class="resize";
?>
<div class="profile_photo">
	<a href="<?=base_url();?>staff/edit/<?=$staff['user_id'];?>"><img class="<?=$class?>" src="<?=$thumb_src;?>" title="<?=$staff['first_name'].' '.$staff['last_name']?>" alt="<?=$photo['name']?>" /></a>
</div>
<?php
}
else
{
?>
<div class="profile_photo">
	<a href="<?=base_url();?>staff/edit/<?=$staff['user_id'];?>"><div class="default-avatar-photo">
		<i class="fa <?=(modules::run('staff/get_staff_gender',$staff['user_id']) == 'm' ? 'fa-male': 'fa-female');?>"></i>
    </div></a>
</div>
<?php
}
?>