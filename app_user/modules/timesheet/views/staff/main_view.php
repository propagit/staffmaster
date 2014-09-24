<!--begin top box--->
<div class="col-md-12">
	<div class="box top-box">
		<h2>Time Sheets</h2>
		<p>To process your pay we require you to submit your time sheets. As you complete your shifts time sheets will become available below for you to submit. Hit the generate time sheet button to generate all your time sheets</p>
		<br />
		<a class="btn btn-core mobile-tab" id="btn-generate">Generate Time sheets</a>
	</div>
</div>
<!--end top box-->

<!--begin bottom box -->
<div class="col-md-12">
	<div class="box bottom-box">
		<div class="inner-box">
			
			<h2>Your Time Sheets</h2>
			<p>If your shift differed from the originally planned shift then make an amendment and hit the submit button</p>
			<?
				$data = array(
					array('value' => 'submit', 'label' => '<i class="fa fa-arrow-right"></i> Submit Selected')
				);
				echo modules::run('common/menu_dropdown', $data, 'timesheet-action', 'Actions');
			?>
			<div class="btn-group btn-nav tab-respond mob-class">
				<ul class="nav nav-tabs tab-respond">
					<li class="active"><a href="#yours_timesheets" data-toggle="tab">Your Time Sheets</a></li>
					
					<li><a href="#supervised_timesheets" data-toggle="tab">Your Supervised Time Sheets</a></li>
					
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
<div id="wrapper_ts_break" class="hide"></div>


<!-- Modal -->
<div class="modal fade" id="waitingModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content" id="order-message">
			<img src="<?=base_url();?>assets/img/loading3.gif" />
			<h2>Please wait!</h2>
			Please wait a moment while we are generating time sheets ...
		</div>
	</div>
</div>



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
	$('#waitingModal').modal({
		backdrop: 'static',
		keyboard: true,
		show: false
	})
	$('#btn-generate').click(function(){
		$('#waitingModal').modal('show');
		$.ajax({
			type: "POST",
			url: "<?=base_url();?>timesheet/ajax_staff/generate_timesheets",
			success: function(html) {
				list_timesheets();
				load_supervised_timesheets();
				setTimeout(function() {
					$('#waitingModal').modal('hide');
				}, 2000);				
			}
		})
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