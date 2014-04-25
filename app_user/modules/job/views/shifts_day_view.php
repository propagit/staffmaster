<div id="nav_shifts">
<?
	$selected_shifts = array();
	if ($this->session->flashdata('selected_shifts')) {
		$selected_shifts = $this->session->flashdata('selected_shifts');
	}
	
	# Action menu
	$data = array(
		array('value' => 'copy', 'label' => '<i class="fa fa-copy"></i> Copy Selected'),
		array('value' => 'edit', 'label' => '<i class="fa fa-pencil-square-o"></i> Edit Selected'),
	);
	if (!$is_client)
	{
		$data[] = array('value' => 'delete', 'label' => '<i class="fa fa-times"></i> Delete Selected');
		$data[] = array('value' => 'attach_brief', 'label' => '<i class="fa fa-info-circle"></i> Attach Brief');
		$data[] = array('value' => 'attach_note', 'label' => '<i class="fa fa-comment-o"></i> Add Note');
		$data[] = array('value' => 'contact_staff', 'label' => '<i class="fa fa-envelope-o"></i> Contact Staff');
	}
	echo modules::run('common/menu_dropdown', $data, 'day-action', 'Actions');
	
	# Filter menu
	$data = array(
		array('value' => '', 'label' => 'Any'),
		array('value' => SHIFT_UNASSIGNED, 'label' => 'Unassigned'),
		array('value' => SHIFT_UNCONFIRMED, 'label' => 'Unconfirmed'),
		array('value' => SHIFT_CONFIRMED, 'label' => 'Confirmed'),
		array('value' => SHIFT_REJECTED, 'label' => 'Rejected'),
		array('value' => SHIFT_FINISHED, 'label' => 'Completed')
	);
	$filter = $this->session->userdata('shift_status_filter');
	$label = 'Status: Any';
	foreach($data as $e) {
		if ($filter != '' && $e['value'] == $filter) { $label = 'Status: ' . $e['label']; }
	}
	echo modules::run('common/menu_dropdown', $data, 'status', $label);
?>
	<div class="btn-group btn-nav">
		<ul class="nav nav-tabs tab-respond">
			<li class="pull-right"><a class="load_month_view"><i class="fa fa-calendar"></i></a></li>
			<li class="pull-right"><a class="load_week_view"><i class="fa fa-list"></i></a></li>
			<li<?=($this->session->userdata('job_date') == 'all') ? ' class="active"' : '';?>><a onclick="load_job_shifts(<?=$job_id;?>,'all')">Total:  <?=$total_date;?> days and <?=modules::run('job/count_job_shifts', $job_id,null);?> shifts</a></li>
			<? foreach($job_dates as $date) { ?>
			<li<?=($this->session->userdata('job_date') == $date['job_date']) ? ' class="active"' : '';?>>
				<a onclick="load_job_shifts(<?=$job_id;?>,'<?=$date['job_date'];?>')">
					<?=date('d', strtotime($date['job_date']));?>
					<span class="month"><?=date('M', strtotime($date['job_date']));?></span>
					(<?=modules::run('job/count_job_shifts', $job_id, strtotime($date['job_date']));?>)
				</a>
			</li>
			<? } ?>
		</ul>
	</div>
</div>
                 
<div class="table-responsive">
<table class="table table-bordered table-hover table-middle" width="100%">
<thead>
	<tr>
		<th class="center" width="20"><input type="checkbox" id="selected_all_shifts" /></th>
		<th class="center">Date <i onclick="sort_shifts('date')" class="fa fa-sort"></i></th>
		<th>Venue <i onclick="sort_shifts('venue')" class="fa fa-sort"></i></th>
		<th>Role <i onclick="sort_shifts('role')" class="fa fa-sort"></i></th>
		<? if ($is_client) { ?>
		<th>Uniform</th>
		<? } ?>
		<th class="center">Start - Finish</th>
		<th class="center">Break</th>
		<? if (!$is_client) { ?>
		<th class="center">Pay rate</th>
		<? } ?>
		<th>Staff Assigned &nbsp; <i onclick="sort_shifts('status')" class="fa fa-sort"></i></th>
		
		<? if (!$is_client) { ?>
		<th class="center" colspan="2">Find</th>
		<th class="center" colspan="2">Settings</th>
		<th class="center" colspan="2" width="30">Brief</th>
		<th class="center">Exp</th>
		<? } else { ?>
		<th class="center" colspan="2">Request</th>
		<? } ?>
	</tr>
