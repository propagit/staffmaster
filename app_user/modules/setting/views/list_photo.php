<div class="row">
    <div class="col-md-2 staff-profile-hero-wrap remove-left-gutter">
        Company Logo <br /><br />
        <div class="picture-box">
            <div class="profile-company-logo company-logo-thumb-preview">
            <? 
            if(isset($company['company_logo']) && $company['company_logo'] != NULL){?> 
            	<img src="<?=base_url().UPLOADS_URL;?>/company/logo/<?=md5($company['id'])?>/thumbnail/<?=$company['company_logo']?>">
                <div align="center" class="action_image" > 
                   <div class="action_icon delete-logo"><i class="fa fa-times" title="Remove this picture as your profile picture"></i></div>
                </div>
			<? }else{?>
                <img src="<?=base_url()?>assets/img/core/staffmaster-logo.jpg">    
            <? } ?>
            </div>
        </div>
        
    </div>
    
</div>
<script>
$(function(){
	$('.delete-logo').on('click',function(e){
		e.stopImmediatePropagation();
		var title = 'Delete Company Logo';
		var message ='Are you sure you would like to delete this "Logo"';
		var photo_id = $(this).attr('delete-data-id');
		help.confirm_delete(title,message,function(confirmed){
			 if(confirmed){
				 delete_logo(<?=(isset($company['id'])) ? $company['id'] : 0 ?>);

			 }
		});
	});
				
	//respond gallery images
	//respond_staff_profile_pictures();
});

$(window).resize(function(){
	//respond_staff_profile_pictures();
});
</script>
