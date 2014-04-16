function confirm_selected(selected_rosters)
{
	$.ajax({
		type: "POST",
		url: base_url + "roster/ajax/confirm_rosters",
		data: {rosters: selected_rosters},
		success: function(data) {
			load_rosters();
		}
	})
}
function reject_selected(selected_rosters)
{
	$.ajax({
		type: "POST",
		url: base_url + "roster/ajax/reject_rosters",
		data: {rosters: selected_rosters},
		success: function(data) {
			load_rosters();
		}
	})
}


function apply_shifts(selected_shifts)
{
	$.ajax({
		type: "POST",
		url: base_url + "work/ajax/apply_shifts",
		data: {shifts: selected_shifts},
		success: function(html) {
			load_works();
		}
	})
}

function unapply_shift(shift_id)
{
	$.ajax({
		type: "POST",
		url: base_url + "work/ajax/unapply_shift",
		data: {shift_id: shift_id},
		success: function(html) {
			load_works();
		}
	})
}