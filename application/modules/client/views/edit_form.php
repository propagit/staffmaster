<!--begin top box--->
<div class="col-md-12">
	<div class="box top-box">
		<? if (modules::run('auth/is_client')) { ?>
		<h2>Your Profile</h2>
		<p>Edit your client profile information below.</p>
		<? } else { ?>
		<h2>Edit Client</h2>
		<p>Edit client using below form.</p>
		<? } ?>
    </div>
</div>
<!--end top box-->

<!--begin bottom box -->
<div class="col-md-12">
	<div class="box bottom-box">
    	<div class="inner-box">
			
			<ul class="nav nav-tabs tab-respond" id="nav-client-profile">
                <li class="active"><a href="#details" data-toggle="tab">Client Details</a></li>
                <li><a href="#departments" data-toggle="tab">Departments</a></li>                              
			</ul>
			
			<div class="tab-content">
				<div class="tab-pane active" id="details"></div>	
                <div class="tab-pane" id="departments"></div>
				
			</div>
		 </div>
    </div>
</div>
<!--end bottom box -->
<script>
function show_tab(tab)
{
	if (!tab.html()) {
		tab.load('<?=base_url() . 'client/ajax/update_client/' . $client['user_id'];?>/' + tab.attr('id'));
	}
}
function init_tabs() {
	show_tab($('.tab-pane.active'));
	$('#nav-client-profile a').on('shown.bs.tab', function(e) {
		tab = $('#' + $(e.target).attr('href').substr(1));
		show_tab(tab);	
	});
}
$(function(){
	init_tabs();
});
</script>