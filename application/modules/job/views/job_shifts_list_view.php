<h2>Jobs On Date</h2>
<p>All shifts for this job campaign are displayed below. Using the checkbox to select shifts will allow you to perform group functions such as delete, duplicate, assign staff, assign briefs or surveys and many other functions</p>

<!-- Split button -->

<br />
<div class="table_action">
	<?=modules::run('common/dropdown_actions','shift', 
		array(
			'attach' => 'Attach Resource',
			'copy' => 'Copy',
			'delete' => 'Delete'
			));?>
	
	<span onclick="load_job_shifts(<?=$job_id;?>)" class="btn btn-info">Total:  <?=$total_date;?> days and <?=modules::run('job/count_job_shifts', $job_id,null);?> shifts</span>
	<? foreach($job_dates as $date) { ?>
	<span onclick="load_job_shifts(<?=$job_id;?>,'<?=$date['job_date'];?>')" class="btn btn-day<?=($this->session->userdata('job_date') == $date['job_date']) ? '-active': '';?>">
		<?=date('d', strtotime($date['job_date']));?>
		<span class="month"><?=date('M', strtotime($date['job_date']));?></span>
		(<?=modules::run('job/count_job_shifts', $job_id, strtotime($date['job_date']));?>)
	</span>
	<? } ?>
	
	<a type="button" class="btn btn-primary load_week_view"><i class="fa fa-list"></i></a>
	<a type="button" class="btn btn-primary load_month_view"><i class="fa fa-calendar"></i></a>
	
	<span class="btn btn-info pull-right"><i class="fa fa-gears"></i> Settings</span>
</div>
<!--
<div class="table_settings">
	<form class="form-inline pull-left" role="form">
		<label>Search </label>
		<div class="form-group">
		<input type="text" class="form-control" placeholder="keywords...">
		</div>
	</form>

	<form class="form-inline pull-right" role="form">
		<label>Show Results</label>
		<div class="form-group">
			<select class="form-control">
				<option>10</option>
				<option>20</option>
			</select>
		</div>
	</form>
</div>
-->
                        
                        
<table class="table table-bordered table-hover" width="100%">
<thead>
	<tr>
		<th class="center" width="5%"><input type="checkbox" id="selected_all_shifts" /></th>
		<th>Venue</th>
		<th>Role</th>
		<th class="center">Start - Finish</th>
		<th class="center">Break</th>
		<th>Staff Assigned</th>
		<th class="center">Pay rate</th>
		<th class="center">Info</th>
		<th class="center">Copy</th>
		<th class="center" width="5%">Delete</th>
	</tr>
</thead>
<tbody>
	<? foreach($job_shifts as $shift) { ?>
	<tr>
		<td class="center"><input type="checkbox" class="selected_shifts" value="<?=$shift['shift_id'];?>" /></td>
		<td>
			
			<a href="#" class="shift_venue" data-type="typeaheadjs" data-pk="<?=$shift['shift_id'];?>"><?=modules::run('attribute/venue/display_venue', $shift['venue_id']);?></a>
		</td>
		<td>
			<a href="#" class="shift_role" data-type="select" data-pk="<?=$shift['shift_id'];?>" data-value="<?=$shift['role_id'];?>"><?=modules::run('attribute/role/display_role', $shift['role_id']);?></a>
		</td>
		<td class="center">
			<a href="#" class="shift_start_time" data-type="combodate" data-template="DD- MM- YYYY HH: mm" data-format="YYYY-MM-DD HH:mm" data-viewformat="HH:mm" data-pk="<?=$shift['shift_id'];?>" data-value="<?=date('Y-m-d H:i', $shift['start_time']);?>" data-title="Shift start date/time"><?=date('H:i', $shift['start_time']);?></a>
			-
			<a href="#" class="shift_finish_time" data-type="combodate" data-template="DD- MM- YYYY HH: mm" data-format="YYYY-MM-DD HH:mm" data-viewformat="HH:mm" data-pk="<?=$shift['shift_id'];?>" data-value="<?=date('Y-m-d H:i', $shift['finish_time']);?>"><?=date('H:i', $shift['finish_time']);?></a> <?=(date('d', $shift['finish_time']) != date('d', $shift['start_time'])) ? '<span class="error">*</span>': '';?>
		</td>
		<td class="center">
			<a id="shift_break_<?=$shift['shift_id'];?>" onclick="load_shift_breaks(this)" class="shift_breaks editable-click" data-pk="<?=$shift['shift_id'];?>"><?=modules::run('common/break_time', $shift['break_time']);?></a>
		</td>
		<td>
			<a href="#" class="shift_staff" data-type="typeaheadjs2" data-pk="<?=$shift['shift_id'];?>" data-value="">
			<? if($shift['staff_id']) { ?>
			<? } else { ?>
			No Staff Assigned
			<? } ?>
			</a>
		</td>
		<td></td>
		<td class="center"><i class="fa fa-edit"></i></td>
		<td class="center">
			<a class="shift_copy" data-toggle="modal" data-target="#copy_shift" href="<?=base_url();?>job/ajax/load_shifts_copy/<?=$shift['shift_id'];?>"><i class="fa fa-copy"></i></a>
		</td>
		<td class="center">
			<a class="shift_delete" data-pk="<?=$shift['shift_id'];?>"><i class="fa fa-trash-o"></i></a>
		</td>
	</tr>
	<? } ?>
</tbody>
</table>

<div id="wrapper_shift_break"></div>
<div id="wrapper_shift_staff" class="hide"></div>

<script>
$(function(){
	$('.shift_venue').on('shown', function(e, editable) {
		$('#wrapper_js').find('.popover-break').hide();
	});
	$('.shift_role').on('shown', function(e, editable) {
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
	$('.shift_staff').editable({
		title: 'Staff Allocated',
		name: 'staff',
		typeahead: {
			name: 'staff',
			prefetch: '<?=base_url();?>staff/ajax/list_staffs',
			template: '<p><strong>{{name}}</strong> – {{img}}</p>',
			engine: Hogan
		},
		url: '<?=base_url();?>job/ajax/update_shift_staff',
		success: function(response, newValue)
		{
			
		}
	})
	$('.shift_role').editable({
		url: '<?=base_url();?>job/ajax/update_shift_role',
		name: 'role_id',
		title: 'Select role',
		source: [<?=modules::run('attribute/role/get_roles', 'data_source'); ?>]
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
	/*
$('.shift_staff').popover({
		html: true,
		placement: 'top',
		trigger: 'manual',
		selector: false,
		title: 'Staff Allocated',
		template: '<div class="popover popover-break"><div class="arrow"></div><div class="popover-inner"><h3 class="popover-title"></h3><div class="popover-content"><p></p></div></div></div>',
		content: function(){
			return $('#wrapper_shift_staff').html();
		}
	})
*/
	
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
	$('.menu_delete_shift').confirmModal({
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
	$('.menu_copy_shift').click(function(){
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