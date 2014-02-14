<div class="table_action">
	
	<ul class="nav nav-tabs nav-action tab-respond">
		<li class="dropdown">
			<a class="dropdown-toggle" data-toggle="dropdown" href="#">Action <b class="caret"></b></a>
			<ul class="dropdown-menu" role="menu">
				<li><a class="multi_apply">Attach Resource</a></li>
				<li><a class="multi_copy">Copy</a></li>
				<li><a class="multi_delete">Delete</a></li>
			</ul>
		</li>
	</ul>
	<ul class="nav nav-tabs tab-respond">
		<li class="pull-right"><a class="load_month_view">&nbsp; <i class="fa fa-calendar"></i></a></li>
		<li class="pull-right"><a class="load_week_view">&nbsp; <i class="fa fa-list"></i></a></li>
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
                        
<div class="table-responsive">
<table class="table table-bordered table-hover table-middle" width="100%">
<thead>
	<tr>
		<th class="center" width="20"><input type="checkbox" id="selected_all_shifts" /></th>
		<th class="center">Date &nbsp; <a onclick="sort_shifts('date')"><i class="fa fa-sort"></i></a></th>
		<th>Venue &nbsp; <a onclick="sort_shifts('venue')"><i class="fa fa-sort"></i></a></th>
		<th>Role &nbsp; <a onclick="sort_shifts('role')"><i class="fa fa-sort"></i></a></th>
		<th class="center">Start - Finish</th>
		<th class="center">Break</th>
		<th>Pay rate</th>
		<th>Staff Assigned &nbsp; <a onclick="sort_shifts('status')"><i class="fa fa-sort"></i></a></th>
		<th class="center" colspan="3">Find Staff</th>
		
		<th class="center" colspan="2" width="30">Functions</th>
	</tr>
</thead>
<tbody>
	<? foreach($job_shifts as $shift) { ?>
	<tr class="<?=modules::run('job/status_to_class', $shift['status']);?>">
		<td class="center"><input type="checkbox" class="selected_shifts" value="<?=$shift['shift_id'];?>" /></td>
		<td class="wp-date" width="80">
			<span class="wk_day"><?=date('D', strtotime($shift['job_date']));?></span>
			<span class="wk_date"><?=date('d', strtotime($shift['job_date']));?></span>
			<span class="wk_month"><?=date('M', strtotime($shift['job_date']));?></span>
		</td>
		<td>
			
			<a href="#" class="shift_venue" data-type="typeaheadjs" data-pk="<?=$shift['shift_id'];?>"><?=modules::run('attribute/venue/display_venue', $shift['venue_id']);?></a>
		</td>
		<td>
			<a href="#" class="shift_role" data-type="select" data-pk="<?=$shift['shift_id'];?>" data-value="<?=$shift['role_id'];?>"><?=modules::run('attribute/role/display_role', $shift['role_id']);?></a>
		</td>
		<td class="center">
			<a href="#" class="shift_start_time" data-type="combodate" data-template="DD- MM- YYYY HH: mm" data-format="YYYY-MM-DD HH:mm" data-viewformat="HH:mm" data-pk="<?=$shift['shift_id'];?>" data-value="<?=date('Y-m-d H:i', $shift['start_time']);?>" data-title="Shift start date/time"><?=date('H:i', $shift['start_time']);?></a>
			-
			<a href="#" class="shift_finish_time" data-type="combodate" data-template="DD- MM- YYYY HH: mm" data-format="YYYY-MM-DD HH:mm" data-viewformat="HH:mm" data-pk="<?=$shift['shift_id'];?>" data-value="<?=date('Y-m-d H:i', $shift['finish_time']);?>"><?=date('H:i', $shift['finish_time']);?></a> <?=(date('d', $shift['finish_time']) != date('d', $shift['start_time'])) ? '<span class="text-danger">*</span>': '';?>
		</td>
		<td class="center">
			<a id="shift_break_<?=$shift['shift_id'];?>" onclick="load_shift_breaks(this)" class="shift_breaks editable-click" data-pk="<?=$shift['shift_id'];?>"><?=modules::run('common/break_time', $shift['break_time']);?></a>
		</td>
		<td><a href="#" class="shift_payrate" data-type="select" data-pk="<?=$shift['shift_id'];?>" data-value="<?=$shift['payrate_id'];?>"><?=modules::run('attribute/payrate/display_payrate', $shift['payrate_id']);?></a></td>
		<td>
			<a id="shift_staff_<?=$shift['shift_id'];?>" onclick="load_shift_staff(this)" class="shift_staff editable-click" data-pk="<?=$shift['shift_id'];?>">
			<? if($shift['staff_id']) { $staff = modules::run('staff/get_staff', $shift['staff_id']); 
				echo $staff['first_name'] . ' ' . $staff['last_name'];				
			?>
			<? } else { ?>
			No Staff Assigned
			<? } ?>
			</a>
		</td>

		<td class="center" width="40"><a data-toggle="modal" data-target="#copy_shift" href="<?=base_url();?>job/ajax/search_staffs"><i class="fa fa-search"></i></a></td>
		<td class="center" width="40"><a data-toggle="modal" data-target=".bs-modal-lg" href="<?=base_url();?>job/ajax/applied_staffs/<?=$shift['shift_id'];?>"><i class="fa fa-thumbs-o-up"></i></a></td>
		<td class="center" width="40"><i class="fa fa-globe"></i></td>

		<td class="center" width="40">
			<a class="shift_copy" data-toggle="modal" data-target="#copy_shift" href="<?=base_url();?>job/ajax/load_shifts_copy/<?=$shift['shift_id'];?>"><i class="fa fa-copy"></i></a>
		</td>
		<td class="center" width="40">
			<a class="shift_delete" data-pk="<?=$shift['shift_id'];?>"><i class="fa fa-trash-o"></i></a>
		</td>
	</tr>
	<? } ?>
