<?php
	$role_params = json_decode($params);
	$staff_id = $role_params->user_staff_id;
	$total_active_staffs = $role_params->total_active_staffs;	
?>
<table class="table table-bordered table-hover table-middle table-expanded">
    <thead>
        <tr>
            <th class="left">Role <i class="fa fa-sort sort-table" sort-by="name"></i></th>
            <th class="center col-md-2">Staff Assigned To Role <i class="fa fa-sort sort-table" sort-by="frequency"></i></th>
            <th class="center col-md-1">Role Assigned</th>
        </tr>
    </thead>
    <tbody>
    <? 
		foreach($roles as $role){ 
		$has_role = modules::run('staff/check_staff_has_role',$staff_id,$role['role_id']);
	?>
    <tr>
        <td class="left"><?=$role['name'];?></td>
        <td class="center"><?=$role['frequency'];?>/<?=$total_active_staffs;?></td>
      	<td class="center <?=($has_role ? 'available-color': '');?>"><input class="roles-checkbox" type="checkbox" <?=($has_role ? 'checked="checked"': '');?> value="<?=$role['role_id'];?>"  /></td>
    </tr>
    <? } ?>
    </tbody>
</table>
<script>
$(function(){
	//pretty checker
	//$('input[type="checkbox"]').prettyCheckable();
	
	//sort data
	help.sort_list('.sort-table',params);
	
	$('.roles-checkbox').on('change',function(){
		//console.log($(this).val());
		$.ajax({
			type: "POST",
			url: "<?=base_url();?>staff/ajax/update_roles",
			data: {staff_id:<?=$staff_id;?>,role_id:$(this).val()},
			success: function(html) {
				help.load_content(params);
			}
		})
	});
	
});
</script>
