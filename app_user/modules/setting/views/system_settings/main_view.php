<!--begin top box -->
<div class="col-md-12">
	<div class="box top-box">
   		 <h2><i class="fa fa-cog"></i> &nbsp; Preferences</h2>
		 <p>
         	Configure your systems preferences here.
         </p>
    </div>
</div>
<!--end top box-->

<!--begin bottom box -->
<div class="col-md-12">
	<div class="box bottom-box">
    	<div class="inner-box push full-width">

			<ul class="nav nav-tabs tab-respond" id="nav-campaign-resource">
            	<li class="active mobile-tab"><a href="#staff_portal" data-toggle="tab">Staff Portal</a></li>
                <li class="mobile-tab"><a href="#information_sheet" data-toggle="tab">Information Sheet</a></li>
                <li class="mobile-tab"><a href="#timesheet" data-toggle="tab">Timesheet</a></li>
                <li class="mobile-tab"><a href="#others" data-toggle="tab">Others</a>
			</ul>

			<div class="tab-content">
            	<div class="tab-pane active" id="staff_portal"></div>
				<div class="tab-pane" id="information_sheet"></div>
                <div class="tab-pane" id="timesheet"></div>
				<div class="tab-pane" id="others"></div>
			</div>
		 </div>
    </div>
</div>

<!--end bottom box -->
<script>
function show_tab(tab)
{
	if (!tab.html()) {
		tab.load('<?=base_url();?>setting/ajax/edit_' + tab.attr('id'));
	}
}
function init_tabs() {
	show_tab($('.tab-pane.active'));
	$('#nav-campaign-resource a').on('shown.bs.tab', function(e) {
		tab = $('#' + $(e.target).attr('href').substr(1));
		show_tab(tab);
	});
}
$(function(){
	init_tabs();
});
</script>
