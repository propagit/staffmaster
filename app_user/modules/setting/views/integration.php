<!--begin top box--->
<div class="col-md-12">
	<div class="box top-box">
   		 <h2>Accounts Integration</h2>
   		 <select class="form-control" id="accounting_platform">
			<option value="">Please select the accounting platform</option>
			<option value="shoebooks">Shoebooks</option>
			<option value="myob">MYOB</option>
		</select>
    </div>
</div>
<!--end top box-->

<!--begin bottom box -->
<div class="col-md-12">
	<div class="box bottom-box">
        <div class="inner-box">
        	<div id="platform-settings"></div>
        </div>
    </div>
</div>
<script>
$(function(){
	$('#accounting_platform').change(function(){
		accounting_platform($(this).val());
	});
	accounting_platform('<?=$this->config_model->get('accounting_platform');?>');
})
function accounting_platform(accounting_platform)
{
	$('#accounting_platform').val(accounting_platform);
	$.ajax({
		type: "POST",
		url: "<?=base_url();?>setting/ajax/accounting_platform",
		data: {accounting_platform: accounting_platform},
		success: function(html) {
			$('#platform-settings').html(html);
		}
	})
}
</script>