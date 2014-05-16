<?php if(isset($users) && count($users)){?>
<table class="table table-bordered table-hover table-middle table-expanded">
    <thead>
    <tr class="heading">
        <th class="left">Receiver</th>
        <th class="center col-md-1">Remove</th>
    </tr>
    </thead>
    <tbody>
	<?php
		foreach($users as $user){
			$full_name = $user->full_name;
			if(!trim($full_name)){
				$full_name = $user->first_name.' '.$user->last_name;	
			}
	?>
    	<tr id="receiver-list-tr-<?=$user->user_id;?>">
       		<td class="left"><?=($full_name != '' ? $full_name : $user->email_address);?></td>
        	<td class="center col-md-1"><i class="fa fa-times delete-receiver" data-receiver-id="<?=$user->user_id;?>"></i></td>
   		</tr>
    <?php
		}
	?>
    </tbody>
</table>


<script>
$(function(){
	$('.delete-receiver').on('click',function(){
		delete_receiver($(this).attr('data-receiver-id'));
	});	
});
</script>
<?php } else{
	echo '<div class="email-modal-receiver-list-error-msg">You have no user in your send list.</div>';
}
?>
