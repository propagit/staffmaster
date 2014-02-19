<!--begin top box--->
<div class="col-md-12">
	<div class="box top-box">
    	 <div id="staff-edit-page-avatar">
			<?=modules::run('common/profile_picture','',$staff['user_id']);?>
   		 </div>
         <div class="staff-profile-bar-box">
             <h2><?=$staff['title'].'. '.$staff['first_name'].' '.$staff['last_name'];?></h2>
             <div class="wp-rating grey-star">
                <?=modules::run('common/field_rating', 'profile_rating', $staff['rating'],false,'basic','wp-rating',true,$staff['user_id']);?>
             </div>
        </div>
    </div>
</div>
<!--end top box-->

<!--begin bottom box -->
<div class="col-md-12">
	<div class="box bottom-box">
    	<div class="inner-box push full-width">
			
			<ul class="nav nav-tabs tab-respond" id="nav-staff-profile">
                <li class="active mobile-tab"><a href="#personal" data-toggle="tab">Personal Details</a></li>
                <li class="mobile-tab"><a href="#pictures" data-toggle="tab">Pictures</a></li>
                <li class="mobile-tab"><a href="#financial" data-toggle="tab">Financial Details</a></li>
                <li class="mobile-tab"><a href="#super" data-toggle="tab">Super Details</a></li>
                <li class="mobile-tab"><a href="#roles" data-toggle="tab">Roles</a></li>
                <li class="mobile-tab"><a href="#availability" data-toggle="tab">Availability</a></li>                
                <li class="mobile-tab"><a href="#location" data-toggle="tab">Locations</a></li>
                <li class="mobile-tab"><a href="#group" data-toggle="tab">Groups</a></li>
                <li class="mobile-tab"><a href="#attribute" data-toggle="tab">Attributes</a></li>
                <li class="mobile-tab"><a href="#documents" data-toggle="tab">Documents</a></li>
                <li class="mobile-tab"><a href="#settings" data-toggle="tab">Settings</a></li>                                
			</ul>
			
			<div class="tab-content">
				<div class="tab-pane active" id="personal"></div>	
                <div class="tab-pane" id="pictures"></div>			
				<div class="tab-pane" id="financial"></div>
				<div class="tab-pane" id="super"></div>
                <div class="tab-pane" id="roles"></div>
				<div class="tab-pane" id="availability"></div>				
				<div class="tab-pane" id="location"></div>
                <div class="tab-pane" id="group"></div>
        		<div class="tab-pane" id="attribute"></div>				
				<div class="tab-pane" id="documents"></div>
                <div class="tab-pane" id="settings"></div>
				
			</div>
		 </div>
    </div>
</div>
<!--end bottom box -->
<script>
function show_tab(tab)
{
	if (!tab.html()) {
		tab.load('<?=base_url() . 'staff/ajax/update_staff/' . $staff['user_id'];?>/' + tab.attr('id'));
	}
}
function init_tabs() {
	show_tab($('.tab-pane.active'));
	$('#nav-staff-profile a').on('shown.bs.tab', function(e) {
		tab = $('#' + $(e.target).attr('href').substr(1));
		show_tab(tab);	
	});
}
$(function(){
	init_tabs();	
});
</script>
