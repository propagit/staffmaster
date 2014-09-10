<!-- Data Tables -->
<script type="text/javascript" src="<?=base_url();?>assets/datatables/media/js/jquery.dataTables.min.js"></script> 

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
		<div class="inner-box">
			<?
				# Action menu
				$data = array(
					array('value' => 'reject', 'label' => 'Reject Selected')
				);
				echo modules::run('common/menu_dropdown', $data, 'applicant-action', 'Actions');
			?>
			<div class="table-responsive">
			<table class="table table-bordered table-hover table-middle" id="table-applicants">
			<thead>
		        <tr class="heading">
		        	<th class="center" width="40"><input type="checkbox" id="select_all_applicants" /></th>
		            <th class="center col-md-2">Applicant Name  <i class="fa fa-sort sort-result" sort-by="applicant_name"></i></th>
		            <th class="left">Applied On  <i class="fa fa-sort sort-result" sort-by="applied_on"></i></th>
		            <th class="center">Provided Data</th>
		            <th class="left">Form Name</th>
		            <th class="center">View</th>
		        </tr>
		    </thead>
		    <form id="multi-applicants-form">
		    <tbody>
			<? foreach($applicants as $applicant) { 
				$name = $this->form_model->get_applicant_name($applicant['applicant_id']);
			?>
				<tr id="applicant_<?=$applicant['applicant_id'];?>">
					<td class="center"><input type="checkbox" name="applicant_ids[]" value="<?=$applicant['applicant_id'];?>" /></td>
					<td class="center"><?=$name;?></td>
					<td class="left"><!--<?=date('Ymd', $applicant['applied_on']);?>--> <?=date('d/m/Y H:i', strtotime($applicant['applied_on']));?></td>
					<td class="center"><?=$applicant['total_fields'];?></td>
					<td class="left"><?=$applicant['name'];?></td>
					<td class="center"><a onclick="view_applicant(<?=$applicant['applicant_id'];?>)"><i class="fa fa-eye"></i></a></td>
				</tr>
			<? } ?>
		    </tbody>
		    </form>
			</table>
			</div>
		</div>
	</div>
</div>
<!--end bottom box -->

<script>
$(function(){
	$('#table-applicants').dataTable({
	    "dom" : '<"top"f<"manify">i>rt<"row"<"col-md-3 actions"><"col-md-6 col-center"p><"col-md-3"l>><"clear">',
	    "paging": false,
	    "info": false,
	    "searching": false,
		"aoColumnDefs": [
			{ 
				'bSortable': false, 
				'aTargets': [ 0, 3, 4, 5 ] 
			}
		]
    });
    
	$('#select_all_applicants').click(function(){
		$('input[name="applicant_ids[]"]').prop('checked', this.checked);		
	});
	$('#menu-applicant-action ul li a[data-value="reject"]').confirmModal({
		confirmTitle: 'Reject selected applicants',
		confirmMessage: 'Are you sure you want to reject selected applicants?',
		confirmCallback: function(e) {
			$.ajax({
				type: "POST",
				url: "<?=base_url();?>form/ajax/reject_applicants",
				data: $('#multi-applicants-form').serialize(),
				success: function(html) {
					location.reload();
				}
			})
		}
	});
})
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