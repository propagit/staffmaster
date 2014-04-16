<!--begin top box--->
<div class="col-md-12">
	<div class="box top-box">
   		 <h2>Conversations</h2>
		 <p>Conversations can be created and posted to your staff groups. Your staff can be asigned to groups via their staff profile. An overview of your conversations can be found below.</p>
    </div>
</div>
<!--end top box-->


<!--begin bottom box -->
<div class="col-md-12">
	<div class="box bottom-box">
    	<div class="inner-box">
            <h2>Manage Conversations</h2>
		 	<p>Add a new conversation or manage an existing conversation. Conversations will automatically delete after 6 months of inactivity.</p>
            <button class="btn btn-core" data-toggle="modal" data-target=".bs-modal-lg" href="<?=base_url();?>forum/ajax/create_topic_form"><i class="fa fa-comments-o"></i> Start Conversation</button>
			<div id="load-conversation-list" class="attr-list-wrap">

            </div>
            
        </div>
    </div>
</div>
<!--end bottom box -->


<!-- Cannot edit poll modal -->
<div class="modal fade" id="editPoll" tabindex="-1" role="dialog" aria-labelledby="editPollLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>
				<h4 class="modal-title">Edit Poll</h4>
			</div>
            <div class="col-md-12">
                <div class="modal-body">
                    <p>Once a poll has been published you cannot edit it. <br /><br />If you made a mistake while creating a poll, you can delete that poll and create a new one.</p>
                </div>
            </div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<script>
var sort_data = {
	'sort_by':'ft.created_on',
	'sort_order':'desc'
};

var params = {
	'url': '<?=base_url();?>forum/ajax/load_conversation_list',
	'output_container':'#load-conversation-list',
	'type':'POST',
	'data':JSON.stringify(sort_data)
};

var delete_conversation_params = {
	'url': '<?=base_url();?>forum/ajax/delete_conversation',
	'delete_id':''
}

$(function(){
	//create conversation
	help.create_conversation('load-conversation-list','<?=base_url();?>forum/ajax/load_conversation_list');
	
	//create poll
	help.create_poll('load-conversation-list','<?=base_url();?>forum/ajax/load_conversation_list');
	
	//load conversation list
	help.load_content(params);
});//ready



</script>