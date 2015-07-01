<h2>Quick Notes</h2>
<p>Quick notes you add below will display under the notes tab in the staff or client profile. 
Notes will be date marked and list the user who added the note</p>        
<div id="load-notes-users" style="margin-top:25px;"></div>
<div class="alert alert-success hide push full-width" id="msg-add-user-note"><i class="fa fa-check"></i> &nbsp; note added successfully!</div>
  



<script>
$(function(){
	// init users
	get_notes_user();
	
	$(document).on('click','#add-user-note',function(){
		add_user_note();
	});	
});

function get_notes_user(){
	$('#load-notes-users').addClass('div-opacity');	
	$.ajax({
		type: "POST",
		url:'<?=base_url();?>user_notes/ajax/get_users',
		success: function(html) {
			$('#load-notes-users').html(html);	
			$('#load-notes-users').removeClass('div-opacity');
		}
	});
}

function add_user_note(){
	$('#user-note-form').find('input').tooltip('destroy');
	$('#user-note-form').find('div[id^=n_]').removeClass('has-error');
	$.ajax({
		type: "POST",
		url:'<?=base_url();?>user_notes/ajax/add_note',
		data:$('#user-note-form').serialize(),
		success: function(data) {
			data = $.parseJSON(data);
			if (!data.ok) {					
				$('#n_' + data.error_id).addClass('has-error');
				$('input[name="' + data.error_id + '"]').tooltip({
					title: data.msg,
					placement: 'bottom'
				});
				$('input[name="' + data.error_id + '"]').focus();
			}else{
				$('#user-note').val('');
				$('#msg-add-user-note').removeClass('hide');
				setTimeout(function(){
					$('#msg-add-user-note').addClass('hide');
				}, 2000);
				refresh_recent_users();
			}
		}
	});
}

function refresh_recent_users(){
	$.ajax({
		url:'<?=base_url();?>user_notes/ajax/get_recent_notes',
		success: function(html) {
			$('#dash-recent-notes').html(html);
			// #dash-recent-notes is on on modules/dashboard/views/dashboard.php
		}
	});	
}

</script>
