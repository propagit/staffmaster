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
	help.create_conversation('load-conversation-list','<?=base_url();?>forum/ajax/load_conversation_list');
	
	//load conversation list
	help.load_content(params);
});//ready



</script>