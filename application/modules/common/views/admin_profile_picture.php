<?

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
<div class="profile_photo">
<img class="<?=$class?>" src="<?=$thumb_src;?>" title="<?=$staff['first_name'].' '.$staff['last_name']?>" alt="<?=$photo['name']?>" />
</div>