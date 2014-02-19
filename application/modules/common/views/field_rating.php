<div> 
   <!-- in this exemple, 12 is the average and 1 is the id of the line to update in DB -->
   <div class="<?=$selector;?>" data-average="<?=$field_value?>" data-id="1"></div>               
   <input type="hidden" name="<?=$field_name?>" id="<?=$field_name?>" class="rating" value="<?=$field_value?>"> 
</div>

<script type="text/javascript">
var ajax_update = <?=$ajax_update;?>;
<? if ($disabled) { ?>
$(function(){
	$(".<?=$selector;?>").jRating({
		isDisabled: true
	});
})
<? } else { ?>
jQuery(document).ready(function(){
      // get the clicked rate !
	jQuery(".<?=$selector;?>").jRating({
		onSuccess:function(){
		 	if(ajax_update){
				update_rating();	
			} 
		}
	});
});
<? } ?>

function update_rating()
{
	$.ajax({
		type: "POST",
		url: "<?=base_url();?>staff/ajax/update_ratings",
		data: {field_name: '<?=$field_name?>',user_id:<?=$user_id;?>,ajax_reload_container:'<?=$ajax_reload_container;?>',new_rating:$('#<?=$field_name;?>').val(),selector:'<?=$selector;?>'},
		success: function(html) {		
				$('.<?=$ajax_reload_container;?>').html(html);
			}
		});
}
</script>
