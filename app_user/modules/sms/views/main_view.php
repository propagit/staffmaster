<!--begin top box -->
<div class="col-md-12">
	<div class="box top-box">
		<div class="pull-right">
			<div class="box_credits">
				<div class="title_bc">SMS Credits</div>
				<div class="content_bc">
					<h2><?=modules::run('account/get_credits', 'sms');?></h2>
					<a href="<?=base_url();?>sms/topup">Buy Credits</a>
				</div>
			</div>
		</div>
   		 <h2><i class="fa fa-message"></i> &nbsp; SMS Settings</h2>
		 <p>Customise your automated SMS messages that are sent to staff.</p>
    </div>
</div>
<!--end top box-->

<!--begin bottom box -->
<div class="col-md-12">
	<div class="box bottom-box">
    	<div class="inner-box">
    		<div class="alert alert-default clearfix">
				<?=modules::run('common/field_select', $templates, 'template_id', '','', false);?>
			</div>

			<div id="template-setting">
			</div>
    	</div>
	</div>
</div>

<script>
$(function(){
	load_template();
	$('select[name="template_id"]').change(function(){
		load_template();
	})
});
function load_template() {
	var template_id = $('select[name="template_id"]').val();
	preloading($('#template-setting'));
	$.ajax({
		type: "POST",
		url: "<?=base_url();?>sms/ajax/load_template",
		data: {template_id: template_id},
		success: function(html) {
			loaded($('#template-setting'), html);
		}
	})
}
</script>
