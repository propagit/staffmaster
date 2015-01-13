<? if (count($timesheets) == 0) { ?>
<div class="alert alert-warning">
There is no time sheet at the moment
</div>
<? } else { ?>
<div class="table-responsive">
<table class="table table-bordered table-hover table-middle" width="100%">
<thead>
	<tr>
		<th class="center" width="20"><input type="checkbox" class="selected_all_timesheets" /></th>
		<th class="center">Date</th>
		<th>Client</th>
		<th>Venue</th>
		<th>Staff</th>
		<th class="center">Start - Finish</th>
		<th class="center">Break</th>
		<th class="center">Pay rate</th>
		<th class="center">Expenses</th>
		<th class="center" width="40">View</th>
		<th class="center" width="140">Status</th>
	</tr>
</thead>
<tbody>
	<? foreach($timesheets as $timesheet) { 
		echo modules::run('timesheet/timesheet_staff/row_timesheet', $timesheet['timesheet_id'], $is_supervised); 
	} ?>
</tbody>
</table>

<script>
$(function() {
	init_edit();
	
	//init tooltip for rejected timesheets
    $('[data-toggle="tooltip"]').tooltip();
	
	$('#menu-timesheet-action ul li a[data-value="submit"]').click(function(){
		var selected_timesheets = new Array();
		$('.selected_timesheet:checked').each(function(){
			//selected_timesheets.push($(this).val());
			submit_timesheet($(this).val());
		});
	});
});
function init_edit() {
	$('.selected_all_timesheets').click(function(){
		$(this).parent().parent().parent().parent().find('input.selected_timesheet').prop('checked', this.checked);		
	});
	$('.ts_start_time').editable({
		combodate: {
            firstItem: '',
            minuteStep: 15
        },
		url: '<?=base_url();?>timesheet/ajax_staff/update_timesheet_start_time',
        success: function(response, newValue) {
	        if (response.status == 'error') {
				return response.msg;
			}
			else {
				refrest_timesheet($(this).attr('data-pk'));
			}
        }
    });
    $('.ts_finish_time').editable({
		combodate: {
            firstItem: '',
            minuteStep: 15
        },
        url: '<?=base_url();?>timesheet/ajax_staff/update_timesheet_finish_time',
        success: function(response, newValue) {
	        if (response.status == 'error') {
				return response.msg;
			}
			else {
				refrest_timesheet($(this).attr('data-pk'));
			}
        }
    });
    
    var tmp = $.fn.popover.Constructor.prototype.show;
	$.fn.popover.Constructor.prototype.show = function () {
	  tmp.call(this);
	  if (this.options.callback) {
	    this.options.callback();
	  }
	}
	
	$('.ts_breaks').popover({
		html: true,
		placement: 'bottom',
		trigger: 'manual',
		selector: false,
		title: 'Break',
		template: '<div class="popover popover-break"><div class="arrow"></div><div class="popover-inner"><h3 class="popover-title"></h3><div class="popover-content"><p></p></div></div></div>',
		content: function(){
			return $('#wrapper_ts_break').html();
		}
	});
	$('body').on('click', function (e) {
	    $('[data-toggle=popover]').each(function () {
	        // hide any open popovers when the anywhere else in the body is clicked
	        if (!$(this).is(e.target) && $(this).has(e.target).length === 0 && $('.popover').has(e.target).length === 0) {
	            $(this).popover('hide');
	        }
	    });
    });
}
function submit_timesheet(timesheet_id) {
	$.ajax({
		type: "POST",
		url: "<?=base_url();?>timesheet/ajax_staff/submit_timesheet",
		data: {timesheet_id: timesheet_id},
		success: function(html) {
			refrest_timesheet(timesheet_id);
		}
	})
}
function refrest_timesheet(timesheet_id) {
	$.ajax({
		type: "POST",
		url: "<?=base_url();?>timesheet/ajax_staff/refresh_timesheet",
		data: {timesheet_id: timesheet_id, is_supervised: <?=$is_supervised;?>},
		success: function(html) {
			$('#timesheet_' + timesheet_id).replaceWith(html);
			init_edit();
		}
	})
}
function load_ts_breaks(obj) {
	$('#wrapper_ts_break').html('');
	$('#wrapper_ts').find('.popover-break').hide();
	var pk = $(obj).attr('data-pk');
	$.ajax({
		type: "POST",
		url: "<?=base_url();?>timesheet/ajax/load_ts_breaks",
		data: {pk: pk},
		success: function(html) {
			$('#wrapper_ts_break').html(html);
		}
	}).done(function(){
		$(obj).popover('show');
		$('.break-add').click(function(){
			var list_breaks = $(this).parent().find('#list-breaks');
			$.ajax({
				type: "POST",
				url: "<?=base_url();?>timesheet/ajax/add_ts_break",
				data: {pk: pk},
				success: function(html) {
					$(list_breaks).append(html);
				}
			})			
		});		
		$('.break-submit').click(function(){
			$.ajax({
		    	type: "POST",
		    	url: "<?=base_url();?>timesheet/ajax/update_ts_breaks",
		    	data: $('#form_update_ts_breaks').serialize(),
				success: function(data) {
					data = $.parseJSON(data);
					if (!data.ok) {	
						$('.editable-breaks').each(function(i,obj) {
							$(obj).removeClass('has-error');
							if (i== data.number) {
								$(obj).addClass('has-error');
							}
						});
					}
					else {
						$('.ts_breaks').popover('hide');
						refrest_timesheet(pk);
					}
					
				}			
			})
		})
		$('.break-cancel').click(function(){
			$('.ts_breaks').popover('hide');
		})
	})
}
</script>
<? } ?>