<div class="staff-profile-detail-box">
	<h2> Roles </h2>
	<p> Roles can be created in the edit attributes section. Assigning roles to your staff will allow you to search for staff by role. <br />Staff can also apply for jobs for roles they are allocated to below. </p>
</div>
<div id="load-roles" class="attr-list-wrap"></div>
<script>
var sort_data = {
	'sort_by':'name',
	'sort_order':'asc',
	'user_staff_id':<?=$staff['user_id'];?>,
	'total_active_staffs':<?=modules::run('staff/get_total_staff');?>
};

var params = {
	'url': '<?=base_url();?>staff/ajax/get_staff_roles',
	'output_container':'#load-roles',
	'type':'POST',
	'data':JSON.stringify(sort_data)
};



$(function(){
	help.load_content(params);

});
</script>