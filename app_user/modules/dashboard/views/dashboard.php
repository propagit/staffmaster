<div class="col-md-12">
	<div class="box top-box dash-box-paddings">
    	<div class="col-md-9 remove-left-padding">
        <h2>Your Dashboard</h2>
        <p>Welcome to your dashboard. Your dashboard will give you a quick overview of activity going on within Staff Master. Check back regularly to keep yourself up to date.</p>
        </div>
        <div class="col-md-3 remove-right-padding remove-left-padding">
        	<div class="inner-box dash-invoice-stat-wrap">
            	<div class="invoice-head-wrap">
            		<span class="dash-invoice-head">Invoice Status</span><a class="invoice-pay-now">Pay Now</a>
                </div>
                <hr class="dash-invoice-hr" />
                <div class="invoice-row">
                	<span class="col-md-6 dash-invoice-label">System Invoice Due:</span><span class="col-md-6 dash-invoice-value">$885.90</span>
                </div>
                <div class="invoice-row">
                    <span class="col-md-6 dash-invoice-label">Due Date:</span><span class="col-md-6 dash-invoice-value text-custom-danger">27 Days <span class="font-weight-600">(over due)</span></span>
                </div>
                <div class="invoice-row">
                    <span class="col-md-6 dash-invoice-label">System Lock:</span><span class="col-md-6 dash-invoice-value text-custom-danger"><i class="fa fa-exclamation-triangle"></i> 3 Days</span>
                </div>
            </div>
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