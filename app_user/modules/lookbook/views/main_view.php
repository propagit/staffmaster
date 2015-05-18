<link href="<?=base_url();?>assets/css/lookbook.css" rel="stylesheet">

<div class="lookbook">
    <?php 
	$staff = array(11,19);
	foreach($staff as $s){
		echo modules::run('lookbook/get_staff_card',$s); 
	}
	
	?>
</div>