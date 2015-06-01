<form id="lookbook-modal-form">
<!-- Contact Staff Modal-->
<div class="modal fade lb-modal" id="lookbook-config-modal" tabindex="-1" role="dialog" aria-labelledby="contact-staff-label" aria-hidden="true">
	<div class="modal-dialog contact-modal">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>
				<h4 class="modal-title">Send Staff Book</h4>
			</div>
			
			<div class="col-xs-12 padding20">
                <div class="modal-body lb-modal-body" ng-controller="LookbookConfigCtrl">
      
                    <div class="col-md-8 lbm-config remove-gutters">
                    	<div class="lb-config-box">
                            <p><i class="fa fa-info-circle fa-lb"></i> <strong>How to create your staff book</strong></p>
                            <p>
                            Send a staff book containing  the selected staff and your choosen attributes. The StaffBook will be sent to your nominated email address with a link to view the staff book online. 
                            </p>
                        </div>
                        <div class="lb-config-box">
                        	<p><i class="fa fa-cog fa-lb"></i> <strong>Configure visible attributes</strong></p>
                            
                            <div class="col-sm-6 remove-left-gutter">
                            <p><strong>Add Personal Details To View</strong></p>
                                <div
                                    multi-select
                                    input-model="personal"
                                    button-label="label"
                                    item-label="label"
                                    tick-property="ticked"
                                    on-item-click="personal.fClick(data)"
                                    helper-elements=""
                                >
                                </div>
                            </div>
                            
                            <div class="col-sm-6 remove-left-gutter">
                            <p><strong>Add Custom Attributes To View</strong></p>
                                <div
                                    multi-select
                                    input-model="custom"
                                    button-label="label"
                                    item-label="label"
                                    tick-property="ticked"
                                    on-item-click="custom.fClick(data)"
                                    helper-elements=""
                                >
                                </div>
                            </div>
   
                            
                        </div>
                        <div class="lb-config-box">
                        	<p><i class="fa fa-pencil fa-lb"></i> <strong>Add a personal message to the email</strong></p>
                            
                            <div class="form-group editor-wrap">
                                 <div class="col-sm-12 remove-gutters">
                                     <textarea id="lb_email_body" name="lb_email_body"><?=$config_message;?></textarea> 
                                 </div>
                             </div>
                        </div>
                    </div>
                    <div class="col-md-4 lbm-card remove-gutters">
                    	<div class="lb-row" id="staff-card-preview">

                        </div>
                        
                        <div class="lb-row">
                        	<span id="selected_staff_count"></span> staff selected in staff book
                        </div>
                        <div class="lb-row">
                        	<a id="lookbook-preview-url" target="_blank" class="btn btn-core lb-max-width" href="#"><i class="fa fa-eye"></i> Preview Staff Book</a>
                        </div>
                    </div>
                    
                    
                    
                    <div class="col-xs-12 lbm-body-footer">
                    	<div class="form-group">
                             <div class="col-sm-5 remove-left-gutter">
                                    <?php echo modules::run('client/field_select','loobook_client_id');?>
                             </div>
                             <label for="add-button" class="col-sm-2 control-label pull-text" style="margin-top:5px;">Send Sample Email</label>
                              <div class="col-sm-5 remove-right-gutter">
                                  <div class="input-group">
                                      <input type="text" class="form-control" id="lookbook_email_to" name="lookbook_email_to">
                                      <span class="input-group-btn">
                                        <button id="send-lookbook" class="btn btn-core btn-default sample-email-btn" type="button"><i class="fa fa-envelope-o"></i></button>
                                      </span>
                                    </div><!-- /input-group -->
                              </div>
                     	</div>

                        <div class="col-sm-12 alert alert-success add-top-margin-20 hide" id="msg-lookbook-email-sent-successfully"><i class="fa fa-check"></i> &nbsp; StaffBook Successfully Sent</div>
                        <div class="col-sm-12 alert alert-danger add-top-margin-20 hide" id="msg-lookbook-email-error"><i class="fa fa-times"></i> &nbsp; <span id="lookbook-email-err-msg"></span></div>
                 
                    </div>     

                </div><!-- /.modal-body -->
            </div><!-- /.col-sm-12 -->
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->

	<input type="hidden" name="selected_user_ids" id="lookbook_selected_user_ids" value="">
    <input type="hidden" id="lookbook_preview_user_id" value="0">
</form>
<script>


var lb_email_body = CKEDITOR.replace('lb_email_body',{
  height:100
});

CKEDITOR.config.toolbar = [
    <?=TRUE ? LIVE_CK_TOOLS : DEV_CK_TOOLS;?>
] ;

function update_lookbook_ckeditor()
{
	for ( instance in CKEDITOR.instances ) {
            CKEDITOR.instances[instance].updateElement();
    }	
}

$(function(){
	get_card_preview();
	
	$('#loobook_client_id').change(function(){
		get_client_email($('#loobook_client_id').val());
	});
	
});
function get_card_preview(){
	var user_id = $('#lookbook_preview_user_id').val();
	$.ajax({
	   method: "GET",
	   url: "<?=base_url();?>lookbook/ajax/get_staff_card_config_view/"+user_id,
	}).done(function(html) {
	  	$('#staff-card-preview').html(html);
	});	
}
function get_client_email(user_id){
	$.ajax({
	   method: "GET",
	   url: "<?=base_url();?>lookbook/ajax/get_client_email/"+user_id,
	}).done(function(data) {
	  	$('#lookbook_email_to').val(data);
	});	
}


</script>