<ul class="messages">
	  <?php 
	  	if($conversations){
			foreach($conversations as $c){ 
	  ?>
      <li class="<?=($user['user_id'] == $c->created_by ? 'by-user' : 'by-me');?>">
          <a href="#" title="">
			<?php
             	 $created_by = modules::run('user/get_user',$c->created_by);
             	 if($created_by['is_client']){
              ?>
                    <div class="profile_photo">
                        <div class="default-avatar-photo">
                            <i class="fa fa-male"></i>
                        </div>
                    </div>
			  <?php
                  }else{
                      echo modules::run('staff/profile_image',$c->created_by);
                  }
              ?>
 
          </a>
          <div class="message-area">
              <span class="aro"><i class="fa <?=($user['user_id'] == $c->created_by ? 'fa-angle-left' : 'fa-angle-right');?> message-fa"></i></span>
              <div class="info-row">
                  <div class="col-md-1 col-xs-1 wrap-list-date time">                            
                      <span class="wk_date display-inline"><?=date('d',strtotime($c->created_on));?></span>
                      <span class="wk_month display-inline"><?=date('M',strtotime($c->created_on));?></span>
                      <?php if($created_by['is_client']) {?>
                      <span class="display-inline text-danger"> - <i class="fa fa-info-circle"></i> <?=$created_by['full_name'];?></span>
                      <?php } ?>
                  </div>
                  <span class="title"><?=substr($c->title,0,200);?></span>
              </div>
              <?php 
				  if($c->type == 'poll'){
					   echo modules::run('forum/load_poll',$c->topic_id);	
				  }else{
					echo nl2br($c->message);
				  }
			  ?>
              <?=($c->document_name ? ($c->document_type == 'image' ? '<img class="message-img" src="'.base_url().'uploads/conversation/img/'.md5('forum'.$c->topic_id).'/thumb/'.$c->document_name.'" />' : '') : '');?>
              <div class="comments-wrap" id="comments-wrap-<?=$c->topic_id;?>">
                  <span class="msg-comments reply text-blue" data-reply="<?=$c->topic_id;?>">Post Reply <?=($c->total_replies ? '('.$c->total_replies.' replies)' : '');?> <i class="fa fa-angle-down reply-arrow-down"></i></span> 
                  <?=($c->document_name ? ($c->document_type == 'file' ? '<span class="badge danger msg-badge">1</span>' : '') : '');?>
                  <span class="msg-comments download-docs text-blue">
				  <?=($c->document_name ? ($c->document_type == 'file' ? '<a class="document-anchor" target="_blank" href="'.base_url().'uploads/conversation/doc/'.md5('forum'.$c->topic_id).'/'.$c->document_name.'" download>Download Documents</a>' : '') : '');?>
                  </span>
              </div>
              <!--reply-->
              <div id="replies-wrap-<?=$c->topic_id;?>" class="custom-hidden">
              		<div class="message-reply-box">
                    <textarea id="reply-<?=$c->topic_id;?>" class="form-control"></textarea>
                    <button onclick="post_reply('<?=$c->topic_id;?>');" type="button" class="btn btn-info reply-btn" data-reply-btn="<?=$c->topic_id;?>"><i class="fa fa-comment"></i> Reply</button></div>
             		<?=modules::run('forum/load_replies',$c->topic_id);?>
              </div>
              <!--reply-->
          </div>
      </li>
      <li class="divider"><span>...</span></li>
      <?php }} ?>

</ul>

<script>
var message_box_active = false;
$(function(){
	$('.reply').on('click',function(){
		var topic_id = $(this).attr('data-reply');
		$('#replies-wrap-'+topic_id).slideToggle('fast');
	});

});//ready

function remove_reply_box()
{
	$('.message-reply-box').remove();	
}

function post_reply(topic_id){
	preloading($('#comments-wrap-'+topic_id));
	var reply = $('#reply-'+topic_id).val();
	$.ajax({
	type: "POST",
	url: "<?=base_url();?>forum/ajax/post_reply",
	data: {topic_id:topic_id,reply:reply},
		success: function(html) {
			remove_reply_box();
			$('#wrapper_loading').remove();
			$('#replies-wrap-'+topic_id).html(html).removeClass('custom-hidden');
		}
	});
}
</script>