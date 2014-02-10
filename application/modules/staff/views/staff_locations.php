<link href="<?=base_url();?>assets/css/bootstrap-tree.css" rel="stylesheet">

	

<div class="tree">
    <ul>
    	<? foreach($locations as $parent_id => $children) { $parent = modules::run('attribute/location/get_location', $parent_id); ?>
        <li>
            <span><i class="icon-folder-open"></i> <?=$parent['name'];?></span> 
            <ul>
            	<? foreach($children as $location_id) { $location = modules::run('attribute/location/get_location', $location_id); ?>
                <li>
                	<span><i class="icon-minus-sign"></i> <?=$location['name'];?></span> 
                    
                </li>
                <? } ?>
            </ul>
        </li>
        <? } ?>
    </ul>
</div>

<script src="<?=base_url();?>assets/js/bootstrap-tree.js"></script>