<div class="table-responsive">
<table class="table table-bordered table-hover table-middle" width="100%">
<thead>
	<tr>
		<th class="center" width="20"></th>
		<th class="center">Date</th>
		<th>Client</th>
		<th>Venue</th>
		<th class="center">Start - Finish</th>
		<th class="center">Break</th>
		<th class="center">Pay rate</th>
		<th class="center">Expenses</th>
		<th class="center" width="40">View</th>
		<th class="center" width="200">Status</th>
	</tr>
</thead>
<tbody>
	<? foreach($timesheets as $timesheet) { 
		echo modules::run('timesheet/timesheet_staff/row_timesheet', $timesheet['timesheet_id']); 
	} ?>
</tbody>
</table>

<div id="wrapper_ts_break" class="hide"></div>
<script>
$(function() {
	init_edit();
});
function init_edit() {
	$('.ts_start_time').editable({
		combodate: {
            firstItem: '',
            minuteStep: 15
        },
		url: '<?=base_url();?>timesheet/ajax/update_timesheet_start_time',
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
        url: '<?=base_url();?>timesheet/ajax/update_timesheet_finish_time',
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
		data: {timesheet_id: timesheet_id},
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