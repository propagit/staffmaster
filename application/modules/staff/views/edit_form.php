<!--begin top box--->
<div class="col-md-12">
	<div class="box top-box">
   		 <h2>Edit Staff</h2>
		 <p>Edit staff using below form.</p>
    </div>
</div>
<!--end top box-->

<!--begin bottom box -->
<div class="col-md-12">
	<div class="box bottom-box">
    	<div class="inner-box push full-width">
			
			<ul class="nav nav-tabs tab-respond" id="nav-staff-profile">
                <li <?=$this->session->flashdata('load_document_tab') ? '' : 'class="active"';?>><a href="#personal" data-toggle="tab">Personal Details</a></li>
                <li><a href="#pictures" data-toggle="tab">Pictures</a></li>
                <li><a href="#financial" data-toggle="tab">Financial Details</a></li>
                <li><a href="#super" data-toggle="tab">Super Details</a></li>
                <li><a href="#roles" data-toggle="tab">Roles</a></li>
                <li><a href="#availability" data-toggle="tab">Availability</a></li>                
                <li><a href="#location" data-toggle="tab">Locations</a></li>
                <li><a href="#group" data-toggle="tab">Groups</a></li>
                <li><a href="#attribute" data-toggle="tab">Attributes</a></li>
                <li <?=$this->session->flashdata('load_document_tab') ? 'class="active"' : '';?>><a href="#documents" data-toggle="tab">Documents</a></li>
                <li><a href="#settings" data-toggle="tab">Settings</a></li>                                
			</ul>
			
			<div class="tab-content">
				<div class="tab-pane <?=$this->session->flashdata('load_document_tab') ? '' : 'active';?>" id="personal"></div>	
                <div class="tab-pane" id="pictures"></div>			
				<div class="tab-pane" id="financial"></div>
				<div class="tab-pane" id="super"></div>
                <div class="tab-pane" id="roles"></div>
				<div class="tab-pane" id="availability"></div>				
				<div class="tab-pane" id="location"></div>
                <div class="tab-pane" id="group"></div>
        		<div class="tab-pane" id="attribute"></div>				
				<div class="tab-pane <?=$this->session->flashdata('load_document_tab') ? 'active' : '';?>" id="documents"></div>
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
