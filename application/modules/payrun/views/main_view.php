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
					<!-- Pay Run stats -->
					<div class="pull-right box-rounded" id="payrun-stats">
						
					</div><!-- End Pay Run stats -->
				</div>
			</div>
			<br />
			<!-- Filter Menus -->
			<div id="nav_payruns">
				<?=modules::run('payrun/menu_dropdown_actions', 'action', 'Actions');?>
				<?=modules::run('common/menu_dropdown_states', 'state', 'Location: Any');?>
				<?=modules::run('payrun/menu_dropdown', 'status', 'Pay Run: Any');?>				
				<?=modules::run('staff/menu_dropdown_tfn', 'tfn', 'Employed: Any');?>				
			</div><!-- End Filter Menus -->
			
			<!-- List Pay Runs -->
			<div id="list_payruns"></div><!-- End List Pay Runs -->
		</div>
	</div>
</div>

<script>
$(function() {
	list_payruns();
	get_payrun_stats();
	<? if ($prf_state = $this->session->userdata('prf_state')) { ?>
	select_menu('state', '<?=$prf_state;?>', 'Location');
	<? } ?>
	<? if ($prf_tfn = $this->session->userdata('prf_tfn')) { ?>
	select_menu('tfn', '<?=$prf_tfn;?>', 'Employed');
	<? } ?>
	<? if ($prf_status = $this->session->userdata('prf_status')) { ?>
	select_menu('status', '<?=$prf_status;?>', 'Pay Run');
	<? } ?>
	$('#menu-state ul li a').click(function(){
		var value = $(this).attr('data-value');
		var label = $(this).html();
		$('#menu-state .menu-label').html('Location: ' + label);
		$.ajax({
			type: "POST",
			url: "<?=base_url();?>payrun/ajax/set_filter",
			data: {name: 'state', value:value},
			success: function(html) {
				list_payruns();
			}
		})		
	});
	$('#menu-tfn ul li a').click(function(){
		var value = $(this).attr('data-value');
		var label = $(this).html();
		$('#menu-tfn .menu-label').html('Employed: ' + label);
		$.ajax({
			type: "POST",
			url: "<?=base_url();?>payrun/ajax/set_filter",
			data: {name: 'tfn', value:value},
			success: function(html) {
				list_payruns();
			}
		})		
	});
	$('#menu-status ul li a').click(function(){
		var value = $(this).attr('data-value');
		var label = $(this).html();
		$('#menu-status .menu-label').html('Pay Run: ' + label);
		$.ajax({
			type: "POST",
			url: "<?=base_url();?>payrun/ajax/set_filter",
			data: {name: 'status', value:value},
			success: function(html) {
				list_payruns();
			}
		})		
	});
})
function select_menu(id, value, label) {
	$('#menu-' + id + ' ul li a').each(function(i, e){
		if ($(this).attr('data-value') == value) {
			$('#menu-' + id + ' .menu-label').html(label + ': ' + $(this).html());
		}
	});
}
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
function get_payrun_stats() {
	preloading($('#payrun-stats'));
	$.ajax({
		type: "POST",
		url: "<?=base_url();?>payrun/ajax/get_payrun_stats",
		success: function(html) {
			loaded($('#payrun-stats'), html);
		}
	})
}
</script>