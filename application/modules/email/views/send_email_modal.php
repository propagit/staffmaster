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
                        <li class="mobile-tab active"><a class="contact-staff-tab-head" href="#send-email" data-toggle="tab">Send Email</a></li>
                        <li class="mobile-tab"><a class="contact-staff-tab-head" href="#send-sms" data-toggle="tab">Send SMS</a></li>                            
                    </ul>
                    
                    <div class="tab-content">
                        <div class="tab-pane active" id="send-email">
                            <form id="send-email-form">
                                 <div class="form-group">
                                     <div class="col-sm-5 remove-left-gutter">
                                            <?=modules::run('email/email_templates_dropdown','email_template_select');?>
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
                                 
                             	 <div class="form-group">
                                	 <div class="col-sm-12 remove-left-gutter remove-right-gutter">
                                      	 <button onclick="send_email();"  type="button" class="btn btn-info"><i class="fa fa-envelope-o"></i> Send Mail</button>
										 &nbsp;&nbsp;
                                         (Selected Recipients: <b><?=$total;?></b>) 
                                         &nbsp;&nbsp;
                                         <a href="#"><i class="fa fa-eye"> </i> View Send List</a>
                                         <div class="alert alert-success add-top-margin-20 hide" id="msg-email-sent-successfully"><i class="fa fa-check"></i> &nbsp; Email Successfully Sent</div>
                                     </div>
                                 </div>
                            </form>
                            
                            
                        </div><!--send-email-->	
                        
                        		
                        <div class="tab-pane" id="send-sms">
                        
                        </div>

                    </div>
                    
                	
                   
                </div>
            </div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<script>

$(function(){
	$('#email_template_select').on('change',function(){
		load_template($(this).val());
	});
});//ready

function send_email()
{
	update_ckeditor();
	$.ajax({
		  type: "POST",
		  url: "<?=base_url();?>email/ajax/send_email",
		  data: $('#send-email-form').serialize(),
		  success: function(html) {
			$('#msg-email-sent-successfully').removeClass('hide');
			setTimeout(function(){
				$('#msg-email-sent-successfully').addClass('hide');
			}, 3000);		
		  }
	  });	
}

function send_sample_email()
{
	update_ckeditor();
	$.ajax({
		  type: "POST",
		  url: "<?=base_url();?>email/ajax/send_sample_email",
		  data: $('#send-email-form').serialize(),
		  success: function(html) {
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
   ['Bold', 'Italic', 'Underline', 'Strike'],[ 'NumberedList', 'BulletedList','-','JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock'],['Link', 'Unlink'],['Font'],['FontSize' ],[ 'TextColor', 'BGColor']
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

</script>