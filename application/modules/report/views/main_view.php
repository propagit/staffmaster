<!--begin top box--->
<div class="col-md-12">
	<div class="box top-box">
		<h2>Accounts Reports</h2>
		<p>Welcome to your Staff Account dashboard. Your Dashboard will give you a quick overview of activity going on within [COMPANY PROFILE NAME]. Check back regularly to keep yourself up to date.</p>
	</div>
</div>
<!--end top box-->

<!-- begin bottom box with 2 separate boxes -->
<div class="col-md-12">
	<div class="box bottom-box">
    	
    	<div class="col-md-6 white-box">
            <div class="inner-box">
            	<?=modules::run('report/financial_year_view');?>
            </div>
        </div>
        
        <div class="col-md-6 white-box">
            <div class="inner-box">
                <?=modules::run('report/fore_cast_view');?>                
            </div>
        </div>
        
	</div>
	
	<div class="box bottom-box">
    	
    	<div class="col-md-6 white-box">
            <div class="inner-box">
            	<div class="pull-right col-lg-4">
            		<?=modules::run('report/field_select_year', 'client_year');?><br /><br />
					<?=modules::run('report/field_select_month', 'client_month');?>
            	</div>
                <h2>Top Clients</h2>
				<p>This graph shows you the top clients based on customer<br />spend from generated invoices for the time period chosen.</p>
				<div class="row" id="wp-char-top-clients"></div>
            </div>
        </div>
        
        <div class="col-md-6 white-box">
            <div class="inner-box">
            	<div class="pull-right col-lg-4">
            		<?=modules::run('report/field_select_year', 'role_year');?><br /><br />
            		<?=modules::run('report/field_select_month', 'role_month');?>
            	</div>
                <h2>Top Roles</h2>
                <p>This graph shows you the top roles based on generated<br />time sheets for the time period chosen.</p>                
                <div class="row" id="wp-char-top-roles"></div>
            </div>
        </div>        
	</div>
	
	<div class="box bottom-box">
    	
    	<div class="col-md-6 white-box">
            <div class="inner-box">
            	<?=modules::run('report/top_staff_view');?>
            </div>
        </div>
        
        <div class="col-md-6 white-box">
            <div class="inner-box">
	            <?=modules::run('report/per_job_view');?>
            </div>
        </div>        
	</div>
</div>
<!-- end bottom box with 2 separate boxes -->

<script>
$(function(){
	$('#client_year').change(function(){
		top_clients_chart();
	});
	$('#client_month').change(function(){
		top_clients_chart();
	});
	$('#role_year').change(function(){
		top_roles_chart();
	});
	$('#role_month').change(function(){
		top_roles_chart();
	});
	top_clients_chart();
	top_roles_chart();
})
function top_roles_chart() {
	var year = $('#role_year').val();
	var month = $('#role_month').val();
	preloading($('#wp-char-top-roles'));
	$.ajax({
		type: "POST",
		url: "<?=base_url();?>report/ajax/load_top_roles_data",
		data: {year: year, month: month},
		success: function(html) {
			loaded($('#wp-char-top-roles'), html);
		}
	})
}
function top_clients_chart() {
	var year = $('#client_year').val();
	var month = $('#client_month').val();
	preloading($('#wp-char-top-clients'));
	$.ajax({
		type: "POST",
		url: "<?=base_url();?>report/ajax/load_top_clients_data",
		data: {year: year, month: month},
		success: function(html) {
			loaded($('#wp-char-top-clients'), html);
		}
	})
}
</script>