<!-- Contact Staff Modal-->
<div class="modal fade" id="email-modal" tabindex="-1" role="dialog" aria-labelledby="contact-staff-label" aria-hidden="true">
	<div class="modal-dialog contact-modal">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>
				<h4 class="modal-title"><?=$email_modal_header;?></h4>
			</div>
			
            <div class="col-md-12">
                <div class="modal-body staff-contact-modal-body">
                	<ul class="nav nav-tabs tab-respond" id="nav-contact-staff">
                        <li class="mobile-tab active"><a class="contact-staff-tab-head" href="#send-email-modal-window" data-toggle="tab">Send Email</a></li>
                        <li class="mobile-tab"><a class="contact-staff-tab-head" href="#send-sms-modal-window" data-toggle="tab">Send SMS</a></li>                            
                    </ul>
                    
                    <div class="tab-content">
                        <div class="tab-pane active" id="send-email-modal-window">
                            <form id="send-email-modal-form">
                               <div class="form-group">
                                     <div class="col-sm-5 remove-left-gutter">
                                            <?=modules::run('email/email_templates_dropdown',$email_template_select_params);?>
                                     </div>
                                     <label for="add-button" class="col-sm-2 control-label">Send Sample Email</label>
                                      <div class="col-sm-5 remove-right-gutter">
                                          <div class="input-group">
                                              <input type="text" class="form-control" id="sample_email_to" name="sample_email_to">
                                              <span class="input-group-btn">
                                                <button onclick="send_sample_email();" class="btn btn-default sample-email-btn" type="button"><i class="fa fa-envelope-o"></i></button>
                                              </span>
                                            </div><!-- /input-group -->
                                      </div>
                                 </div>
                                 
                                 <div class="form-group editor-wrap">
                                	 <div class="col-sm-12 remove-left-gutter remove-right-gutter">
                                      	 <textarea id="email_body" name="email_body"></textarea> 
                                     </div>
                                 </div>
                                 <input type="hidden" id="selected-user-ids" name="selected_user_ids" value='<?=$selected_user_ids;?>' />
                                 <input type="hidden" id="selected-module-ids" name="selected_module_ids" value='<?=$selected_module_ids;?>' />
                            </form>
                             	 <div class="form-group">
                                	 <div class="col-sm-6 remove-left-gutter remove-left-gutter">
                                      	 <button id="send-email-from-modal" type="button" class="btn no-user-in-send-list"><i class="fa fa-envelope-o"></i> Send Mail</button>
										 &nbsp;&nbsp;
                                         (Selected Recipients: <b id="total-selected-receiver"><?=$total;?></b>) 
                                         &nbsp;&nbsp;
                                         <a href="#" id="view-send-list"><i class="fa fa-eye"> </i> View Send List</a>
                                         <div class="alert alert-success add-top-margin-20 hide" id="msg-email-sent-successfully"><i class="fa fa-check"></i> &nbsp; Email Successfully Sent</div>
                                     </div>
                                     <?php
									 	if($template_id != CLIENT_INVOICE_EMAIL_TEMPLATE_ID && $template_id != CLIENT_QUOTE_EMAIL_TEMPLATE_ID && $template_id != SHIFT_REMINDER_EMAIL_TEMPLATE_ID){
									 ?>
                                     <div class="col-sm-6 remove-left-gutter remove-right-gutter">
                                       <label for="add-button" class="col-sm-2 control-label">Groups</label>
                                        <div class="col-sm-10 remove-right-gutter">
                                     		<?=modules::run('attribute/group/field_select','send_email_modal_groups');?>
                                        </div>
                                     </div>
                                     <?php
										}
									 ?>
                                 </div>
                                 
                            
                            
                            
                            <div id="ajax-receiver-list" class="email-modal-receiver-list"></div>
                            
                        </div><!--send-email-->	
                        
                        		
                        <div class="tab-pane" id="send-sms-modal-window">
                        	<h4 class="modal-title">Send SMS feature comming soon. </h4>
                            <p>Don't forget to check the latest Staff Master Updates.</p>
                        </div>

                    </div>
                    
                	
                   
                </div>
            </div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<script>
