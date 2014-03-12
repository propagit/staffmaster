<div class="modal-dialog modal-lg" id="conversation-create-modal">
	<div class="modal-content">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>
			<h4 class="modal-title" id="myModalLabel">Start Conversation</h4>
		</div>
		<div class="col-md-12">			
			<div class="modal-body modal-form">
            	<ul class="nav nav-tabs tab-respond">
                    <li class="mobile-tab modal-tab-li active"><a class="modal-tab-head" href="#start-conversation-tab" data-toggle="tab">Conversation</a></li>
                    <li class="mobile-tab modal-tab-li"><a class="modal-tab-head" href="#create-poll-tab" data-toggle="tab">Poll</a></li>                            
                </ul>
				<p>
                <br />
                Conversations can be posted to all active staff or to groups of staff. Groups can be created in the manage groups section. Ticking the also send by email will post the conversation to the system dash board an will also send a copy via email to all members of the group.
                </p>
				
				<div class="tab-content">
                        <div class="tab-pane active" id="start-conversation-tab">
                            <form id="start-conversation-form"  enctype="multipart/form-data" action="<?=base_url();?>forum/ajax/start_conversation" method="POST">
                                 <div class="form-group">
                                     <label for="add-button" class="col-sm-2 control-label">Title:</label>
                                      <div class="col-sm-10 modal-add-left-padding">
                                           <input type="text" class="form-control" id="conversation_title" name="conversation_title" data="required" value="<? if(isset($conversation)){ echo $conversation->title; }?>">
                                      </div>
                                 </div>
                                 
                                 <div class="form-group editor-wrap">
                                 	 <label for="add-button" class="col-sm-2 control-label">Message:</label>
                                	 <div class="col-sm-10 modal-add-left-padding">
                                      	 <textarea class="form-control" id="conversation_message" name="conversation_message" data="required"><? if(isset($conversation)){ echo $conversation->message; }?></textarea> 
                                     </div>
                                 </div>
                                 
                                 <div class="form-group editor-wrap margin-bottom-5">
                                 	 <label for="add-button" class="col-sm-2 control-label">&nbsp;</label>
                                	 <div class="col-sm-10 modal-add-left-padding">
                                      	 <div class="fileupload fileupload-staff" data-provides="fileupload" >        
                                            <span class="btn btn-file">
                                                <i class="fa fa-paperclip"></i>
                                                <span class="fileupload-new"> Attach File</span>
                                                <span class="fileupload-exists">Change</span>         
                                                <input type="file" name="userfile"/>
                                            </span>
                                            <span class="fileupload-preview"></span>
                                            <a href="#" class="fileupload-exists" data-dismiss="fileupload" style="float: none"><i class="fa fa-trash-o"></i></a>
                                        </div>  
                                     </div>
                                 </div>
                             	 
                                 <div class="form-group editor-wrap">
                                 	 <label for="add-button" class="col-sm-2 control-label">Post To:</label>
                                	 <div class="col-sm-5">
                                      	 <?=modules::run('attribute/group/conversation_field_select','conversation_groups'); ?> 
                                     </div>
                                	 <div class="col-sm-5 modal-add-left-padding modal-checkbox-wrap">
                                      	 <input type="checkbox" name="send_by_email" /> Also send via email
                                         <button id="start-conversation" type="button" class="btn btn-info pull"><i class="fa fa-comments-o"></i> Post</button>
                                     </div>
                                 </div>
                                 
                                 <div class="form-group add-top-margin-20 hide"  id="msg-conversation-started-successfully">
                                     <label for="add-button" class="col-sm-2 control-label">&nbsp;</label>
                                      <div class="col-sm-10 modal-add-left-padding">
                                           <div class="alert alert-success"><i class="fa fa-check"></i> &nbsp; Conversation Succesfully Posted</div>
                                      </div>
                                 </div>
                                 <input type="hidden" name="update_id" value="<? if(isset($conversation)){ echo $conversation->topic_id; }?>" />
                            </form>
                            
                            
                        </div><!--send-email-->	
                        
                        		
                        <div class="tab-pane" id="create-poll-tab">
                        
                        </div>

                    </div>
			</div>
		</div>
	</div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->

