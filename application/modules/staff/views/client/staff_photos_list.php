<?=var_dump($photos);?>
<div id="carousel" class="flexslider gallery_staff">
  <ul class="slides popup-gallery staff-photos">
   <?
        foreach($photos as $photo){
            $photo_src_full = base_url().'uploads/staff/profile/'.md5($user_id).'/'.$photo['name'];                                
            $thumb_src = base_url().'uploads/staff/profile/'.md5($user_id).'/thumbnail/'.$photo['name'];
        ?>
            <li class="flex-li" style="width:232px !important;">
                <img style="width:auto!important; height:216px;" src="<?=$thumb_src;?>" />
                
            </li>
        <?
        }
		?>        
     
    <!-- items mirrored twice, total of 12 -->
  </ul>
</div>


<script>
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
	</script>