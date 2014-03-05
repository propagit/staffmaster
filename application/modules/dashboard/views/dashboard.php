<div class="col-md-12">
	<div class="box top-box dash-box-paddings">
    	<div class="col-md-9 remove-left-padding">
        <h2>Your Dashboard</h2>
        <p>Welcome to your dashboard. Your dashboard will give you a quick overview of activity going on within Staffmaster. Check back regularly to keep yourself up to date.</p>
        </div>
        <div class="col-md-3 remove-right-padding">
        	<div class="inner-box dash-invoice-stat-wrap">
            	<span class="dash-invoice-head">Invoice Status</span><a class="invoice-pay-now">Pay Now</a>
                <hr class="dash-invoice-hr" />
                <div class="invoice-row">
                	<span class="col-md-6 dash-invoice-label">System Invoice Due:</span><span class="col-md-6 dash-invoice-value">$885.90</span>
                    <span class="col-md-6 dash-invoice-label">Due Date:</span><span class="col-md-6 dash-invoice-value text-custom-danger">27 Days <span class="font-weight-600">(over due)</span></span>
                    <span class="col-md-6 dash-invoice-label">System Lock:</span><span class="col-md-6 dash-invoice-value text-custom-danger"><i class="fa fa-exclamation-triangle"></i> 3 Days</span>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="col-md-12">
	<div class="box bottom-box">
    	<div class="col-md-6 white-box">
            <div class="inner-box">
                <h2>Conversations</h2>
                <p>Join the conversation and get involved!</p>
                <button class="btn btn-core dash-start-conversation"><i class="fa fa-comments-o"></i> Start Conversation</button>
                <ul class="messages">
                    <li class="by-user">
                        <a href="#" title=""><img src="<?=base_url();?>assets/img/dummy/default-avatar.png" alt=""></a>
                        <div class="message-area">
                            <span class="aro"><i class="fa fa-angle-left message-fa"></i></span>
                            <div class="info-row">
                                <span class="title"><strong>John</strong> says:</span>
                                <span class="time">3 hours ago</span>
                            </div>
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam vel est enim, vel eleifend felis. Ut volutpat, leo eget euismod scelerisque, eros purus lacinia velit, nec rhoncus mi dui eleifend orci. 
                            Phasellus ut sem urna, id congue libero. Nulla eget arcu vel massa suscipit ultricies ac id velit
                        </div>
                    </li>
                
                    <li class="divider"><span>...</span></li>
                
                    <li class="by-me">
                        <a href="#" title=""><img src="<?=base_url();?>assets/img/dummy/default-avatar.png" alt=""></a>
                        <div class="message-area">
                            <span class="aro"><i class="fa fa-angle-right message-fa"></i></span>
                            <div class="info-row">
                                <span class="title"><strong>Eugene</strong> says:</span>
                                <span class="time">3 hours ago</span>
                            </div>
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam vel est enim, vel eleifend felis. Ut volutpat, leo eget euismod scelerisque, eros purus lacinia velit, nec rhoncus mi dui eleifend orci. 
                            Phasellus ut sem urna, id congue libero. Nulla eget arcu vel massa suscipit ultricies ac id velit
                        </div>
                    </li>
                
                    <li class="by-me">
                        <a href="#" title=""><img src="<?=base_url();?>assets/img/dummy/default-avatar.png" alt=""></a>
                        <div class="message-area">
                            <span class="aro"><i class="fa fa-angle-right message-fa"></i></span>
                            <div class="info-row">
                                <span class="title"><strong>Eugene</strong> says:</span>
                                <span class="time">3 hours ago</span>
                            </div>
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam vel est enim, vel eleifend felis. Ut volutpat, leo eget euismod scelerisque, eros purus lacinia velit, nec rhoncus mi dui eleifend orci. 
                            Phasellus ut sem urna, id congue libero. Nulla eget arcu vel massa suscipit ultricies ac id velit
                        </div>
                    </li>
                    
                    <li class="divider"><span>...</span></li>
                
                    <li class="by-user">
                        <a href="#" title=""><img src="<?=base_url();?>assets/img/dummy/default-avatar.png" alt=""></a>
                        <div class="message-area">
                            <span class="aro"><i class="fa fa-angle-left message-fa"></i></span>
                            <div class="info-row">
                                <span class="title"><strong>John</strong> says:</span>
                                <span class="time">3 hours ago</span>
                            </div>
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam vel est enim, vel eleifend felis. Ut volutpat, leo eget euismod scelerisque, eros purus lacinia velit, nec rhoncus mi dui eleifend orci. 
                            Phasellus ut sem urna, id congue libero. Nulla eget arcu vel massa suscipit ultricies ac id velit
                        </div>
                    </li>
                    
                    <li class="divider"><span>...</span></li>
                
                    <li class="by-me">
                        <a href="#" title=""><img src="<?=base_url();?>assets/img/dummy/default-avatar.png" alt=""></a>
                        <div class="message-area">
                            <span class="aro"><i class="fa fa-angle-right message-fa"></i></span>
                            <div class="info-row">
                                <span class="title"><strong>Eugene</strong> says:</span>
                                <span class="time">3 hours ago</span>
                            </div>
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam vel est enim, vel eleifend felis. Ut volutpat, leo eget euismod scelerisque, eros purus lacinia velit, nec rhoncus mi dui eleifend orci. 
                            Phasellus ut sem urna, id congue libero. Nulla eget arcu vel massa suscipit ultricies ac id velit
                        </div>
                    </li>
            </ul>
            </div>
        </div>
        
        <div class="col-md-6 white-box">
            <div class="inner-box">
                <?=modules::run('dashboard/load_daily_statistics');?>
            </div>
        </div>
    </div>
</div>