"use strict";
/*
 * job_id: (int) 
 * date: (string) YYYY-MM-DD format
 */
function load_job_shifts(job_id, date, scroll)
{
	if (date)
	{
		var job_date = moment(date).format("DD-MM-YYYY");                
		$('input[name="job_date"]').val(job_date + " 12:00");
		$('#start_date').datetimepicker('update');
		$('input[name="finish_time"]').val(job_date + " 12:00");
    	$('#finish_time').datetimepicker('setStartDate', job_date + " 12:00");
    	$('input[name="break_start_at"]').val(job_date + " 12:00");
    	$('#break_start_time').datetimepicker('setStartDate', job_date + " 12:00");
	}
	preloading($('#wrapper_js'));
	$.ajax({
		type: "POST",
		url: base_url + 'job/ajax/load_job_shifts',
		data: { job_id: job_id, date: date },
		success: function(html)
		{
			loaded($('#wrapper_js'), html);
			if (scroll)
			{
				$('body').scrollTo('#wrapper_js', 500 );
			}
			load_job_calendar(job_id, date);
		}
	})
}
/*
 * job_id: (int)
 * date: (string) YYYY-MM-DD format
 */
function load_job_calendar(job_id, date)
{
	preloading($('#wrapper_calendar'));
	$.ajax({
		type: "POST",
		url: base_url + 'job/ajax/load_job_calendar',
		data: { job_id: job_id, date: date },
		success: function(html)
		{
			loaded($('#wrapper_calendar'), html);
		}
	})
}
/* 
 * job_id: (int)
 * custom_date: (int) timestamp format
 */
function load_month_view(job_id, custom_date)
{
	$.ajax({
		type: "POST",
		url: base_url + 'job/ajax/load_month_view',
		data: { date: custom_date},
		success: function(html)
		{
			$('body').scrollTo('#wrapper_calendar', 500 );
			load_job_shifts(job_id, html);
		}
	})
}
/* 
 * job_id: (int)
 * custom_date: (int) timestamp format
 */
function load_week_view(job_id, custom_date)
{
	$.ajax({
		type: "POST",
		url: base_url + 'job/ajax/load_week_view',
		data: { date: custom_date},
		success: function(html)
		{
			$('body').scrollTo('#wrapper_calendar', 500 );
			load_job_shifts(job_id, html);
		}
	})
}
/*
 * selected_shifts: array of int
 */

function delete_shifts(selected_shifts)
{
	$.ajax({
		type: "POST",
		url: base_url + 'job/ajax/delete_shifts',
		data: {shifts: selected_shifts},
		success: function(data) {
			data = $.parseJSON(data);
			load_job_shifts(data.job_id, data.job_date, false);
		}
	})
}



$(function(){
	//$.fn.editable.defaults.mode = 'popup';
	
	$('input[type="checkbox"]').prettyCheckable();
	$('.selectpicker').selectpicker();
	
	$('.input_number_only').keydown(function(event) {
        // Allow special chars + arrows 
        if (event.keyCode == 46 || event.keyCode == 8 || event.keyCode == 9 
            || event.keyCode == 27 || event.keyCode == 13 
            || (event.keyCode == 65 && event.ctrlKey === true) 
            || (event.keyCode >= 35 && event.keyCode <= 39)){
                return;
        }else {
            // If it's not a number stop the keypress
            if (event.shiftKey || (event.keyCode < 48 || event.keyCode > 57) && (event.keyCode < 96 || event.keyCode > 105 )) {
                event.preventDefault(); 
            }   
        }
    });
})

