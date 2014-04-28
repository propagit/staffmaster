<ul class="messages">
	  <?php 
	  	if($conversations){
			foreach($conversations as $c){ 
	  ?>
      <li class="<?=($user['user_id'] == $c->created_by ? 'by-user' : 'by-me');?>">
          
			<?php
				 $client_msg_border = '';
				 $client_msg_arrow_color = '';
             	 $created_by = modules::run('user/get_user',$c->created_by);
             	 if($created_by['is_client']){
					 $client_msg_border = 'client_support_msg';
					 $client_msg_arrow_color = 'client_msg_arrow_color';
					 $client = modules::run('client/get_client',$c->created_by);	 
              ?>
              		<a href="<?=base_url();?>client/edit/<?=$c->created_by?>">
                        <div class="profile_photo">
                            <div class="default-avatar-photo">
                                <i class="fa fa-male"></i>
                            </div>
                        </div>
                    </a>
			  <?php
                  }else{
					  echo '<a href="'.base_url().'staff/edit/'.$c->created_by.'">';
                      echo modules::run('staff/profile_image',$c->created_by);
					  echo '</a>';
                  }
              ?>
			 
          
          <div class="message-area <?=$client_msg_border;?>">
              <span class="aro"><i class="fa <?=($user['user_id'] == $c->created_by ? 'fa-angle-left' : 'fa-angle-right');?> message-fa <?=$client_msg_arrow_color;?>"></i></span>
              <div class="info-row">
                  <div class="col-md-1 col-xs-1 wrap-list-date time">                            
                      <span class="wk_date display-inline"><?=date('d',strtotime($c->created_on));?></span>
                      <span class="wk_month display-inline"><?=date('M',strtotime($c->created_on));?></span>
                      <?php if($created_by['is_client']) {?>
                      <span class="display-inline text-danger support-text"> &nbsp;<i class="fa fa-exclamation-triangle"></i> <b>Client Support</b> - <?=$client['company_name'];?> - <?=$created_by['full_name'];?></span>
                      <?php }else{ 
					  		if($c->type == 'support'){
					  ?>
						<span class="display-inline text-danger support-text"> &nbsp;<i class="fa fa-exclamation-triangle"></i> <b>Staff Support</b> - <?=$created_by['first_name'].' '.$created_by['last_name'];?></span>  
					  <?php }}?>
                  </div>
                  <span class="title"><?=substr($c->title,0,100);?></span>
              </div>
              <?php 
				  if($c->type == 'poll'){
					   echo modules::run('forum/load_poll',$c->topic_id);	
				  }else{
					echo nl2br($c->message);
				  }
			  ?>
              <?=($c->document_name ? ($c->document_type == 'image' ? '<img class="message-img" src="'.base_url().UPLOADS_URL.'/conversation/img/'.md5('forum'.$c->topic_id).'/thumb/'.$c->document_name.'" />' : '') : '');?>
              <div class="comments-wrap" id="comments-wrap-<?=$c->topic_id;?>">
                  <span class="msg-comments reply text-blue" data-reply="<?=$c->topic_id;?>">Post Reply <span id="reply-count-<?=$c->topic_id;?>"><?=($c->total_replies ? '('.$c->total_replies.' replies)' : '');?></span> <i class="fa fa-angle-down reply-arrow-down"></i></span> 
                  <?=($c->document_name ? ($c->document_type == 'file' ? '<span class="badge danger msg-badge">1</span>' : '') : '');?>
                  <span class="msg-comments download-docs text-blue">
				  <?=($c->document_name ? ($c->document_type == 'file' ? '<a class="document-anchor" target="_blank" href="'.base_url().UPLOADS_URL.'/conversation/doc/'.md5('forum'.$c->topic_id).'/'.$c->document_name.'" download>Download Documents</a>' : '') : '');?>
                  </span>
              </div>
              <!--reply-->
              <div id="replies-wrap-<?=$c->topic_id;?>" class="custom-hidden">
              		<div class="message-reply-box">
                    <textarea id="reply-<?=$c->topic_id;?>" class="form-control"></textarea>
                    <button onclick="post_reply('<?=$c->topic_id;?>');" type="button" class="btn btn-info reply-btn" data-reply-btn="<?=$c->topic_id;?>"><i class="fa fa-comment"></i> Reply</button>
                    </div>
                    <div id="replies-<?=$c->topic_id;?>">
             		<?=modules::run('forum/load_replies',$c->topic_id);?>
                    </div>
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

function post_reply(topic_id){
	preloading($('#comments-wrap-'+topic_id));
	var reply = $('#reply-'+topic_id).val();
	$.ajax({
	type: "POST",
	dataType: "JSON",
	url: "<?=base_url();?>forum/ajax/post_reply",
	data: {topic_id:topic_id,reply:reply},
		success: function(data) {
			$('#reply-'+topic_id).val('');
			$('#wrapper_loading').remove();
			$('#replies-'+topic_id).html(data['replies']).removeClass('custom-hidden');
			$('#reply-count-'+topic_id).html('('+data['total_replies']+' replies)');
		}
	});
}
</script>