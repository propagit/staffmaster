<table class="table table-bordered table-hover table-middle table-expanded">
    <thead>
    <tr class="heading">
        <th class="left">Brief Title</th>
        <th class="center col-md-1">View</th>
        <th class="center col-md-1">Remove</th>
    </tr>
    </thead>
    <tbody>
    <?php if($shift_info['information_sheet']){?>
    	 <tr>
            <td class="left">Information Sheet</td>
            <td class="center"><a target="_blank" href="<?=base_url();?>brief/view_brief/<?=$shift_info['shift_id'];?>"><i class="fa fa-eye"></i></a></td>
            <td class="center"><a class="delete-shift-information-sheet" delete-data-id="<?=$shift_info['shift_id'];?>"><i class="fa fa-times"></i></a></td>
        </tr>
    <?php } ?>
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
	var message ='Are you sure you would like to remove this Brief from this shift';
	var shift_brief_id = $(this).attr('delete-data-id');
	help.confirm_delete(title,message,function(confirmed){
		 if(confirmed){
			delete_shift_brief(shift_brief_id);
		 }
	});
});

//remove information sheet
$('.delete-shift-information-sheet').on('click',function(){
	var title = 'Remove Information Sheet From Shift';
	var message ='Are you sure you would like to remove this Information sheet from this shift';
	var shift_id = $(this).attr('delete-data-id');
	help.confirm_delete(title,message,function(confirmed){
		 if(confirmed){
			delete_shift_information_sheet(shift_id);
		 }
	});
});
</script>