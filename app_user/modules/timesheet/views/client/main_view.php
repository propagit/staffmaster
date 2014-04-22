<!--begin top box--->
<div class="col-md-12">
	<div class="box top-box">
		<h2>Time Sheets</h2>
		<p>To process your pay we require you to submit your time sheets. As you complete your shifts time sheets will become availble below for you to submit. Hit the generate time sheet button to generate all your time sheets</p>
		<br />
		<a class="btn btn-core mobile-tab" href="<?=base_url();?>timesheet/generate">Generate Timesheets</a>
	</div>
</div>
<!--end top box-->

<!--begin bottom box -->
<div class="col-md-12">
	<div class="box bottom-box">
		<div class="inner-box">
			
			<h2>Your Supervised Time Sheets</h2>
			<p>If your shift differed from the originally planned shift then make an amendment and hit the submit button</p>
			<?
				$data = array(
					array('value' => 'submit', 'label' => '<i class="fa fa-arrow-right"></i> Submit Selected')
				);
				echo modules::run('common/menu_dropdown', $data, 'timesheet-action', 'Actions');
			?>
			
			<div id="supervised_timesheets">
			</div>
		</div>
	</div>
</div>
<!--end bottom box -->
<div id="wrapper_ts_break" class="hide"></div>
<script>
$(function(){
	load_supervised_timesheets();
})

function load_supervised_timesheets() {
	preloading($('#supervised_timesheets'));
	$.ajax({
		type: "POST",
		url: "<?=base_url();?>timesheet/ajax_client/load_supervised_timesheets",
		success: function(html) {
			loaded($('#supervised_timesheets'), html);
		}
	})
}
</script>