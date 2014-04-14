<?
if(count($photo)>0)
{
	$thumb_src = base_url().UPLOADS_URL.'/staff/profile/'.md5($staff['user_id']).'/thumbnail2/'.$photo['name'];
	$class="resize";
?>

<img class="<?=$class?>" src="<?=$thumb_src;?>" title="<?=$staff['first_name'].' '.$staff['last_name']?>" alt="<?=$photo['name']?>" /></a>

<?php
}
else
{
?>
	<i class="fa <?=(modules::run('staff/get_staff_gender',$staff['user_id']) == 'm' ? 'fa-male': 'fa-female');?>"></i>
<?php
}
?>
