<div> 
   <!-- in this exemple, 12 is the average and 1 is the id of the line to update in DB -->
   <div class="basic" data-average="<?=$field_value?>" data-id="1"></div>               
   <input type="hidden" name="<?=$field_name?>" id="<?=$field_name?>" class="rating" value="<?=$field_value?>"> 
</div>
<link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/js/rating/jRating.jquery.css" media="screen" />
<script type="text/javascript" src="<?=base_url()?>assets/js/rating/jRating.jquery.js"></script>
<script type="text/javascript">
jQuery(document).ready(function(){
      // get the clicked rate !
	jQuery(".basic").jRating({
		onClick : function(element,rate) {
	 	jQuery('#rating').val(rate); 
		}
	});
});
</script>
