<div class="modal-dialog">
	<div class="modal-content">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			<h4 class="modal-title" id="myModalLabel">Copy shift</h4>
		</div>
		<div class="modal-body">
			<div class="shift_brief">
				<!--
Venue: 
				<?=modules::run('attribute/venue/display_venue', $shift['venue_id']);?>
				(<?=date('H:i', $shift['start_time']);?> - <?=date('H:i', $shift['finish_time']);?>)
-->
			</div>
			<div class="btn-group">
				<a data-calendar-nav="prev" type="button" class="btn btn-info"><i class="fa fa-arrow-left"></i></a>
				<span type="button" class="btn btn-info" id="modal-header-month"> &nbsp; </span>
				<a data-calendar-nav="next" type="button" class="btn btn-info"><i class="fa fa-arrow-right"></i></a>
			</div>
			<div id="calendar-copy"></div>
			<div class="has-error"><span class="help-block" id="error_day_selected"></span></div>
		</div>
		<div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			<button type="button" class="btn btn-danger btn-clear-days">Clear</button>
			<button type="button" class="btn btn-primary btn-copy-selected-days">Copy to selected dates</button>
		</div>
	</div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->

<script>
var clicked_date = '<?=$shift['job_date'];?>';
var selected_dates = new Array();

$(function(){
	load_copy_calendar();
	$('.btn-clear-days').click(function(){
		$.ajax({
			url: "<?=base_url();?>job/ajax/clear_selected_days",
			success: function(data) {
				load_copy_calendar();
			}
		})	
	});
	$('.btn-copy-selected-days').click(function(){
		$.ajax({
			type: "POST",
			url: "<?=base_url();?>job/ajax/copy_selected_days",
			data: {shift_id: <?=$shift['shift_id'];?>},
			success: function(html) {
				location.reload();
			}
		})
	})
});
function update_selected_days(ts) {
	$.ajax({
		type: "POST",
		url: "<?=base_url();?>job/ajax/update_selected_day",
		data: {ts: ts},
		success: function(data) {
			data = $.parseJSON(data);
			if (data.success) {
				$('#error_day_selected').html('');
				load_copy_calendar();
			}
			else
			{
				$('#error_day_selected').html(data.msg);
			}
		}
	})
}
function load_copy_calendar()
{
	var options = {
		events_source: "<?=base_url();?>job/ajax/get_selected_days",
		view: 'month',
		tmpl_path: "<?=base_url();?>assets/bootstrap-calendar/shift_copy/",
		tmpl_cache: false,
		day: clicked_date,
		onAfterViewLoad: function(view) {
			$('#modal-header-month').text(this.getTitle());
		},
	};	
	var calendar = $('#calendar-copy').calendar(options);
	$('.modal-dialog').find('a[data-calendar-nav]').each(function() {
		var $this = $(this);
		$this.click(function() {
			calendar.navigate($this.data('calendar-nav'));
			$('.modal-dialog').find('*[data-cal-date]').parent().click(function() {
				clicked_date = $(this).find('[data-cal-date]').data('cal-date');
				ts = moment(clicked_date).unix();
				update_selected_days(ts);
			});	
		});
	});
	$('.modal-dialog').find('*[data-cal-date]').parent().click(function() {
		clicked_date = $(this).find('[data-cal-date]').data('cal-date');
		ts = moment(clicked_date).unix();
		update_selected_days(ts);
	});
}
</script>