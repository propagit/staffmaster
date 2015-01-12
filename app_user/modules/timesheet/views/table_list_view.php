<hr />
<h2>Search Results</h2>
<p>Your search returned <b><?=count($timesheets);?></b> results</p>

<? if (count($timesheets) > 0) { ?>
<div id="wrapper_ts">
	<!-- Filter Menus -->
	<div id="nav_payruns">
		<?=modules::run('timesheet/menu_dropdown_actions', 'ts-action', 'Actions');?>			
	</div><!-- End Filter Menus -->
	<div class="table-responsive">
	<table class="table table-bordered table-hover table-middle" width="100%">
	<thead>
		<tr>
			<th class="center" width="20"><input type="checkbox" id="selected_all_timesheets" /></th>
			<th class="center">Date <i class="fa fa-sort sort-data" sort-by="t.job_date"></i></th>
			<th>Client</th>
			<th>Campaign Name</th>
			<th class="center">Start - Finish</th>
			<th class="center">Break</th>
			<th class="center">Pay rate</th>
			<th>Staff Assigned</th>
			<th class="center">Expenses</th>
			<th class="center" width="40">View</th>
			<th class="center" width="40">Batch</th>
			<th class="center" width="40">Delete</th>
		</tr>
	</thead>
	<tbody>
		<? foreach($timesheets as $timesheet) { 
			echo modules::run('timesheet/row_timesheet', $timesheet['timesheet_id']); 
		} ?>
	</tbody>
	</table>
	</div>
	<div id="wrapper_ts_break" class="hide"></div>
	<div id="wrapper_ts_payrate" class="hide"></div>
	<div id="wrapper_ts_staff" class="hide"></div>
</div>
<script>
$(function(){
	init_edit();
	
	//init tooltip for rejected timesheets
    $('[data-toggle="tooltip"]').tooltip();
	
	$('.sort-data').on('click',function(){
		sort_data.sort_by = $(this).attr('sort-by');
		//toggle sort order data for next sort
		(sort_data.sort_order == 'asc' ? sort_data.sort_order = 'desc' : sort_data.sort_order = 'asc');	
		search_timesheets();
	});
})
function init_edit() {
	$('#selected_all_timesheets').click(function(){
		$('input.select_timesheet').prop('checked', this.checked);	
	});
	$('#menu-ts-action ul li a[data-value="batch"]').click(function(){
		$('.select_timesheet:checked').each(function(){
			batch_timesheet($(this).val());
		});
	})
	
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
    /*
$('.ts_payrate').editable({
		url: '<?=base_url();?>timesheet/ajax/update_timesheet_payrate',
		name: 'payrate_id',
		title: 'Select Pay Rate',
		source: [<?=modules::run('attribute/payrate/get_payrates', 'data_source');?>],
		success: function(response, newValue) {
	        refrest_timesheet($(this).attr('data-pk'));
        }
	});
*/
	
	$('.ts_payrate').popover({
		html: true,
		placement: 'bottom',
		trigger: 'manual',
		selector: false,
		title: 'Select Pay Rate',
		template: '<div class="popover popover-break"><div class="arrow"></div><div class="popover-inner"><h3 class="popover-title"></h3><div class="popover-content"><p></p></div></div></div>',
		content: function(){
			return $('#wrapper_ts_payrate').html();
		}
	})
	
	$('body').on('click', function (e) {
	    $('[data-toggle=popover]').each(function () {
	        // hide any open popovers when the anywhere else in the body is clicked
	        if (!$(this).is(e.target) && $(this).has(e.target).length === 0 && $('.popover').has(e.target).length === 0) {
	            $(this).popover('hide');
	        }
	    });
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
	$('.ts_staff').popover({
		html: true,
		placement: 'bottom',
		trigger: 'manual',
		selector: false,
		title: 'Staff Allocated',
		template: '<div class="popover popover-break"><div class="arrow"></div><div class="popover-inner"><h3 class="popover-title"></h3><div class="popover-content"><p></p></div></div></div>',
		content: function(){
			return $('#wrapper_ts_staff').html();
		}
	})
}
function refrest_timesheet(timesheet_id) {
	$.ajax({
		type: "POST",
		url: "<?=base_url();?>timesheet/ajax/refresh_timesheet",
		data: {timesheet_id: timesheet_id},
		success: function(html) {
			$('#timesheet_' + timesheet_id).replaceWith(html);
			init_edit();
		}
	})
}
function batch_timesheet(timesheet_id) {
	$.ajax({
		type: "POST",
		url: "<?=base_url();?>timesheet/ajax/batch_timesheet",
		data: {timesheet_id: timesheet_id},
		success: function(html) {
			$('#timesheet_' + timesheet_id).remove();
		}
	})
}
function delete_timesheet(timesheet_id) {
	var title = 'Delete Timesheet';
	var message ='This action will delete the timesheet and unlock the shift.<br />Are you sure you want to do so?';
	help.confirm_delete(title,message,function(confirmed){
		 if(confirmed){
			 $.ajax({
				 type: "POST",
				 url: "<?=base_url();?>timesheet/ajax/delete_timesheet",
				 data: {timesheet_id: timesheet_id},
				 success: function(html) {
					 $('#timesheet_' + timesheet_id).remove();
				 }
			 })
		 }
	});
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
function load_ts_payrate(obj) {
	$('#wrapper_ts_payrate').html('');
	$('#wrapper_js').find('.popover-break').hide();
	var pk = $(obj).attr('data-pk');
	$.ajax({
		type: "POST",
		url: "<?=base_url();?>timesheet/ajax/load_ts_payrates",
		data: {pk: pk},
		success: function(html)
		{
			$('#wrapper_ts_payrate').html(html);
		}
	}).done(function(){
		$(obj).popover('show');
	})
}
function load_ts_staff(obj) {
	$('#wrapper_ts_staff').html('');
	$('#wrapper_ts').find('.popover-break').hide();
	var pk = $(obj).attr('data-pk');
	$.ajax({
		type: "POST",
		url: "<?=base_url();?>timesheet/ajax/load_ts_staff",
		data: {pk: pk},
		success: function(html) {
			$('#wrapper_ts_staff').html(html);
		}
	}).done(function(){
		$(obj).popover('show');
		$('.ts_staff').on('input', function(){
			var query = $(this).val();
			$.ajax({
				type: "POST",
				url: "<?=base_url();?>timesheet/ajax/search_staff_for_ts",
				data: {query: query},
				success: function(html) {
					$('#staff_quick_search_result').html(html);
				}
			})
		});
	    	
		$('.staff-cancel').click(function(){
			$('.ts_staff').popover('hide');
		});
		$('.staff-submit').click(function(){
			$.ajax({
				type: "POST",
				url: "<?=base_url();?>timesheet/ajax/update_ts_staff",
				data: $('#form_update_ts_staff').serialize(),
				success: function(data) {
					data = $.parseJSON(data);
					if (!data.ok) {	
						$('#f_shift_staff').addClass('has-error');
					}
					else
					{
						refrest_timesheet(pk);
					}
				}
			})
		})
	})
	
}
</script>
<? } ?>