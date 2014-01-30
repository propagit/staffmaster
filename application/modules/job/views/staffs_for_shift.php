<? foreach($staffs as $staff) { ?>
<a onclick="select_staff(this)" class="photo_staff photo_2" data-pk="<?=$staff['user_id'];?>" data-toggle="tooltip" data-original-title="<?=$staff['first_name'] . ' ' . $staff['last_name'];?>">
</a>
<? } ?>
<script>
$(function(){
	$('.photo_staff').tooltip();
})
function select_staff(obj)
{
	$('input[name="shift_staff"]').val($(obj).attr('data-original-title'));
	$('input[name="shift_staff_id"]').val($(obj).attr('data-pk'));
}
</script>