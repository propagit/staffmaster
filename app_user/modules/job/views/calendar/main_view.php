<div class="col-md-12">
	<div class="box top-box">
        <h2>Company Calendar</h2>
        <p>As you create jobs they will plot to the company calendar below. All shifts on all job campaigns are displayed and colour coded based on unfilled, unconfirmed, confirmed, rejected or completed. Active job campaigns are  show in charcoal and shifts created by clients will be shown in purple . Click the numbers to quick jump to those jobs.</p>
        <div id="shifts_badge">
			<div class="shift_badge first-child">
				<span id="job-campaigns-count" class="badge dark-grey-bg">0</span>
				<div class="step_label">Active Job Campaigns</div>
			</div>
			<div class="shift_badge">
				<span id="client-shifts-count" class="badge purple">0</span>
				<div class="step_label">Created by Client</div>
			</div>
			<div class="shift_badge">
				<span id="unfilled-shifts-count" class="badge grey-bg">0</span>
				<div class="step_label">Unfilled Shifts</div>
			</div>
			<div class="shift_badge">
				<span id="unconfirmed-shifts-count" class="badge warning">0</span>
				<div class="step_label">Unconfirmed Shifts</div>
			</div>
			<div class="shift_badge">
				<span id="rejected-shifts-count" class="badge danger">0</span>
				<div class="step_label">Rejected Shifts</div>
			</div>
			<div class="shift_badge">
				<span id="confirmed-shifts-count" class="badge success">0</span>
				<div class="step_label">Confirmed Shifts</div>
			</div>
			<div class="shift_badge">
				<span id="completed-shifts-count" class="badge primary">0</span>
				<div class="step_label">Completed Shifts</div>
			</div>
        </div>
    </div>
</div>


<div class="col-md-12">
	<div class="box bottom-box">
    	<div class="inner-box">
        	<!-- filter -->
        	<? if (modules::run('auth/is_client')) { ?>        	
        	<?#=modules::run('client/menu_dropdown_departments', $user_id, 'department_id', 'Department: Any');?>
        	<? } else { ?>
            <?=modules::run('client/menu_dropdown', 'client_id', 'Client: Any', $this->session->userdata('company_calendar_filter_client_id'));?>
            <? } ?>
            <?=modules::run('common/menu_dropdown_states', 'state', 'Location: Any', $this->session->userdata('company_calendar_filter_state_code'));?>
            
            <!-- calendar nav -->
			<div id="nav_month_shifts" class="company-calendar-nav-wrap">
				<div class="btn-group btn-nav">
					<ul class="nav nav-tabs tab-respond">
						<li class="active"><a data-calendar-nav="today">Today</a></li>
						<li class="active first-child"><a data-calendar-nav="prev" type="button" class="btn btn-info"><i class="fa fa-arrow-left"></i> &nbsp;</a></li>
						<li class="active mid-child"><a id="header-company-calendar-month"> &nbsp; </a></li>
						<li class="active last-child"><a data-calendar-nav="next" type="button" class="btn btn-info"><i class="fa fa-arrow-right"></i> &nbsp;</a></li>
					</ul>
				</div>
			</div>
			
            <div id="wp_calendar" style="min-height:600px;">
	            
            </div>
        </div><!--inner box-->
	</div><!--box-->
</div>

<script>
var calendar = null;
$(function(){
	<? if ($filter_state = $this->session->userdata('company_calendar_filter_state_code')) { ?>
	select_menu('state', '<?=$filter_state;?>', 'Location');
	<? } ?>
	<? if ($filter_client = $this->session->userdata('company_calendar_filter_client_id') && !modules::run('auth/is_client')) { ?>
	select_menu('client_id', '<?=$filter_client;?>', 'Client');
	<? } ?>
	
	load_calendar('<?=date('Y-m');?>');
	$('a[data-calendar-nav]').each(function() {
		var $this = $(this);
		$this.click(function() {
			calendar.navigate($this.data('calendar-nav'));
			load_calendar($('#header-company-calendar-month').html());
		});
	});
	$('#menu-state ul li a').click(function(){
		var value = $(this).attr('data-value');
		var label = $(this).html();
		$('#menu-state .menu-label').html('Location: ' + label);
		$.ajax({
			type: "POST",
			url: "<?=base_url();?>job/ajax_calendar/set_filter",
			data: {name: 'state_code', value:value},
			success: function(html) {
				load_calendar($('#header-company-calendar-month').html());
			}
		})		
	});
	$('#menu-client_id ul li a').click(function(){
		var value = $(this).attr('data-value');
		var label = $(this).html();
		$('#menu-client_id .menu-label').html('Client: ' + label);
		$.ajax({
			type: "POST",
			url: "<?=base_url();?>job/ajax_calendar/set_filter",
			data: {name: 'client_id', value:value},
			success: function(html) {
				load_calendar($('#header-company-calendar-month').html());
			}
		})		
	});
});
function load_calendar(month){
	$.ajax({
		type: 'POST',
		url: '<?=base_url();?>job/ajax_calendar/load_calendar',
		data: {month: month},
		success: function(html){
			load_month_summary(month);
			$('#wp_calendar').html(html);
		}
	});		
}
function load_month_summary(month){
	$.ajax({
		type: 'POST',
		url: '<?=base_url();?>job/ajax_calendar/load_month_summary',
		data:{month:month},
		dataType:'json',
		success: function(data){
			$('#job-campaigns-count').html(data['job_campaign']);
			$('#client-shifts-count').html(data['client']);
			$('#unfilled-shifts-count').html(data['unassigned']);
			$('#unconfirmed-shifts-count').html(data['unconfirmed']);
			$('#rejected-shifts-count').html(data['rejected']);
			$('#confirmed-shifts-count').html(data['confirmed']);
			$('#completed-shifts-count').html(data['completed']);
		}
	});	
}
function redirect_search_shift(shift_date,shift_status)
{
	$.ajax({
		type: 'POST',
		url: '<?=base_url();?>job/ajax_calendar/redirect_to_shift_search',
		data:{shift_date:shift_date,shift_status:shift_status,client_user_id:'<?=$this->session->userdata('company_calendar_filter_client_id');?>' },
		success: function(html){
			window.location.href = '<?=base_url();?>job/search';
		}
	});	
}
</script>