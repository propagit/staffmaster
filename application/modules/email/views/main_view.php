<script src="<?=base_url()?>assets/ckeditor/ckeditor.js"></script>
<script src="<?=base_url()?>assets/ckeditor/config.js"></script>
<script src="<?=base_url()?>assets/ckeditor/styles.js"></script>
<!--begin top box--->
<div class="col-md-12">
	<div class="box top-box">
   		 <h2>Email Templates</h2>
		 <p>Customise your automated email templates that are sent to clients and staff. <br>Use the preset variables to create dynamic content in your emails</p>
    </div>
</div>
<!--end top box-->

<!--begin bottom box -->
<div class="col-md-12">
	<div class="box bottom-box">
    	<div class="inner-box">
            <ul class="nav nav-tabs tab-respond" id="nav-email-templates">
                <li class="active mobile-tab"><a href="#welcome_staff" data-toggle="tab">Welcome Staff</a></li>
                <li class="mobile-tab"><a href="#roster_update" data-toggle="tab">Roster Update</a></li>
                <li class="mobile-tab"><a href="#apply_shift" data-toggle="tab">Apply For Shifts</a></li> 
                <li class="mobile-tab"><a href="#shift_reminder" data-toggle="tab">Shift Reminder</a></li> 
                <li class="mobile-tab"><a href="#work_confirmation" data-toggle="tab">Work Confirmation</a></li>
                <li class="mobile-tab"><a href="#forgot_password" data-toggle="tab">Forgot Password</a></li>
                <li class="mobile-tab"><a href="#client_invoice" data-toggle="tab">Client Invoice</a></li> 
                <li class="mobile-tab"><a href="#client_quote" data-toggle="tab">Client Quote</a></li>                             
			</ul>
			
			
			<div class="tab-content tab-email">
				<div class="tab-pane active" id="welcome_staff"></div>	
                <div class="tab-pane" id="roster_update"></div>			
				<div class="tab-pane" id="apply_shift"></div>
				<div class="tab-pane" id="shift_reminder"></div>
				<div class="tab-pane" id="work_confirmation"></div>
                <div class="tab-pane" id="forgot_password"></div>
                <div class="tab-pane" id="client_invoice"></div>
                <div class="tab-pane" id="client_quote"></div>
			</div>
			
			<div class="clearfix"></div>
    	</div>
	</div>
</div>

<script>
function show_tab(tab)
{
	tab.load('<?=base_url();?>email/ajax/load_email_template/' + tab.attr('id'));
}
function init_tabs() {
	show_tab($('.tab-pane.active'));
	$('#nav-email-templates a').on('shown.bs.tab', function(e) {
		tab = $('#' + $(e.target).attr('href').substr(1));
		show_tab(tab);	
	});
}

$(function(){
	init_tabs();
});//ready

function update_template(form_id){
	update_ckeditor();
	$.ajax({
		  type: "POST",
		  url: "<?=base_url();?>email/ajax/update_template",
		  data: $('#'+form_id).serialize(),
		  success: function(html) {
			$('.email-template-updated').removeClass('hide');
			setTimeout(function(){
				$('.email-template-updated').addClass('hide');
			}, 2000); 
		  }
	  });
}

function update_ckeditor()
{
	for ( instance in CKEDITOR.instances ) {
            CKEDITOR.instances[instance].updateElement();
    }	
}

</script>
