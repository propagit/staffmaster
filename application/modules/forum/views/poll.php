<div id="survey-box-<?=$topic_id;?>" class="survey-wrap">
	<?php if($poll_answers){
			foreach($poll_answers as $pa){
	?>
	 <div class="form-group msg-frm-group">
        <div class="col-sm-12 remove-left-padding">
          <div class="radio msg-radio">
            <label>
              <input class="poll-radio" type="radio" name="poll_survey_<?=$topic_id;?>" value="<?=$pa->poll_answer_id;?>" data-topic-id="<?=$topic_id;?>"> <?=$pa->answer;?>
            </label>
          </div>
        </div>
      </div>	
    <?php }} ?>	
</div>
<script>
$(function(){
	$('.poll-radio').on('click',function(){
		var poll_answer_id = $(this).val();
		var topic_id = $(this).attr('data-topic-id');
		$.ajax({
			type: "POST",
			url: "<?=base_url();?>forum/ajax/take_poll",
			data: {poll_answer_id:poll_answer_id,topic_id:topic_id},
			success: function(html) {
				$('#survey-box-'+topic_id).html(html);
			}
		});
	});
});//ready

</script>