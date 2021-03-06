"use strict";

function reload_wizard(step) {
	if ($('#setup_wizard').length)
	{
		$.ajax({
			type: "POST",
			url: base_url + 'wizard/ajax/reload_wizard',
			data: {step: step},
			success: function(html) {
				$('#list-steps').html(html);
				$('body').scrollTo('#setup_wizard', 500 );
			}
		})
	}
}

function switch_config(key, value) {
    var data = new Object();
    data[key] = value;
    $.ajax({
        type: "POST",
        url: base_url + "config/ajax/add",
        data: data,
        success: function(html) {
            if (value != '') {
                $('#key-' + key).html('<button type="button" class="btn btn-success btn-sm">On</button><button type="button" class="btn btn-default btn-sm" onclick="switch_config(\'' + key + '\', \'\')">Off</button>');
            } else {
                $('#key-' + key).html('<button type="button" class="btn btn-default btn-sm" onclick="switch_config(\'' + key + '\', \'1\')">On</button><button type="button" class="btn btn-danger btn-sm">Off</button>');
            }
        }
    })
}

function init_date() {
	$('#start_date').datetimepicker({
        weekStart: 1,
        todayBtn:  1,
		autoclose: 1,
		todayHighlight: 1,
		startView: 2,
		forceParse: 1,
        minuteStep: 15,
        format: 'dd-mm-yyyy hh:ii',
        //startDate: "<?=date('Y-m-d');?>"
    }).on('changeDate', function(e) {
    	var start_date = moment(e.date.valueOf() - 11*60*60*1000);
    	var finish_date = $('input[name="finish_time"]').val();
    	if (start_date > moment(finish_date, "DD-MM-YYYY HH:mm"))
    	{
	    	$('input[name="finish_time"]').val(start_date.format("DD-MM-YYYY HH:mm"));
    	}
    	$('#finish_time').datetimepicker('setStartDate', start_date.format("DD-MM-YYYY HH:mm"));
    	$('#break_start_time').datetimepicker('setStartDate', start_date.format("DD-MM-YYYY HH:mm"));
    });
    $('#finish_time').datetimepicker({
        weekStart: 1,
        todayBtn:  1,
		autoclose: 1,
		todayHighlight: 1,
		startView: 2,
		forceParse: 1,
        minuteStep: 15,
        format: 'dd-mm-yyyy hh:ii',
        //startDate: "<?=date('Y-m-d');?>"
    }).on('changeDate', function(e) {
    	var finish_date = moment(e.date.valueOf() - 11*60*60*1000);
    	$('#break_start_time').datetimepicker('setEndDate', finish_date.format("DD-MM-YYYY HH:mm"));
    });
    $('#break_start_time').datetimepicker({
        weekStart: 1,
        todayBtn:  1,
		autoclose: 1,
		todayHighlight: 1,
		startView: 2,
		forceParse: 1,
        minuteStep: 15,
        format: 'dd-mm-yyyy hh:ii',
    });
}

function load_week_shifts(job_id, monday)
{
    preloading($('#wrapper_js'));
    $.ajax({
        type: "POST",
        url: base_url + 'job/ajax/load_week_shifts',
        data: {job_id: job_id, monday: monday},
        success: function(html) {
            loaded($('#wrapper_js'), html);
            load_job_calendar(job_id, monday);
        }
    })
}

/**
 * job_id: (int), date: (string) YYYY-MM-DD format
 */
function load_job_shifts(job_id, date, scroll)
{
	if (date && date != 'all')
	{
		var job_date = moment(date).format("DD-MM-YYYY");
		//$('input[name="start_date"]').val(job_date + " 12:00");
		$('#start_date').datetimepicker('update', date + " 09:00");
		//$('#start_date').datetimepicker('setStartDate', job_date + " 12:00");
		//$('input[name="finish_time"]').val(job_date + " 12:00");
		$('#finish_time').datetimepicker('update', date + " 17:00");
    	$('#finish_time').datetimepicker('setStartDate', job_date + " 09:00");
    	//$('input[name="break_start_at"]').val(job_date + " 12:00");
    	$('#break_start_time').datetimepicker('update', date + " 12:00");
    	$('#break_start_time').datetimepicker('setStartDate', job_date + " 12:00");
	}
	preloading($('#wrapper_js'));
	$.ajax({
		type: "POST",
		url: base_url + 'job/ajax/load_day_shifts',
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
    var timezone = jstz.determine();
    var timezone_name = timezone.name();
    console.log(timezone_name);
	preloading($('#wrapper_calendar'));
	$.ajax({
		type: "POST",
		url: base_url + 'job/ajax/load_job_calendar',
		data: { job_id: job_id, date: date, timezone: timezone_name },
		success: function(html)
		{
			loaded($('#wrapper_calendar'), html);
		}
	})
}
/*
 * job_id: (int)
 * date: (int) timestamp format
 */
function load_month_view(job_id, date)
{
	$.ajax({
		type: "POST",
		url: base_url + 'job/ajax/load_month_view',
		data: { date: date},
		success: function(html)
		{
			$('body').scrollTo('#wrapper_calendar', 500 );
			load_job_shifts(job_id, html);
		}
	})
}
/*
 * job_id: (int)
 * date: (int) timestamp format
 */
function load_week_view(job_id, date)
{
	$.ajax({
		type: "POST",
		url: base_url + 'job/ajax/load_week_view',
		data: { date: date},
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

	//$('input[type="checkbox"]').prettyCheckable();
	$('.selectpicker').selectpicker();

	$('.input_number_only').keydown(function(event) {
        // Allow special chars + arrows
        if (event.keyCode == 46 || event.keyCode == 8 || event.keyCode == 9 || event.keyCode == 190
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