</thead>
<tbody>
<? if (count($job_shifts) == 0) { ?>
	<tr>
		<td colspan="14">
			No shifts found
		</td>
	</tr>
<? } else foreach($job_shifts as $shift) {
	echo modules::run('job/shift/row_view', $shift['shift_id']);
	
} ?>
</tbody>
</table>
</div>


<div id="wrapper_shift_break"></div>
<div id="wrapper_shift_staff" class="hide"></div>
<div id="wrapper_staff_hours" class="hide"></div>

<!--email-->
<div id="ajax-email-apply-shift-modal"></div>
<form id="apply-shift-contact-email-form">
<input type="hidden" name="email_modal_header" value="Invoice Client" />
<input type="hidden" name="email_template_id" value="<?=APPLY_FOR_SHIFT_EMAIL_TEMPLATE_ID;?>" />
<input type="hidden" id="selected-module-ids" name="selected_module_ids[]" value="" />
<?php $allowed_email_templates = array(APPLY_FOR_SHIFT_EMAIL_TEMPLATE_ID);?>
<input type="hidden" name="allowed_template_ids" value="<?=json_encode($allowed_email_templates);?>" />
</form>
<!--end email-->


<script>
$(function(){
	init_inline_edit();
	$('#menu-status ul li a').click(function(){
		var value = $(this).attr('data-value');
		$.ajax({
			type: "POST",
			url: "<?=base_url();?>job/ajax_shift/set_status_filter",
			data: {value:value},
			success: function(html) {
				load_job_shifts(<?=$job_id;?>);
			}
		})		
	});
	
	$.each($('tr.disabled'), function() {
		$(this).find('input').remove();
		disabled($(this));
		<? if (!modules::run('auth/is_client')) { ?>
		var pk = $(this).find('.shift_uniform').attr('data-pk');
		$(this).find('.content-disabled').html('<a class="btn btn-default" onclick="unlock_shift(' + pk + ')"><i class="fa fa-lock"></i></a>');
		<? } ?>
	});
	
	
	  
    
    var selected_shifts = new Array();
    	

	$('#selected_all_shifts').click(function(){
		$('input.selected_shifts').prop('checked', this.checked);		
	});
	$('#menu-day-action ul li a[data-value="delete"]').confirmModal({
		confirmTitle: 'Delete selected shifts',
		confirmMessage: 'Are you sure you want to delete selected shifts?',
		confirmCallback: function(e) {
			selected_shifts.length = 0;
			$('.selected_shifts:checked').each(function(){
				selected_shifts.push($(this).val());
			});
			delete_shifts(selected_shifts);
		}
	});
	$('#menu-day-action ul li a[data-value="copy"]').click(function(){
		selected_shifts.length = 0;
		$('.selected_shifts:checked').each(function(){
			selected_shifts.push($(this).val());
		});
		if (selected_shifts.length > 0) {
			$('#copy_shift').modal({
				remote: "<?=base_url();?>job/ajax/load_shifts_copy/" + selected_shifts.join("~"),
				show: true
			});
		}
	});
	$('#menu-day-action ul li a[data-value="edit"]').click(function(){
		selected_shifts.length = 0;
		$('.selected_shifts:checked').each(function(){
			selected_shifts.push($(this).val());
		});
		if (selected_shifts.length > 0) {
			$('.bs-modal-lg').modal({
				remote: "<?=base_url();?>job/ajax_shift/load_update_modal/" + selected_shifts.join("~"),
				show: true
			});
		}
		
	});
	//attach brief to multiple shift
	$('#menu-day-action ul li a[data-value="attach_brief"]').click(function(){
		selected_shifts.length = 0;
		$('.selected_shifts:checked').each(function(){
			selected_shifts.push($(this).val());
		});
		if (selected_shifts.length > 0) {
			$('.bs-modal-sml').modal({
				remote: "<?=base_url();?>job/ajax_shift/load_add_brief_multi_shift/" + selected_shifts.join("~"),
				show: true
			});
		}
		
	});
	//attach notes to multiple shift
	$('#menu-day-action ul li a[data-value="attach_note"]').click(function(){
		selected_shifts.length = 0;
		$('.selected_shifts:checked').each(function(){
			selected_shifts.push($(this).val());
		});
		if (selected_shifts.length > 0) {
			$('.bs-modal-sml').modal({
				remote: "<?=base_url();?>job/ajax_shift/load_add_note_multi_shift/" + selected_shifts.join("~"),
				show: true
			});
		}
		
	});
		
	//contact staff
	$('#menu-day-action ul li a[data-value="contact_staff"]').click(function(){
		selected_shifts.length = 0;
		$('.selected_shifts:checked').each(function(){
			selected_shifts.push($(this).val());
		});
		if (selected_shifts.length > 0) {
			$('#selected-module-ids').val(selected_shifts);
			$.ajax({
			  type: "POST",
			  url: "<?=base_url();?>email/ajax/get_send_email_modal",
			  data: $('#apply-shift-contact-email-form').serialize(),
			  success: function(html) {
				  $('#ajax-email-apply-shift-modal').html(html);
				  $('#email-modal').modal('show');	
			  }
		  });
		}
		
	});
})
function init_inline_edit() {
	$('.update_link').on('save', function(e, params) {
		$(this).parent().parent().removeClass('purple');
	});
	$('.shift_venue').editable({
		url: '<?=base_url();?>job/ajax/update_shift_venue',
		name: 'venue_id',
		title: 'Select venue',
		source: [<?=modules::run('attribute/venue/get_venues', 'data_source'); ?>]
	});
	$('.shift_role').editable({
		url: '<?=base_url();?>job/ajax/update_shift_role',
		name: 'role_id',
		title: 'Select role',
		source: [<?=modules::run('attribute/role/get_roles', 'data_source'); ?>]
	});
	<? if (!$is_client) { ?>
	$('.shift_uniform').editable({
		url: '<?=base_url();?>job/ajax/update_shift_uniform',
		name: 'uniform_id',
		title: 'Select Uniform',
		source: [<?=modules::run('attribute/uniform/get_uniforms', 'data_source');?>],
		display: function(value, sourceData) {
			return;
		}
	});
	$('.shift_supervisor').editable({
		url: '<?=base_url();?>job/ajax/update_shift_supervisor',
		name: 'supervisor_id',
		title: 'Select Supervisor',
		source: [<?=modules::run('user/get_users', 'data_source');?>],
		display: function(value, sourceData) {
			return;
		}
	});
	
	<? } else { ?>
	$('.shift_uniform').editable({
		url: '<?=base_url();?>job/ajax/update_shift_uniform',
		name: 'uniform_id',
		title: 'Select Uniform',
		source: [<?=modules::run('attribute/uniform/get_uniforms', 'data_source');?>]
	});
	<? } ?>
	$('.shift_payrate').editable({
		url: '<?=base_url();?>job/ajax/update_shift_payrate',
		name: 'payrate_id',
		title: 'Select Pay Rate',
		source: [<?=modules::run('attribute/payrate/get_payrates', 'data_source');?>]
	});
	$('.shift_start_time').editable({
		combodate: {
            firstItem: '',            
            minuteStep: 15
        },
		url: '<?=base_url();?>job/ajax/update_shift_start_time',
        success: function(response, newValue)
        {
	        if (response.status == 'error')
			{
				return response.msg;
			}
        }
    });
	$('.shift_finish_time').editable({
		combodate: {
            firstItem: '',
            minuteStep: 15
        },
        url: '<?=base_url();?>job/ajax/update_shift_finish_time',
        success: function(response, newValue)
        {
	        if (response.status == 'error')
			{
				return response.msg;
			}
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
	var tmp = $.fn.popover.Constructor.prototype.show;
	$.fn.popover.Constructor.prototype.show = function () {
	  tmp.call(this);
	  if (this.options.callback) {
	    this.options.callback();
	  }
	}
	$('.shift_breaks').popover({
		html: true,
		placement: 'bottom',
		trigger: 'manual',
		selector: false,
		title: 'Break',
		template: '<div class="popover popover-break"><div class="arrow"></div><div class="popover-inner"><h3 class="popover-title"></h3><div class="popover-content"><p></p></div></div></div>',
		content: function(){
			return $('#wrapper_shift_break').html();
		}
	});
	$('.staff_hours').popover({
		html: true,
		placement: 'bottom',
		trigger: 'manual',
		selector: false,
		title: 'Staff Working Hours',
		template: '<div class="popover popover-break"><div class="arrow"></div><div class="popover-inner"><h3 class="popover-title"></h3><div class="popover-content"><p></p></div></div></div>',
		content: function(){
			return $('#wrapper_staff_hours').html();
		}		
	})
	$('.shift_staff').popover({
		html: true,
		placement: 'bottom',
		trigger: 'manual',
		selector: false,
		title: 'Staff Allocated',
		template: '<div class="popover popover-break"><div class="arrow"></div><div class="popover-inner"><h3 class="popover-title"></h3><div class="popover-content"><p></p></div></div></div>',
		content: function(){
			return $('#wrapper_shift_staff').html();
		}
	})
}


//this function is called from job/views/job_details.php
//this is because if included in this page an event listner will be added for each time a search request is made and multiple email request will be triggered
function email_apply_for_shift(){
	//update_ckeditor() function in send_email_modal view file
	preloading($('#send-email-modal-window'));
	update_ckeditor();
	$.ajax({
		type: "POST",
		url: "<?=base_url();?>job/ajax_shift/email_apply_for_shift",
		data: $('#send-email-modal-form').serialize(),
		success: function(html) {
			$('#wrapper_loading').remove();
			$('#msg-email-sent-successfully').removeClass('hide');
			setTimeout(function(){
				$('#msg-email-sent-successfully').addClass('hide');
			}, 3000);
			setTimeout(function(){
				$('#email-modal').modal('hide');
			}, 4000);
		}
	}); 
}


function unlock_shift(pk) {
	 $.ajax({
		type: "POST",
		url: "<?=base_url();?>job/ajax/unlock_shift",
		data: {pk: pk},
		success: function(html) {
			load_job_shifts(<?=$job_id;?>);
		}
	})
	
}
function load_staff_hours(obj)
{
	$('#wrapper_staff_hours').html('');
	$('#wrapper_js').find('.popover-break').hide();
	var pk = $(obj).attr('data-pk');
	var date = $(obj).attr('data-date');
	$.ajax({
		type: "POST",
		url: "<?=base_url();?>job/ajax_shift/load_staff_hours",
		data: {staff_id: pk, date: date},
		success: function(html)
		{
			$('#wrapper_staff_hours').html(html);
		}
	}).done(function(){
		$(obj).popover('show');
	})
}
function load_shift_staff(obj) {
	$('#wrapper_shift_staff').html('');
	$('#wrapper_js').find('.popover-break').hide();
	var pk = $(obj).attr('data-pk');
	$.ajax({
		type: "POST",
		url: "<?=base_url();?>job/ajax/load_shift_staff",
		data: {pk: pk},
		success: function(html)
		{
			$('#wrapper_shift_staff').html(html);
		}
	}).done(function(){
		$(obj).popover('show');
	})
	
}
function load_shift_breaks(obj) {
	$('#wrapper_shift_break').html('');
	$('#wrapper_js').find('.popover-break').hide();
	var pk = $(obj).attr('data-pk');
	$.ajax({
		type: "POST",
		url: "<?=base_url();?>job/ajax/load_shift_breaks",
		data: {pk: pk},
		success: function(html)
		{
			$('#wrapper_shift_break').html(html);
		}
	}).done(function(){		
		$(obj).popover('show');
		$('.break-add').click(function(){
			var list_breaks = $(this).parent().find('#list-breaks');
			$.ajax({
				type: "POST",
				url: "<?=base_url();?>job/ajax/add_shift_break",
				data: {pk: pk},
				success: function(html)
				{
					$(list_breaks).append(html);
				}
			})			
		});		
		$('.break-submit').click(function(){
			$.ajax({
		    	type: "POST",
		    	url: "<?=base_url();?>job/ajax/update_job_shift_breaks",
		    	data: $('#form_update_shift_breaks').serialize(),
				success: function(data)
				{
					data = $.parseJSON(data);
					if (!data.ok)
					{	
						$('.editable-breaks').each(function(i,obj) {
							$(obj).removeClass('has-error');
							if (i== data.number)
							{
								$(obj).addClass('has-error');
							}
						});
					}
					else
					{
						$('.shift_breaks').popover('hide');
						$('#shift_break_' + data.shift_id).html(data.minutes);
					}
					
				}			
			})
		})
		$('.break-cancel').click(function(){
			$('.shift_breaks').popover('hide');
		})
	})
}
</script>