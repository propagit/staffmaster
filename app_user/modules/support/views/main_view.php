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
           <br />
           <form id="start-conversation-form" class="form-horizontal" enctype="multipart/form-data" action="<?=base_url();?>forum/ajax/start_conversation" method="POST">
             <div class="form-group">
                 <label for="add-button" class="col-sm-2 control-label">Title:</label>
                  <div class="col-sm-4">
                       <input type="text" class="form-control" id="conversation_title" name="conversation_title" data="required" value="<? if(isset($conversation)){ echo $conversation->title; }?>" maxlength="100">
                  </div>
             </div>
             
             <div class="form-group">
                 <label for="add-button" class="col-sm-2 control-label">Message:</label>
                 <div class="col-sm-4">
                     <textarea class="form-control" id="conversation_message" name="conversation_message" data="required"><? if(isset($conversation)){ echo $conversation->message; }?></textarea> 
                 </div>
             </div>
             
             <div class="form-group margin-bottom-5">
                 <label for="add-button" class="col-sm-2 control-label">&nbsp;</label>
                 <div class="col-sm-4">
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
             
             <div class="form-group">
             	<label for="add-button" class="col-sm-2 control-label">&nbsp;</label>
                 <div class="col-sm-4">
                     <button id="start-conversation" type="button" class="btn btn-info pull"><i class="fa fa-comments-o"></i> Post</button>
                 </div>
             </div>
             <input type="hidden" value="support" name="conversation_type" />
        </form>
		
        <div id="load-spports">
			<?=modules::run('support/load_support_tickets');?>
        </div>        
        
        </div>
    </div>
</div>
<!--end bottom box -->
<script>
$(function(){
	//create conversation
	help.create_conversation('load-spports','<?=base_url();?>support/ajax/reload_supports');
});//ready
</script>