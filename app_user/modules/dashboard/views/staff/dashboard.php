<div class="col-md-12">
	<div class="box top-box">
		<h2>Your Dashboard</h2>
		<p>Welcome to your Staff Account dashboard. Your Dashboard will give you a quick overview of activity going on within <?=isset($company['company_name']) ? $company['company_name'] : '';?>. Check back regularly to keep yourself up to date.</p>
        
        <a href="https://itunes.apple.com/us/app/staffbooks/id944842219" target="_blank" class="prim-color-to-txt-color">
            <div class="app-box">
            	<div class="app-logo">
                	<i class="fa fa-apple"></i>
                </div>
                <div class="app-info">
                	<span class="header">Download</span>
                	<span class="sub-header">In The App Store</span>
                </div>
                <span class="company-code">Company Code - <?php #echo SUBDOMAIN;?>labourking</span>
            </div>
        </a>
	</div>
</div>


<div class="col-md-12">
	<div class="box bottom-box">
        
        <div class="col-md-6 white-box">
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
            <?=modules::run('dashboard/dashboard_staff/activity_log');?>		
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