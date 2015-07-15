<ul class="slides popup-gallery staff-photos hidden">
 <?
      foreach($photos as $photo){
          $photo_src_full = base_url().UPLOADS_URL . '/staff/' . $user_id .'/'.$photo['name'];
          $thumb_src = base_url().UPLOADS_PATH. '/staff/' . $user_id .'/thumbnail/'.$photo['name'];
      ?>
          <li class="flex-li popup-gallery-images" title="<?=$photo['name'];?>" href="<?=$photo_src_full?>"></li>
      <?
      }
      ?>
</ul>



<script>
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

$(function(){
	$('.popup-gallery-images').click();
});
</script>
