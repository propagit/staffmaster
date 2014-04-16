<table class="table table-bordered table-hover table-middle table-expanded">
    <thead>
    <tr class="heading">
        <th class="left">Brief Title</th>
        <th class="center col-md-1">View</th>
        <th class="center col-md-1">Remove</th>
    </tr>
    </thead>
    <tbody>
    <?php 
		if(isset($briefs) && $briefs){
			foreach($briefs as $brief){
	?>
        <tr>
            <td class="left"><?=$brief->name;?></td>
            <td class="center"><a target="_blank" href="<?=base_url();?>brief/view_brief/<?=$brief->shift_id;?>/<?=$brief->brief_id;?>"><i class="fa fa-eye"></i></a></td>
            <td class="center"><a class="delete-shift-brief" delete-data-id="<?=$brief->shift_brief_id;?>"><i class="fa fa-times"></i></a></td>
        </tr>
     <?php
			}
			
		}
	 ?>
    </tbody>
</table>

<script>
//remove brief from shift
$('.delete-shift-brief').on('click',function(){
	var title = 'Remove Brief From Shift';
	var message ='Are you sure you would like to remove this Brief fromt this shift';
	var shift_brief_id = $(this).attr('delete-data-id');
	help.confirm_delete(title,message,function(confirmed){
		 if(confirmed){
			delete_shift_brief(shift_brief_id);
		 }
	});
});
</script>