<!-- Color Picker -->
<link rel="stylesheet" media="screen" type="text/css" href="<?=base_url()?>assets/js/colorpicker/colorpicker.css" />  
<script type="text/javascript" src="<?=base_url()?>assets/js/colorpicker/colorpicker.js"></script>

<?=modules::run('wizard/main_view', 'company');?>
<!--begin top box--->
<div class="col-md-12">
	<div class="box top-box">
   		 <h2><i class="icon-company"></i> &nbsp; Manage Company Profile</h2>
		 <p>Your company profile information is used in various areas of the system such as email correspondence, your invoices, your quotes and login screen, Please ensure the below information is accurate.</p>
    </div>
</div>
<!--end top box-->

<!--begin bottom box -->
<div class="col-md-12">
	<div class="box bottom-box">
    	<div class="inner-box push full-width">
			
			<ul class="nav nav-tabs tab-respond" id="nav-company-profile">
                <li class="active mobile-tab"><a href="#companyinformation" data-toggle="tab">Company Information</a></li>
                <li class="mobile-tab"><a href="#companylogo" data-toggle="tab">Your Company Logo</a></li>
                <li class="mobile-tab"><a href="#companyemail" data-toggle="tab">Your Email Signature</a></li>
			</ul>
			
			<div class="tab-content">
				<div class="tab-pane active" id="companyinformation"></div>	
                <div class="tab-pane" id="companylogo"></div>			
				<div class="tab-pane" id="companyemail"></div>				
			</div>
		 </div>
    </div>
</div>

<!--end bottom box -->
<script>
function show_tab(tab)
{
	if (!tab.html()) {		
		tab.load('<?=base_url() . 'setting/ajax/update_company/'?>' + tab.attr('id'));
	}
}
function init_tabs() {
	show_tab($('.tab-pane.active'));
	$('#nav-company-profile a').on('shown.bs.tab', function(e) {
		tab = $('#' + $(e.target).attr('href').substr(1));
		show_tab(tab);	
	});
}
$(function(){
	init_tabs();	
});
</script>
