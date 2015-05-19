<link href="<?=base_url();?>assets/css/lookbook.css" rel="stylesheet">

<div class="lookbook">
    <?php 
	$lookbook = modules::run('lookbook/get_lookbook','c4ca4238a0b923820dcc509a6f75849b');
	$config_custom = '';
	$config_personal = '';
	if($lookbook){
		$staff = json_decode($lookbook['included_user_ids']);
		$config_personal = $lookbook['personal_fields'];
		$config_custom = $lookbook['custom_fields'];
	}
	
	foreach($staff as $s){	
		echo modules::run('lookbook/get_staff_card_publish_view',$s,$config_personal,$config_custom); 
	}
	
	?>
</div>