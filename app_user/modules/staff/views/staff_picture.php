<?
if(count($photo)>0)
{
	$thumb_src = base_url().UPLOADS_URL.'/staff/'.$staff['user_id'].'/thumb/'.$photo['name'];
	$class="resize";
?>
<div class="profile_photo">
	<img class="<?=$class?>" src="<?=$thumb_src;?>" title="<?=$staff['first_name'].' '.$staff['last_name']?>" alt="<?=$photo['name']?>" />
</div>
<?php
}
else
{
?>
<div class="profile_photo">
	<div class="default-avatar-photo">
		<i class="fa fa-user"></i>
    </div>
</div>
<?php
}
?>
