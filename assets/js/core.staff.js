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