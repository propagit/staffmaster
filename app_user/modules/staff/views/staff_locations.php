<link href="<?=base_url();?>assets/css/bootstrap-tree.css" rel="stylesheet">

	
<div class="tree">
    <ul>
    	<? if(count($locations) > 0) foreach($locations as $parent_id => $childrens) { $parent = modules::run('attribute/location/get_location', $parent_id); ?>
        <li>
            <span><i class="icon-folder-open"></i> <?=$parent['name'];?></span> <a onclick="remove_staff_location('<?=$parent['location_id'];?>','')"><i class="fa fa-minus-circle"></i></a>
            <ul>
            	<? if(count($childrens) > 0) foreach($childrens as $child_id) { $children = modules::run('attribute/location/get_location', $child_id); ?>
                <li>
                	<span><i class="icon-minus-sign"></i> <?=$children['name'];?></span> <a onclick="remove_staff_location('<?=$parent['location_id'];?>','<?=$children['location_id'];?>')"><i class="fa fa-minus-circle"></i></a>                    
                </li>
                <? } ?>
            </ul>
        </li>
        <? } ?>
    </ul>
</div>

<script src="<?=base_url();?>assets/js/bootstrap-tree.js"></script>
<script>
function remove_staff_location(parent_id,location_id)
{	
	$.ajax({
		type: "POST",
		url: "<?=base_url();?>staff/ajax/remove_location",
		data: {user_id: '<?=$staff['user_id'];?>', parent_id: parent_id, location_id: location_id},
		success: function(html) {
			load_staff_locations();
		}
	})
}
</script>