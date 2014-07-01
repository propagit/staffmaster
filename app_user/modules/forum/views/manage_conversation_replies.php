<!--begin top box--->
<div class="col-md-12">
	<div class="box top-box">
   		 <h2>Conversations</h2>
		 <p>Conversations can be created and posted to your staff groups. Your staff can be assigned to groups via their staff profile. An overview of your conversations can be found below.</p>
    </div>
</div>
<!--end top box-->


<!--begin bottom box -->
<div class="col-md-12">
	<div class="box bottom-box">
    	<div class="inner-box">
            <h2>Manage Conversation Replies</h2>
		 	<p>Delete replies for Conversation <strong>[<?=$conversation->title;?>]</strong></p>
			<table class="table table-bordered table-hover table-middle table-expanded">
                <thead>
                <tr class="heading">
                    <th class="left">Replies</td>
                    <th class="left col-md-2">Author</th>
                    <th class="center col-md-1">Date</th>
                    <th class="center col-md-1"><i class="icon-trash"></i> Delete</td>
                </tr>
                </thead>
                <tbody>
                <?php 
                    if($replies){
                        foreach($replies as $r){ 
                  ?>
                <tr id="tr-msg-<?=$r->message_id;?>">
                    <td class="left"><?=$r->message;?></td>
                    <td class="left"><a href="<?=base_url();?>staff/edit/<?=$r->posted_by;?>"><?=modules::run('user/get_user_full_name',$r->posted_by);?></a></td>
                    <td class="center">
                        <div class="col-md-1 col-xs-1 wrap-list-date time center-div-date">                            
                            <span class="wk_date"><?=date('d',strtotime($r->posted_on));?></span>
                            <span class="wk_month"><?=date('M',strtotime($r->posted_on));?></span>
                        </div>
                    </td>
                    <td class="center"><a class="delete-conversation" delete-data-id="<?=$r->message_id;?>"><i class="fa fa-times"></i></a></td>
                </tr>
                <?php }} ?>
                </tbody>
            </table>
            
        </div>
    </div>
</div>
<!--end bottom box -->
<script>
$(function(){
	
	//delete conversation
	$('.delete-conversation').on('click',function(){
		var title = 'Delete Reply';
		var message ='Are you sure you would like to delete this "Reply"';
		var message_id = $(this).attr('delete-data-id');
		help.confirm_delete(title,message,function(confirmed){
			 if(confirmed){
				 delete_forum_message(message_id);
			 }
		});
	});
});//ready

function delete_forum_message(message_id){
	$.ajax({
		type: "POST",
		url: "<?=base_url();?>forum/ajax/delete_forum_reply",
		data: {message_id:message_id},
		success: function(html) {
			$('#tr-msg-'+message_id).remove();
		}
	});
}

</script>