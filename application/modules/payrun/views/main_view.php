<!--begin top box--->
<div class="col-md-12">
	<div class="box top-box">
		<h2>Pay Run</h2>
		<p>Create a pay run and export it to your favourite accounts package. Time sheets have been batched together by staff name. Set the status of the time sheets you would like to process to “Pay Now”, and use the filters to create your pay run for export.</p>
	</div>
</div>
<!--end top box-->

<!--begin bottom box -->
<div class="col-md-12">
	<div class="box bottom-box">
		<div class="inner-box">
			<ul class="nav nav-tabs tab-respond">
				<li><a href="<?=base_url();?>timesheet">Time Sheets</a></li>
				<li class="active"><a>Pay Run</a></li>
			</ul>
			<br />
			<div class="row">
				<div class="col-md-7 white-box">
					<h2>Approved Time Sheets</h2>
					<p>All the below time sheets have been approved and are ready for processing. To create your "Pay Run" change the status of the time sheets to "Pay Now" then filter the list by status. Choose export selected from the action menu to export time sheets to your favourite accounts package. Setting the status of the time sheets as "Paid" will remove them from the list, archive the records and update your accounts dashboard and statistical reports in the system</p>
				</div>
				<div class="col-md-5">
					<div class=" pull-right box-rounded">
						<table class="table table-topless">
							<tr>
								<th>Type</th>
								<th>Staff</th>
								<th>Amount</th>
							</tr>
							<tr>
								<td>TFN Pay Run</td>
								<td></td>
								<td></td>
							</tr>
							<tr>
								<td>ABN Pay Run</td>
								<td></td>
								<td></td>
							</tr>
						</table>
					</div>
				</div>
			</div>
			<br />
			<div id="nav_payruns">
				<div class="btn-group btn-nav">
					<button type="button" class="btn btn-core">Action</button>
					<button type="button" class="btn btn-core dropdown-toggle" data-toggle="dropdown">
						<span class="caret"></span>
						<span class="sr-only">Toggle Dropdown</span>
					</button>
					<ul class="dropdown-menu" role="menu">
						<li><a>Edit name</a></li>
						<li><a>Duplicate</a></li>
						<li><a>Delete</a></li>
					</ul>
				</div>
				<?=modules::run('common/menu_dropdown_states', 'state', 'Filter by Location');?>
				
				<div class="btn-group btn-nav">
					<button type="button" class="btn btn-core">Filter by Status</button>
					<button type="button" class="btn btn-core dropdown-toggle" data-toggle="dropdown">
						<span class="caret"></span>
						<span class="sr-only">Toggle Dropdown</span>
					</button>
					<ul class="dropdown-menu" role="menu">
						<li><a>Edit name</a></li>
						<li><a>Duplicate</a></li>
						<li><a>Delete</a></li>
					</ul>
				</div>
				<?=modules::run('staff/menu_dropdown_tfn', 'tfn', 'Filter by TFN');?>				
			</div>
			<div id="list_payruns"></div>
		</div>
	</div>
</div>

<script>
$(function() {
	list_payruns();
})

function list_payruns() {
	preloading($('#list_payruns'));
	$.ajax({
		type: "POST",
		url: "<?=base_url();?>payrun/ajax/list_payruns",
		success: function(html) {
			loaded($('#list_payruns'), html);
		}
	})
}
</script>