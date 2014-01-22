<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script> 
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.9.2/jquery-ui.min.js"></script>
<script src="<?=base_url();?>assets/js/select2/jquery.select2.min.js"></script>
<script src="<?=base_url();?>assets/js/select2/bootstrap.js"></script>
<link href="<?=base_url()?>assets/js/select2/select2.css" rel="stylesheet" media="screen">
<script>

$(document).ready(function(){
	change_area($('#'+'<?=$field_name;?>').val());
	//alert($('#'+'<?=$field_name;?>').val());
	
	//===== Select2 dropdowns =====//

	
	$(".select").select2();
	$(".selectMultiple").select2();
		
	$("#loadingdata").select2({
		placeholder: "Enter at least 1 character",
        allowClear: true,
        minimumInputLength: 1,
        query: function (query) {
            var data = {results: []}, i, j, s;
            for (i = 1; i < 5; i++) {
                s = "";
                for (j = 0; j < i; j++) {s = s + query.term;}
                data.results.push({id: query.term + i, text: s});
            }
            query.callback(data);
        }
    });		
		
	
});
function change_area(e)
{
	var loc = e.value;
	$.ajax({
		url: '<?=base_url()?>common/dropdown_get_area/',
		type: 'POST',
		data: ({loc:loc,field_name:'<?=$field_name;?>',field_value:'<?=$field_value;?>'}),
		dataType: "html",
		success: function(html) {
			$('#area_location').html(html);
		}
	})		
}
function get_area_submit()
{
//alert('id');	
	var loc= $('#'+'<?=$field_name;?>').val();
	$('.select2-search-choice').each(function(){
		var suburb=($(this).children().html());
		$.ajax({
			url: '<?=base_url()?>common/define_area/',
			type: 'POST',
			data: ({loc:loc,suburb:suburb}),
			dataType: "html",
			success: function(html) {
				$('#txt').val($('#txt').val()+html);
			}
		})		
	});
	
}
</script>



<label for="title" class="col-lg-2 control-label">Select Locations</label>
                                
<div class="col-lg-10">

<select name="<?=$field_name;?>" class="form-control auto-width" id="<?=$field_name;?>" onchange="change_area(this)">
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
</div>
<div style="clear:both; height:20px;"></div>
<label for="title" class="col-lg-2 control-label">Select Area</label>
<div id="area_location" style="float:left; margin-left:10px;">
</div>

<div style="clear:both; height:20px;"></div>


<textarea id="txt"></textarea>