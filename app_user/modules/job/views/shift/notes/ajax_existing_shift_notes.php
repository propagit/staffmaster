<?php if(count($shift_notes)){ ?>
<h4 class="modal-body-title">Existing Shift Notes</h4>
<table class="table table-bordered table-hover table-middle table-expanded">
    <thead>
    <tr class="heading">
        <th class="left">Notes</th>
        <th class="center col-md-1">Remove</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach($shift_notes as $notes){ ?>
    <tr class="heading">
        <td class="left"><?=nl2br($notes->note);?></td>
        <td class="center col-md-1"><a class="delete-shift-notes" delete-data-id="<?=$notes->job_shift_note_id;?>"><i class="fa fa-times"></i></a></td>
    </tr>
    <?php } ?>
    </tbody>
</table>

<script>
//remove brief from shift
$('.delete-shift-notes').on('click',function(){
	var title = 'Remove Note From Shift';
	var message ='Are you sure you would like to remove this Note from this shift';
	var job_shift_note_id = $(this).attr('delete-data-id');
	help.confirm_delete(title,message,function(confirmed){
		 if(confirmed){
			delete_shift_note(job_shift_note_id);
		 }
	});
});

</script>

<?php } ?>