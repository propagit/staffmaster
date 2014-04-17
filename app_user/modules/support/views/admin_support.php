<!--begin top box--->
<div class="col-md-12">
	<div class="box top-box">
   		 <h2>Support</h2>
		 <p>
         	Need support?<br />
            Contact our team via the below form to receive a prompt response.
         </p>
    </div>
</div>
<!--end top box-->


<!--begin bottom box -->
<div class="col-md-12">
	<div class="box bottom-box">
    	<div class="inner-box push full-width">
           <h2>Lodge Support Ticket</h2>
           <p>Support tickets are lodget to StaffMaster support staff. Support tickets will be responded to via the email address of the user who submits the ticket.</p>
           <br />
           <form id="lodge-support-form" class="form-horizontal">
             <div class="form-group">
                 <label for="add-button" class="col-sm-2 control-label">Support Ticket Title</label>
                  <div class="col-sm-4">
                       <input type="text" class="form-control" name="ticket_title" data="required" value="">
                  </div>
             </div>
             
             <div class="form-group">
                 <label for="add-button" class="col-sm-2 control-label">Support Type</label>
                  <div class="col-sm-4">
                   <?=modules::run('support/support_type_dropdown','support_type');?>    
                  </div>
             </div>
             
             <div class="form-group">
                 <label for="add-button" class="col-sm-2 control-label">Message</label>
                 <div class="col-sm-4">
                     <textarea class="form-control" name="support_message" data="required"></textarea> 
                 </div>
             </div>
             
             <div class="form-group">
             	<label for="add-button" class="col-sm-2 control-label">&nbsp;</label>
                 <div class="col-sm-4">
                     <button id="lodge-support" type="button" class="btn btn-info push"><i class="fa fa-envelope"></i> Send</button>
                 </div>
             </div>
             <div class="form-group">
             	<label for="add-button" class="col-sm-2 control-label">&nbsp;</label>
                <div class="col-sm-10">
                	<div class="alert alert-success add-top-margin-20 hide" id="msg-email-sent-successfully"><i class="fa fa-check"></i> &nbsp; Support Ticket Successfully Lodged</div>
                </div>
             </div>
             
        </form>

        </div>
    </div>
</div>
<!--end bottom box -->
<script>
$(function(){
	//send support email
	$('#lodge-support').on('click',function(){
		if(help.validate_form('lodge-support-form')){
			send_email();	
		}
	});
});//ready

function send_email(){
	preloading($('body'));			
	$.ajax({
		  type: "POST",
		  url: "<?=base_url();?>support/ajax/lodge_admin_support",
		  data: $('#lodge-support-form').serialize(),
		  success: function(html) {
			$('#wrapper_loading').remove();
			$('#msg-email-sent-successfully').removeClass('hide');
			setTimeout(function(){
				$('#msg-email-sent-successfully').addClass('hide');
			}, 3000);		
		  }
	  });	
}
</script>