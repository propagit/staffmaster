<!--reply -->
<?php 
	if(isset($replies) && count($replies)){ 
		foreach($replies as $r){
?>
<div class="reply-wrap">
    <a class="<?=($user['user_id'] == $r->posted_by ? 'push' : 'pull');?>" href="#" title="">
    	<?php
			$reply_user = modules::run('user/get_user',$r->posted_by);
			if($reply_user['is_client']){
		?>
        	<div class="profile_photo">
                <div class="default-avatar-photo">
                    <i class="fa fa-male"></i>
                </div>
            </div>
        <?php
			}else{
				echo modules::run('staff/profile_image',$r->posted_by);
			}
		?>
    </a>
    <div class="message-area <?=($user['user_id'] == $r->posted_by ? 'reply-by-user' : 'reply-by-me');?>">
        <span class="aro <?=($user['user_id'] == $r->posted_by ? 'aro-left' : 'aro-right');?>"><i class="fa <?=($user['user_id'] == $r->posted_by ? 'fa-angle-left' : 'fa-angle-right');?> message-fa"></i></span>
        <div class="info-row reply-row">
            <div class="col-md-1 col-xs-1 wrap-list-date time reply-date">                            
                <span class="wk_date display-inline"><?=date('d',strtotime($r->posted_on));?></span>
                <span class="wk_month display-inline"><?=date('M',strtotime($r->posted_on));?></span>
            </div>
            <span class="title reply-user-name"><?=modules::run('user/get_user_full_name',$r->posted_by);?></span>
        </div>
        <?=nl2br($r->message);?>
    </div>
</div>
<?php } }?>
<!--end reply-->