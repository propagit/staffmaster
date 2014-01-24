<script>
$(document).ready(function(){
	change_area<?=$field_name;?>($('#'+'<?=$field_name;?>').val());
});

function change_area<?=$field_name;?>(e)
{
	var loc = e.value;
	$.ajax({
		url: '<?=base_url()?>common/dropdown_form_get_area_state/',
		type: 'POST',
		data: ({loc:loc,field_name:'<?=$field_name;?>',field_value:'<?=$field_value;?>'}),
		dataType: "html",
		success: function(html) {
			//$('#area_location').html(html);
			$('#area_state<?=$field_name;?>').html(html);
		}
	})		
}
</script>
<select name="state<?=$field_name;?>" class="form-control auto-width" id="<?=$field_name;?>" onchange="change_area<?=$field_name;?>(this)">
        <option value="">Select Location</option>
        <? foreach($locations as $loc){?>
               <option value="<?=$loc['location_id'];?>"<?=($field_value == $loc['location_id']) ? ' selected' : '';?>><b><?=$loc['name'];?></b></option>
            <? $areas = $this->common_model->get_locations_child($loc['location_id']);
                foreach($areas as $area)
                {?>
                    <option value="<?=$area['location_id'];?>"<?=($field_value == $area['location_id']) ? ' selected' : '';?>>&nbsp;&nbsp;&nbsp;&nbsp;<?=$area['name'];?></option>
            <?	}
            ?>
        <? }?>
</select>
<div style="height:15px;"></div>
<div id="area_state<?=$field_name;?>"></div>
