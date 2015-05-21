<link href="<?=base_url();?>assets/css/lookbook.css" rel="stylesheet">
<script src="<?=base_url()?>assets/ckeditor/ckeditor.js"></script>
<script src="<?=base_url()?>assets/ckeditor/config.js"></script>
<script src="<?=base_url()?>assets/ckeditor/styles.js"></script>
<script src="<?=base_url()?>js/lookbook.js"></script>
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
	
	/*foreach($staff as $s){	
		echo modules::run('lookbook/get_staff_card',$s,$config_personal,$config_custom); 
	}*/
	
	?>
</div>





<?php echo modules::run('lookbook/email_modal'); ?>




<script>
$(function(){
	adjust_height('.lb-table');
	
	setTimeout(function(){
		adjust_height('.lb-table');
	},1000);
	
	$('#lookbook-email-modal').modal('show');
});


var lb_email_body = CKEDITOR.replace('lb_email_body',{
  height:100
});

CKEDITOR.config.toolbar = [
    <?=TRUE ? LIVE_CK_TOOLS : DEV_CK_TOOLS;?>
] ;

function update_ckeditor()
{
	for ( instance in CKEDITOR.instances ) {
            CKEDITOR.instances[instance].updateElement();
    }	
}

function adjust_height(selector){
	var maxHeight = 0;
	$(selector).each(function() { 
		maxHeight = Math.max(maxHeight, $(this).height()); 
	});
	$(selector).css({'height':maxHeight});	
}
</script>