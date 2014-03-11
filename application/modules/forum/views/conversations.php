<ul class="messages">
	  <?php 
	  	if($conversations){
			foreach($conversations as $c){  
	  ?>
      <li class="<?=($user['user_id'] == $c->created_by ? 'by-user' : 'by-me');?>">
          <a href="#" title=""><?=modules::run('staff/profile_image',$c->created_by);?></a>
          <div class="message-area">
              <span class="aro"><i class="fa <?=($user['user_id'] == $c->created_by ? 'fa-angle-left' : 'fa-angle-right');?> message-fa"></i></span>
              <div class="info-row">
                  <span class="title"><?=substr($c->title,0,200);?></span>
                  <div class="col-md-1 col-xs-1 wrap-list-date time">                            
                      <span class="wk_date"><?=date('d',strtotime($c->created_on));?></span>
                      <span class="wk_month"><?=date('M',strtotime($c->created_on));?></span>
                  </div>
              </div>
              <?=$c->message;?>
              <?=($c->document_name ? ($c->document_type == 'image' ? '<img class="message-img" src="'.base_url().'uploads/conversation/img/'.md5('forum'.$c->topic_id).'/thumb/'.$c->document_name.'" />' : '') : '');?>
              <div class="comments-wrap" id="comments-wrap-<?=$c->topic_id;?>">
                  <span class="msg-comments reply text-blue" data-reply="<?=$c->topic_id;?>">Post Reply</span>
                  <?=($c->document_name ? ($c->document_type == 'file' ? '<span class="badge danger msg-badge">1</span>' : '') : '');?>
                  <span class="msg-comments download-docs text-blue">
				  <?=($c->document_name ? ($c->document_type == 'file' ? '<a class="document-anchor" target="_blank" href="'.base_url().'uploads/conversation/doc/'.md5('forum'.$c->topic_id).'/'.$c->document_name.'" download>Download Documents</a>' : '') : '');?>
                  </span>
              </div>
          </div>
      </li>
      <li class="divider"><span>...</span></li>
      <?php }} ?>
      
	  
	  
	  
	  <?php if(0){ ?>
      <li class="by-user">
          <a href="#" title=""><img class="msg-avatar" src="<?=base_url();?>assets/img/dummy/avatar-2.jpg" alt=""></a>
          <div class="message-area">
              <span class="aro"><i class="fa fa-angle-left message-fa"></i></span>
              <div class="info-row">
                  <span class="title">Conversation title limited to 200 Characters</span>
                  <div class="col-md-1 col-xs-1 wrap-list-date time">                            
                      <span class="wk_date">02</span>
                      <span class="wk_month">JUN</span>
                  </div>
              </div>
              Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam vel est enim, vel eleifend felis. Ut volutpat, leo eget euismod scelerisque, eros purus lacinia velit, nec rhoncus mi dui eleifend orci. 
              Phasellus ut sem urna, id congue libero. Nulla eget arcu vel massa suscipit ultricies ac id velit
              <div class="comments-wrap">
                  <span class="badge danger msg-badge">1</span><span class="msg-comments reply text-blue">Post Reply</span>
                  <span class="msg-comments download-docs text-blue">Download Documents</span>
              </div>
          </div>
      </li>
  
      <li class="divider"><span>...</span></li>
  
      <li class="by-me">
          <a href="#" title=""><img class="msg-avatar" src="<?=base_url();?>assets/img/dummy/avatar-4.jpg" alt=""></a>
          <div class="message-area">
              <span class="aro"><i class="fa fa-angle-right message-fa"></i></span>
              <div class="info-row">
                  <span class="title">Conversation title limited to 200 Characters</span>
                  <div class="col-md-1 col-xs-1 wrap-list-date time">                            
                      <span class="wk_date">02</span>
                      <span class="wk_month">JUN</span>
                  </div>
              </div>
              Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam vel est enim, vel eleifend felis. Ut volutpat, leo eget euismod scelerisque, eros purus lacinia velit, nec rhoncus mi dui eleifend orci. 
              Phasellus ut sem urna, id congue libero. Nulla eget arcu vel massa suscipit ultricies ac id velit
              <div class="comments-wrap">
                  <span class="msg-comments reply text-blue">Post Reply <i class="fa fa-angle-down"></i></span>
                  <span class="msg-comments download-docs text-blue">Download Documents</span>
              </div>
              <!--reply -->
              <div class="reply-wrap">
                  <a class="reply-avatar" href="#" title=""><img class="msg-avatar" src="<?=base_url();?>assets/img/dummy/avatar-2.jpg" alt=""></a>
                  <div class="message-area">
                      <span class="aro"><i class="fa fa-angle-right message-fa"></i></span>
                      <div class="info-row reply-row">
                          <span class="title">Conversation title limited to 200 Characters</span>
                          <div class="col-md-1 col-xs-1 wrap-list-date time">                            
                              <span class="wk_date">02</span>
                              <span class="wk_month">JUN</span>
                          </div>
                      </div>
                      Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam vel est enim, vel eleifend felis. Ut volutpat, leo eget euismod scelerisque, eros purus lacinia velit, nec rhoncus mi dui eleifend orci. 
                      Phasellus ut sem urna, id congue libero. Nulla eget arcu vel massa suscipit ultricies ac id velit
                  </div>
              </div>
              
              <!--end reply-->
              
          </div>
      </li>
  
      <li class="divider"><span>...</span></li>
  
      <li class="by-user">
          <a href="#" title=""><img class="msg-avatar" src="<?=base_url();?>assets/img/dummy/avatar-3.jpg" alt=""></a>
          <div class="message-area">
              <span class="aro"><i class="fa fa-angle-left message-fa"></i></span>
              <div class="info-row">
                  <span class="title">Conversation title limited to 200 Characters</span>
                  <div class="col-md-1 col-xs-1 wrap-list-date time">                            
                      <span class="wk_date">02</span>
                      <span class="wk_month">JUN</span>
                  </div>
              </div>
              Make small radio button quiz so that people can take a quick response
              <div class="survey-wrap">
                  <div class="form-group msg-frm-group">
                      <div class="col-sm-12 remove-left-padding">
                        <div class="radio msg-radio">
                          <label>
                            <input type="radio"> Answer 1
                          </label>
                        </div>
                      </div>
                    </div>
                    <div class="form-group msg-frm-group">
                      <div class="col-sm-12 remove-left-padding">
                        <div class="radio msg-radio">
                          <label>
                            <input type="radio"> Answer 2
                          </label>
                        </div>
                      </div>
                    </div>
              </div>
              <div class="comments-wrap">
                  <span class="badge danger msg-badge">1</span><span class="msg-comments reply text-blue">Post Reply</span>
                  <span class="msg-comments download-docs text-blue">Download Documents</span>
              </div>
          </div>
      </li>
      
      <li class="divider"><span>...</span></li>
  
      <li class="by-me">
          <a href="#" title=""><img class="msg-avatar" src="<?=base_url();?>assets/img/dummy/avatar-5.jpg" alt=""></a>
          <div class="message-area">
              <span class="aro"><i class="fa fa-angle-right message-fa"></i></span>
              <div class="info-row">
                  <span class="title">Conversation title limited to 200 Characters</span>
                  <div class="col-md-1 col-xs-1 wrap-list-date time">                            
                      <span class="wk_date">02</span>
                      <span class="wk_month">JUN</span>
                  </div>
              </div>
              Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam vel est enim, vel eleifend felis. Ut volutpat, leo eget euismod scelerisque, eros purus lacinia velit, nec rhoncus mi dui eleifend orci. 
              Phasellus ut sem urna, id congue libero. Nulla eget arcu vel massa suscipit ultricies ac id velit
              <div class="comments-wrap">
                  <span class="msg-comments reply text-blue">Post Reply</span>
                  <span class="msg-comments download-docs text-blue">Download Documents</span>
              </div>
          </div>
      </li>
      <?php } ?>
</ul>

<script>
$(function(){
	$('.reply').on('click',function(){
		var topic_id = $(this).attr('data-reply');
		var reply_elem = '<div class="message-reply-box"><textarea id="reply-'+topic_id+'" class="form-control"></textarea><button type="button" class="btn btn-info reply-btn" data-reply-btn="'+topic_id+'"><i class="fa fa-comment"></i> Reply</button></div>';
		$('#comments-wrap-'+topic_id).append(reply_elem);
	});
});//ready
</script>