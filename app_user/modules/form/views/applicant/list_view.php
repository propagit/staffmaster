<!-- Data Tables -->
<script type="text/javascript" src="<?=base_url();?>assets/datatables/media/js/jquery.dataTables.min.js"></script>

<!--begin top box--->
<div class="col-md-12">
	<div class="box top-box">
   		 <h2><i class="icon-applicantStaff"></i> &nbsp; Applicants</h2>
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
					array('value' => 'print', 'label' => 'Print Selected'),
					array('value' => 'reject', 'label' => 'Reject Selected')
				);
				echo modules::run('common/menu_dropdown', $data, 'applicant-action', 'Actions');
			?>
		    <form id="multi-applicants-form">
			<div class="table-responsive">
			<table class="table table-bordered table-hover table-middle" id="table-applicants">
			<thead>
		        <tr class="heading">
		        	<th class="center" width="40"><input type="checkbox" id="select_all_applicants" /></th>
		            <th class="left col-md-2">Applicant Name  <i class="fa fa-sort sort-result" sort-by="applicant_name"></i></th>
		            <th class="left">Applied On  <i class="fa fa-sort sort-result" sort-by="applied_on"></i></th>
		            <th class="center">Provided Data</th>
		            <th class="left">Form Name</th>
		            <th class="center">View</th>
		        </tr>
		    </thead>
		    <tbody>
			<? foreach($applicants as $applicant) {
				$name = $this->form_model->get_applicant_name($applicant['applicant_id']);
			?>
				<tr id="applicant_<?=$applicant['applicant_id'];?>">
					<td class="center"><input type="checkbox" name="applicant_ids[]" value="<?=$applicant['applicant_id'];?>" /></td>
					<td class="left"><?=$name;?></td>
					<td class="left"><!--<?=date('Ymd', strtotime($applicant['applied_on']));?>--> <?=date('d/m/Y H:i', strtotime($applicant['applied_on']));?></td>
					<td class="center"><?=$applicant['total_fields'];?></td>
					<td class="left"><?=$applicant['name'];?></td>
					<td class="center"><a onclick="view_applicant(<?=$applicant['applicant_id'];?>)"><i class="fa fa-eye"></i></a></td>
				</tr>
			<? } ?>
		    </tbody>
			</table>
			</div>
		    </form>
		</div>
	</div>
</div>
<!--end bottom box -->

<!-- Modal -->
<div class="modal fade" id="waitingModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content" id="order-message">
			<img src="<?=base_url();?>assets/img/loading3.gif" />
			<h2>Please wait!</h2>
			<p>Please wait a moment while we are processing your request ...</p>
		</div>
	</div>
</div>

<script>
$(function(){
	$('#table-applicants').dataTable({
	    "dom" : '<"top"f<"manify">i>rt<"row"<"col-md-3 actions"><"col-md-6 col-center"p><"col-md-3"l>><"clear">',
	    "paging": false,
	    "info": false,
	    "searching": false,
		"aoColumns": [
			null,
			{ "bSortable": true },
			{ "sType": "string" }, //THIS IS THE DATE
			null,
			null,
			null
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

	$('#menu-applicant-action ul li a[data-value="print"]').click(function(e){
		e.preventDefault();
		$('#waitingModal').modal('show');
		$.ajax({
			type: "POST",
			async: false,
			url: "<?=base_url();?>form/ajax/print_applicants",
			data: $('#multi-applicants-form').serialize(),
			success: function(html) {
				$('#waitingModal').modal('hide');
				window.open('<?=base_url() . UPLOADS_URL;?>/pdf/' + html, 'Shifts List');
			}
		})
	})
	$('#waitingModal').modal({
		backdrop: 'static',
		keyboard: true,
		show: false
	})
})
function view_applicant(applicant_id) {
	$('.bs-modal-lg').modal({
		remote: "<?=base_url();?>form/ajax/view_applicant/" + applicant_id,
		show: true
	});
}
function reject_applicant(applicant_id, btn) {
	help.confirm_delete('Reject Applicant','Are you sure you want to reject this applicant?',function(confirmed){
		if(confirmed){
			$(btn).button('loading');
			$.ajax({
				type: "POST",
				url: "<?=base_url();?>form/ajax/reject_applicant",
				data: {applicant_id: applicant_id},
				success: function(html) {
					$(btn).button('reset');
					$('#applicant_' + applicant_id).remove();
					$('.bs-modal-lg').modal('hide');
				}
			})
		}
	});
}
function accept_applicant(applicant_id, status, btn) {
	$(btn).button('loading');
	$.ajax({
		type: "POST",
		url: "<?=base_url();?>form/ajax/accept_applicant",
		data: {applicant_id: applicant_id, status: status},
		success: function(html) {
			$(btn).button('reset');
			$('#applicant_' + applicant_id).remove();
			$('.bs-modal-lg').modal('hide');
		}
	})
}
</script>
<? } ?>
