<div class="col-md-12">
	<div class="box top-box">
    	<div class="col-md-10 remove-left-padding">
        <h2>Company Calendar</h2>
        <p>As you create jobs they will plot to the company calendar below. All jobs in all job campaigns are displayed and colour coded based on "Un-filled, "Un-confirmed" or "Confirmed". Active jobs campaigns are show in charcoal. Click the numbers to quick jump to those jobs</p>
        </div>
        <div class="col-md-2 remove-left-padding">
        	<ul class="calendar-job-stat-legend">
            	<li>Active Job Campaigns <span class="badge badge-xs dark-grey-bg">1</span></li>
                <li>Unfilled Shifts <span class="badge badge-xs grey-bg">1</span></li>
                <li>Un-confirmed Shifts <span class="badge badge-xs danger">1</span></li>
                <li>Confirmed Shifts <span class="badge badge-xs success">1</span></li>
            </ul>
        </div>
    </div>
</div>

<div class="col-md-12">
	<div class="box bottom-box">
    	<div class="inner-box">
        	<div id="ajax-load-company-calenar"></div>
        </div><!--inner box-->
	</div><!--box-->
</div>


<script>
$(function(){
	get_month_data('<?=date('F Y');?>');
});


function get_month_data(new_date){
	$.ajax({
		type: 'POST',
		url: '<?=base_url();?>job/ajax_calendar/get_calendar_data',
		data:{new_date:new_date},
		success: function(html){
			$('#ajax-load-company-calenar').html(html);
		}
	});		
}
</script>