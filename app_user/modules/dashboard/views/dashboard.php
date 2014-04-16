<div class="col-md-12">
	<div class="box top-box dash-box-paddings">
    	<div class="col-md-9 remove-left-padding">
        <h2>Your Dashboard</h2>
        <p>Welcome to your dashboard. Your dashboard will give you a quick overview of activity going on within Staff Master. Check back regularly to keep yourself up to date.</p>
        </div>
        <div class="pull-right">
        	<?=modules::run('account/box_credits');?>
        </div>
    </div>
</div>

<div class="col-md-12">
	<div class="box bottom-box">
    	<div class="col-md-6 white-box">
        	<div class="inner-box desktop-hidden-lg add-bottom-margin">
                <?=modules::run('dashboard/load_daily_statistics');?>
            </div>
            <div class="inner-box">
            	<div class="msg-head-wrap">
                    <h2>Conversations</h2>
                    <p>Join the conversation and get involved!</p>
                    <button class="btn btn-core dash-start-conversation" data-toggle="modal" data-target=".bs-modal-lg" href="<?=base_url();?>forum/ajax/create_topic_form"><i class="fa fa-comments-o"></i> Start Conversation</button>
                </div>
                <div id="load-conversations">
                	<?=modules::run('forum/load_conversation');?>
                </div>
            </div>
        </div>
        
        <div class="col-md-6 white-box">
            <div class="inner-box desktop-visible-lg">
                <?=modules::run('dashboard/load_daily_statistics');?>
            </div>
            <div class="inner-box add-top-margin">
            	<?=modules::run('dashboard/activity_log');?>
            </div>
            
        </div>
    </div>
</div>
<script>
$(function(){
	//create conversation
	help.create_conversation('load-conversations','<?=base_url();?>forum/ajax/reload_conversation');
	//create poll
	help.create_poll('load-conversations','<?=base_url();?>forum/ajax/reload_conversation');
});//ready
</script>