<div class="col-md-12">
	<div class="box top-box">
    	<div class="col-md-10 remove-left-padding">
        <h2>Company Calendar</h2>
        <p>As you create jobs they will plot to the company calendar below. All jobs in all job campaigns are displayed and colour coded based on "Un-filled, "Un-confirmed" or "Confirmed". Active jobs campaigns are show in charcoal. Click the numbers to quick jump to those jobs</p>
        </div>
        <div class="col-md-2 remove-left-padding">
        	<ul class="calendar-job-stat-legend">
            	<li><span class="cal-legend-txt">Active Job Campaigns</span><span class="cal-home-shift-count-wrap"><span id="job-campaigns-count" class="badge dark-grey-bg">0</span></span></li>
                <li><span class="cal-legend-txt">Unfilled Shifts</span><span class="cal-home-shift-count-wrap"><span id="unfilled-shifts-count" class="badge grey-bg">0</span></span></li>
                <li><span class="cal-legend-txt">Un-confirmed Shifts</span><span class="cal-home-shift-count-wrap"><span id="unconfirmed-shifts-count" class="badge warning">0</span></span></li>
                <li><span class="cal-legend-txt">Rejected Shifts</span><span class="cal-home-shift-count-wrap"><span id="rejected-shifts-count" class="badge danger">0</span></span></li>
                <li><span class="cal-legend-txt">Confirmed Shifts</span><span class="cal-home-shift-count-wrap"><span id="confirmed-shifts-count" class="badge success">0</span></span></li>
                <li><span class="cal-legend-txt">Completed Shifts</span><span class="cal-home-shift-count-wrap"><span id="completed-shifts-count" class="badge primary">0</span></span></li>
            </ul>
        </div>
    </div>
</div>

<div class="col-md-12">
	<div class="box bottom-box">
    	<div class="inner-box">
        	
        	<form id="company-calendar-form">
            <div class="company-calendar-actions">
                <div class="btn-group btn-nav company-calendar-filter">
                    <button type="button" class="btn btn-core menu-label cc-filter-btn">Filter By Client</button>
                    <button type="button" class="btn btn-core dropdown-toggle cc-filter-btn" data-toggle="dropdown">
                        <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu filter-dropdown" role="menu">
                    	<li class="client-list-li" data-user-id="all">All</li>
                        <?php if($clients) { foreach($clients as $c){?>
                        <li class="client-list-li <?=($selected_client_user_id == $c['user_id']) ? 'active-filter' : '';?>" data-user-id="<?=$c['user_id'];?>"><?=$c['company_name']?></li>
                        <?php }}?>
                   </ul>
                </div><!--end filter by client-->
                
                <div class="btn-group btn-nav company-calendar-filter">
                    <button type="button" class="btn btn-core menu-label cc-filter-btn">Filter By State</button>
                    <button type="button" class="btn btn-core dropdown-toggle cc-filter-btn" data-toggle="dropdown">
                        <span class="caret"></span>
                        <span class="sr-only">Toggle Dropdown</span>
                    </button>
                    <ul class="dropdown-menu filter-dropdown" role="menu">
                   		<li class="state-list-li" data-state-code="all">All</li>
                    	<?php if($states) { foreach($states as $s){?>
                        <li class="state-list-li <?=($selected_state_code == $s['code']) ? 'active-filter' : '';?>" data-state-code="<?=$s['code'];?>"><?=$s['name']?></li>
                        <?php }}?>
                   </ul>
                </div><!--end filter by state-->
            </div>
       		</form>
            
        	<div id="ajax-load-company-calenar"></div>
        </div><!--inner box-->
	</div><!--box-->
</div>


<script>
var filter_client_user_id = '<?=$selected_client_user_id;?>';
var filter_state_code = '<?=$selected_state_code;?>';

$(function(){
	get_month_data('<?=date('F Y');?>');
	
	//client filter
	$('.client-list-li').on('click',function(){
		$('.client-list-li').removeClass('active-filter');
		$(this).addClass('active-filter');
		filter_client_user_id = $(this).attr('data-user-id');
		set_filters($('#header-company-calendar-month').html());
		
	});
	
	//state filter
	$('.state-list-li').on('click',function(){
		$('.state-list-li').removeClass('active-filter');
		$(this).addClass('active-filter');
		filter_state_code = $(this).attr('data-state-code');
		set_filters($('#header-company-calendar-month').html());
		
	});
});


function get_month_data(new_date){
	$.ajax({
		type: 'POST',
		url: '<?=base_url();?>job/ajax_calendar/get_calendar_data',
		data:{new_date:new_date},
		success: function(html){
			get_calendar_data_summary(new_date);
			$('#ajax-load-company-calenar').html(html);
		}
	});		
}

function get_calendar_data_summary(new_date){
	$.ajax({
		type: 'POST',
		url: '<?=base_url();?>job/ajax_calendar/get_calendar_data_summary',
		data:{new_date:new_date},
		dataType:'json',
		success: function(data){
			$('#job-campaigns-count').html(data['job_campaign']);
			$('#unfilled-shifts-count').html(data['unassigned']);
			$('#unconfirmed-shifts-count').html(data['unconfirmed']);
			$('#rejected-shifts-count').html(data['rejected']);
			$('#confirmed-shifts-count').html(data['confirmed']);
			$('#completed-shifts-count').html(data['completed']);
		}
	});	
}

function set_filters(new_date)
{
	$.ajax({
		type: 'POST',
		url: '<?=base_url();?>job/ajax_calendar/set_company_calendar_filter',
		data:{client_user_id:filter_client_user_id,state_code:filter_state_code},
		success: function(html){
			get_month_data(new_date);
		}
	});		
}

function redirect_search_shift(shift_date,shift_status)
{
	$.ajax({
		type: 'POST',
		url: '<?=base_url();?>job/ajax_calendar/redirect_to_shift_search',
		data:{shift_date:shift_date,shift_status:shift_status,client_user_id:filter_client_user_id},
		success: function(html){
			window.location.href = '<?=base_url();?>job/search';
		}
	});	
}
</script>