<!--reply -->
<?php 
	if(isset($replies) && count($replies)){ 
		foreach($replies as $r){
?>
<div class="reply-wrap">
    <a class="<?=($user['user_id'] == $r->posted_by ? 'push' : 'pull');?>" href="#" title=""><?=modules::run('staff/profile_image',$r->posted_by);?></a>
    <div class="message-area <?=($user['user_id'] == $r->posted_by ? 'reply-by-me' : '');?>">
        <span class="aro <?=($user['user_id'] == $r->posted_by ? 'aro-left' : '');?>"><i class="fa <?=($user['user_id'] == $r->posted_by ? 'fa-angle-left' : 'fa-angle-right');?> message-fa"></i></span>
        <div class="info-row reply-row">
        	<span class="title reply-user-name"><?=modules::run('user/get_user_full_name',$r->posted_by);?></span>
            <div class="col-md-1 col-xs-1 wrap-list-date time">                            
                <span class="wk_date"><?=date('d',strtotime($r->posted_on));?></span>
                <span class="wk_month"><?=date('M',strtotime($r->posted_on));?></span>
            </div>
        </div>
        <?=nl2br($r->message);?>
    </div>
</div>
<?php } }?>
<!--end reply-->