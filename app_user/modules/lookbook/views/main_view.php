<script src="<?=base_url()?>assets/ckeditor/ckeditor.js"></script>
<script src="<?=base_url()?>assets/ckeditor/config.js"></script>
<script src="<?=base_url()?>assets/ckeditor/styles.js"></script>
<div class="lookbook">
    <?php 
	$lookbook = modules::run('lookbook/get_lookbook_by_key','a869c01e7cb730e18f984503bff34d06');
	
	#print_r($lookbook);
	
	
	$config_custom = '';
	$config_personal = '';
	if($lookbook){
		$staff = json_decode($lookbook['included_user_ids']);
		$config_personal = $lookbook['personal_fields'];
		$config_custom = $lookbook['custom_fields'];
	}
	
	foreach($staff as $s){	
		echo modules::run('lookbook/get_staff_card',$s,$config_personal,$config_custom); 
	}
	/*$str = '["first_name","last_name","dob","gender","state"]';
	$test_arr = json_decode($str);
	echo '<pre>' . print_r($test_arr,true) . '</pre>';
	unset($test_arr[2]);
	$new_arr = array_values($test_arr);
	echo '<pre>' . print_r($test_arr,true) . '</pre>';
	print_r(json_encode($new_arr));*/
	#$new_str = implode(',',$test_arr);
	#print_r(json_encode($new_str));
	
	#$configed_fields = $this->lookbook_model->get_lookbook_config(LB_CUSTOM);
	#print_r($configed_fields);
	?>
</div>






<script>
$(function(){
	adjust_height('.lb-table');
	
	setTimeout(function(){
		adjust_height('.lb-table');
	},1000);
	
	$('#lookbook-config-modal').modal('show');
});



function adjust_height(selector){
	var maxHeight = 0;
	$(selector).each(function() { 
		maxHeight = Math.max(maxHeight, $(this).height()); 
	});
	$(selector).css({'height':maxHeight});	
}
</script>