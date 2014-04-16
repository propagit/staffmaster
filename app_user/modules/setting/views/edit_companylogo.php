<div class="company-profile-detail-box">
<h2>Company Logo</h2>
<p>Upload Your Company Logo
<br />To <b>delete image</b>  roll over the image and click the <i class="fa fa-times"></i> </p>
</div>

<button type="button" class="btn btn-info" onclick="$('#addImage').modal('show');"><i class="fa fa-upload"></i> Upload Image</button>
<br /><br />

<div id="picture_photo"></div>


<!-- Add Staff Picture Modal -->
<div class="modal fade" id="addImage" tabindex="-1" role="dialog" aria-labelledby="addImageLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>
				<h4 class="modal-title">Add Company Logo</h4>
			</div>
            <div class="col-md-12">
                <div class="modal-body">
                	<?=modules::run('setting/form_upload_photo', (isset($company['id'])) ? $company['id'] : 0);?>
                </div>
            </div>
			</form>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<script>
$(function(){
	load_picture(<?=(isset($company['id'])) ? $company['id'] : 0 ?>);
});
function load_picture(company_id)
{
	preloading($('#picture_photo'));
	$.ajax({
		type: "POST",
		url: "<?=base_url();?>setting/ajax/load_picture",
		data: {company_id: company_id},
		success: function(html) {		
			loaded($('#picture_photo'), html);
		}
	})
}
function update_logos()
{
	load_picture(<?=(isset($company['id'])) ? $company['id'] : 0 ?>);
	update_company_logo_header(<?=(isset($company['id'])) ? $company['id'] : 0 ?>);
	
}
function update_company_logo_header()
{
	$.ajax({
		type: 'POST',
		url: '<?=base_url();?>setting/ajax/reload_header_logo',		
		success: function(html) {
			$('.logo').html(html);
		}
	});		
}

function delete_logo(company_id){
	$.ajax({
		type: 'POST',
		url: '<?=base_url();?>setting/ajax/delete_logo',
		data:{company_id:company_id},
		success: function(html) {
			update_logos();
		}
	});	 
}

</script>