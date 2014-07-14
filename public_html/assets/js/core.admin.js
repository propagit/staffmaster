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

/**
 * job_id: (int), date: (string) YYYY-MM-DD format
 */
function load_job_shifts(job_id, date, scroll)
{
	if (date && date != 'all')
	{
		var job_date = moment(date).format("DD-MM-YYYY");
		//$('input[name="start_date"]').val(job_date + " 12:00");
		$('#start_date').datetimepicker('update', date + " 12:00");
		//$('#start_date').datetimepicker('setStartDate', job_date + " 12:00");
		//$('input[name="finish_time"]').val(job_date + " 12:00");
		$('#finish_time').datetimepicker('update', date + " 12:00");
    	$('#finish_time').datetimepicker('setStartDate', job_date + " 12:00");
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

function updateTextboxCounter(field_name, id_element) {
	var w = ("abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789@$_ !#%&()*+,-./:;<=>?\"\'");
   	var whash = {};
  	for (var i = 0; i < w.length; i++)
       whash[w.charAt(i)] = true;
    var unicodeFlag = 0;
    var extraChars = 0;
    var msgCount = 0;
    var msg = $('textarea[name="' +  field_name + '"]').val();
    var m = msg.length;
    for (var i = (m-1); (!unicodeFlag && (i > 0)); i--) 
	{
		if (whash[msg.charAt(i)]) {}
      	else if (msg.charCodeAt(i) == 0xA3) {}
      	else if (msg.charCodeAt(i) == 0xA5) {}
      	else if (msg.charCodeAt(i) == 0xE8) {}
      	else if (msg.charCodeAt(i) == 0xE9) {}
      	else if (msg.charCodeAt(i) == 0xF9) {}
      	else if (msg.charCodeAt(i) == 0xEC) {}
		else if (msg.charCodeAt(i) == 0xF2) {}
		else if (msg.charCodeAt(i) == 0xC7) {}  
		else if (msg.charAt(i) == '\r') {}  
		else if (msg.charAt(i) == '\n') {}  
		else if (msg.charCodeAt(i) == 0xD8) {}  
		else if (msg.charCodeAt(i) == 0xF8) {}  
		else if (msg.charCodeAt(i) == 0xC5) {}  
		else if (msg.charCodeAt(i) == 0xE5) {}  
		else if (msg.charCodeAt(i) == 0x394) {}  
		else if (msg.charCodeAt(i) == 0x3A6) {}  
		else if (msg.charCodeAt(i) == 0x393) {}  
		else if (msg.charCodeAt(i) == 0x39B) {}  
		else if (msg.charCodeAt(i) == 0x3A9) {}  
		else if (msg.charCodeAt(i) == 0x3A0) {}
		else if (msg.charCodeAt(i) == 0x3A8) {}  
		else if (msg.charCodeAt(i) == 0x3A3) {}  
		else if (msg.charCodeAt(i) == 0x398) {}  
		else if (msg.charCodeAt(i) == 0x39E) {}  
		else if (msg.charCodeAt(i) == 0xC6) {}  
		else if (msg.charCodeAt(i) == 0xE6) {}  
		else if (msg.charCodeAt(i) == 0xDF) {}  
		else if (msg.charCodeAt(i) == 0xC9) {}  
		else if (msg.charCodeAt(i) == 0xA4) {}  
		else if (msg.charCodeAt(i) == 0xA1) {} 
		else if (msg.charCodeAt(i) == 0xC4) {}  
		else if (msg.charCodeAt(i) == 0xD6) {}  
		else if (msg.charCodeAt(i) == 0xD1) {}  
		else if (msg.charCodeAt(i) == 0xDC) {}  
		else if (msg.charCodeAt(i) == 0xA7) {}  
		else if (msg.charCodeAt(i) == 0xBF) {}  
		else if (msg.charCodeAt(i) == 0xE4) {}  
		else if (msg.charCodeAt(i) == 0xF6) {}  
		else if (msg.charCodeAt(i) == 0xF1) {}  
		else if (msg.charCodeAt(i) == 0xFC) {}  
		else if (msg.charCodeAt(i) == 0xE0) {}  
		else if (msg.charCodeAt(i) == 0x391) {}  
		else if (msg.charCodeAt(i) == 0x392) {}  
		else if (msg.charCodeAt(i) == 0x395) {}  
		else if (msg.charCodeAt(i) == 0x396) {}  
		else if (msg.charCodeAt(i) == 0x397) {}  
		else if (msg.charCodeAt(i) == 0x399) {} 
		else if (msg.charCodeAt(i) == 0x39A) {}  
		else if (msg.charCodeAt(i) == 0x39C) {}  
		else if (msg.charCodeAt(i) == 0x39D) {}  
		else if (msg.charCodeAt(i) == 0x39F) {}  
		else if (msg.charCodeAt(i) == 0x3A1) {}  
		else if (msg.charCodeAt(i) == 0x3A4) {}
		else if (msg.charCodeAt(i) == 0x3A5) {}  
		else if (msg.charCodeAt(i) == 0x3A7) {}  
		else if (msg.charAt(i) == '^') {
		   extraChars++;  
		}  
		else if (msg.charAt(i) == '{') {  
		   extraChars++;  
		}  
		else if (msg.charAt(i) == '}') {  
		   extraChars++;  
		}  
		else if (msg.charAt(i) == '\\') {  
		   extraChars++;  
		}
		else if (msg.charAt(i) == '[') {  
		   extraChars++;  
		}  
		else if (msg.charAt(i) == '~') {  
		   extraChars++;  
		}  
		else if (msg.charAt(i) == ']') {  
		   extraChars++;  
		}  
		else if (msg.charAt(i) == '|') {  
		   extraChars++;  
		}  
		else if (msg.charCodeAt(i) == 0x20AC) {  
		   extraChars++;  
		}  
		else {  
		   unicodeFlag = 1;  
		}
   }

 
   
   //else {
      msgCount = m + extraChars;
      if (msgCount <= 160) {
         msgCount = 1;
      }
      else {
         //msgCount += (153-1);
         //msgCount -= (msgCount % 153);
         //msgCount /= 153;
		 msgCount = Math.ceil((msgCount / 160));
      }
      $('#' + id_element).html("<b>" + (m + extraChars) + "</b> characters, <b>" + msgCount + "</b> SMS message(s)");
   //}   
}