var receiver_list_visible = false;
var receiver_list_loaded = false;
$(function(){
	load_template(<?=$template_id;?>);
	//load template on first load
	setTimeout(function(){
		load_template(<?=$template_id;?>);	
	},500);

	
	$('#email_template_select').on('change',function(){
		load_template($(this).val());
	});
	
	//view receiver list
	$('#view-send-list').on('click',function(e){
		e.preventDefault();
		if(receiver_list_visible){
			receiver_list_visible = false;
			$('#ajax-receiver-list').hide();
		}else{
			receiver_list_visible = true;
			$('#ajax-receiver-list').show();
			if(!receiver_list_loaded){
				preloading($('#send-email-modal-window'));
				load_receiver_list();
			}
		}
	});
	
	
	//add user belonging to group to selected list
	$('#send_email_modal_groups').on('change',function(){
		add_group_users($(this).val());
	});
	
	toggle_send_mail_btn();
	
	$('.no-user-in-send-list').on('click',function(){
		if($('#total-selected-receiver').html() == '0'){
			$('#ajax-receiver-list').html('<div class="email-modal-receiver-list-error-msg">You have no user in your send list.</div>');
		}
	});

});//ready

function send_sample_email()
{
	preloading($('#send-email-modal-window'));
	update_ckeditor();
	$.ajax({
		  type: "POST",
		  url: "<?=base_url();?>email/ajax/send_sample_email",
		  data: $('#send-email-modal-form').serialize(),
		  success: function(html) {
			$('#wrapper_loading').remove();
			$('#msg-email-sent-successfully').removeClass('hide');
			setTimeout(function(){
				$('#msg-email-sent-successfully').addClass('hide');
			}, 3000);
		  }
	  });
}

var email_body = CKEDITOR.replace('email_body',{
  height:250
});

CKEDITOR.config.toolbar = [
    <?=LIVE_SERVER ? LIVE_CK_TOOLS : DEV_CK_TOOLS;?>
] ;

function update_ckeditor()
{
	for ( instance in CKEDITOR.instances ) {
            CKEDITOR.instances[instance].updateElement();
    }	
}


function load_template(template_id)
{
	$.ajax({
		  type: "POST",
		  url: "<?=base_url();?>email/ajax/load_template",
		  data:{template_id:template_id},
		  success: function(html) {
			  $('#email_body').val(html);
			  CKEDITOR.instances['email_body'].setData(html)
		  }
	  });		
}

function load_receiver_list()
{
	$.ajax({
		  type: "POST",
		  url: "<?=base_url();?>email/ajax/load_receiver_list",
		  data:{selected_user_ids:$('#selected-user-ids').val()},
		  success: function(html) {
			  $('#ajax-receiver-list').html(html);
			  $('#wrapper_loading').remove();
			  receiver_list_loaded = true;
		  }
	  });	
}


function delete_receiver(delete_receiver_id)
{
	$.ajax({
		  type: "POST",
		  url: "<?=base_url();?>email/ajax/delete_receiver",
		  data: {delete_receiver_id:delete_receiver_id,selected_user_ids:$('#selected-user-ids').val()},
		  dataType: "json",
		  success: function(data) {
			$('#receiver-list-tr-'+delete_receiver_id).remove();
			$('#selected-user-ids').val(data['selected_user_ids']);
			$('#total-selected-receiver').html(data['total_selected_users']);
			if(!data['total_selected_users']){
				load_receiver_list();	
				toggle_send_mail_btn();
			}
		  }
	  });	
}

function add_group_users(group_id)
{
	$.ajax({
		  type: "POST",
		  url: "<?=base_url();?>email/ajax/add_group_users_to_email_list",
		  data: {group_id:group_id},
		  dataType: "json",
		  success: function(data) {
			$('#selected-user-ids').val(data['selected_user_ids']);
			$('#total-selected-receiver').html(data['total_selected_users']);
			load_receiver_list();
			toggle_send_mail_btn();
		  }
	  });	
}

function toggle_send_mail_btn()
{
	if($('#total-selected-receiver').html() != '0'){
		$('#send-email-from-modal').addClass('btn-info').addClass('send-email-from-modal').removeClass('no-user-in-send-list');
	}else{
		$('#send-email-from-modal').removeClass('btn-info').removeClass('send-email-from-modal').addClass('no-user-in-send-list');;
	}
}

<?php if(0){?>
/* 

//Function for reference only.
//Write this function from where ever the modal window is being called
//Since the email can be sent to different users such as client or staff with different parameters
//It is wise to gather those info in the individual page itself then pass it to the send email function 

function send_email()
{
	update_ckeditor();
	$.ajax({
		  type: "POST",
		  url: "<?=base_url();?>email/ajax/send_email",
		  data: $('#send-email-modal-form').serialize(),
		  success: function(html) {
			$('#msg-email-sent-successfully').removeClass('hide');
			setTimeout(function(){
				$('#msg-email-sent-successfully').addClass('hide');
			}, 3000);		
		  }
	  });	
} */
<?php } ?>
</script>