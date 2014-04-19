<? if (!$company_profile || !$has_staff || !$has_client || !$has_payrate || !$has_venue) { ?>
<div class="inner-box">
	<h2>Welcome to Staff Master</h2>
	<p>To get you started configuring your system we have created the below step by step guide.</p>
	<div class="list-group" id="list-tasks">
		<a class="list-group-item<?=($company_profile) ? ' list-group-item-success' : '';?>" href="<?=base_url();?>setting/company" taret="_blank">
			<? if ($company_profile) { ?>
				<i class="fa fa-done fa-check-circle fa-3x pull-right"></i>
			<? } ?>
			<h3><i class="fa fa-flag"></i> &nbsp; Update Company Profile</h3>
			<? if (!$company_profile) { ?>
				<p>Update company logo and address information</p>
			<? } ?>
		</a>
		
		<a class="list-group-item<?=($has_staff) ? ' list-group-item-success' : '';?>" href="<?=base_url();?>staff/add" target="_blank">
			<? if ($has_staff) { ?>
				<i class="fa fa-done fa-check-circle fa-3x pull-right"></i>
			<? } ?>
			<h3><i class="fa fa-users"></i> &nbsp; Add Staff</h3>
			<? if (!$has_staff) { ?>
				<p>Add or import your staff so that you can assign staff to work on jobs your create</p>
			<? } ?>
		</a>
		
		
		<a class="list-group-item<?=($has_client) ? ' list-group-item-success' : '';?>" href="<?=base_url();?>client/add" target="_blank">
			<? if ($has_client) { ?>
				<i class="fa fa-done fa-check-circle fa-3x pull-right"></i>
			<? } ?>
			<h3><i class="fa fa-book"></i> &nbsp; Add Clients</h3>
			<? if (!$has_client) { ?>
				<p>Add or import your clients to the system.<br />Clients are companies you will bill for doing work.</p>
			<? } ?>
		</a>
		
		<a class="list-group-item<?=($has_payrate) ? ' list-group-item-success' : '';?>" href="<?=base_url();?>attribute/payrate" target="_blank">
			<? if ($has_payrate) { ?>
				<i class="fa fa-done fa-check-circle fa-3x pull-right"></i>
			<? } ?>
			<h3><i class="fa fa-dollar"></i> &nbsp; Add Pay Rates</h3>
			<? if (!$has_payrate) { ?>
				<p>Add a pay rate or other custom attributes like roles under the edit attribute menu</p>
			<? } ?>
		</a>
		<a class="list-group-item<?=($has_venue) ? ' list-group-item-success' : '';?>" href="<?=base_url();?>attribute/venue" target="_blank">
			<? if ($has_venue) { ?>
				<i class="fa fa-done fa-check-circle fa-3x pull-right"></i>
			<? } ?>
			<h3><i class="fa fa-map-marker"></i> &nbsp; Add Venues</h3>
			<? if (!$has_venue) { ?>
				<p>Add or import venues that you will be performing jobs</p>
			<? } ?>
		</a>
	</div>
</div>
<br />
<? } ?>