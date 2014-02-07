<!--<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script> -->
<!--<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.9.2/jquery-ui.min.js"></script>-->
<script src="<?=base_url();?>assets/js/select2/jquery.select2.min.js"></script>
<script src="<?=base_url();?>assets/js/select2/bootstrap.js"></script>
<link href="<?=base_url()?>assets/js/select2/select2.css" rel="stylesheet" media="screen">
<script>
var code='#';
$(document).ready(function(){
	change_area($('#'+'<?=$field_name;?>').val());
	change_area_all();
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
		
	//$("#area_location").click(function() {
  		//alert( "Handler for .click() called." );
	//	get_area_submit();
	//});
	$("#area_location").bind('click', function(event) {
    	event.preventDefault();
		get_area_submit();
    	//$($("#frameTrigger a:eq(1)").attr('target')).attr('src', $("#frameTrigger a:eq(1)").attr('href'));
	});
});

function deletelink(e)
{
	alert(e.text);
}

function change_area(e)
{
	var loc = e.value;
	$.ajax({
		url: '<?=base_url()?>common/dropdown_get_area_state/',
		type: 'POST',
		data: ({loc:loc,field_name:'<?=$field_name;?>',field_value:'<?=$field_value;?>'}),
		dataType: "html",
		success: function(html) {
			//$('#area_location').html(html);
			$('#area_state').html(html);
		}
	})		
}

function change_area_all()
{
	var loc= $('#area_code_num').val();
	$.ajax({
		url: '<?=base_url()?>common/dropdown_get_area/',
		type: 'POST',
		data: ({loc:loc,field_name:'<?=$field_name;?>',field_value:'<?=$field_value;?>'}),
		dataType: "html",
		success: function(html) {
			//$('#area_location').html(html);
			$('#area_location').html(html);
		}
	})		
}

function add_locations()
{
	var locs= $('#area_location_state').val();
	$('#area_code_num').val($('#area_code_num').val()+'#'+locs);
	$('#area_code').val($('#area_code').val()+'#'+locs);
	var loc= $('#area_code_num').val();
	$.ajax({
		url: '<?=base_url()?>common/dropdown_get_area/',
		type: 'POST',
		data: ({loc:loc,field_name:'<?=$field_name;?>',field_value:'<?=$field_value;?>'}),
		dataType: "html",
		success: function(html) {
			$('#area_location').html(html);
			//$('#area_state').html(html);
		}
	})	
	
}
function get_area_submit()
{
	
	var loc= $('#area_code').val();
	
	$('.select2-search-choice').each(function(){
		var suburb=($(this).children().html());
		$.ajax({
			url: '<?=base_url()?>common/define_area/',
			type: 'POST',
			data: ({suburb:suburb}),
			dataType: "html",
			success: function(html) {
				code=code+html;
				//alert(code);
			}
		})		
		
	});
	//$('#area_code').val($('#area_code').val()+code);
}
</script>



<label for="title" class="col-lg-2 control-label">Select Locations</label>
                                
<div class="col-lg-10">
    <select name="<?=$field_name;?>" class="form-control auto-width custom-select select-locations" id="<?=$field_name;?>" onchange="change_area(this)">
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
    <span class="input-group-addon select-addon" onclick="help.open_select('.select-locations');"><i class="fa fa-unsorted"></i></span>
</div>

<div style="clear:both; height:20px;"></div>

<label for="title" class="col-lg-2 control-label">Select Area</label>
<div class="col-lg-10"><div id="area_state" style="float:left;"></div><input type="button" value="Add Location" class="btn btn-info" name="add_location" onclick="add_locations()" style="float:left; margin-left:20px;"></div>
<div style="clear:both; height:20px;"></div>


<label for="title" class="col-lg-2 control-label">Your Area</label>
<div id="area_location" style="float:left; margin-left:10px;">
</div>

<div style="clear:both; height:20px;"></div>
<?
	$temp_loc = json_decode($field_value);
	$str='';
	if(isset($temp_loc)){
		foreach($temp_loc as $tl)
		{
			$str= $str.$tl.'#';
		}
	}
?>

<input id="area_code" name="area_code" type="hidden" value="<?=$str?>">
<input id="area_code_num" name="area_code_num" type="hidden" value="">