<!--begin top box--->
<div class="col-md-12">
	<div class="box top-box">
		<h2>Time Sheets</h2>
		<p>To process your pay we require you to submit your time sheets. As you complete your shifts time sheets will become availble below for you to submit.</p>
		<br />
		<a class="btn btn-core" href="#">Generate Timesheets</a>
	</div>
</div>
<!--end top box-->

<!--begin bottom box -->
<div class="col-md-12">
	<div class="box bottom-box">
		<div class="inner-box">
			
			<h2>Your Time Sheets</h2>
			<p>As you are the nominated supervisor for the below shifts we require your approval to submit the time sheets to payroll.  Staff amended time sheets are diplayed red.</p>
			<?
				$data = array(
					array('value' => 'submit', 'label' => '<i class="fa fa-arrow-right"></i> Submit Selected')
				);
				echo modules::run('common/menu_dropdown', $data, 'timesheet-action', 'Actions');
			?>
			<div class="btn-group btn-nav">
				<ul class="nav nav-tabs tab-respond">
					<li class="active"><a href="#yours_timesheets" data-toggle="tab">Your Time Sheets</a></li>
					<? if (count($supervised_timesheets) > 0) { ?>
					<li><a href="#supervised_timesheets" data-toggle="tab">Your Supervised Time Sheets</a></li>
					<? } ?>
				</ul>
			</div>
    			
			<div class="tab-content">
				<div class="tab-pane active" id="yours_timesheets">
				</div>
				<div class="tab-pane" id="supervised_timesheets">
				</div>
			</div>

			
			
		</div>
	</div>
</div>
<!--end bottom box -->

<script>
$(function(){
	list_timesheets();
	load_supervised_timesheets();
	$('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
		//e.target // activated tab
		//e.relatedTarget // previous tab
		$('input.selected_all_timesheets').prop('checked', false);
		$('input.selected_timesheet').prop('checked', false);
	})

})

function list_timesheets() {
	preloading($('#yours_timesheets'));
	$.ajax({
		type: "POST",
		url: "<?=base_url();?>timesheet/ajax_staff/list_timesheets",
		success: function(html) {
			loaded($('#yours_timesheets'), html);
		}
	})
}
function load_supervised_timesheets() {
	preloading($('#supervised_timesheets'));
	$.ajax({
		type: "POST",
		url: "<?=base_url();?>timesheet/ajax_staff/load_supervised_timesheets",
		success: function(html) {
			loaded($('#supervised_timesheets'), html);
		}
	})
}
</script>