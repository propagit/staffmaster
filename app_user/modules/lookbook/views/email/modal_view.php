
<!-- Contact Staff Modal-->
<div class="modal fade lb-modal" id="lookbook-email-modal" tabindex="-1" role="dialog" aria-labelledby="contact-staff-label" aria-hidden="true">
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
                            <div class="col-md-8">
                                <div
                                    multi-select
                                    input-model="states"
                                    button-label="code"
                                    item-label="code name"
                                    tick-property="ticked"
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
                    	<div class="lb-row">
                    		<?php echo modules::run('lookbook/get_staff_card_preview',11);?>
                        </div>
                        
                        <div class="lb-row">
                        	<span id="selected-staff-count">22</span> staff selected in staff book
                        </div>
                        <div class="lb-row">
                        	<button class="btn btn-core lb-max-width"><i class="fa fa-eye"></i> Preview Staff Book</button>
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
                                      <input type="text" class="form-control" id="sample_email_to" name="sample_email_to">
                                      <span class="input-group-btn">
                                        <button id="send-sample-email" class="btn btn-default sample-email-btn" type="button"><i class="fa fa-envelope-o"></i></button>
                                      </span>
                                    </div><!-- /input-group -->
                              </div>
                     	</div>
                    </div>     

                </div><!-- /.modal-body -->
            </div><!-- /.col-sm-12
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->