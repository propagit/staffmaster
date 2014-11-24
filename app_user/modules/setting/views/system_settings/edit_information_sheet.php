<div class="company-profile-detail-box">
	<h2>Information Sheet</h2>
	<p>
    The information sheet can be downloaded by staff when they view their roster or apply for shifts and click the view brief icon. <br />
    You can control what information will appear on the information sheet by clicking the below criteria on or off.
    </p>
</div>
<p>Tick the appropriate boxes you would like to include on the informaton sheet<br /><br /></p>
<div class="col-md-12 remove-gutters">
<?php
	$total = count($info_sheet_configs) ? count($info_sheet_configs) : 0;
	$row_count = round($total/2);
	$counter = 1;
	if($total){
		echo '<div class="col-md-3">';
		foreach($info_sheet_configs as $config){
		if($counter > $row_count){
			echo '</div><div class="col-md-3">';
			$counter = 0;
		}
?>
		<div class="checkbox">
			<label>
			  <input class="update-info-sheet-config" type="checkbox" <?=$config->element_active == 'yes' ? 'checked="checked"' : ''?> data-id="<?=$config->information_sheet_config_id;?>" data-status="<?=$config->element_active;?>"> <?=$config->element_label;?>
			</label>
		</div>
<?php
		$counter++;
		}
		echo '</div>';
	}
?>
</div>
<br /><br />
<div class="alert alert-success push hide" id="msg-success"><i class="fa fa-check"></i> &nbsp; Your settings was successfully updated!</div>
<script>
$('.update-info-sheet-config').on('click',function(){
	update_information_sheet($(this));
});


function update_information_sheet(obj)
{
	preloading($('body'));
	var info_sheet_id = obj.attr('data-id');
	$.ajax({
	type: "POST",
	url: "<?=base_url();?>setting/ajax/update_information_sheet",
	data: {information_sheet_id:info_sheet_id},
		success: function(html) {
			$('#wrapper_loading').remove();
			$('#msg-success').removeClass('hide');
			setTimeout(function(){
				$('#msg-success').addClass('hide');
			}, 2000);
		}
	});
}
</script>
