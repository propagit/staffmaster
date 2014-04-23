<table class="table table-bordered table-hover table-middle" width="100%">
<thead>
	<tr>
		<th class="center" width="100">Created <i class="fa fa-sort sort-result" sort-by="created"></i></th>
		<th class="left">Brief Name <i class="fa fa-sort sort-result" sort-by="name"></i></th>
		<th class="center" width="120">Status</th>
		<th class="center" width="100">View-Edit</th>
		<th class="center" width="100">Email</th>
        <th class="center" width="100">Delete</th>
	</tr>
</thead>
<tbody>
	<?php 
		if(isset($briefs) && $briefs){ 
			foreach($briefs as $brief){
	?>
	<tr id="brief-row-<?=$brief->brief_id;?>">
		<td class="wp-date center">
			<span class="wk_date inline-block full-width"><?=date('d', strtotime($brief->created));?></span>
			<span class="wk_month inline-block full-width"><?=date('M', strtotime($brief->created));?></span>
		</td>
		<td class="left"><a target="_blank" href="<?=base_url();?>brief/view/<?=md5('brief_url'.$brief->brief_id)?>"><?=$brief->name;?></a></td>
		<td class="center">
        	<? $brief_status = modules::run('brief/check_brief_status',$brief->brief_id);?>
        	<?=(!$brief_status) ? '<button type="button" class="btn btn-danger brief-status" data-brief="'.$brief->brief_id.'">Inactive</button>' : '<button type="button" class="btn btn-success brief-status" data-brief="'.$brief->brief_id.'">Active</button>';?>
        </td>
		<td class="center"><a href="<?=base_url();?>brief/edit/<?=$brief->brief_id?>"><i class="fa fa-eye"></i></a></td>
		<td class="center"><i class="fa fa-envelope-o email-brief" data-brief-id="<?=$brief->brief_id;?>"></i></td>
        <td class="center"><a class="delete-brief" delete-data-id="<?=$brief->brief_id;?>"><i class="fa fa-times"></i></a></td>
	</tr>
	<?php } }?>
</tbody>
</table>
<div id="ajax-email-brief-modal"></div>
<form id="email-brief-form">
<input type="hidden" name="email_modal_header" value="Email Brief" />
<input type="hidden" name="email_template_id" value="<?=BRIEF_EMAIL_TEMPLATE_ID;?>" />
<input id="selected-brief-id" type="hidden" name="selected_module_ids[]" value="" />
<?php $allowed_email_templates = array(BRIEF_EMAIL_TEMPLATE_ID);?>
<input type="hidden" name="allowed_template_ids" value="<?=json_encode($allowed_email_templates);?>" />
</form>
<script>

$(function(){
	//sort result
	$('.sort-result').on('click',function(){
		var sort_order = $('#sort-order').val();
		$('#sort-order').val(sort_order == 'asc' ? 'desc' : 'asc');
		$('#sort-by').val($(this).attr('sort-by'));
		reset_current_page();
		search_brief();
	});	

	
	//delete brief
	$('.delete-brief').on('click',function(){
		var title = 'Delete Brief';
		var message ='Are you sure you would like to delete this Brief';
		var brief_id = $(this).attr('delete-data-id');
		help.confirm_delete(title,message,function(confirmed){
			 if(confirmed){
				delete_brief(brief_id);
			 }
		});
	});
	
	//get email modal
	$('.email-brief').on('click',function(){
		$('#selected-brief-id').val($(this).attr('data-brief-id'));
		get_email_model('#email-brief-form');

	});



});//ready
</script>