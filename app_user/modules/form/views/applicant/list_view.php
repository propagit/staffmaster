<!--begin top box--->
<div class="col-md-12">
	<div class="box top-box">
   		 <h2>Applicants</h2>
   		 <p>List of applicants who apply through the forms</p> 
    </div>
</div>

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
				<tr>
					<td class="center"><?=$applicant['applicant_id'];?></td>
					<td class="left"><?=date('H:i jS M Y', strtotime($applicant['applied_on']));?></td>
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
</script>