<!--begin top box--->
<div class="col-md-12">
	<div class="box top-box">
   		 <h2>Applicants</h2>
   		 <p>Below you will find a list of responses to the forms you have created and syndicated to the web. You can review the responses and delete or approve them to become active or pending staff in the system.</p> 
    </div>
</div>
<? if (count($applicants) > 0) { ?>
<!--begin bottom box -->
<div class="col-md-12">
	<div class="box bottom-box">
		<div class="inner-box table-responsive">
			<table class="table table-bordered table-hover table-middle">
			<thead>
		        <tr class="heading">
		            <th class="center col-md-2">Applicant ID</th>
		            <th class="left">Applied On</th>
		            <th class="center">Provided Data</th>
		            <th class="left">Form Name</th>
		            <th class="center">View</th>
		        </tr>
		    </thead>
		    <tbody>
			<? foreach($applicants as $applicant) { ?>
				<tr id="applicant_<?=$applicant['applicant_id'];?>">
					<td class="center"><?=$applicant['applicant_id'];?></td>
					<td class="left"><?=date('j M Y \a\t H:i', strtotime($applicant['applied_on']));?></td>
					<td class="center"><?=$applicant['total_fields'];?></td>
					<td class="left"><?=$applicant['name'];?></td>
					<td class="center"><a onclick="view_applicant(<?=$applicant['applicant_id'];?>)"><i class="fa fa-eye"></i></a></td>
				</tr>
			<? } ?>
		    </tbody>
			</table>
		</div>
	</div>
</div>
<!--end bottom box -->

<script>
function view_applicant(applicant_id) {
	$('.bs-modal-lg').modal({
		remote: "<?=base_url();?>form/ajax/view_applicant/" + applicant_id,
		show: true
	});
}
function reject_applicant(applicant_id) {
	help.confirm_delete('Reject Applicant','Are you sure you want to reject this applicant?',function(confirmed){
		if(confirmed){
			$.ajax({
				type: "POST",
				url: "<?=base_url();?>form/ajax/reject_applicant",
				data: {applicant_id: applicant_id},
				success: function(html) {
					$('#applicant_' + applicant_id).remove();
					$('.bs-modal-lg').modal('hide');
				}
			})
		}
	});
}
function accept_applicant(applicant_id, status) {
	$.ajax({
		type: "POST",
		url: "<?=base_url();?>form/ajax/accept_applicant",
		data: {applicant_id: applicant_id, status: status},
		success: function(html) {
			$('#applicant_' + applicant_id).remove();
			$('.bs-modal-lg').modal('hide');
		}
	})
}
</script>
<? } ?>