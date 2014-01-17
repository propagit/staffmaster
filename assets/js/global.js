function load_job_shifts(job_id, date=null)
{
	if (date)
	{
		var job_date = moment(date);
		$('input[name="job_date"]').val(job_date.format("DD-MM-YYYY"));
	}
	$.ajax({
		type: "POST",
		url: base_url + 'job/ajax/load_job_shifts',
		data: { job_id: job_id, date: date },
		success: function(html)
		{
			$('#wrapper_js').html(html);
			load_job_calendar(job_id, date);
		}
	})
}
function load_job_calendar(job_id, date=null)
{
	$.ajax({
		type: "POST",
		url: base_url + 'job/ajax/load_job_calendar',
		data: { job_id: job_id, date: date },
		success: function(html)
		{
			$('#wrapper_calendar').html(html);
		}
	})
}
function load_job_week(job_id,date,i)
{
	//alert(job_id + ' ' + date + ' '  + i);
	$.ajax({
		type: "POST",
		url: base_url + 'job/ajax/load_job_week',
		data: { date: date, i: i},
		success: function(html)
		{
			//alert(html);
			//load_job_shifts(job_id);
			//load_job_calendar(job_id, html);
		}
	})
}

$(function(){
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