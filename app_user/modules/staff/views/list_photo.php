<div class="row">
    <div class="col-md-2 staff-profile-hero-wrap remove-left-gutter">
        <i class="fa fa-heart"></i> Profile Image <br /><br />
        <div class="picture-box">
            <div class="profile-picture">
            <? 
            if(isset($hero_photo) && $hero_photo != NULL){?> 
            	<img src="<?=base_url().UPLOADS_URL;?>/staff/<?=$user_id?>/thumb/<?=$hero_photo['name']?>">
                <div align="center" class="action_image" > 
                   <div class="action_icon uset-hero"><i class="fa fa-times" title="Remove this picture as your profile picture"></i></div>
                </div>
			<? }else{?>
                    <i class="fa fa-user default-profile-photo"></i>
            <? } ?>
            </div>
        </div>
        
    </div>
    <div class="col-md-10 staff-profile-gallery-wrap remove-left-gutter">
        <i class="fa fa-picture-o"></i> Your Gallery <br /><br />
         <?  if(isset($photos) && $photos != NULL){?>
        <div id="carousel" class="flexslider gallery_staff">
          <ul class="slides popup-gallery staff-photos">
           <?
                foreach($photos as $photo){
                    $photo_src_full = base_url().UPLOADS_URL.'/staff/'.$user_id.'/'.$photo['name'];                                
                    $thumb_src = base_url().UPLOADS_URL.'/staff/'.$user_id.'/thumb/'.$photo['name'];
                ?>
                    <li class="flex-li" style="width:232px !important;">
                        <img style="width:auto!important; height:216px;" src="<?=$thumb_src;?>" />
                        <div align="center" class="action_image popup-gallery-images" title="<?=$photo['name'];?>" href="<?=$photo_src_full?>"> 
                           <div class="action_icon set-hero" data-photo-id="<?=$photo['id'];?>"><i class="fa fa-heart <?=($photo['hero'] == 1 ? 'hero-img' : '' );?>" title="Set this picture as your profile picture"></i></div>
                           <div class="action_icon delete-photo" delete-data-id="<?=$photo['id'];?>"><i class="fa fa-times" title="Delete this picture"></i></div>
                        </div>
                    </li>
                <?
                }
				?>
                
             
            <!-- items mirrored twice, total of 12 -->
          </ul>
        </div>
        <? }?>
        <div style="clear:both;"></div>
    </div>
</div>
<script>
$(function(){
	$('.delete-photo').on('click',function(e){
		e.stopImmediatePropagation();
		var title = 'Delete Photo';
		var message ='Are you sure you would like to delete this "Photo"';
		var photo_id = $(this).attr('delete-data-id');
		help.confirm_delete(title,message,function(confirmed){
			 if(confirmed){
				 delete_photo(photo_id);
			 }
		});
	});
	
	$('.set-hero').on('click',function(e){
		e.stopImmediatePropagation();
		var photo_id = $(this).attr('data-photo-id');
		set_hero(photo_id);
	});
	
	$('.uset-hero').on('click',function(){
		uset_hero();
	});
	
	$('.flexslider').flexslider({
		animation: "slide",
		animationLoop: false,
		itemWidth:230,
		itemMargin:0
	});
	
	
	$('.popup-gallery-images').magnificPopup({
		type: 'image',
		tLoading: 'Loading image #%curr%...',
		mainClass: 'mfp-img-mobile',
		gallery: {
			enabled: true,
			navigateByImgClick: true,
			preload: [0,1] // Will preload 0 - before current, and 1 after the current image
		},
		image: {
			tError: '<a href="%url%">The image #%curr%</a> could not be loaded.',
			titleSrc: function(item) {
				return item.el.attr('title');
			}
		}
	});
	
	//respond gallery images
	respond_staff_profile_pictures();
});

$(window).resize(function(){
	respond_staff_profile_pictures();
});
</script>
