<?php
if (count($groups) > 0) { 
	$group_params = json_decode($params);
	$staff_id = $group_params->user_staff_id;
	$total_active_staffs = $group_params->total_active_staffs;	
?>
<table class="table table-bordered table-hover table-middle table-expanded">
	<thead>
	<tr class="heading">
		<th class="left">Group Name <i class="fa fa-sort sort-table" sort-by="name"></i></td>
        <th class="center col-md-2">Staff Assigned To Group <i class="fa fa-sort sort-table" sort-by="frequency"></i></th>
		<th class="center col-md-2">Group Assigned</th>
	</tr>
	</thead>
    <tbody>
	<? foreach($groups as $group) { 
	   $has_group = modules::run('staff/check_staff_has_group',$staff_id,$group['group_id']);
	?>
	<tr>
		<td class="left"><?=$group['name'];?></td>
        <td class="center"><?=$group['frequency'];?>/<?=$total_active_staffs;?></td>
		<td class="center <?=($has_group ? 'available-color': '');?>"><input class="groups-checkbox" type="checkbox" <?=($has_group ? 'checked="checked"': '');?> value="<?=$group['group_id'];?>"  /></td>
	</tr>
	<? } ?>
    </tbody>
</table>
<script>
$(function(){
	
	//sort data
	help.sort_list('.sort-table',params);
	
	$('.groups-checkbox').on('change',function(){
		$.ajax({
			type: "POST",
			url: "<?=base_url();?>staff/ajax/update_groups",
			data: {staff_id:<?=$staff_id;?>,group_id:$(this).val()},
			success: function(html) {
				help.load_content(params);
			}
		})
	});

});
</script>
<? } ?>