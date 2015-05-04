<?=modules::run('wizard/main_view', 'dashboard');?>

<div class="col-md-12">
	<div class="box top-box dash-box-paddings">
    	<div class="col-md-9 remove-left-padding">
        <h2>Your Dashboard</h2>
        <p>Welcome to your dashboard. Your dashboard will give you a quick overview of activity going on within Staff Master. Check back regularly to keep yourself up to date.</p>
        </div>
        <div class="dash-credit-box pull">
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
            

        	<div class="inner-box add-top-margin">
                <?=modules::run('user_notes/main_view');?>
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
<!-- Modal -->
<div class="modal fade" id="waitingModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content" id="order-message">
			<img src="<?=base_url();?>assets/img/loading3.gif" />
			<h2>Please wait!</h2>
			Please wait a moment while we are generating time sheets ...
		</div>
	</div>
</div>
<script>
$(function(){
	//create conversation
	help.create_conversation('load-conversations','<?=base_url();?>forum/ajax/reload_conversation');
	//create poll
	help.create_poll('load-conversations','<?=base_url();?>forum/ajax/reload_conversation');
	
	$('#waitingModal').modal({
		backdrop: 'static',
		keyboard: true,
		show: false
	});
	
	$(document).on('click','.generate-timesheet-admin',function(){
		$('#waitingModal').modal('show');
		$.ajax({
			type: "POST",
			url: "<?=base_url();?>timesheet/ajax/generate_timesheets",
			success: function(html) {
				$('#waitingModal').modal('hide');
				get_completed_shift_count();			
			}
		});
	});
	get_completed_shift_count();
	
});//ready
function get_completed_shift_count(){
	$.get( "<?=base_url();?>dashboard/ajax/get_completed_shift_count", function(data) {
 		 $('.completed-shift-count').html(data);
	});
}

</script>
