<table class="table table-bordered table-hover table-middle table-expanded">
	<thead>
	<tr class="heading">
		<th class="left">Title <i class="fa fa-sort sort-table" sort-by="ft.title"></i></td>
        <th class="left col-md-2">Author <i class="fa fa-sort sort-table" sort-by="u.first_name"></i></th>
        <th class="center col-md-1">Date <i class="fa fa-sort sort-table" sort-by="ft.created_on"></i></th>
        <th class="center col-md-1">Replies <i class="fa fa-sort sort-table" sort-by="total_replies"></i></th>
		<th class="center col-md-1"><i class="icon-eye-open"></i> View/Edit</td>
		<th class="center col-md-1"><i class="icon-trash"></i> Delete</td>
	</tr>
	</thead>
    <tbody>
    <?php 
	  	if($conversations){
			foreach($conversations as $c){ 
	  ?>
	<tr>
		<td class="left"><?=$c->title;?> <?=($c->type == 'poll' ? '<strong>(Poll)</strong>' : '');?></td>
        <td class="left"><a href="<?=base_url();?>staff/edit/<?=$c->created_by;?>"><?=$c->first_name.' '.$c->last_name;?></a></td>
        <td class="center">
            <div class="col-md-1 col-xs-1 wrap-list-date time center-div-date">                            
                <span class="wk_date"><?=date('d',strtotime($c->created_on));?></span>
                <span class="wk_month"><?=date('M',strtotime($c->created_on));?></span>
            </div>
        </td>
        <td class="center"><a href="<?=base_url();?>forum/manage_conversation_replies/<?=$c->topic_id?>"><?=$c->total_replies;?></a></td>
		<td class="center">
        	<?php if($c->type == 'poll'){ ?>
            <a data-toggle="modal" data-target="#editPoll"><i class="fa fa-pencil edit-poll"></i></a>
            <?php }else{ ?>
        	<a data-toggle="modal" data-target=".bs-modal-lg" href="<?=base_url();?>forum/ajax/load_edit_conversation_modal/<?=$c->topic_id;?>" class="edit-conversation" edit-data-id="<?=$c->topic_id;?>"><i class="fa fa-pencil"></i></a>
            <?php } ?>
        </td>
		<td class="center"><a class="delete-conversation" delete-data-id="<?=$c->topic_id;?>" delete-data-title="Conversation"><i class="fa fa-times"></i></a></td>
	</tr>
	<?php }} ?>
    </tbody>
</table>

<script>
$(function(){
	//sort data
	help.sort_list('.sort-table',params);
	
	//delete conversation
	$('.delete-conversation').on('click',function(){
		var conversation_type = $(this).attr('delete-data-title');
		var title = 'Delete '+conversation_type;
		var message ='Are you sure you would like to delete this "'+conversation_type+'"';
		var topic_id = $(this).attr('delete-data-id');
		help.confirm_delete(title,message,function(confirmed){
			 if(confirmed){
				 delete_conversation_params.delete_id = topic_id;
				 help.delete_data(delete_conversation_params,params);
			 }
		});
	});
	

});//ready

</script>