</tbody>
</table>
</div>


<div id="wrapper_shift_break"></div>
<div id="wrapper_shift_staff" class="hide"></div>

<script>
$(function(){
	$('.disabled').prop('disabled', true);
	$('.shift_venue').on('shown', function(e, editable) {
		$('#wrapper_js').find('.popover-break').hide();
	});
	$('.shift_role').on('shown', function(e, editable) {
		$('#wrapper_js').find('.popover-break').hide();
	});
	$('.shift_payrate').on('shown', function(e, editable) {
		$('#wrapper_js').find('.popover-break').hide();
	});
	$('.shift_start_time').on('shown', function(e, editable) {
		$('#wrapper_js').find('.popover-break').hide();
	});
	$('.shift_finish_time').on('shown', function(e, editable) {
		$('#wrapper_js').find('.popover-break').hide();
	});
	$('.shift_venue').editable({
		title: 'Start typing venue...',
		name: 'venue',
		typeahead: {
            name: 'venue',
            local: [<?=modules::run('attribute/venue/get_venues','data_source');?>]
        },
		tpl: '<input type="text" size="30" />',
		url: '<?=base_url();?>job/ajax/update_shift_venue',
		success: function(response, newValue)
		{
			if (response.status == 'error')
			{
				return response.msg;
			}
		}
	});
	$('.shift_role').editable({
		url: '<?=base_url();?>job/ajax/update_shift_role',
		name: 'role_id',
		title: 'Select role',
		source: [<?=modules::run('attribute/role/get_roles', 'data_source'); ?>]
	});
	$('.shift_payrate').editable({
		url: '<?=base_url();?>job/ajax/update_shift_payrate',
		name: 'payrate_id',
		title: 'Select Pay Rate',
		source: [<?=modules::run('attribute/payrate/get_payrates', 'data_source');?>]
	});
	$('.shift_start_time').editable({
		combodate: {
            firstItem: 'name'
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
            firstItem: 'name'
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
	
    var selected_shifts = new Array();
    	

	$('#selected_all_shifts').click(function(){
		$('input.selected_shifts').prop('checked', this.checked);		
	});
	$('.shift_delete').confirmModal({
		confirmTitle: 'Delete this shift',
		confirmMessage: 'Are you sure you want to delete this shift?',
		confirmCallback: function(e){
			selected_shifts.length = 0;
			selected_shifts.push($(e).attr('data-pk'));
			delete_shifts(selected_shifts);
		}
	});
	$('.multi_delete').confirmModal({
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
	$('.multi_copy').click(function(){
		selected_shifts.length = 0;
		$('.selected_shifts:checked').each(function(){
			selected_shifts.push($(this).val());
		});
		$('#copy_shift').modal({
			remote: "<?=base_url();?>job/ajax/load_shifts_copy/" + selected_shifts.join("~"),
			show: true
		});
		

	});
})
function load_shift_staff(obj)
{
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
function load_shift_breaks(obj)
{
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