<div class="staff-profile-detail-box">
	<h2> Groups </h2>
</div>

<div id="load-groups" class="attr-list-wrap"></div>
<script>
var sort_data = {
	'sort_by':'name',
	'sort_order':'asc',
	'user_staff_id':<?=$staff['user_id'];?>,
	'total_active_staffs':<?=modules::run('staff/get_total_staff');?>
};

var params = {
	'url': '<?=base_url();?>staff/ajax/get_staff_groups',
	'output_container':'#load-groups',
	'type':'POST',
	'data':JSON.stringify(sort_data)
};



$(function(){
	help.load_content(params);

});
</script>